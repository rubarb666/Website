#!/bin/bash

yum update -y

if [[ -n  `pgrep httpd` ]]; then
    service httpd stop
    yum remove -y httpd
fi

amazon-linux-extras install nginx1.12
yum install -y php72-fpm php72-common php72-opcache php72-mbstring php72-mysqlnd php72-pdo php72-xml php72-cli php72-mcrypt

# clear existing files (or else install will fail)
rm -f /etc/nginx/nginx.conf
rm -f /etc/nginx/conf.d/virtual.conf
rm -f /etc/php.ini
rm -f /etc/php-fpm.d/www.conf
rm -rf /var/www
mkdir -p /var/www/settings/
chown -R nginx: /var/www
chown -R nginx: /var/log/php-fpm
chown root:nginx /var/lib/php/7.1/session/
