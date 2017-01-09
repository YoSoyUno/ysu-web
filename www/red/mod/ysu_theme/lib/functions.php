<?php

function is_viajero() {
  $viajeros = elgg_get_plugin_setting('viajeros', 'ysu_theme');
  return $viajeros;
}
