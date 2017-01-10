<?php
/**
 * Elgg News plugin
 * @package amapnews
 */

$object = $vars['item']->getObjectEntity();
$excerpt = elgg_get_excerpt($object->excerpt);

echo elgg_view('river/elements/layout-event', array(
    'item' => $vars['item'],
    'message' => $excerpt
    //'attachments' => elgg_view('output/url', array('href' => $object->address)),
));
