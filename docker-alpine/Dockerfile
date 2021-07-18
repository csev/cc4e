# GCC Autograder Docker image

# docker build . --tag alpine_gcc
# cat hello.sh | docker run --network none --rm -i alpine_gcc:latest "-"

# To redo
# docker container prune
# docker image rm alpine_gcc:latest

# https://hub.docker.com/_/alpine

FROM alpine

# https://wiki.alpinelinux.org/wiki/GCC  (build-base)
RUN apk add --no-cache build-base cpulimit

ENTRYPOINT ["/bin/ash"]

# Define default command.  (Should never get here)
CMD ["/bin/ash"]


