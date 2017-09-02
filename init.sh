#usr/bin/sh

composer update
chmod a+w -R log temp www
cp ./app/config/config.local.default.neon ./app/config/config.local.neon
