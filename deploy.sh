#!/usr/bin/env bash
#sudo svn update

sudo php bin/console cache:clear --env=prod
sudo php bin/console assets:install --symlink

sudo chown -R www-data:www-data var/cache/
sudo chown -R www-data:www-data var/logs/
sudo chown -R www-data:www-data var/sessions/

sudo mkdir -p web/uploads
sudo mkdir -p web/minimized
sudo chown -R www-data:www-data web/uploads/
sudo chown -R www-data:www-data web/minimized/

php vendor/bin/phinx migrate -e production
