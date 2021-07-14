sed -i 's/# \(.*multiverse$\)/\1/g' /etc/apt/sources.list
export DEBIAN_FRONTEND=noninteractive
export LC_ALL=C.UTF-8
locale -a
env
echo ======= Update 1
apt-get update
echo ======= Upgrade
apt-get -y upgrade
apt-get install -y build-essential
apt-get install -y software-properties-common
apt-get install -y byobu curl git htop man unzip vim wget
apt-get install -y apt-utils 
if [ ! -f "/usr/bin/crontab" ]; then
    apt-get install -y cron 
fi
apt-get install -y ca-certificates
apt-key adv --keyserver keyserver.ubuntu.com --recv-keys 4F4EA0AAE5267A6C
echo ======= Update 2
apt-get update
add-apt-repository -y ppa:ondrej/php
add-apt-repository -y ppa:ondrej/apache2
# https://certbot.eff.org/lets-encrypt/ubuntubionic-apache
add-apt-repository -y universe
add-apt-repository -y ppa:certbot/certbot
apt-get update
echo ======= Cofigure Postfix
echo "postfix postfix/mailname string example.com" | debconf-set-selections
echo "postfix postfix/main_mailer_type string 'Internet Site'" | debconf-set-selections
apt-get install -y apache2 \
                   php7.3 \
                   libapache2-mod-php7.3 php7.3-mysql php7.3-curl php7.3-json \
                   php7.3-mbstring php7.3-zip php7.3-xml php7.3-gd \
                   php7.3-apc \
                   php7.3-intl \
                   php-memcached php-memcache \
                   mysql-client \
                   nfs-common \
                   certbot python-certbot-apache \
                   mailutils

a2enmod -q rewrite dir expires headers
phpenmod mysqlnd pdo_mysql intl

echo ====== Check out build scripts if they are not already there
if [ ! -d "/root/tsugi-build" ]; then
    git clone https://github.com/tsugiproject/tsugi-build.git /root/tsugi-build
fi
echo ======= Cleanup Start
df
apt-get -y autoclean
apt-get -y clean
apt-get -y autoremove
rm -rf /var/lib/apt/lists/*
echo ======= Cleanup Done
df
echo ======= Cleanup Done 
