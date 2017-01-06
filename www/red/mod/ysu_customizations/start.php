<?php

require_once(dirname(__FILE__) . '/lib/functions.php');

/**
 * Init function for this plugin
 *
 * @return void
 */
function ysu_customizations_init() {
	elgg_extend_view('css/elgg', 'css/ysu_customizations.css');
}

// register default elgg events
elgg_register_event_handler('init', 'system', 'ysu_customizations_init');
