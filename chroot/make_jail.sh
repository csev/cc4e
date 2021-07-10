#! /bin/bash

rm -rf jail
mkdir jail

cp simple-chroot.sh jail
cp hello.c jail

cd jail

./simple-chroot.sh install bash vim gcc as ld ls which rm find sh

mkdir tmp
chmod 1777 tmp
mkdir var
mkdir var/tmp
chmod 1777 var/tmp

mkdir usr/lib/gcc/
mkdir usr/lib/gcc/x86_64-linux-gnu
cp -r /usr/lib/gcc/x86_64-linux-gnu/* usr/lib/gcc/x86_64-linux-gnu
cp -r /usr/lib/x86_64-linux-gnu/* usr/lib/x86_64-linux-gnu

mkdir usr/include
mkdir usr/include/x86_64-linux-gnu
cp -r /usr/include/x86_64-linux-gnu/* usr/include/x86_64-linux-gnu
cp -r /usr/include/* usr/include
cp -r /lib/x86_64-linux-gnu/* lib/x86_64-linux-gnu/

