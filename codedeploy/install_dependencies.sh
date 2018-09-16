#!/bin/bash

yum update -y

if [[ -n  `pgrep httpd` ]]; then
    service httpd stop
    yum remove -y httpd
fi

amazon-linux-extras install nginx1.12
amazon-linux-extras install php7.2
yum install -y git php-fpm php-common php-opcache php-mbstring php-mysqlnd php-pdo php-xml php-cli

# Composer required for manual updates
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
ln -s /usr/local/bin/composer /usr/bin/composer

# clear existing files (or else install will fail)
rm -f /etc/nginx/nginx.conf
rm -f /etc/nginx/conf.d/virtual.conf
rm -f /etc/php.ini
rm -f /etc/php-fpm.d/www.conf
rm -rf /var/www
mkdir -p /var/www/settings/
chown -R nginx: /var/www
chown -R nginx: /var/log/php-fpm
chown root:nginx /var/lib/php/session/
