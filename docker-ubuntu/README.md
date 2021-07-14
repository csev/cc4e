
CC Runner
=========

    docker build --tag ubuntu_gcc .
    docker run -p 8080:80 -e BOB=42 -dit ubuntu_gcc:latest

To redo

    docker container prune
    docker image rm ubuntu_gcc:latest

In the Container
----------------

    cp -r /home/gcc/cc4e/docker/apache/* /var/www/html

