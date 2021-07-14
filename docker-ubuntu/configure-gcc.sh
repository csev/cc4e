
COMPLETE=/usr/local/bin/gcc-complete

if [ -f "$COMPLETE" ]; then
    echo "gcc jail has already has run"
else

echo "---- Starting gcc jail setup  ----"

cd /home/gcc/cc4e
git pull

cd /home/gcc/cc4e/chroot
bash make_jail.sh

cp -r /home/gcc/cc4e/docker/apache/* /var/www/html

echo "---- Finished gcc jail setup  ----"

# if COMPLETE
fi

# Continue with the rest
bash /usr/local/bin/tsugi-base-configure.sh

