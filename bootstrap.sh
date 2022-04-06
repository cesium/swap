#!/usr/bin/env bash

#Dependencies
apt-get update
apt-get install -y php7.4-mysql php7.4-xml php7.4-gd php7.4-mbstring php7.4-zip mysql-server composer npm openjdk-17-jre-headless

#Install maven manually
mkdir maven
cd /maven
wget -P https://dlcdn.apache.org/maven/maven-3/3.8.5/binaries/apache-maven-3.8.5-bin.tar.gz /maven
tar xzvf apache-maven-3.8.5-bin.tar.gz
export PATH=/opt/apache-maven-3.8.5/bin:$PATH

cd /vagrant
rm package-lock.json
mysql -u root -p -e 'CREATE DATABASE swap;'
mysql -u root  -e "ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'swap';"
composer install
php artisan key:generate
php artisan migrate
php artisan db:seed

