<?php

function is_viajero($user) {

  $viajeros = explode(",", elgg_get_plugin_setting('viajeros', 'ysu_theme'));
  foreach ($viajeros as $viajero) {
    if (get_user_by_username($viajero)) {
      $guid = get_user_by_username($viajero);

      if ($guid->getGUID() == $user) {
        return true;
      }
    }
  return false;
  }
}
