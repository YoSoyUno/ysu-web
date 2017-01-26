#!/bin/bash

# Permite activar o desactivar rapidamente el cache


if [ $1 == "0" ]
then
  /srv/ysu-web/www/red/vendor/bin/elgg-cli config:setting system_cache_enabled 0
  /srv/ysu-web/www/red/vendor/bin/elgg-cli config:setting simplecache_enabled 0
  echo "Cache desactivados!"
else
  /srv/ysu-web/www/red/vendor/bin/elgg-cli config:setting system_cache_enabled 1
  /srv/ysu-web/www/red/vendor/bin/elgg-cli config:setting simplecache_enabled 1
  echo "Cache activados!"
fi
