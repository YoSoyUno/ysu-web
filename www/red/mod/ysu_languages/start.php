<?php

/**
 * Init function for this plugin
 *
 * @return void
 */
function ysu_languages_init() {
}

// register default elgg events
elgg_register_event_handler('init', 'system', 'ysu_languages_init');
