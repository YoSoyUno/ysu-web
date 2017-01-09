<?php
/**
 * Elgg News plugin
 * @package amapnews
 */

$object = $vars['item']->getObjectEntity();
$excerpt = elgg_get_excerpt($object->excerpt);

echo elgg_view('river/elements/layout-news', array(
    'item' => $vars['item'],
    'message' => $excerpt,
    'item_class' => 'xxx'
    //'attachments' => elgg_view('output/url', array('href' => $object->address)),
));
