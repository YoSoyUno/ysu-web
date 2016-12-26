<?php
/**
 * Profile owner block
 */

$user = elgg_get_page_owner_entity();

if (!$user) {
	// no user so we quit view
	echo elgg_echo('viewfailure', array(__FILE__));
	return TRUE;
}

$icon = elgg_view_entity_icon($user, 'large', array(
	'use_hover' => false,
	'href' => $user->getIconURL('master'),
	'alt' => $user->name,
	'title' => $user->name,
	'link_class' => 'elgg-lightbox-photo',
	'img_class' => 'photo u-photo',
));

// grab the actions and admin menu items from user hover
$menu = elgg_trigger_plugin_hook('register', "menu:user_hover", array('entity' => $user), array());
$builder = new ElggMenuBuilder($menu);
$menu = $builder->getMenu();
$menu = elgg_trigger_plugin_hook('prepare', "menu:user_hover", array(
	'menu' => $menu,
	'entity' => $user,
	'username' => $user->username,
	'name' => 'user_hover',
), $menu);

$actions = elgg_extract('action', $menu, array());
$admin = elgg_extract('admin', $menu, array());

$profile_actions = '';
if (elgg_is_logged_in() && $actions) {
	$profile_actions = '<ul class="elgg-menu profile-action-menu mvm">';
	foreach ($actions as $action) {
		$item = elgg_view_menu_item($action, array('class' => 'elgg-action-a'));
		$profile_actions .= "<li class=\"{$action->getItemClass()}\">$item</li>";
	}
	$profile_actions .= '</ul>';
}

$nombre = strtoupper($user->name);
echo <<<HTML

<div id="profile-owner-block">
	$icon
</div>
<div class="elgg-profile-name">
	<span class="nickname p-nickname">YOSOY</span>
	<h2 class="p-name fn">$nombre</h2>
</div>
<div id="elgg-profile-config">
	<a href="#config" id="profile-config-botom"><i class="fa fa-2x fa-ellipsis-v"></i></a>
	<div id="elgg-profile-actions">
		$profile_actions
	</div>
</div>

HTML;
