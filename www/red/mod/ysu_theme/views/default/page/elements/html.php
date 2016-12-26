<?php
/**
 * Page shell for all HTML pages
 *
 * @uses $vars['head']        Parameters for the <head> element
 * @uses $vars['body_attrs']  Attributes of the <body> tag
 * @uses $vars['body']        The main content of the page
 */
// Set the content type
header("Content-type: text/html; charset=UTF-8");

$lang = get_current_language();

$attrs = "";
if (isset($vars['body_attrs'])) {
	$attrs = elgg_format_attributes($vars['body_attrs']);
	if ($attrs) {
		$attrs = " $attrs";
	}
}
$context = elgg_get_context();
$attrs .= " id='body-$context'";
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $lang; ?>" lang="<?php echo $lang; ?>">
	<head>
		<?php echo $vars["head"]; ?>

		<link href='//fonts.googleapis.com/css?family=Expletus+Sans:400,700' rel='stylesheet' type='text/css'>
		<style type="text/css">
		<?php //if (elgg_is_logged_in() && elgg_get_context()!='admin') : ?>
		@media (max-width: 820px) {
				.logo, .elgg-sidebar{
					display: none;
				}

				.sliderbar-user-menu {
					display: block;
				}

		}
		@media (max-width: 600px) {

			.elgg-avatar-topbar, .logo, .elgg-sidebar{
				display: none;
			}

			.sliderbar-user-menu {
					display: block;
			}
		}
		<?php //endif ?>
		</style>
		<script type="text/javascript">
		<?php //echo elgg_get_plugin_setting('header_code', 'ysu_theme') ?>
		</script>
		<!-- <script type="text/javascript" src="/mod/ysu_theme/views/default/lib/slidebars/slidebars.js"></script> -->
	</head>
	<body<?php echo $attrs ?>>
		<?php echo $vars["body"]; ?>

		<?php echo elgg_get_plugin_setting('footer_code', 'ysu_theme') ?>
	</body>
</html>
