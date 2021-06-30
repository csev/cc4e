#!/bin/bash

# Copyright (c) 2015, M. Helmy Hemeda. All rights reserved.
# Use of this source code is governed by a BSD-style license that can be
# found in the LICENSE file.

function usage {
	echo "Usage: ./simple-chroot.sh    help"
	echo "                             execute {file_path | external_command}"
	echo "                             install {file_path | external_command}..."
	echo "                             purge   {file_path | external_command}..."
}

function echo_fatal {
	tput setaf 1
	>&2 echo "Fatal error: " "$@"
	tput sgr0
}

function echo_note {
	tput setaf 3
	echo "Note: " "$@"
	tput sgr0
}

function is_installed {
	[[ -f $FILE_INSTALLED ]] || return 1

	local path_to_file="$1"

	grep -q "^$path_to_file$" $FILE_INSTALLED
	return $?
}

function set_installed {
	local path_to_file="$1"
	touch $FILE_INSTALLED

	is_installed "$path_to_file" || {
		echo "$path_to_file" >> $FILE_INSTALLED && {
			echo "Set installation of \`$path_to_file'"
			return 0
		}
	}

	echo_note "Could not set installation of \`$path_to_file'!"
	return 1
}

function unset_installed {
	local path_to_file="$1"

	[[ -f $FILE_INSTALLED ]] || return 1

	is_installed "$path_to_file" && {
		sed -i "\|$path_to_file|d" $FILE_INSTALLED && {
			echo "Unset installation of \`$path_to_file'"
			return 0
		}
	}

	echo_note "Could not unset installation of \`$path_to_file'!"
	return 1
}

function inc_refcount {
	touch $FILE_REFS

	local line="$(grep "$1" $FILE_REFS)"

	if [ -z "$line" ]; then
		line="$1 1"
		echo "$line" >> $FILE_REFS
		return
	fi

	sed -i "\|$1|d" $FILE_REFS

	local line_arr=($line)
	local dep=${line_arr[0]}
	local num=${line_arr[1]}

	num=$((num+1))

	line="$dep $num"

	echo "$line" >> $FILE_REFS
}

function dec_refcount {
	local line="$(grep "$1" $FILE_REFS)"

	sed -i "\|$1|d" $FILE_REFS

	local line_arr=($line)
	local dep=${line_arr[0]}
	local num=${line_arr[1]}

	num=$((num-1))

	if ((num <= 0)); then
		rm -v ".$dep"
		return
	fi

	line="$dep $num"
	echo "$line" >> $FILE_REFS
}

function collect_deps {
	local path_to_file="$1"
	local deps="$(ldd "$path_to_file" | grep -oh '/.* ')"
	deps="$path_to_file $deps"

	echo "$deps"
}

function jail_execute {
	local path_to_file="$1"

	jail_install "$1"
	sudo chroot ./ "$1"

	return $?
}

function jail_install {
	local path_to_file="$1"

	if is_installed "$path_to_file" ; then
		echo_note "\`$path_to_file' will be ignored because it is already installed!"
		return 1
	fi

	local cloned="$(collect_deps "$path_to_file")"

	for i in $cloned; do
		cp -v --parents "$i" ./
		inc_refcount "$i"
	done

	set_installed "$path_to_file"
	return $?
}

function jail_purge {
	local path_to_file="$1"

	if ! is_installed "$path_to_file" ; then
		echo_note "\`$path_to_file' is not installed to be purged!"
		return 1
	fi

	local decremented="$(collect_deps "$path_to_file")"

	for i in $decremented; do
		dec_refcount "$i"
	done

	unset_installed "$path_to_file"
	return $?
}

function check_command {
	command_type="$(type -t "$1")"

	if [[ "$command_type" == builtin ]] ; then
		echo_fatal "\`$1' is a builtin!"
		echo_note "try installing a shell instead, e.g. bash!"
		exit 1
	fi

	if [[ "$command_type" != "file" ]] ; then
		echo_fatal "\`$1' command not found!"
		exit 1
	fi

	command_file="$(type -P "$1")"

	check_file "$command_file"
}

function check_file {
	if [[ ! -f "$1" ]]; then
		echo_fatal "\`$1' is not a file!"
		exit 1
	fi
}

paths_to_files=()
action=""

FILE_REFS=".jail-data/refs"
FILE_INSTALLED=".jail-data/installed"

for arg; do
	if [[ $action == "" ]]; then
		if [[ "$arg" == execute ]] || [[ "$arg" == install ]] || [[ "$arg" == purge ]] ; then
			if (( "$#" < 2 )); then
				echo_fatal "too few arguments!"
				usage
				exit 1
			fi
			action="jail_$arg"
		elif [[ "$arg" == help ]] || [[ "$arg" == "--help" ]]; then
			usage
			exit 0
		else
			echo_fatal "unknown action \`$arg'!"
			usage
			exit 1
		fi
	else
		if [[ "$arg" == /* ]]; then
			check_file "$arg"
			paths_to_files+=("$arg")
		elif [[ "$arg" == .* ]]; then
			check_file "$arg"
			paths_to_files+=("$(realpath $arg)")
		else
			check_command "$arg"
			paths_to_files+=("$command_file")
		fi
	fi
done

output_dir="./"
mkdir -p $output_dir

cd $output_dir || {
	echo_fatal "could not enter jail directory \`$output_dir'!"
	exit 1
}

mkdir -p ".jail-data"

for path in "${paths_to_files[@]}"; do
	$action "$path"
done

