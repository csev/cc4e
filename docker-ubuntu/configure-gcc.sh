
COMPLETE=/usr/local/bin/gcc-complete

if [ -f "$COMPLETE" ]; then
    echo "gcc setup has already has run"
else

cd /var/www/html
git pull

echo "---- Finished gcc setup  ----"

# if COMPLETE
fi

# Continue with the rest
bash /usr/local/bin/tsugi-base-configure.sh

