#!/bin/sh

echo -e "\nUpdate Composer...\n"

php composer.phar self-update

echo -e "\nUpdate Vendors...\n"

php composer.phar update

echo -e "\nCHMOD 777 to right folder\n..."

chmod -R 777 var/*
chmod -R 777 app/logs
chmod -R 777 app/cache

echo -e "\nCreate database...\n"

php bin/console doctrine:schema:update --force
