<?php
/**
 * Navigation
 *
 * @package Elgg.Core
 * @subpackage UI
 */
$topbar_a_color = elgg_get_plugin_setting('topbar_a_color', 'ysu_theme');
$content_button_color = elgg_get_plugin_setting('content_button_color', 'ysu_theme');
$slidebar_background_color = elgg_get_plugin_setting('slidebar_background_color', 'ysu_theme');
$slidebar_a_color = elgg_get_plugin_setting('slidebar_a_color', 'ysu_theme');
?>
/* <style> /**/

/* ***************************************
	PAGINATION
*************************************** */
.elgg-pagination {
	margin: 20px 0 10px;
	display: block;
	text-align: center;
}
.elgg-pagination li {
	display: inline;
	text-align: center;
	margin-left: -1px;
}
.elgg-pagination li:first-child a,
.elgg-pagination li:first-child span {
	border-radius: 3px 0 0 3px;
}
.elgg-pagination li:last-child a,
.elgg-pagination li:last-child span {
	border-radius: 0 3px 3px 0;
}
.elgg-pagination li:first-child a:before,
.elgg-pagination li:first-child span:before {
	content: "\ab";
	margin-right: 6px;
}
.elgg-pagination li:last-child a:after,
.elgg-pagination li:last-child span:after {
	content: "\bb";
	margin-left: 6px;
}
.elgg-pagination a,
.elgg-pagination span {
	display: inline-block;
	padding: 6px 15px;
	color: #444;
	border: 1px solid #DCDCDC;
}
.elgg-pagination a:hover {
	color: #999;
	text-decoration: none;
}
.elgg-pagination .elgg-state-disabled span {
	color: #CCC;
}
.elgg-pagination .elgg-state-selected span {
	color: #999;
}

/* ***************************************
	TABS
*************************************** */
.elgg-tabs {
	margin-bottom: 5px;
	border-bottom: 1px solid #DCDCDC;
	display: table;
	width: 100%;
}
.elgg-tabs li {
	float: left;
	border: 1px solid #DCDCDC;
	border-bottom: 0;
	background: #eee;
	margin: 0 0 0 5px;
	border-radius: 3px 3px 0 0;
}
.elgg-tabs a {
	text-decoration: none;
	display: block;
	padding: 4px 15px 6px;
	text-align: center;
	height: auto;
	color: #666;
}
.elgg-tabs a:hover {
	background: #DEDEDE;
	color: #444;
}
.elgg-tabs .elgg-state-selected {
	border-color: #DCDCDC;
	background: #FFF;
}
.elgg-tabs .elgg-state-selected a {
	position: relative;
	top: 1px;
	background: #FFF;
}

/* ***************************************
	BREADCRUMBS
*************************************** */
.elgg-breadcrumbs {
	font-size: 100%;
	font-weight: normal;
	line-height: 1.4em;
	padding: 0 10px 1px 0;
	color: #BABABA;
}
.elgg-breadcrumbs > li {
	display: inline-block;
}
.elgg-breadcrumbs > li:after {
	content: "\003E";
	padding: 0 4px;
	font-weight: normal;
}
.elgg-breadcrumbs > li > a {
	display: inline-block;
	color: #999;
}
.elgg-breadcrumbs > li > a:hover {
	color: #0054a7;
	text-decoration: underline;
}
.elgg-main .elgg-breadcrumbs {
  display: block;
  margin: 0;
  padding: 0 10px;
}

/* ***************************************
	TOPBAR MENU
*************************************** */
.elgg-menu-topbar {
	float: left;
}

.elgg-menu-topbar > li {
	float: left;
	height: 33px;
}

.elgg-menu-topbar > li > a {
	padding-top: 5px;
	color: <?php echo $topbar_a_color; ?>;
	margin: 0 6px;
	font-weight: bold
}

.elgg-menu-topbar > li > a:hover {
	color: <?php echo $content_button_color; ?>;
	text-decoration: none;
}

.elgg-menu-topbar-alt {
	float: right;
	margin-right: 10px;
	margin-top: 5px;
}

.elgg-menu-topbar .elgg-icon {
	vertical-align: middle;
	margin-top: -1px;
}

.elgg-menu-topbar > li > a.elgg-topbar-logo {
	margin-top: 0;
	padding-left: 5px;
	width: 38px;
	height: 20px;
}

.elgg-menu-topbar > li > a.elgg-topbar-avatar {
	width: 18px;
	height: 18px;
	/*padding-top: 7px;*/
}

.profile-text{
	display: block;
  margin: 3px 30px;
  width: 150px;
}

/* ***************************************
	SITE MENU
*************************************** */
.elgg-menu-site {
	float: left;
	left: 0;
	top: 0;
	position: relative;
	z-index: 1;
}
.elgg-menu-site > li {
	float: left;
}
.elgg-menu-site > li > a {
	color: <?php echo $slidebar_a_color ?>;
	padding: 14px 18px;
}

.elgg-menu-site  .elgg-more > a {
	display: none;
}

.elgg-menu-site > li > a:hover {
	text-decoration: none;
}
.elgg-menu-site > .elgg-state-selected > a,
.elgg-menu-site > li:hover > a {
	background-color: <?php echo $content_button_color; ?>;
	color: <?php echo $slidebar_a_color ?>;
}
.elgg-menu-site > li > ul {
	position: absolute;
	display: none;
	text-align: left;
	top: 47px;
	margin-left: 0;
	width: 180px;
	border-radius: 0 0 3px 3px;
	box-shadow: 1px 3px 5px rgba(0, 0, 0, 0.25);
}
.elgg-menu-site > li:hover > ul {
	display: block;
}
.elgg-menu-site-more li {
	width: 180px;
}
.elgg-menu-site-more > li > a {
	color: <?php echo $slidebar_a_color ?>;
}
.elgg-menu-site-more > li:last-child > a,
.elgg-menu-site-more > li:last-child > a:hover {
	border-radius: 3px;
}
.elgg-menu-site-more > li.elgg-state-selected > a,
.elgg-menu-site-more > li > a:hover {
	background-color: <?php echo $content_button_color; ?>;
	color: <?php echo $slidebar_a_color ?>;
}
.elgg-more {
	width: 182px;
}
.elgg-more > a {
	display: none
}
/* ***************************************
	TITLE
*************************************** */
.elgg-menu-title {
	float: right;
	margin: 20px 10px 0 0;
}
.elgg-menu-title > li {
	display: inline-block;
	margin-left: 4px;
}

/* ***************************************
	FILTER MENU
*************************************** */
.elgg-menu-filter {
	margin-bottom: 5px;
/*	margin-left: 5px;*/
	width: 100%;
}
.elgg-menu-filter > li {
	float: left;
	border-bottom: 0;
}
.elgg-menu-filter > li.elgg-state-selected a:hover {
	background: #FFFFFF;
}
.elgg-menu-filter > li > a {
	text-decoration: none;
	display: block;
	padding: 4px 5px 5px;
	text-align: left;
	height: auto;
	color: #A9A9A9;
}
.elgg-menu-filter > li > a:hover {
	color: #444;
}
.elgg-menu-filter > .elgg-state-selected {
	font-weight: bold;
}

/* ***************************************
	PAGE MENU
*************************************** */
.elgg-menu-page {
	margin-bottom: 15px;
}
.elgg-menu-page a {
	color: #444;
	display: block;
	margin: 3px 0 5px 0;
	padding: 2px 4px 2px 0;
}
.elgg-menu-page a:hover {
	color: #999;
}
.elgg-menu-page li.elgg-state-selected > a {
	color: #999;
	text-decoration: underline;
}
.elgg-menu-page .elgg-child-menu {
	display: none;
	margin-left: 15px;
}
.elgg-menu-page .elgg-state-selected > .elgg-child-menu {
	display: block;
}
.elgg-menu-page .elgg-menu-closed:before, .elgg-menu-opened:before {
	display: inline-block;
	padding-right: 4px;
}
.elgg-menu-page .elgg-menu-closed:before {
	content: "\25B8";
}
.elgg-menu-page .elgg-menu-opened:before {
	content: "\25BE";
}

/* ***************************************
	HOVER MENU
*************************************** */
.elgg-menu-hover {
	display: none;
	position: absolute;
	z-index: 10000;
	overflow: hidden;
	min-width: 180px;
	max-width: 250px;
	border: 1px solid #DEDEDE;
	background-color: #FFF;

	border-radius: 0 3px 3px 3px;
	box-shadow: 1px 3px 5px rgba(0, 0, 0, 0.25);
}
.elgg-menu-hover > li {
	border-bottom: 1px solid #ddd;
}
.elgg-menu-hover > li:last-child {
	border-bottom: none;
}
.elgg-menu-hover .elgg-heading-basic {
	display: block;
}
.elgg-menu-hover > li a {
	padding: 6px 18px;
}
.elgg-menu-hover a:hover {
	background-color: #F0F0F0;
	text-decoration: none;
}
.elgg-menu-hover-admin a {
	color: #FF0000;
}
.elgg-menu-hover-admin a:hover {
	color: #FFF;
	background-color: #FF0000;
}

/* ***************************************
	SITE FOOTER
*************************************** */
.elgg-menu-footer > li,
.elgg-menu-footer > li > a {
	display: inline-block;
	color: #000;
}

.elgg-menu-footer > li:after {
	content: "\007C";
	padding: 0 6px;
}

.elgg-menu-footer-default {
	float: right;
}

.elgg-menu-footer-alt {
	float: left;
}

.elgg-menu-footer-meta {
	float: left;
}

/* ***************************************
	GENERAL MENU
*************************************** */
.elgg-menu-general > li,
.elgg-menu-general > li > a {
	display: inline-block;
	color: #999;
}

.elgg-menu-general > li:after {
	content: "\007C";
	padding: 0 6px;
}

/* ***************************************
	ENTITY AND ANNOTATION
*************************************** */
<?php // height depends on line height/font size ?>
.elgg-menu-entity, .elgg-menu-annotation {
	  color: #aaa;
    display: block;
    float: right;
    font-size: 90%;
    height: auto;
    line-height: 16px;
    margin: 15px 0 15px -15px;
}

.elgg-menu-entity > li, .elgg-menu-annotation > li {
	margin-left: 15px;
}
.elgg-menu-entity > li > a, .elgg-menu-annotation > li > a {
	color: #AAA;
}
<?php // need to override .elgg-menu-hz ?>
.elgg-menu-entity > li > a, .elgg-menu-annotation > li > a {
	display: block;
}
.elgg-menu-entity > li > span, .elgg-menu-annotation > li > span {
	vertical-align: baseline;
}

/* ***************************************
	OWNER BLOCK
*************************************** */
.sliderbar-user-menu .elgg-menu-owner-block li a {
	display: block;
	margin: 3px 0 5px 0;
	padding: 2px 4px 2px 0;
	color: <?php echo $slidebar_a_color ?>;
}
.sliderbar-user-menu  .elgg-menu-owner-block li a:hover {
	color: <?php echo $content_button_color ?>;
}
.sliderbar-user-menu  .elgg-menu-owner-block li.elgg-state-selected > a {
	color: <?php echo $content_button_color ?>;
	text-decoration: underline;
}
.elgg-menu-owner-block li a {
	display: block;
	margin: 3px 0 5px 0;
	padding: 2px 4px 2px 0;
	color: #444;
}
.elgg-menu-owner-block li a:hover {
	color: #999;
}
.elgg-menu-owner-block li.elgg-state-selected > a {
	color: #999;
	text-decoration: underline;
}


/* ***************************************
	LONGTEXT
*************************************** */
.elgg-menu-longtext {
	float: right;
}

/* ***************************************
	RIVER
*************************************** */
.elgg-menu-river {
	color: #aaa;
  float: left;
  font-size: 90%;
  height: 16px;
  line-height: 16px;
  margin: 5px;
	border-radius: 5px;
}
.elgg-menu-river > li {
	display: inline-block;
	margin-left: 5px;
}
.elgg-menu-river > li > a {
	color: #AAA;
	height: 16px;
	margin-right: 3px;
}
<?php // need to override .elgg-menu-hz ?>
.elgg-menu-river > li > a {
	display: block;
}
.elgg-menu-river > li > span {
	vertical-align: baseline;
}

/* ***************************************
	SIDEBAR EXTRAS (rss, bookmark, etc)
*************************************** */
.elgg-menu-extras {
	margin-bottom: 15px;
}
.elgg-menu-extras li {
	padding-right: 5px;
}

/* ***************************************
	WIDGET MENU
*************************************** */
.elgg-menu-widget > li {
	position: absolute;
	top: 8px;
	display: inline-block;
	width: 18px;
	height: 18px;
}
.elgg-menu-widget > .elgg-menu-item-collapse {
	left: 10px;
}
.elgg-menu-widget > .elgg-menu-item-delete {
	right: 10px;
}
.elgg-menu-widget > .elgg-menu-item-settings {
	right: 32px;
}

/* -----------------------------------
 * Slidebars
 * Version 0..10
 * http://plugins.adchsm.me/slidebars/
 *
 * Written by Adam Smith
 * http://www.adchsm.me/
 *
 * Released under MIT License
 * http://plugins.adchsm.me/slidebars/license.txt
 *
 * -------------------
 * Slidebars CSS Index
 *
 * 001 - Box Model, Html & Body
 * 002 - Site
 * 003 - Slidebars
 * 004 - Animation
 * 005 - Helper Classes
 *
 * ----------------------------
 * 001 - Box Model, Html & Body
 */

html, body, #sb-site, .sb-site-container, .sb-slidebar {
	/* Set box model to prevent any user added margins or paddings from altering the widths or heights. */
	margin: 0;
	padding: 0;
	-webkit-box-sizing: border-box;
	   -moz-box-sizing: border-box;
	        box-sizing: border-box;
}

/* ----------
 * 002 - Site
 */

#sb-site, .sb-site-container {
	/* You may now use class .sb-site-container instead of #sb-site and use your own id. However please make sure you don't set any of the following styles any differently on your id. */
	width: 100%;
	position: relative;
	z-index: 1; /* Site sits above Slidebars */
}

/* ---------------
 * 003 - Slidebars
 */

.sb-slidebar {
	height: 100%;
	overflow-y: auto; /* Enable vertical scrolling on Slidebars when needed. */
	position: fixed;
	top: 0;
	z-index: 0; /* Slidebars sit behind sb-site. */
	display: none; /* Initially hide the Slidebars. Changed from visibility to display to allow -webkit-overflow-scrolling. */
	-webkit-transform: translate(0px); /* Fixes issues with translated and z-indexed elements on iOS 7. */
	background-color: <?php echo $slidebar_background_color ?>;
}

.sb-left {
	left: 0; /* Set Slidebar to the left. */
}

.sb-right {
	right: 0; /* Set Slidebar to the right. */
}

html.sb-static .sb-slidebar,
.sb-slidebar.sb-static {
	position: absolute; /* Makes Slidebars scroll naturally with the site, and unfixes them for Android Browser < 3 and iOS < 5. */
}

.sb-slidebar.sb-active {
	display: block; /* Makes Slidebars visibile when open. Changed from visibility to display to allow -webkit-overflow-scrolling. */
}

.sb-style-overlay {
	z-index: 9999; /* Set z-index high to ensure it overlays any other site elements. */
}

.sb-momentum-scrolling {
	-webkit-overflow-scrolling: touch; /* Adds native momentum scrolling for iOS & Android devices. */
}

/* Slidebar widths for browsers/devices that don't support media queries. */
	.sb-slidebar {
		width: 30%;
	}

	.sb-width-thin {
		width: 15%;
	}

	.sb-width-wide {
		width: 45%;
	}

@media (max-width: 480px) { /* Slidebar widths on extra small screens. */
	.sb-slidebar {
		width: 70%;
	}

	.sb-width-thin {
		width: 55%;
	}

	.sb-width-wide {
		width: 85%;
	}
}

@media (min-width: 481px) { /* Slidebar widths on small screens. */
	.sb-slidebar {
		width: 55%;
	}

	.sb-width-thin {
		width: 40%;
	}

	.sb-width-wide {
		width: 70%;
	}
}

@media (min-width: 768px) { /* Slidebar widths on medium screens. */
	.sb-slidebar {
		width: 40%;
	}

	.sb-width-thin {
		width: 25%;
	}

	.sb-width-wide {
		width: 55%;
	}
}

@media (min-width: 992px) { /* Slidebar widths on large screens. */
	.sb-slidebar {
		width: 30%;
	}

	.sb-width-thin {
		width: 15%;
	}

	.sb-width-wide {
		width: 45%;
	}
}

@media (min-width: 1200px) { /* Slidebar widths on extra large screens. */
	.sb-slidebar {
		width: 20%;
	}

	.sb-width-thin {
		width: 5%;
	}

	.sb-width-wide {
		width: 35%;
	}
}

/* ---------------
 * 004 - Animation
 */

.sb-slide, #sb-site, .sb-site-container, .sb-slidebar {
	-webkit-transition: -webkit-transform 400ms ease;
	   -moz-transition: -moz-transform 400ms ease;
	     -o-transition: -o-transform 400ms ease;
	        transition: transform 400ms ease;
	-webkit-transition-property: -webkit-transform, left, right; /* Add left/right for Android < 4.4. */
	-webkit-backface-visibility: hidden; /* Prevents flickering. This is non essential, and you may remove it if your having problems with fixed background images in Chrome. */
}

/* --------------------
 * 005 - Helper Classes
 */

.sb-hide {
	display: none; /* Optionally applied to control classes when Slidebars is disabled over a certain width. */
}
