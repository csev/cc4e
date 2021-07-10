
echo "---- Starting preparation ----"

mkdir /home/gcc
cd /home/gcc 
git clone https://github.com/csev/cc4e.git

cd /home/gcc/cc4e/chroot
bash make_jail.sh

echo "---- Preparation complete ----"
