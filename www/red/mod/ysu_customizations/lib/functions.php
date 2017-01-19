<?php
/**
 * Returns event type options
 *
 * @return bool|array
 */
function event_manager_event_type_options_ysu($admin) {
	$type_settings = trim(elgg_get_plugin_setting('type_list', 'event_manager'));

	if (empty($type_settings)) {
		return false;
	}
	//$type_options = array('-');

	// Si es admin muestra el array completo, sino quita la primera opcion "activacion ysu"
	if ($admin) {
		$type_options = explode(',', $type_settings);
	} else {
		$type_options = explode(',', $type_settings);
		$type_options_first = array_shift($type_options);
	}

	//$type_options = array_merge($type_options, $type_list);

	array_walk($type_options, create_function('&$val', '$val = trim($val);'));

	return $type_options;
}


function ysu_ultimo_punto() {
	$entities = array(
	    "type" => "group",
	    "full_view" => FALSE,
	    'limit' => get_input('limit', 0),
	    'offset' => get_input('proximity_offset', 0),
	    'count' => false
	);

	foreach ($entities as $group) {
		$object_x['orden'] = $group->orden;
		$object_x['estado'] = $group->estado;
	}


}
