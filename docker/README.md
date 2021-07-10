
CC Runner
=========

    docker build --tag gcc_base .
    docker run -p 8080:80 -p 3306:3306 -e BOB=42 -dit gcc_base:latest

To redo

    docker container prune
    docker image rm gcc_dbase:latest

In the Container
----------------

    cp -r /home/gcc/cc4e/docker/apache/* /var/www/html

