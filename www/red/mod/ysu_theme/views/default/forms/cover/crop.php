<?php
/**
 * Avatar crop form
 *
 * @uses $vars['entity']
 */

elgg_load_js('jquery.imgareaselect');
elgg_load_js('cover_cropper');
elgg_load_css('jquery.imgareaselect');

$master_img = elgg_view('output/img', array(
	'src' => getCoverIconUrl('master'),
	'alt' => elgg_echo('cover'),
	'class' => 'mrl',
	'id' => 'user-cover-cropper',
));

$preview_img = elgg_view('output/img', array(
	'src' => getCoverIconUrl('master'),
	'alt' => elgg_echo('cover'),
));

?>
<div class="clearfix">
	<?php echo $master_img; ?>	
</div>
<div class="elgg-foot">
<?php
$coords = array('x1', 'x2', 'y1', 'y2');
foreach ($coords as $coord) {
	echo elgg_view('input/hidden', array('name' => $coord, 'value' => $vars['entity']->$coord));
}

echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $vars['entity']->guid));

echo elgg_view('input/submit', array('value' => elgg_echo('cover:create')));

?>
</div>
