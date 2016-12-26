<?php
/**
 * Cover upload view
 *
 * @uses $vars['entity']
 */

$cover_imagen = elgg_view('output/img', array(
	'src' => getCoverIconUrl(),
	'alt' => elgg_echo('cover'),
));

$current_label = elgg_echo('cover:current');

$remove_button = '';
if ($vars['entity']->covertime) {
	$remove_button = elgg_view('output/url', array(
		'text' => elgg_echo('remove'),
		'title' => elgg_echo('avatar:remove'),
		'href' => 'action/cover/remove?guid=' . elgg_get_page_owner_guid(),
		'is_action' => true,
		'class' => 'elgg-button elgg-button-cancel mll',
	));
}

$form_params = array('enctype' => 'multipart/form-data');
$upload_form = elgg_view_form('cover/upload', $form_params, $vars);

?>

<p class="mtm">
	<?php echo elgg_echo('cover:upload:instructions'); ?>
</p>

<?php

$image = <<<HTML
<div id="current-user-avatar" class="mrl prl">
	<label>$current_label</label><br />
	$cover_imagen
</div>
$remove_button
HTML;

$body = <<<HTML
<div id="avatar-upload">
	$upload_form
</div>
HTML;

echo elgg_view_image_block($image, $upload_form);
