#!/bin/bash

PLUGINS=`awk -vORS=, '{ print $1 }' plugins.list | sed 's/,$/\n/' | sed 's/,,/,/g' | sed 's/,*$//g'`

# desactiva todos los plugins
vendor/bin/elgg-cli plugins:deactivate --all

echo ""
echo "------------------"
echo ""

# activa todos los listados en plugins.list en el orden sugerido
vendor/bin/elgg-cli plugins:activate "$PLUGINS"
