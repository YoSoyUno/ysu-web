<?php


//import('../../amap_maps_api/lib/geo_functions.php');
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


function ysu_ordenar_puntos() {
	$entities = array(
		"type" => "group",
    "full_view" => TRUE,
    'limit' => get_input('limit', 0),
    'offset' => get_input('proximity_offset', 0),
    'count' => false
	);

	$groups = elgg_get_entities_from_metadata($entities);

	// Ordena objetos del array de acuerdo al valor de orden
	usort($groups, function($a, $b)
	{
    return strnatcmp($a->orden, $b->orden);
	});

	return $groups;
}


function ysu_punto_actual() {
	$groups = ysu_ordenar_puntos();
	$actual = 0;
	foreach ($groups as $key => $g) {
		if ($g->estado == 'Completo') {
			$ultimo_completo = $g->getGUID();
			// error_log("guid del ultimo: {$g->getGUID()}");

			// Asumimos que el proximo punto a activar es el que le sigue al ultimo completo
			$actual_key = $key + 1;
			$actual = $groups[$actual_key]->getGUID();
		}
	}

	return $actual;
}

// ysu_punto_actual();
$x = get_entity(ysu_punto_actual());
//error_log(print_r($x,TRUE));
//error_log($x->getLatitude());

function ysu_calcula_distancia($punto_limite) {
	elgg_load_library('elgg:groupsmap');
	elgg_load_library('elgg:amap_maps_api');
	elgg_load_library('elgg:amap_maps_api_geo');

	if (!$punto_limite) {
		$punto_limite = ysu_punto_actual();

	}

	$groups = ysu_ordenar_puntos();

	foreach ($groups as $key => $g) {
		if ($primero) {
			$distance_tramo = get_distance($lat_old,$lng_old,$g->getLatitude(),$g->getLongitude());
			$distance = $distance + $distance_tramo;
			if ($g->getGUID() == $punto_limite) {
				// error_log('el guid es ' . $g->getGUID());
				$recorrido = $distance;
			}
			$lat_old = $g->getLatitude();
			$lng_old = $g->getLongitude();
		}
		$primero = 1;

		// if ($g->estado == 'Completo') {
		// 	$ultimo_completo = $g->getGUID();
		// 	// error_log("guid del ultimo: {$g->getGUID()}");
		//
		// 	// Asumimos que el proximo punto a activar es el que le sigue al ultimo completo
		// 	$actual_key = $key + 1;
		// 	$actual = $groups[$actual_key]->getGUID();
		// }
	}
	error_log('limite: ' . print_r($punto_limite,TRUE));
	error_log('total: ' . print_r($distance,TRUE));
	error_log('parcial: ' . print_r($recorrido,TRUE));

	return array($distance, $recorrido);
}
