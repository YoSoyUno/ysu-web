#!/bin/bash

source ../../bin/database_auth.sh

PLUGINS=`awk -vORS=, '{ print $1 }' plugins.list | sed 's/,$/\n/' | sed 's/,,/,/g' | sed 's/,*$//g'`

# desactiva todos los plugins
vendor/bin/elgg-cli plugins:deactivate --all

echo ""
echo "------------------"
echo ""

# activa todos los listados en plugins.list en el orden sugerido
# y activa plugins de desarrollo en funcion si estamos en entornos de desarrollo
if [ $VERSION == "ALFA" ] || [ $VERSION == "BETA" ]
then
  vendor/bin/elgg-cli plugins:activate "$PLUGINS,developers"
else
  vendor/bin/elgg-cli plugins:activate "$PLUGINS"
fi

#limpia caches
echo ""
echo "Limpio el cache..."
vendor/bin/elgg-cli site:flush_cache
