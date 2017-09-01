#usr/bin/sh

mkdir -p ./temp/cache
mkdir -p ./www/webtemp
cp ./app/config/config.local.default.neon ./app/config/config.local.neon
chmod 0777 -R ./temp/cache
composer update