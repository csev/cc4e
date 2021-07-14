
echo "---- Starting preparation ----"

apt-get update
apt-get install docker-ce docker-ce-cli containerd.io

cd /var/www
mv html /tmp
git clone https://github.com/csev/cc4e.git www

echo ======= Cleanup Start
df
apt-get -y autoclean
apt-get -y clean
apt-get -y autoremove
rm -rf /var/lib/apt/lists/*
echo ======= Cleanup Done
df
echo ======= Cleanup Done

echo "---- Preparation complete ----"
