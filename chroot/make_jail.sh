#! /bin/bash

rm -rf jail
mkdir jail

cp simple-chroot.sh jail
cp hello.c jail

cd jail

./simple-chroot.sh install busybox bash sh vim gcc as ld ls which rm find

mkdir usr/libexec 
cp -r /usr/libexec/* usr/libexec

mkdir usr/include
cp -r /usr/include/* usr/include

cp -r /usr/lib/* usr/lib

cp -r /lib/* lib

