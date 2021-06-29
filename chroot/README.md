Adapted from

https://github.com/mh5/simple-chroot


# simple-chroot

simple-chroot is a bash script that manages installation and uninstallation of executable files on chrooted environments. The script automatically identifies the dependencies of the executables you want to install or purge using `ldd`. If you install an executable, its dependencies are cloned automatically. You can uninstall these executables later on, and dependencies that are no longer needed by any other executables are deleted automatically. The chroot environment is assumed to be the working directory of the script.


## Executing files

```
# create a folder for the jail and enter it
mkdir jail && cd jail

# execute bash directly
$ ./simple-chroot.sh execute bash
```

## Installing files

```
# create a folder for the jail and enter it
mkdir jail && cd jail

# installing bash, vim and another executable.
$ ./simple-chroot.sh install bash vim /path/to/another/executable
```

## Uninstalling files
```
# uninstalling vim and another executable.
$ ./simple-chroot.sh purge vim /path/to/another/executable
```

## Referencing files

You can reference a file using one of the following ways...

1. the absolute path to the file
2. a relative path (that starts with a dot) to the file
3. if the file is recognized as an external command, like `ls`, you can use the command name directly, and it will be expanded using `type`, a bash builtin.

