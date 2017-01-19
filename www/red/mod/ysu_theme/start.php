<?php
/**
 * YSU theme plugin
 *
 * @package YSU theme
 */
 require_once(dirname(__FILE__) . '/lib/functions.php');

elgg_register_event_handler('init','system','ysu_theme_init');

function ysu_theme_init() {

  // Desactiva funciones de grupo que no usamos
  remove_group_tool_option('membersmap');
  remove_group_tool_option('tp_images');
  remove_group_tool_option('activity');
  remove_group_tool_option('related_groups');

	elgg_register_event_handler('pagesetup', 'system', 'ysu_theme_pagesetup', 1000);

	// theme specific CSS
	elgg_extend_view('css/elgg', 'ysu_theme/css');
	// theme specific CSS
	//elgg_extend_view('css/elgg', 'extractability/css');
	elgg_register_css('ysu', '/mod/ysu_theme/views/default/ysu_theme/custom.css');
 	elgg_load_css('ysu');

	elgg_register_plugin_hook_handler('head', 'page', 'ysu_theme_setup_head');
	// registered with priority < 500 so other plugins can remove likes
	elgg_unregister_plugin_hook_handler('register', 'menu:river', 'likes_river_menu_setup');
	elgg_unregister_plugin_hook_handler('register', 'menu:entity', 'likes_entity_menu_setup');
	elgg_unregister_plugin_hook_handler('register', 'menu:river', '_elgg_river_menu_setup');
	elgg_unregister_plugin_hook_handler('register', 'menu:entity', '_elgg_entity_menu_setup');
	elgg_unregister_plugin_hook_handler('register', 'menu:topbar', 'messages_register_topbar');

	elgg_register_plugin_hook_handler('register', 'menu:river', '_my_elgg_river_menu_setup');
	elgg_register_plugin_hook_handler('register', 'menu:entity', '_my_elgg_entity_menu_setup');
	elgg_register_plugin_hook_handler('register', 'menu:river', 'my_likes_river_menu_setup', 401);
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'my_likes_entity_menu_setup', 401);

	elgg_unregister_widget_type('river_widget');
	//elgg_extend_view('elgg.js', 'elgg/ckeditor/set-basepath.js');
	//elgg_extend_view('elgg.js', 'lib/slidebars/slidebars.js');
	$slidebars = elgg_get_simplecache_url('lib/slidebars/slidebars.js');
  elgg_register_js('slidebars', $slidebars, 'footer');

	elgg_register_js('js_validate', elgg_get_simplecache_url('lib/jquery-validate/jquery.validate.min.js'), 'footer');
	elgg_register_js('bootstrap', elgg_get_simplecache_url('lib/landing_page/bootstrap/js/bootstrap.min.js'), 'footer');
	elgg_register_js('modernizr', elgg_get_simplecache_url('lib/landing_page/js/modernizr.custom.js'), 'footer');
	elgg_register_js('scrollTo', elgg_get_simplecache_url('lib/landing_page/js/jquery.scrollTo-1.4.3.1-min.js'), 'footer');
	elgg_register_js('parallax', elgg_get_simplecache_url('lib/landing_page/js/jquery.parallax.min.js'), 'footer');
	elgg_register_js('landing_page_startup', elgg_get_simplecache_url('lib/landing_page/js/startup-kit.js'), 'footer');
	elgg_register_js('landing_page_script', elgg_get_simplecache_url('lib/landing_page/js/script.js'), 'footer');

  // #### Efecto ink

  // Carga CSS
  elgg_register_css('ink', '/mod/ysu_theme/lib/ink/css/style.css', 'footer');
  elgg_load_css('ink');

  elgg_register_css('jquery-ui', '/mod/ysu_theme/lib/jquery-ui/jquery-ui.css', 'footer');
  elgg_load_css('jquery-ui');


  // Carga codigo CSS como vista, el cual llama luego a una accion - definida mas abajo
  elgg_register_simplecache_view('ysu_theme/ink.js');
  elgg_require_js("ysu_theme/ink");

	//elgg_register_css('font-awesome', 'mod/ysu_theme/lib/font-awesome/css/font-awesome.min.css');

	// extend js view
	 elgg_extend_view('elgg.js', "js/ysu_theme/functions.js");


	$base = elgg_get_plugins_path() . 'ysu_theme';

	// non-members do not get visible links to RSS feeds
	if (!elgg_is_logged_in()) {
		elgg_unregister_plugin_hook_handler('output:before', 'layout', 'elgg_views_add_rss_link');
	}

	// Register page handler
	elgg_unregister_page_handler('activity', 'elgg_river_page_handler');
	elgg_register_page_handler('activity', 'river_auto_update_page_handler_ysu');


	//reset action
	$action_base = elgg_get_plugins_path() . 'ysu_theme/actions';

  elgg_register_action("ysu_theme/reset", "$action_base/reset.php");

  // accion de carga de contenidos usada por efecto ink
  elgg_register_action("ysu_theme/ink", "$action_base/ink.php", 'public');


	//cover
	elgg_register_page_handler('cover', 'elgg_cover_page_handler');
	elgg_register_js('cover_cropper', 'mod/ysu_theme/lib/cover/ui.cover_cropper.js');
	elgg_register_action("cover/upload", "$action_base/cover/upload.php");
	elgg_register_action("cover/crop", "$action_base/cover/crop.php");
	elgg_register_action("cover/remove", "$action_base/cover/remove.php");
	elgg_register_plugin_hook_handler('register', 'menu:user_hover', 'elgg_user_cover_hover_menu');

	elgg_register_page_handler('', 'ysu_theme_index');

	//set default settings values
	ysu_theme_set_defaults();
}

/**
 * Serve the landing page
 *
 * @return bool Whether the page was sent.
 */
function ysu_theme_index() {
	if (!include_once(dirname(__FILE__) . "/index.php")) {
		return false;
	}

	return true;
}

function river_auto_update_page_handler_ysu($page) {
	$base = elgg_get_plugins_path() . 'ysu_theme';

	elgg_set_page_owner_guid(elgg_get_logged_in_user_guid());

	// make ajax procedure visible to the activity page
	if ($page[0] == "proc") {
		include($base."/procedures/" . $page[1] . ".php");
	}
	else {
		$page_type = elgg_extract(0, $page, 'all');
		$page_type = preg_replace('[\W]', '', $page_type);
		if ($page_type == 'owner') {
			$page_type = 'mine';
		}
		set_input('page_type', $page_type);
	}

	require_once($base."/pages/river.php");
	return true;
}

function elgg_cover_page_handler($page) {
	$base = elgg_get_plugins_path() . 'ysu_theme';

	$user = get_user_by_username($page[1]);
	if ($user) {
		elgg_set_page_owner_guid($user->getGUID());
	}

	if ($page[0] == 'edit') {
		require_once("{$base}/pages/cover/edit.php");
		return true;
	} else {
		set_input('size', $page[2]);
		require_once("{$base}/pages/cover/view.php");
		return true;
	}
	return false;
}

/**
 * Rearrange menu items
 */
function ysu_theme_pagesetup() {

	elgg_unextend_view('page/elements/sidebar', 'search/header');
	//elgg_extend_view('page/elements/topbar', 'search/header', 0);

	elgg_register_menu_item('topbar', array(
		'name' => 'sidebar',
		'id' => 'open-slidebar',
		'href' => "#",
		'text' => '<i class="sb-toggle-left fa fa-bars fa-lg"></i>',
		'priority' => 50,
		'link_class' => '',
	));

	elgg_unregister_menu_item('footer','powered');

	if (elgg_is_logged_in()) {
		$user = elgg_get_logged_in_user_entity();
		$username = $user->username;
		 if (elgg_is_active_plugin('messages')) {
			 elgg_unregister_menu_item('menu:topbar','messages');
	 		//elgg_register_plugin_hook_handler('register', 'menu:topbar', 'messages_register_topbar');
	 		$text = "<i class=\"fa fa-envelope fa-lg\"></i>";
	 		$tooltip = elgg_echo("messages");
	 		// get unread messages
	 		$num_messages = (int)messages_count_unread();
	 		if ($num_messages != 0) {
	 			$text .= "<span class=\"elgg-topbar-new\">$num_messages</span>";
	 			$tooltip .= ": ".elgg_echo("messages:unreadcount", array($num_messages));
	 		}

	 		elgg_register_menu_item('topbar', array(
	 			'name' => 'messages',
	 			'href' => "messages/inbox/$username",
	 			'text' => $text,
	 			'section' => 'alt',
	 			'priority' => 100,
	 			'title' => $tooltip,
	 		));

	 		elgg_register_menu_item('topbar', array(
	 			'href' => false,
	 			'name' => 'search',
	 			'text' => '<i class="fa fa-search fa-lg"></i>'.elgg_view('search/header'),
	 			'priority' => 0,
	 			'section' => 'alt',
	 		));
		 }

		$text = '<i class="fa fa-users fa-lg"></i>';
		$tooltip = elgg_echo("friends");
		$href = "/friends/".$username;
		if (elgg_is_active_plugin('friend_request')) {
			elgg_unregister_menu_item('topbar', 'friend_request');
			$options = array(
				"type" => "user",
				"count" => true,
				"relationship" => "friendrequest",
				"relationship_guid" => $user->getGUID(),
				"inverse_relationship" => true
			);

			$count = elgg_get_entities_from_relationship($options);
			if (!empty($count)) {
				$text .= "<span class=\"elgg-topbar-new\">$count</span>";
				$tooltip = elgg_echo("friend_request:menu").": ".$count;
				$href = "friend_request/" . $username;
			}
		}

		elgg_unregister_menu_item('topbar', 'friends');

		// elgg_register_menu_item('topbar', array(
		// 	'href' => $href,
		// 	'name' => 'friends',
		// 	'text' =>  $text,
		// 	'section' => 'alt',
		// 	'priority' => 200,
		// 	'title' => $tooltip,
		// ));

		$viewer = elgg_get_logged_in_user_entity();
		elgg_unregister_menu_item('topbar', 'profile');
		elgg_register_menu_item('topbar', array(
			'name' => 'profile',
			'href' => $viewer->getURL(),
			'title' => $viewer->name,
			'text' => elgg_view('output/img', array(
				'src' => $viewer->getIconURL('small'),
				'alt' => $viewer->name,
				'title' => $viewer->name,
				'class' => 'elgg-border-plain elgg-transition',
			)).'<span class="profile-text">'.elgg_get_excerpt($viewer->name, 20).'</span>',
			'priority' => 500,
			'link_class' => 'elgg-topbar-avatar',
			'item_class' => 'elgg-avatar elgg-avatar-topbar',
		));

    // Boton de donar
		elgg_register_menu_item('topbar', array(
			'name' => 'donate',
			'text' => '<i class="fa fa-heart fa-lg"></i> ',
			'href' => "#",
			'priority' => 90,
      'title' => 'Dona ahora',
      'data-target' => 'ysu_settings_donar',
      'class' => 'cd-modal-trigger',
			'section' => 'alt'
		));

		elgg_register_menu_item('topbar', array(
			'name' => 'account',
			'text' => '<i class="fa fa-cog fa-lg"></i> ',
			'href' => "#",
			'priority' => 300,
			'section' => 'alt',
			'link_class' => 'elgg-topbar-dropdown',
		));

		if (elgg_is_active_plugin('dashboard')) {
			$item = elgg_unregister_menu_item('topbar', 'dashboard');
			if ($item) {
				$item->setText(elgg_echo('dashboard'));
				$item->setSection('default');
				elgg_register_menu_item('site', $item);
			}
		}

		$item = elgg_unregister_menu_item('extras', 'bookmark');
		if ($item) {
			$item->setText('<i class="fa fa-bookmark fa-lg"></i>');
			elgg_register_menu_item('extras', $item);
		}

	  elgg_unregister_menu_item('extras', 'rss');

		$url = elgg_format_url($url);
		elgg_register_menu_item('extras', array(
			'name' => 'rss',
			'text' => '<i class="fa fa-rss fa-lg"></i>',
			'href' => $url,
			'title' => elgg_echo('feed:rss'),
		));

		$item = elgg_get_menu_item('topbar', 'usersettings');
		if ($item) {
			$item->setParentName('account');
			$item->setText(elgg_echo('settings'));
			$item->setPriority(103);
		}

		$item = elgg_get_menu_item('topbar', 'logout');
		if ($item) {
			$item->setParentName('account');
			$item->setText(elgg_echo('logout'));
			$item->setPriority(104);
		}

		$item = elgg_get_menu_item('topbar', 'administration');
		if ($item) {
			$item->setParentName('account');
			$item->setText(elgg_echo('admin'));
			$item->setPriority(101);
		}

		if (elgg_is_active_plugin('site_notifications')) {
			$item = elgg_get_menu_item('topbar', 'site_notifications');
			if ($item) {
				$item->setParentName('account');
				$item->setText(elgg_echo('site_notifications:topbar'));
				$item->setPriority(102);
			}
		}

		if (elgg_is_active_plugin('reportedcontent')) {
			$item = elgg_unregister_menu_item('footer', 'report_this');
			if ($item) {
				$item->setText('<i class="fa fa-flag fa-lg"></i>');
				$item->setPriority(500);
				$item->setSection('default');
				elgg_register_menu_item('extras', $item);
			}
		}

		elgg_register_menu_item('page', array(
			'name' => 'edit_cover',
			'href' => "cover/edit/{$username}",
			'text' => elgg_echo('cover:edit'),
			'section' => '1_profile',
			'contexts' => array('settings'),
		));

	}
	else{
		if (elgg_get_context()=='main')
			$href= "#login";
		else
			$href= "/#login";

			elgg_register_menu_item('topbar', array(
				'name' => 'login',
				'text' => elgg_echo('login'),
				'href' => '#',
				'priority' => 90,
				'section' => 'alt',
        'data-target' => 'modal-login',
				'class' => 'btn btn-info elgg-button elgg-button-submit go-login cd-btn cd-modal-trigger'
			));
	}
}

/**
 * Register items for the html head
 *
 * @param string $hook Hook name ('head')
 * @param string $type Hook type ('page')
 * @param array  $data Array of items for head
 * @return array
 */
function ysu_theme_setup_head($hook, $type, $data) {
	$data['metas']['viewport'] = array(
		'name' => 'viewport',
		'content' => 'width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no',
	);

	$data['links']['apple-touch-icon'] = array(
		'rel' => 'apple-touch-icon',
		'href' => elgg_normalize_url('mod/ysu_theme/graphics/favicon/favicon-128.png'),
	);

	// favicons
	$data['links']['icon-ico'] = array(
		'rel' => 'icon',
		'href' => elgg_normalize_url('mod/ysu_theme/graphics/favicon/favicon.ico'),
	);
	$data['links']['icon-vector'] = array(
		'rel' => 'icon',
		'sizes' => '16x16 32x32 48x48 64x64 128x128',
		'type' => 'image/svg+xml',
		'href' => elgg_normalize_url('mod/ysu_theme/graphics/favicon/favicon.svg'),
	);
	$data['links']['icon-16'] = array(
		'rel' => 'icon',
		'sizes' => '16x16',
		'type' => 'image/png',
		'href' => elgg_normalize_url('mod/ysu_theme/graphics/favicon/favicon-16.png'),
	);
	$data['links']['icon-32'] = array(
		'rel' => 'icon',
		'sizes' => '32x32',
		'type' => 'image/png',
		'href' => elgg_normalize_url('mod/ysu_theme/graphics/favicon/favicon-32.png'),
	);
	$data['links']['icon-64'] = array(
		'rel' => 'icon',
		'sizes' => '64x64',
		'type' => 'image/png',
		'href' => elgg_normalize_url('mod/ysu_theme/graphics/favicon/favicon-64.png'),
	);
	$data['links']['icon-128'] = array(
		'rel' => 'icon',
		'sizes' => '128x128',
		'type' => 'image/png',
		'href' => elgg_normalize_url('mod/ysu_theme/graphics/favicon/favicon-128.png'),
	);

	return $data;
}

function ysu_theme_reset_settings($url, $object){
	elgg_set_plugin_setting('topbar_background_color', '#000000','ysu_theme');
	elgg_set_plugin_setting('topbar_a_color', '#dcdcdc','ysu_theme');
	elgg_set_plugin_setting('content_background_color', '#f2f2f2','ysu_theme');
	elgg_set_plugin_setting('content_font_color', '#000000','ysu_theme');
	elgg_set_plugin_setting('content_a_color', '#e95725','ysu_theme');
	elgg_set_plugin_setting('content_button_color', '#50c28c','ysu_theme');
	elgg_set_plugin_setting('background_type', 'imagen','ysu_theme');
	elgg_set_plugin_setting('extractability', 'all','ysu_theme');
	elgg_set_plugin_setting('slidebar_background_color','#222222','ysu_theme');
	elgg_set_plugin_setting('slidebar_a_color','#ffffff','ysu_theme');
}

function ysu_theme_set_defaults(){
	$c1 = elgg_get_plugin_setting('topbar_background_color', 'ysu_theme');
	$c2 = elgg_get_plugin_setting('topbar_a_color', 'ysu_theme');
	$c3 = elgg_get_plugin_setting('content_background_color', 'ysu_theme');
	$c4 = elgg_get_plugin_setting('content_font_color', 'ysu_theme');
	$c5 = elgg_get_plugin_setting('content_a_color', 'ysu_theme');
	$c6 = elgg_get_plugin_setting('content_button_color', 'ysu_theme');
	$c7 = elgg_get_plugin_setting('background_type', 'ysu_theme');
	$c8 = elgg_get_plugin_setting('extractability', 'ysu_theme');

	if($c1=="" && $c2=="" && $c3=="" && $c4=="" && $c5=="" && $c6=="" && $c7=="")
		ysu_theme_reset_settings();

}

function extractability($url, $object){
	$excerpt = null;
	$config = elgg_get_plugin_setting('extractability', 'ysu_theme');
	if($config!='disabled'){
		$api_key = "30f3da72547b708b42bf3c2c2a02cdc00fbf0f2b";
		$wp_annotations = $object->getAnnotations(array(
				  'annotation_name' => 'web_scraper',
				  'limit' => 1
				  ));

		if(count($wp_annotations)==0){
			$scraper_json = file_get_contents("http://extractability.fernandovega.mx/method/get.json?api_key=".$api_key."&url=".$url);
			$scraper = json_decode($scraper_json);
			if($scraper->status=="success"){
				$object->annotate('web_scraper', $scraper_json , $object->access_id);
				if($scraper->type=="oembed" && ($config=='oembed' || $config=='all'))
					$excerpt = $scraper->object_html;
				else if($config=='information' || $config=='all')
					$excerpt = elgg_view('extractability/web', array('extractability'=>$scraper));
			}
		}
		else if(count($wp_annotations)>0){
			$scraper = $wp_annotations[0];
			$scraper = json_decode($scraper->value);
			if($scraper->type=="oembed" && ($config=='oembed' || $config=='all'))
				$excerpt = $scraper->object_html;
			else if($config=='information' || $config=='all')
				$excerpt = elgg_view('extractability/web', array('extractability'=>$scraper));
		}
	}

	return $excerpt;
}


/**
 * Add likes to entity menu at end of the menu
 */
function my_likes_entity_menu_setup($hook, $type, $return, $params) {
	if (elgg_in_context('widgets')) {
		return $return;
	}

	/* @var ElggEntity $entity */
	if ( 	elgg_is_active_plugin('likes')) {
		$entity = $params['entity'];
		if ($entity->canAnnotate(0, 'likes')) {
			$hasLiked = \Elgg\Likes\DataService::instance()->currentUserLikesEntity($entity->guid);

			// Always register both. That makes it super easy to toggle with javascript
			$return[] = ElggMenuItem::factory(array(
				'name' => 'likes',
				'href' => elgg_add_action_tokens_to_url("/action/likes/add?guid={$entity->guid}"),
				'text' => '<i class="fa fa-thumbs-o-up fa-lg"></i>',
				'title' => elgg_echo('likes:likethis'),
				'item_class' => $hasLiked ? 'hidden' : '',
				'priority' => 100,
			));

			$return[] = ElggMenuItem::factory(array(
				'name' => 'unlike',
				'href' => elgg_add_action_tokens_to_url("/action/likes/delete?guid={$entity->guid}"),
				'text' => '<i class="fa  fa-thumbs-up fa-lg" style="color:#50C28C"></i>',
				'title' => elgg_echo('likes:remove'),
				'item_class' => $hasLiked ? '' : 'hidden',
				'priority' => 100,
			));
		}

		// likes count
		$count = elgg_view('likes/count', array('entity' => $entity));
		if ($count) {
			$options = array(
				'name' => 'likes_count',
				'text' => $count,
				'href' => false,
				'priority' => 101,
			);
			$return[] = ElggMenuItem::factory($options);
		}

		return $return;

	}
}

/**
 * Add a like button to river actions
 */
function my_likes_river_menu_setup($hook, $type, $return, $params) {
	if (!elgg_is_logged_in() || elgg_in_context('widgets')) {
		return;
	}

	$item = $params['item'];
	/* @var ElggRiverItem $item */

	// only like group creation #3958
	if ($item->type == "group" && $item->view != "river/group/create") {
		return;
	}

	// don't like users #4116
	if ($item->type == "user") {
		return;
	}

	if ($item->annotation_id != 0) {
		return;
	}

	$object = $item->getObjectEntity();
	if (!$object || !$object->canAnnotate(0, 'likes')) {
		return;
	}
	if ( 	elgg_is_active_plugin('likes')) {
		$hasLiked = \Elgg\Likes\DataService::instance()->currentUserLikesEntity($object->guid);
	}

	// Always register both. That makes it super easy to toggle with javascript
	$return[] = ElggMenuItem::factory(array(
		'name' => 'likes',
		'href' => elgg_add_action_tokens_to_url("/action/likes/add?guid={$object->guid}"),
		'text' => '<i class="fa fa-thumbs-o-up fa-lg"></i>',
		'title' => elgg_echo('likes:likethis'),
		'item_class' => $hasLiked ? 'hidden' : '',
		'priority' => 100,
	));
	$return[] = ElggMenuItem::factory(array(
		'name' => 'unlike',
		'href' => elgg_add_action_tokens_to_url("/action/likes/delete?guid={$object->guid}"),
		'text' => '<i class="fa  fa-thumbs-up fa-lg" style="color:#50C28C"></i>',
		'title' => elgg_echo('likes:remove'),
		'item_class' => $hasLiked ? '' : 'hidden',
		'priority' => 100,
	));

	// likes count
	$count = elgg_view('likes/count', array('entity' => $object));
	if ($count) {
		$return[] = ElggMenuItem::factory(array(
			'name' => 'likes_count',
			'text' => $count,
			'href' => false,
			'priority' => 101,
		));
	}

	return $return;
}

/**
 * Add the comment and like links to river actions menu
 * @access private
 */
function _my_elgg_river_menu_setup($hook, $type, $return, $params) {
	if (elgg_is_logged_in()) {
		$item = $params['item'];
		/* @var \ElggRiverItem $item */
		$object = $item->getObjectEntity();
    $owner = $object->getOwnerEntity();

		// add comment link but annotations cannot be commented on
		if ($item->annotation_id == 0) {
			if ($object->canComment()) {
				$options = array(
					'name' => 'comment',
					'href' => "#comments-add-$object->guid",
					'text' => '<i class="fa fa-comment-o fa-lg"></i>',
					'title' => elgg_echo('comment:this'),
					'rel' => 'toggle',
					'priority' => 200,
				);
				$return[] = \ElggMenuItem::factory($options);
			}
		}

		if (elgg_is_admin_logged_in()) {
			$options = array(
				'name' => 'delete',
				'href' => elgg_add_action_tokens_to_url("action/river/delete?id=$item->id"),
				'text' => '<i class="fa fa-trash-o fa-lg"></i>',
				'title' => elgg_echo('river:delete'),
				'confirm' => elgg_echo('deleteconfirm'),
				'priority' => 300,
				'item_class' => 'align-right',
			);
			$return[] = \ElggMenuItem::factory($options);
		}


    // Agrega boton par reportar mensajes usuarios desde el river
    if ($object->getSubtype() == 'thewire' || $object->getSubtype() == 'comment') {

      $href = elgg_http_add_url_query_elements('reportedcontent/add', [
    		'address' => $object->getURL(),
    		'title' => elgg_echo('reportedcontent:this:content:text') . $owner->getDisplayName(),
    	]);

    	$return[] = \ElggMenuItem::factory([
    		'name' => 'reportuser',
    		'title' => elgg_echo('reportedcontent:this:content:tooltip'),
        'text' => elgg_view_icon('report-this'),
    		'href' => $href,
    		'section' => 'action',
    		'link_class' => 'elgg-lightbox',
    		'deps' => 'elgg/reportedcontent',
    	]);


      // $options = array(
      //   'name' => 'report_this',
      //   'href' => "/reportedcontent/add?address=/{$object->getSubtype()}/thread/{$object->getGUID()}",
      //   'text' => '<i class="fa fa-flag fa-lg"></i>',
      //   'title' => elgg_echo('reportedcontent:this:tooltip'),
      //   'priority' => 300,
      //   'item_class' => 'align-right',
      // );
      // $return[] = \ElggMenuItem::factory($options);
    }


	}

	return $return;
}


/**
 * Entity menu is list of links and info on any entity
 * @access private
 */
function _my_elgg_entity_menu_setup($hook, $type, $return, $params) {
	if (elgg_in_context('widgets')) {
		return $return;
	}

	$entity = $params['entity'];
	/* @var \ElggEntity $entity */
	$handler = elgg_extract('handler', $params, false);

	// access
	if (elgg_is_logged_in()) {
		$access = elgg_view('output/access', array('entity' => $entity));
		$options = array(
			'name' => 'access',
			'text' => $access,
			'href' => false,
			'priority' => 100,
		);
		$return[] = \ElggMenuItem::factory($options);
	}

	if ($entity->canEdit() && $handler) {
		// edit link
		$options = array(
			'name' => 'edit',
			'text' => '<i class="fa fa-edit fa-lg"></i>',
			'title' => elgg_echo('edit:this'),
			'href' => "$handler/edit/{$entity->getGUID()}",
			'priority' => 200,
		);
		$return[] = \ElggMenuItem::factory($options);

		// delete link
		$options = array(
			'name' => 'delete',
			'text' => '<i class="fa fa-trash-o fa-lg"></i>',
			'title' => elgg_echo('delete:this'),
			'href' => "action/$handler/delete?guid={$entity->getGUID()}",
			'confirm' => elgg_echo('deleteconfirm'),
			'priority' => 300,
		);
		$return[] = \ElggMenuItem::factory($options);
	}

	return $return;
}

function elgg_user_cover_hover_menu($hook, $type, $return, $params) {
	$user = $params['entity'];
	/* @var \ElggUser $user */

	if (elgg_is_logged_in()) {
		if (elgg_get_logged_in_user_guid() == $user->guid) {
			$url = "cover/edit/$user->username";
			$item = new \ElggMenuItem('cover:edit', elgg_echo('cover:edit'), $url);
			$item->setSection('action');
			$return[] = $item;
		}
	}

	return $return;
}

global $CONFIG;

if (!isset($CONFIG->cover_sizes)) {
	$cover_sizes = array(
				'topbar' => array('w' => 320, 'h' => 95, 'square' => FALSE, 'upscale' => FALSE),
				'tiny' => array('w' => 900, 'h' => 200, 'square' => FALSE, 'upscale' => FALSE),
				'small' => array('w' => 320, 'h' => 180, 'square' => FALSE, 'upscale' => FALSE),
				'medium' => array('w' => 400, 'h' => 200, 'square' => FALSE, 'upscale' => FALSE),
				'large' => array('w' => 1000, 'h' => 400, 'square' => FALSE, 'upscale' => FALSE),
				'master' => array('w' => 1000, 'h' => 990, 'square' => FALSE, 'upscale' => FALSE),
			  );
	elgg_set_config('cover_sizes', $cover_sizes);
}

function getCoverIconUrl($size) {

	//$size = elgg_strtolower($size);
	$owner = elgg_get_page_owner_entity();
	//$user_guid = $user->
	$icon_time = $owner->covertime;
	// Get the size
	//$size = strtolower(get_input('size'));
	if (!in_array($size, array('master', 'large', 'medium', 'small', 'tiny', 'topbar'))) {
		$size = 'medium';
	}

	// If user exist, return default icon
	if ($icon_time) {
    $uploaded_url = "cover/view/$owner->username/$size/$icon_time";
    return elgg_normalize_url($uploaded_url);
	}
	else{
	  $default_url = "mod/ysu_theme/graphics/cover/$size.jpg";

		return elgg_normalize_url($default_url);
	}
}
