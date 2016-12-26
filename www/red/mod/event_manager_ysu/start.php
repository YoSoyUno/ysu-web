<?php

require_once(dirname(__FILE__) . '/lib/functions.php');

/**
 * Init function for this plugin
 *
 * @return void
 */
function event_manager_ysu_init() {
	elgg_extend_view('css/elgg', 'css/event_manager_ysu.css');
}

// register default elgg events
	elgg_register_event_handler('init', 'system', 'event_manager_ysu_init');
