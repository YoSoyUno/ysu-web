<?php
/**
 * Elgg Maps of Groups plugin
 * @package groupsmap
 */


if (!elgg_is_xhr()) {
    register_error('Sorry, Ajax only!');
    forward(REFERRER);
}

if (!elgg_is_active_plugin("amap_maps_api")) {
    register_error(elgg_echo("groupsmap:settings:amap_maps_api:disabled"));
    forward(REFERER);
}

elgg_load_library('elgg:groupsmap');
elgg_load_library('elgg:amap_maps_api');
elgg_load_library('elgg:amap_maps_api_geo');

// get variables
$s_location = get_input("s_location");
$s_radius = (int) get_input('s_radius', 0);
$s_keyword = get_input("s_keyword");
$showradius = get_input("showradius");
$initial_load = get_input("initial_load");

if ($s_radius > 0)
    $search_radius_txt = amap_ma_get_radius_string($s_radius);
else
    $search_radius_txt = amap_ma_get_default_radius_search_string();

$s_radius = amap_ma_get_default_radius_search($s_radius);

// retrieve coords of location asked, if any
$coords = amap_ma_geocode_location($s_location);

$title = elgg_echo('groupsmap:all');


$options = array(
    "type" => "group",
    "full_view" => FALSE,
    'limit' => get_input('limit', 0),
    'offset' => get_input('proximity_offset', 0),
    'count' => false
);


$options['metadata_name_value_pairs'][] = array('name' => 'location', 'value' => '', 'operand' => '!=');
$options['metadata_name_value_pairs'][] = array('name' => 'country', 'value' => '', 'operand' => '!=');
$options['metadata_name_value_pairs_operator'] = 'OR';

if ($initial_load) {
    if ($initial_load == 'newest') {
        $options['limit'] = amap_ma_get_initial_limit('groupsmap');
        $title = elgg_echo('groupsmap:groups:newest', array($options['limit']));
    } else if ($initial_load == 'location') {
        // retrieve coords of location asked, if any
        $user = elgg_get_logged_in_user_entity();
        if ($user->location) {
            $s_lat = $user->getLatitude();
            $s_long = $user->getLongitude();

            if ($s_lat && $s_long) {
                $s_radius = amap_ma_get_initial_radius('groupsmap');
                $search_radius_txt = $s_radius;
                $s_radius = amap_ma_get_default_radius_search($s_radius);
                $options = add_order_by_proximity_clauses($options, $s_lat, $s_long);
                $options = add_distance_constraint_clauses($options, $s_lat, $s_long, $s_radius);

                $title = elgg_echo('groupsmap:groups:nearby:search', array($user->location));
            }
        }
    }
} else {
    if ($s_keyword) {
        $db_prefix = elgg_get_config("dbprefix");
        $query = sanitise_string($s_keyword);

        $options["joins"] = array("JOIN {$db_prefix}groups_entity ge ON e.guid = ge.guid");
        $where = "(ge.name LIKE '%$query%' OR ge.description LIKE '%$query%')";
        $options["wheres"] = array($where);
    }

    if ($coords) {
        $search_location_txt = $s_location;
        $s_lat = $coords['lat'];
        $s_long = $coords['long'];

        if ($s_lat && $s_long) {
            $options = add_order_by_proximity_clauses($options, $s_lat, $s_long);
            $options = add_distance_constraint_clauses($options, $s_lat, $s_long, $s_radius);
        }
        $title = elgg_echo('groupsmap:groups:nearby:search', array($search_location_txt));
    }
}

$groups = elgg_get_entities_from_metadata($options);

$users = array();
if (amap_ma_check_if_membersmap_gm_enabled()) {
	$options1 = array('type' => 'user', 'full_view' => false);
	$options1['limit'] =0;
	$options1['metadata_name_value_pairs'] = array(array('name' => 'location', 'value' => '', 'operand' => '!='));
	$users = elgg_get_entities_from_metadata($options1);
	$indextable .= elgg_view('input/checkbox', array(
		'name' => 'chbx_user',
		'id' => 'chbx_user',
		'checked' => true,
	)).'<label for="chbx_user">'.elgg_echo('amap_maps_api:members').'</label>';

	if ($users) {
		foreach ($users as $entity) {
			$entity = amap_ma_set_entity_additional_info($entity, 'name', 'description', $entity->location);
		}
	}
}

$events = array();
if (amap_ma_check_if_eventmanager_gm_enabled()) {
	$array4 = array();
	$options4 = array(
		'type' => 'object',
		'subtype' => 'event',
		'full_view' => false,
		'limit' => 0,
	);
	$events = elgg_get_entities($options4);

	if ($events) {
		foreach ($events as $entity) {
			$entity = amap_ma_set_entity_additional_info($entity, 'title', 'description', $entity->location);
		}
	}

}


$entities1 = array_merge($users, $groups);
$entities = array_merge($entities1, $events);


$map_objects = array();
if ($entities) {

    foreach ($entities as $entity) {
        $entity = amap_ma_set_entity_additional_info($entity, 'name', 'briefdescription', groupsmap_get_group_location_str($entity));
    }

    //error_log(echo json_encode($entities));
    //error_log( print_r($entities, TRUE) );


    foreach ($entities as $e) {

      $icon = elgg_trigger_plugin_hook('entity:icon:url', 'user', array('entity' => $e, 'size' => 'topbar'), '');
        if ($e->getLatitude() && $e->getLongitude())  {
            $object_x = array();
            $object_x['guid'] = $e->getGUID();
            $object_x['url'] = $e->getURL();
            $object_x['title'] = amap_ma_remove_shits($e->getVolatileData('m_title'));;
            $object_x['description'] = amap_ma_get_entity_description($e->getVolatileData('m_description'));
            $object_x['location'] = amap_ma_remove_shits($e->getVolatileData('m_location'));

            // Si solo es numeros, suponemos que es una coordenada
            if (preg_match('/[A-Za-z]/', $object_x['location']))
            {
              $object_x['lat'] = $e->getLatitude();
              $object_x['lng'] = $e->getLongitude();
              //error_log("### {$object_x['location']} --- Longitud: {$object_x['lng']} Latitud: {$object_x['lng']}");

            } else {
              // Consideramos que es una coordenada porque no tiene letras
              $coord = explode(',',$object_x['location']);
              $object_x['lat'] = $coord[0];
              $object_x['lng'] = $coord[1];
              //error_log("### {$object_x['location']} --- Longitud: {$object_x['lng']} Latitud: {$object_x['lng']}");
            }

            $object_x['icon'] = $e->getVolatileData('m_icon');
            $object_x['type'] = $e->getType().$e->getSubtype();
            if ($e->getSubtype() === 'event') {
              $event_type = str_replace(' ', '-', strtolower($e->event_type));
              $object_x['event_type'] = $event_type;

              $event_group = $e->getContainerEntity();
              if ($event_group) {
                $object_x['event_group'] = $event_group->guid;
              }
            }
            $object_x['other_info'] = $e->getVolatileData('m_other_info');
            if ($icon) {
              $object_x['map_icon'] = $icon;
            } else {
              $object_x['map_icon'] = $e->getVolatileData('m_map_icon');
            }

            $avatar = elgg_view_entity_icon($e, 'small');
            switch ($object_x['type']) {
              case 'group':
                // Define el orden del punto en el viaje
                $object_x['orden'] = $e->orden;
                $object_x['estado'] = $e->estado;
                $object_x['tipo'] = $e->tipo;

                $subtitulo = elgg_echo('ysu:nodo');
                $object_x['info_window'] = $avatar.' <h3><a href="'.$object_x['url'].'">'.$object_x['title'].'</a></h3>';
                //$object_x['info_window'] .= ($object_x['location']?''.$object_x['location']:'');
                //$object_x['info_window'] .= ($object_x['other_info']?'<br/>'.$object_x['other_info']:'');
                $object_x['info_window'] .= ($object_x['description']?''.$object_x['description']:'');

                break;
              case 'user':
                $object_x['info_window'] = $avatar.' <h3><a href="'.$object_x['url'].'">'.$object_x['title'].'</a></h3>';
                $object_x['info_window'] .= ($object_x['location']?''.$object_x['location']:'');
                //$object_x['info_window'] .= ($object_x['other_info']?'<br/>'.$object_x['other_info']:'');
                $object_x['info_window'] .= ($object_x['description']?'<br/>'.$object_x['description']:'');
                break;
              case 'objectevent':

                $event_start = $e->getStartTimestamp();

                $icon = "<div class='event_manager_event_list_icon' title='" . event_manager_format_date($event_start) . "'>";
                $icon .= "<div class='event_manager_event_list_icon_month'>" . strtoupper(trim(elgg_echo('date:month:short:' . date("m", $event_start), ['']))) . "</div>";
                $icon .= "<div class='event_manager_event_list_icon_day'>" . date("d", $event_start) . "</div>";
                $icon .= "</div>";

                $object_x['info_window'] = $icon;
                $object_x['info_window'] .= $e->event_type;
                $object_x['info_window'] .= '<h3><a href="'.$object_x['url'].'">'.$e->title.'</a></h3>';
                $object_x['info_window'] .= ($object_x['location']?''.$object_x['location']:'');
                //$object_x['info_window'] .= ($object_x['other_info']?'<br/>'.$object_x['other_info']:'');
                //$object_x['info_window'] .= ($object_x['description']?'<br/>'.$object_x['description']:'');
                break;
            }




            array_push($map_objects, $object_x);
        }
    }

    $sidebar = '';
    if (amap_ma_check_if_add_sidebar_list('groupsmap')) {
        $box_color_flag = true;
        foreach ($entities as $entity) {
            $sidebar .= elgg_view('groupsmap/sidebar', array('entity' => $entity, 'box_color' => ($box_color_flag ? 'box_even' : 'box_odd')));
            $box_color_flag = !$box_color_flag;
        }
    }
}
else {
    $content = elgg_echo('amap_maps_api:search:personalized:empty');
}

$result = array(
    'error' => false,
    'title' => $title,
    'location' => $search_location_txt,
    'radius' => $search_radius_txt,
    's_radius' => amap_ma_get_default_radius_search($s_radius, true),
    's_radius_no' => $s_radius,
    'content' => $content,
    'map_objects' => json_encode($map_objects),
    's_location_lat' => ($s_lat? $s_lat: ''),
    's_location_lng' => ($s_long? $s_long: ''),
    's_location_txt' => $search_location_txt,
    'sidebar' => $sidebar,
);

// release variables
unset($entities);
unset($map_objects);

echo json_encode($result);
exit;
