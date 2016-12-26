<?php
/**
 * Elgg topbar wrapper
 * Check if the user is logged in and display a topbar
 * @since 1.10 
 */
?>
<div class="elgg-page-topbar sb-slide">
	<div class="elgg-inner">
		<?php
		echo elgg_view('page/elements/topbar', $vars);    
		?>
    <div class="logo"> 
    <a href="/">
      <img src="<?php echo elgg_get_site_url() ?>mod/ysu_theme/graphics/logo.png">      
    </a>
    </div>    
	</div>
</div>