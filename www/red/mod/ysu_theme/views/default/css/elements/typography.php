<?php
/**
 * CSS typography
 *
 * @package Elgg.Core
 * @subpackage UI
 */
$content_font_color = elgg_get_plugin_setting('content_font_color', 'ysu_theme');
$content_a_color = elgg_get_plugin_setting('content_a_color', 'ysu_theme');
$content_background_color = elgg_get_plugin_setting('content_background_color', 'ysu_theme');
$background_type = elgg_get_plugin_setting('background_type', 'ysu_theme');
$content_button_color = elgg_get_plugin_setting('content_button_color', 'ysu_theme');
?>
/* <style> /**/

/* ***************************************
	Typography
*************************************** */
body.cke_editable {
	background: #FFFFFF;
}

body {
	color: <?php echo $content_font_color ?>;
	font-size: 90%;
	line-height: 1.4em;
	  -webkit-font-smoothing: antialiased;
  font-family: 'Expletus Sans', 'Sans-Serif';
  font-weight: lighter;

	background: url('/mod/ysu_theme/graphics/bg.jpg'), linear-gradient(270deg, #e9d9a6, #af974b, #787878);
	background-size: cover, 2000% 2000%;
  background-blend-mode: multiply;
	background-attachment: fixed;

	-webkit-animation: background 45s ease infinite;
	-moz-animation: background 45s ease infinite;
	animation: background 45s ease infinite;
}

@-webkit-keyframes background {
    0%{background-position:0% 52%}
    50%{background-position:100% 49%}
    100%{background-position:0% 52%}
}
@-moz-keyframes background {
    0%{background-position:0% 52%}
    50%{background-position:100% 49%}
    100%{background-position:0% 52%}
}
@keyframes background {
    0%{background-position:0% 52%}
    50%{background-position:100% 49%}
    100%{background-position:0% 52%}
}

a {
	color: <?php echo $content_a_color ?>;
	outline: 0;
}

a:hover,
a.selected { <?php //@todo remove .selected ?>
	color: #555;
	text-decoration: underline;
}

a.close-sidebar{
	float: right;
	margin: 10px;
}

p {
	margin-bottom: 15px;
}

p:last-child {
	margin-bottom: 0;
}

pre, code {
	font-family: Monaco, "Courier New", Courier, monospace;
	font-size: 12px;

	background:#EBF5FF;
	color: #000;
	overflow:auto;

	overflow-x: auto; /* Use horizontal scroller if needed; for Firefox 2, not needed in Firefox 3 */

	white-space: pre-wrap;
	word-wrap: break-word; /* IE 5.5-7 */

}

pre {
	padding:3px 15px;
	margin:0px 0 15px 0;
	line-height:1.3em;
}

code {
	padding:2px 3px;
}

.elgg-monospace {
	font-family: Monaco, "Courier New", Courier, monospace;
}

blockquote {
	line-height: 1.3em;
	padding: 10px 15px;
	margin: 0 0 15px 0;
	background: #E2F2FE;
	border: 1px solid #A1CBEA;
	border-radius: 3px;
}

h1, h2, h3, h4, h5, h6 {
	font-weight: bold;
	color: #444;

	text-rendering: optimizelegibility;
}

h1 { font-size: 1.8em; }
h2 { font-size: 1.7em; line-height: 1.0em; }
h3 { font-size: 1.2em; }
h4 { font-size: 1.0em; }
h5 { font-size: 0.9em; }
h6 { font-size: 0.8em; }

.elgg-heading-site, .elgg-heading-site:hover {
	font-size: 2em;
	line-height: 1.2em;
	color: #FFF;
	text-shadow: 1px 1px 3px #333;
	text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.4);
	text-decoration: none;
}
.elgg-heading-main {
	display: inline-block;
	padding-top: 15px;
	margin: 10px 0 0 0px;
}
.elgg-heading-basic {
	color: #0054A7;
	font-size: 1.2em;
	font-weight: bold;
}

.elgg-subtext {
	color: #666;
	font-size: 85%;
	line-height: 1.4em;
	display: block;
}

.elgg-text-help {
	display: block;
	font-size: 85%;
	font-style: italic;
}

.elgg-quiet {
	color: #666;
}

.elgg-loud {
	color: #0054A7;
}

/* ***************************************
	USER INPUT DISPLAY RESET
*************************************** */
.elgg-output {
	margin-top: 10px;
}

.elgg-output dt { font-weight: bold }
.elgg-output dd { margin: 0 0 1em 1em }

.elgg-output ul, .elgg-output ol {
	margin: 0 1.5em 1.5em 0;
	padding-left: 1.5em;
}
.elgg-output ul {
	list-style-type: disc;
}
.elgg-output ol {
	list-style-type: decimal;
	list-style-position: inside;
	padding-left: .4em;
}
.elgg-output table {
	border: 1px solid #DCDCDC;
}
.elgg-output table td {
	border: 1px solid #DCDCDC;
	padding: 3px 5px;
}
.elgg-output img {
	max-width: 100%;
	height: auto;
}
