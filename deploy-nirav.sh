#!/usr/bin/env bash
sudo svn update

sudo php bin/console cache:clear --env=prod
sudo php bin/console assets:install --symlink

sudo chown -R niravgosalia:staff var/cache/
sudo chown -R niravgosalia:staff var/logs/
sudo chown -R niravgosalia:staff var/sessions/

# sudo chown -R niravgosalia:staff web/bundles/
sudo chown -R niravgosalia:staff web/uploads/

php vendor/bin/phinx migrate -e production

