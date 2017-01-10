<?php
/**
* Layout of a river item
 *
 * @uses $vars['item'] ElggRiverItem
 */
// include(elgg_get_plugins_path() . 'event_manager/lib/functions.php');

$item = $vars['item'];

// echo elgg_view('page/components/image_block', array(
// 	'image' => elgg_view('river/elements/image', $vars),
// 	'body' => elgg_view('river/elements/body', $vars),
// 	'class' => 'elgg-river-item-news',
// ));

$item = $vars['item'];
$object = $item->getObjectEntity();
// print_r($item);
/* @var ElggRiverItem $item */

elgg_unregister_menu_item('river', 'delete');

$menu = elgg_view_menu('river', array(
	'item' => $item,
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));

// river item header
$timestamp = elgg_view_friendly_time($item->getTimePosted());

$summary = elgg_extract('summary', $vars);
if ($summary === null) {
	$summary = elgg_view('river/elements/summary', array(
		'item' => $vars['item'],
	));
}

if ($summary === false) {
	$subject = $item->getSubjectEntity();
	$summary = elgg_view('output/url', array(
		'href' => $subject->getURL(),
		'text' => $subject->name,
		'class' => 'elgg-river-subject',
		'is_trusted' => true,
	));
}

$message = elgg_extract('message', $vars);
if ($message !== null) {
	$message = "<div class=\"elgg-river-message\">$message</div>";
}

$attachments = elgg_extract('attachments', $vars);
if ($attachments !== null) {
	$attachments = "<div class=\"elgg-river-attachments clearfix\">$attachments</div>";
}

$responses = elgg_view('river/elements/responses', $vars);
if ($item->annotation_id == 0 && $object->canComment() && $responses) {
	$responses = "<div class=\"elgg-river-responses\">$responses</div>";
}
else{
	$responses = "<div class=\"elgg-river-responses\"></div>";
}


$group_string = '';
$container = $object->getContainerEntity();
if ($container instanceof ElggGroup && $container->guid != elgg_get_page_owner_guid()) {
	$group_link = elgg_view('output/url', array(
		'href' => $container->getURL(),
		'text' => $container->name,
		'is_trusted' => true,
	));
	$group_string = elgg_echo('river:ingroup', array($group_link));
}

if ($object->getIconURL('event_banner')) {
	$banner_image = $object->getIconURL('event_banner');
} else {
}

$banner_image = str_replace(' ', '%20', "https://maps.googleapis.com/maps/api/staticmap?center={$object->location}&zoom=4&scale=false&size=460x400&maptype=satellite&format=png&visual_refresh=true&markers=size:mid%7Ccolor:0xff0000%7Clabel:%7C{$object->location}");


$event_start = $object->getStartTimestamp();
$event_end = $object->getEndTimestamp();

// $when_title = elgg_echo('date:weekday:' . gmdate('w', $event_start)) . ', ';
$when_title = gmdate('j', $event_start) . '/';
$when_title .= gmdate('m', $event_start) . ' ';
// $when_title .= gmdate('Y', $event_start);


$banner = "<div><a href='{$object->getURL()}' class='river-item-banner' style='background-image: url(\"{$banner_image}\")'><header><span>{$when_title} - <i>{$object->location}</i></span><h1>$object->title</h1></header></a></div>";

// echo <<<RIVER
// <div class="elgg-river-summary">$summary $group_string <span class="elgg-river-timestamp">$timestamp</span></div>
// $image
// $message
// $attachments
// $menu
// $responses
// RIVER;

echo <<<RIVER
$banner
RIVER;
