
echo "---- Starting preparation ----"

apt-get update
apt-get install docker-ce docker-ce-cli containerd.io

cd /var/www
rm -rf html
git clone https://github.com/csev/cc4e.git html

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
