<?php
/**
 * Group event manager module
 */

$group = elgg_get_page_owner_entity();

$entities = elgg_extract('entities', $vars);



if ($group->event_manager_enable == 'no') {
	return true;
}

$event_options = [
	'container_guid' => elgg_get_page_owner_guid(),
];

$events = event_manager_search_events($event_options);


// Reordena el listado de eventos para mostrar los eventos principales arriba
$i=0;
$entities = $events['entities'];
$entities_ysu = array();
foreach ($events['entities'] as $x) {
		if ($x->event_type == 'Activacion YSU') {
			$object = $events['entities'][$i];
			array_push($entities_ysu,$object);
			unset($entities[$i]);
		}
	$i++;
}

$entities_final = array_merge($entities_ysu,$entities);

elgg_push_context('widgets');
$content = elgg_view_entity_list($entities_final, [
	'count' => 0,
	'offset' => 0,
	'limit' => 5,
	'full_view' => false,
	'no_results' => elgg_echo('event_manager:list:noresults'),
]);


elgg_pop_context();

$all_link = elgg_view('output/url', [
	'href' => '/events/event/list/' . $group->getGUID(),
	'text' => elgg_echo('link:view:all'),
]);

$new_link = elgg_view('output/url', [
	'href' => '/events/event/new/' . $group->getGUID(),
	'text' => elgg_echo('event_manager:menu:new_event'),
]);

echo elgg_view('groups/profile/module', [
	'title' => elgg_echo('event_manager:group'),
	'content' => $content,
	'all_link' => $all_link,
	'add_link' => $new_link,
]);
