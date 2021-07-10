
# Tsugi base PHP docker

# docker build --tag tsugi_base .
# docker run -p 8080:80 -p 3306:3306 -e BOB=42 -dit tsugi_base:latest

# To redo
# docker container prune
# docker image rm tsugi_dev:latest tsugi_mysql:latest tsugi_base:latest

# Pull base image.
FROM ubuntu:18.04

COPY tsugi-base-configure.sh /usr/local/bin/
COPY tsugi-base-prepare.sh /usr/local/bin/

# Install.
RUN bash /usr/local/bin/tsugi-base-prepare.sh

#  apt-get install -y mailutils

# Setup files
COPY monitor-apache.sh /usr/local/bin/
COPY apache2.conf /etc/apache2

# Set environment variables.
ENV HOME /root

# Define working directory.
WORKDIR /root


EXPOSE 80 443
ENTRYPOINT ["bash", "/usr/local/bin/tsugi-base-configure.sh"]

# Define default command.  (Should never get here)
CMD ["bash"]
