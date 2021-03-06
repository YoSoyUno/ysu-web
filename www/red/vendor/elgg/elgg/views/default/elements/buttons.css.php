<?php
/**
 * CSS buttons
 *
 * @package Elgg.Core
 * @subpackage UI
 */
?>
/* <style> /**/

/* **************************
	BUTTONS
************************** */

/* Base */
.elgg-button {
	font-size: 14px;
	font-weight: bold;
	border-radius: 5px;
	width: auto;
	padding: 2px 4px;
	cursor: pointer;
	box-shadow: 0px 1px 0px rgba(0, 0, 0, 0.40);
	background-color: #ccc;
}
a.elgg-button {
	padding: 3px 6px;
}

.elgg-button:hover,
.elgg-button:focus {
	background: #eee;
}

/* Submit: This button should convey, "you're about to take some definitive action" */
.elgg-button-submit {
	color: white;
	text-shadow: 1px 1px 0px black;
	text-decoration: none;
	border: 1px solid #4690d6;
	background: #4690d6 url(<?= elgg_get_simplecache_url("button_graduation.png"); ?>) repeat-x left 10px;
}

.elgg-button-submit:hover,
.elgg-button-submit:focus {
	border-color: #0054a7;
	text-decoration: none;
	color: white;
	background: #0054a7 url(<?= elgg_get_simplecache_url("button_graduation.png"); ?>) repeat-x left 10px;
}

.elgg-button-submit.elgg-state-disabled {
	background: #999;
	border-color: #999;
	cursor: default;
}

/* Cancel: This button should convey a negative but easily reversible action (e.g., turning off a plugin) */
.elgg-button-cancel {
	color: #333;
	background: #ddd url(<?= elgg_get_simplecache_url("button_graduation.png"); ?>) repeat-x left 10px;
	border: 1px solid #999;
}
.elgg-button-cancel:hover,
.elgg-button-cancel:focus {
	color: #444;
	background-color: #999;
	background-position: left 10px;
	text-decoration: none;
}

/* Action: This button should convey a normal, inconsequential action, such as clicking a link */
.elgg-button-action {
	background: #ccc url(<?= elgg_get_simplecache_url("button_background.gif"); ?>) repeat-x 0 0;
	border:1px solid #999;
	color: #333;
	padding: 2px 15px;
	text-align: center;
	font-weight: bold;
	text-decoration: none;
	text-shadow: 0 1px 0 white;
	cursor: pointer;
	border-radius: 5px;
	box-shadow: none;
}

.elgg-button-action:hover,
.elgg-button-action:focus {
	background: #ccc url(<?= elgg_get_simplecache_url("button_background.gif"); ?>) repeat-x 0 -15px;
	color: #111;
	text-decoration: none;
	border: 1px solid #999;
}

/* Delete: This button should convey "be careful before you click me" */
.elgg-button-delete {
	color: #bbb;
	text-decoration: none;
	border: 1px solid #333;
	background: #555 url(<?= elgg_get_simplecache_url("button_graduation.png"); ?>) repeat-x left 10px;
	text-shadow: 1px 1px 0px black;
}
.elgg-button-delete:hover,
.elgg-button-delete:focus {
	color: #999;
	background-color: #333;
	background-position: left 10px;
	text-decoration: none;
}

.elgg-button-dropdown {
	padding:3px 6px;
	text-decoration:none;
	display:block;
	font-weight:bold;
	position:relative;
	margin-left:0;
	color: white;
	background-color: transparent;
	border:1px solid #71B9F7;
	border-radius:4px;
	box-shadow: 0 0 0;
}

.elgg-button-dropdown:after {
	content: " \25BC ";
	font-size:smaller;
}

.elgg-button-dropdown:hover {
	background-color:#71B9F7;
	text-decoration:none;
}
.elgg-button-dropdown:focus {
	text-decoration: none;
}
.elgg-button-dropdown.elgg-state-active {
	background: #ccc;
	outline: none;
	color: #333;
	border:1px solid #ccc;
	border-radius:4px 4px 0 0;
}
