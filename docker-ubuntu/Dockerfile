
# Tsugi base PHP docker

# docker build --tag ubuntu_gcc .
# docker run -p 8080:80 -e BOB=42 -dit ubuntu_gcc:latest

# To redo
# docker container prune
# docker image rm ubuntu_gcc:latest

# Pull base image.
FROM ubuntu:18.04

COPY tsugi-base-configure.sh /usr/local/bin/
COPY tsugi-base-prepare.sh /usr/local/bin/
COPY prepare-gcc.sh /usr/local/bin
COPY configure-gcc.sh /usr/local/bin

# Install.
RUN bash /usr/local/bin/tsugi-base-prepare.sh
RUN bash /usr/local/bin/prepare-gcc.sh

#  apt-get install -y mailutils

# Setup files
COPY monitor-apache.sh /usr/local/bin/
COPY apache2.conf /etc/apache2

# Set environment variables.
ENV HOME /root

# Define working directory.
WORKDIR /root


EXPOSE 80 443
ENTRYPOINT ["bash", "/usr/local/bin/configure-gcc.sh"]

# Define default command.  (Should never get here)
CMD ["bash"]
