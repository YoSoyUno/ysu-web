<?php
/**
 * Elgg icons
 *
 * @package Elgg.Core
 * @subpackage UI
 */

?>
/* <style> /**/

/* ***************************************
	ICONS
*************************************** */
.elgg-avatar > .elgg-icon-hover-menu {
	display: none;
	position: absolute;
	right: 0;
	bottom: 0;
	margin: 0;
	cursor: pointer;
}

.elgg-ajax-loader {
	background: #FFF url(<?= elgg_get_simplecache_url("ajax_loader_bw.gif"); ?>) no-repeat center center;
	min-height: 31px;
	min-width: 31px;
}

/* ***************************************
	AVATAR ICONS
*************************************** */
.elgg-avatar {
	position: relative;
	display: inline-block;
}
.elgg-avatar > a > img {
	display: block;
	width: 24px;
	float: left;
	border-radius: 50%;
  box-shadow: rgba(240, 239, 237, 0.77) 0px 0px 10px;
	margin: -2px;
}
.elgg-avatar-tiny > a > img {
	width: 25px;
	height: 25px;

	border-radius: 50%;

	background-clip:  border;
	background-size: 25px;
}
.elgg-avatar-small > a > img {
	width: 40px;
	height: 40px;

	/* remove the border-radius if you don't want rounded avatars in supported browsers */
	border-radius: 50%;

	background-clip:  border;
	background-size: 40px;
}
.elgg-avatar-medium > a > img {
	width: 100px;
	height: 100px;
}
.elgg-avatar-large {
	width: 100%;
}
.elgg-avatar-large > a > img {
	width: 100%;
	height: auto;
}
.elgg-state-banned {
	opacity: 0.5;
}
