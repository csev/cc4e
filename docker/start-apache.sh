#! /bin/bash 

touch /tmp/zap

apachectl start

# Should never happen
# https://stackoverflow.com/questions/2935183/bash-infinite-sleep-infinite-blocking
echo "Start Apache Sleeping forever..."
while :; do sleep 2073600; done

