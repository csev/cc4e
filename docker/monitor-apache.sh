#! /bin/bash

while : 
do
  echo Monitoring Apache Logs `date`
  tail -F /var/log/apache2/access.log /var/log/apache2/error.log
  echo Apache Log Monitoring Failed `date`
  echo Waiting to re-try log monitoring...
  sleep 120
done

# https://stackoverflow.com/questions/2935183/bash-infinite-sleep-infinite-blocking
echo "Tsugi Base Sleeping forever..."
while :; do sleep 2073600; done
