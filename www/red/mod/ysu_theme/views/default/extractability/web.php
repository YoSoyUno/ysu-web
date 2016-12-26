<?php  
  $extractability =  $vars['extractability'];
?>
<div class="elgg-extractability">
   
      <?php if($extractability->imagen!=''): ?>
      <div class="elgg-extractability-imagen" style="background: url('<?php echo $extractability->imagen ?>') no-repeat center center; background-size: 350px;">
        <a rel="nofollow" tabindex="0" class="d-s ot-anchor Ks" target="_blank" href="<?php echo $extractability->url ?>"> 
          <img itemprop="image" width="300px" height="200px" src="<?php echo elgg_get_site_url();?>mod/ysu_theme/graphics/t.png">
        </a>
      </div>
      <?php endif; ?>
      <div class="elgg-extractability-content">
        <div class="elgg-extractability-title">
          <a rel="nofollow" tabindex="0" title="<?php echo $extractability->title ?>" target="_blank" href="<?php echo $extractability->url ?>">
            <?php echo $extractability->title ?>
          </a>
        </div>
        <div class="elgg-extractability-dominio">
          <a rel="nofollow" tabindex="0" target="_blank" href="<?php echo $extractability->url ?>"><?php echo $extractability->dominio ?></a>
        </div>
        <?php if($extractability->resumen!=''): ?>
        <div class="elgg-extractability-resumen">
          <?php echo $extractability->resumen ?>
        </div>
        <?php endif; ?>
      </div>
 
</div>