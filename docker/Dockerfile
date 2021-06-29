# GCC Autograder Docker image

# docker build . --tag gcc_base
# docker run -p 8080:80 -dit gcc_base:latest

# docker exec -it 8e4251ace0b04003c52ec59b9ea822b908da792e3b07c75b4a5f6c373ff6d6c2 /bin/sh
# apachectl start

# To redo
# docker container prune
# docker image rm gcc_base:latest

# https://hub.docker.com/_/alpine

FROM httpd:alpine
# FROM php:7.4-apache
# https://wiki.alpinelinux.org/wiki/GCC
# FROM php:7.4-alpine
RUN apk add --no-cache build-base php7 php7-apache2 vim bash bash-completion git
RUN apk add --no-cache lynx
COPY start-apache.sh /usr/local/bin/
COPY prepare-gcc.sh /usr/local/bin/

# Install.
RUN bash /usr/local/bin/prepare-gcc.sh

# ENTRYPOINT ["/usr/local/apache2/bin/apachectl", "start"]
# ENTRYPOINT ["sh"]

# WORKDIR /root
EXPOSE 80

ENTRYPOINT ["bash", "/usr/local/bin/start-apache.sh"]

# Define default command.  (Should never get here)
CMD ["bash"]


