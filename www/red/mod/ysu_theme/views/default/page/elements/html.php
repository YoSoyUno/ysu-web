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
$user = elgg_get_logged_in_user_entity();
$top_box = $vars['login'];

if ($user) {
	$attrs .= " class=\"body-{$user['username']}\"";
}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $lang; ?>" lang="<?php echo $lang; ?>">
	<head>
		<?php echo $vars["head"]; ?>

		<link href="https://fonts.googleapis.com/css?family=Expletus+Sans:400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
		<style type="text/css">
		<?php //if (elgg_is_logged_in() && elgg_get_context()!='admin') : ?>
		@media (max-width: 820px) {
			.elgg-avatar-topbar, .elgg-sidebar{
				display: none;
			}

			.sliderbar-user-menu {
				display: block;
			}

		}
		@media (max-width: 600px) {
			.elgg-avatar-topbar, .elgg-sidebar{
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

	<!-- INICIO CAJA DE MODAL EFECTO INK -->
		<div class="cd-transition-layer">
			<div class="bg-layer"></div>
		</div> <!-- .cd-transition-layer -->

		<div id="modal-login" class="cd-modal cd-modal-login">
			<div class="modal-content-login">
				<section class="content-7 v-center">
						<div>
								<div class="container">
								<?php if (!elgg_is_logged_in()) { ?>

										<div class="row v-center">
												<div class="col-sm-1"></div>
												<div class="col-sm-5">
													<h3><?php echo elgg_echo('ysu:login:title1'); ?></h3>
													<?php echo elgg_view_form('login'); ?>
												</div>
												<div class="col-sm-1"></div>
												<div class="col-sm-4">
													<h3><?php echo elgg_echo('ysu:login:title2'); ?></h3>
													<?php echo elgg_view_form('register'); ?>
												</div>
												<div class="col-sm-1"></div>
										</div>
									<?php } ?>
								</div>
						</div>
				</section>
			</div> <!-- .modal-content -->

			<a href="#0" class="modal-close" title="<?php echo elgg_echo('ysu:login:close'); ?>"></a>
		</div> <!-- .cd-modal -->

		<div id="modal-test" class="cd-modal cd-modal-generic">
			<div class="modal-content">
				<section class="content-7 v-center">
					<div id="modal-inner-content">
					</div>
				</section>
			</div> <!-- .modal-content -->

			<a href="#0" class="modal-close" title="<?php echo elgg_echo('ysu:login:close'); ?>"></a>
		</div> <!-- .cd-modal -->

	<!-- FIN CAJA DE MODAL -->

		<?php echo $vars["body"]; ?>



		<?php echo elgg_get_plugin_setting('footer_code', 'ysu_theme') ?>
	</body>
</html>
