<?php
/**
 * Elgg custom index page
 * 
 */


$list_params = array(
	'type' => 'object',
	'limit' => 4,
	'full_view' => false,
	'list_type_toggle' => false,
	'pagination' => false,
);

//grab the latest 4 blog posts
$list_params['subtype'] = 'blog';
$blogs = elgg_list_entities($list_params);


//get the newest members who have an avatar
$newest_members = elgg_list_entities_from_metadata(array(
	'metadata_names' => 'icontime',
	'type' => 'user',
	'limit' => 10,
	'full_view' => false,
	'pagination' => false,
	'list_type' => 'gallery',
	'gallery_class' => 'elgg-gallery-users',
	'size' => 'small',
));

//newest groups
$list_params['type'] = 'group';
unset($list_params['subtype']);
$groups = elgg_list_entities($list_params);

//grab the login form
$login = elgg_view("core/account/login_box");

// create the registration url - including switching to https if configured
$register_url = elgg_get_site_url() . 'action/register';
if (elgg_get_config('https_login')) {
	$register_url = str_replace("http:", "https:", $register_url);
}
$form_params = array(
	'action' => $register_url,
	'class' => 'elgg-form-account',
);

$register = elgg_view_form('register', $form_params);


// lay out the content
$params = array(
	'blogs' => $blogs,
	'groups' => $groups,
	'login' => $login,
	'register' => $register,
	'members' => $newest_members,
);
$body = elgg_view_layout('landing_page', $params);

echo elgg_view_page('', $body);
