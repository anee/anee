#usr/bin/sh

mkdir -p ./temp/cache
mkdir -p ./www/webtemp
cp ./app/config/config.local.default.neon ./app/config/config.local.neon

composer update