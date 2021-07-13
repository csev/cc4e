

As User
=======

    apt-get install uidmap

    root@ip-172-31-16-241:/home/csev# cat /etc/subgid
    www-data:100000:65536
    root@ip-172-31-16-241:/home/csev# cat /etc/subuid
    www-data:100000:65536
    root@ip-172-31-16-241:/home/csev# 

    root@ip-172-31-16-241:/home/csev# su -s "/bin/bash" www-data
    www-data@ip-172-31-16-241:/home/csev$ id -u
    33
    www-data@ip-172-31-16-241:/home/csev$ whoami
    www-data

    sudo systemctl disable --now docker.service docker.socket

    su -s "/bin/bash" www-data

    root@ip-172-31-16-241:/home/csev# su -s "/bin/bash" www-data
    www-data@ip-172-31-16-241:/home/csev$ cd
    www-data@ip-172-31-16-241:~$ pwd
    /var/www
    www-data@ip-172-31-16-241:~$ /usr/bin/do
    do-release-upgrade             docker-proxy                   dockerd-rootless.sh            dotlock.mailutils
    docker                         dockerd                        domainname                     
    docker-init                    dockerd-rootless-setuptool.sh  dotlock                        
    www-data@ip-172-31-16-241:~$ /usr/bin/dockerd-rootless-setuptool.sh install
    [INFO] systemd not detected, dockerd-rootless.sh needs to be started manually:

    PATH=/usr/bin:/sbin:/usr/sbin:$PATH dockerd-rootless.sh 

    [INFO] Creating CLI context "rootless"
    Successfully created context "rootless"

    [INFO] Make sure the following environment variables are set (or add them to ~/.bashrc):

    # WARNING: systemd not found. You have to remove XDG_RUNTIME_DIR manually on every logout.
    export XDG_RUNTIME_DIR=/var/www/.docker/run
    export PATH=/usr/bin:$PATH
    export DOCKER_HOST=unix:///var/www/.docker/run/docker.sock

    www-data@ip-172-31-16-241:~$ 

    www-data@ip-172-31-16-241:~$     export XDG_RUNTIME_DIR=/var/www/.docker/run
    www-data@ip-172-31-16-241:~$     export PATH=/usr/bin:$PATH
    www-data@ip-172-31-16-241:~$     export DOCKER_HOST=unix:///var/www/.docker/run/docker.sock
    www-data@ip-172-31-16-241:~$ dockerd-rootless.sh &


In another window:

    sudo bash
    su -s "/bin/bash" www-data
    cd /var/www/html/docker-alpine
    export XDG_RUNTIME_DIR=/var/www/.docker/run
    export PATH=/usr/bin:$PATH
    export DOCKER_HOST=unix:///var/www/.docker/run/docker.sock
    docker build . --tag alpine_gcc 
    cat hello.sh | docker run --network none --rm -i alpine_gcc:latest "-"

enable.php :

    $docker_command = 'export DOCKER_HOST=unix:///var/www/.docker/run/docker.sock; docker run --network none --rm -i alpine_gcc:latest "-"';





