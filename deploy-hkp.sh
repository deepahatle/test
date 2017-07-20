#!/usr/bin/env bash
#sudo svn update

sudo php bin/console cache:clear
sudo php bin/console assets:install --symlink

sudo chown -R hkp:staff var/cache/
sudo chown -R hkp:staff var/logs/
sudo chown -R hkp:staff var/sessions/

sudo mkdir -p web/uploads
sudo mkdir -p web/minimized
sudo chown -R hkp:staff web/uploads/
sudo chown -R hkp:staff web/minimized/

php vendor/bin/phinx migrate -e development
