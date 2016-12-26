<?php
/**
 * Upload and crop an cover page
 */

// Only logged in users
elgg_gatekeeper();

elgg_push_context('settings');
elgg_push_context('profile_edit');

$title = elgg_echo('cover:edit');

$entity = elgg_get_page_owner_entity();
if (!elgg_instanceof($entity, 'user') || !$entity->canEdit()) {
	register_error(elgg_echo('cover:noaccess'));
	forward(REFERER);
}

$content = elgg_view('cover/upload', array('entity' => $entity));

//only offer the crop view if an cover has been uploaded
if (isset($entity->covertime)) {
	$content .= elgg_view('cover/crop', array('entity' => $entity));
}

$content .= '<style type="text/css">
.elgg-main {
  background-color: #fff
}
</style>';

$params = array(
	'content' => $content,
	'title' => $title,
);
$body = elgg_view_layout('one_column', $params);

echo elgg_view_page($title, $body);
