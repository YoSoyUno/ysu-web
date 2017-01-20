<?php

require_once(dirname(__FILE__) . '/lib/functions.php');

/**
 * Init function for this plugin
 *
 * @return void
 */
 // register default elgg events
elgg_register_event_handler('init', 'system', 'ysu_customizations_init');

 // Register a handler for create groups
elgg_register_event_handler('create', 'group', 'groups_create_event_tools');

function ysu_customizations_init() {
	elgg_extend_view('css/elgg', 'css/ysu_customizations.css');
}

function groups_create_event_tools($event, $object_type, $object) {

	$tipo_punto = $object->tipo;

	switch ($tipo_punto) {
		case 'poder':
			$object->activity_enable = 'no';
			$object->tp_images_enable = 'no';
			$object->membersmap_enable = 'no';
			$object->related_groups_enable = 'no';
			$object->amapnews_enable = 'yes';
			$object->photos_enable = 'yes';
			$object->event_manager_enable = 'yes';
			break;
		case 'paso':
			$object->activity_enable = 'no';
			$object->tp_images_enable = 'no';
			$object->membersmap_enable = 'no';
			$object->related_groups_enable = 'no';
			$object->amapnews_enable = 'yes';
			$object->photos_enable = 'yes';
			$object->event_manager_enable = 'no';
			break;
		default:
			# code...
			break;
	}
}
