#usr/bin/sh

mkdir -p ./temp/cache
mkdir -p ./www/webtemp
cp ./app/config/config.local.default.neon ./app/config/config.local.neon
chmod -R 777 ./*

composer update