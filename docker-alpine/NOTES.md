
As Root
=======

    cd /root
    git clone https://github.com/tsugiproject/tsugi-build.git
    cd tsugi-build
    bash ubuntu/build-prod.sh

    apt-get install apt-transport-https ca-certificates curl gnupg lsb-release
    apt-get update

    curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /usr/share/keyrings/docker-archive-keyring.gpg

    echo \
    "deb [arch=amd64 signed-by=/usr/share/keyrings/docker-archive-keyring.gpg] https://download.docker.com/linux/ubuntu \
    $(lsb_release -cs) stable" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null

    apt-get update
    apt-get install docker-ce docker-ce-cli containerd.io

    cd /var/www
    git clone https://github.com/csev/cc4e.git
    replace html with cc4e
    cd cc4e

    git config --global user.name "Charles R. Severance"
    git config --global user.email csev@umich.edu
    git config --global core.editor vim

Install/Use Root Docker (If you fail getting rootless to work)
--------------------------------------------------------------

    sudo bash

    Add www-data to the docker group in /etc/groups
    docker:x:999:www-data

    groups www-data

    service docker status
    service docker start

    ls -l /var/run/docker.sock 

    export DOCKER_HOST=unix:///var/run/docker.sock
    docker info

    su -s "/bin/bash" www-data
    cd /var/www/html/docker-alpine

    export DOCKER_HOST=unix:///var/run/docker.sock
    docker info

    docker build . --tag alpine_gcc

    cat hello.sh | docker run --network none --rm -i alpine_gcc:latest "-"

Install Rootless Docker As User
===============================

    (I have not gotten this to work in Unbuntu 22)

    https://docs.docker.com/engine/security/rootless/

    sudo systemctl disable --now docker.service docker.socket

    shutdown -r now

    login as csev / ubuntu

    sudo bash
    apt-get install -y uidmap

    echo "www-data:100000:65536" >> /etc/subuid
    echo "www-data:100000:65536" >> /etc/subgid

    sudo systemctl disable --now docker.service docker.socket

    su -s "/bin/bash" www-data

    /usr/bin/dockerd-rootless-setuptool.sh install

Start the rootless Docker (as user)
-----------------------------------

After install - or after reboot

    sudo bash
    sudo systemctl disable --now docker.service docker.socket

    su -s "/bin/bash" www-data
    cd /var/www/html/docker-alpine

    export XDG_RUNTIME_DIR=/var/www/.docker/run
    export PATH=/usr/bin:$PATH
    export DOCKER_HOST=unix:///var/www/.docker/run/docker.sock
    rm -r $XDG_RUNTIME_DIR
    mkdir $XDG_RUNTIME_DIR
    dockerd-rootless.sh &

    docker info

In another window:

    sudo bash
    su -s "/bin/bash" www-data
    cd /var/www/html/docker-alpine
    export XDG_RUNTIME_DIR=/var/www/.docker/run
    export PATH=/usr/bin:$PATH
    export DOCKER_HOST=unix:///var/www/.docker/run/docker.sock

    docker info

    docker build . --tag alpine_gcc 
    cat hello.sh | docker run --network none --rm -i alpine_gcc:latest "-"

enable.php :

    $docker_command = 'export DOCKER_HOST=unix:///var/www/.docker/run/docker.sock; docker run --network none --rm -i alpine_gcc:latest "-"';




WTF???
=====

    https://docs.docker.com/engine/security/rootless/

    # mkdir -p /etc/systemd/system/user@.service.d
    # cat > /etc/systemd/system/user@.service.d/delegate.conf << EOF
    [Service]
    Delegate=cpu cpuset io memory pids
    EOF
    # systemctl daemon-reload

