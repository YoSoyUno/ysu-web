<?php
/**
 * Cover cropping view
 *
 * @uses vars['entity']
 */

?>
<div id="avatar-croppingtool" class="mtl ptm">	
	<p>
		<?php echo elgg_echo("cover:create:instructions"); ?>
	</p>
	<?php echo elgg_view_form('cover/crop', array(), $vars); ?>
</div>
