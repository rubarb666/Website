#!/bin/sh
cp /vagrant/vagrant/httpd-start.conf /etc/init/httpd.conf -f
cp /vagrant/vagrant/httpd.conf /etc/httpd/conf/httpd.conf -f
cp /vagrant/vagrant/php.ini /etc/php.ini -f
cp /vagrant/vagrant/xdebug.ini /etc/php.d/xdebug.ini -f
cp /vagrant/vagrant/site.config.php /vagrant/settings/site.config.php -f

service httpd restart
