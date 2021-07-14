
echo "---- Starting preparation ----"

apt-get update
apt-get install docker-ce docker-ce-cli containerd.io

cd /var/www
mv html /tmp
git clone https://github.com/csev/cc4e.git www

echo "---- Preparation complete ----"
