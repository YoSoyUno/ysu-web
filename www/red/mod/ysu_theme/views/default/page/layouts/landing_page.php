<?php



// If user logs in then forward to activity
if (elgg_is_logged_in()) {
    header("Location: activity");
}


elgg_load_js('jquery');
// elgg_load_js('js_validate');
// elgg_load_js('bootstrap');
// elgg_load_js('modernizr');
elgg_load_js('scrollTo');
// elgg_load_js('parallax');
// elgg_load_js('landing_page_startup');
elgg_load_js('landing_page_script');

//elgg_load_css('ink-reset');



?>



<!-- <link rel="stylesheet" href="/mod/ysu_theme/lib/landing_page/bootstrap/css/bootstrap.css"> -->
<link rel="stylesheet" href="/mod/ysu_theme/lib/landing_page/css/flat-ui.css">
<link rel="stylesheet" href="/mod/ysu_theme/lib/landing_page/css/style.css">
<!-- <link rel="stylesheet" href="/mod/ysu_theme/lib/ink/css/style.css"> -->




<div class="page-wrapper">
            <!-- header-10 -->
<!--              -->
            <!-- content-23  -->
            <section class="content-23   v-center bg-midnight-blue custom-bg">
                <div>
                    <div class="container">
                        <div class="hero-unit">
                            <h1><?php echo "YOSOY" ?></h1>
                            <h3><?php echo elgg_echo('ysu:landing:subtitle'); ?></h3>
        		                <!-- <a href="#0" class="cd-btn cd-modal-trigger" data-target='modal-login'>Iniciar sesión</a>
                            <a href="#0" class="cd-btn cd-modal-trigger" data-target='ysu_settings_ayuda'>TEST</a> -->

                        </div>
                    </div>
                   <a class="control-btn go-intro" href="#" title="<?php echo elgg_echo('ysu:landing:botonintro'); ?>"><i class="fa fa-lg fa-angle-double-down"></i></a>
                </div>

            </section>

             <!-- content-8  -->
             <section class="content-8 v-center intro">

                   <div id="intro-bajada" class="container">
                       <span><?php echo elgg_echo('ysu:landing:text0') ?></span>
                   </div>

                 <div>
                     <div class="container">
                        <div class="videoWrapper">
                          <iframe id="intro-video" width="560" height="315" src="https://www.youtube.com/embed/7IT9g1YDcuc?autoplay=0&showinfo=0&controls=0&rel=0&enablejsapi=1" frameborder="0" allowfullscreen fs="1"></iframe>
                        </div>
                     </div>
                 </div>
             </section>
             <section style='background: white;margin-bottom:100px;' class="content-8 v-center">
               <div class="container">

                 <div id="intro-text" class="row">
                     <div class="col-sm-6 ">
                       <?php echo elgg_echo('ysu:landing:text1') ?>
                     </div>
                     <div class="col-sm-6 hero-unit">
                       <?php echo elgg_echo('ysu:landing:text2') ?>
                     </div>
                 </div>
                <div class="row">
                  <div class="col-sm-12">
                    <a style="display: inline-block;"class="btn btn-large btn-clear cd-modal-trigger" data-target="modal-login" href="#"><?php echo elgg_echo('ysu:landing:sumate') ?></a>
                    <p style="display: block; position: relative; font-size: 14px; margin: 15px;"><a href='http://www.yosoyuno.org'><?php echo elgg_echo('ysu:landing:text4') ?></a></p>
                  </div>
                </div>
              </div>

             </section>


            <!-- <section class="header-10-sub v-center bg-midnight-blue">
                <div class="background">
                    &nbsp;
                </div>
                <div>
                    <div class="container">
                        <div class="hero-unit">
                            <h1>Startup Framework is a set of components</h1>
                            <p>
                                We’ve created the product that will help your
                                <br/>
                                startup to look even better.
                            </p>
                        </div>
                    </div>
                </div>
                <a class="control-btn fui-arrow-down" href="#"> </a>
            </section> -->


            <!-- footer-3 -->
            <header class="header-10">
                <div class="container">
                    <div class="navbar col-sm-12" role="navigation">
                        <div class="collapse navbar-collapse pull-right">
                           <?php echo elgg_view_menu('site'); ?>

                        </div>
                    </div>
                </div>
            </header>
            <footer class="footer-3">
                <div class="container">
                    <div class="row v-center">
                        <div class="col-sm-2">
                            <div class="brand"><?php echo elgg_get_config('sitename') ?><br/>
                              <small><?php echo shell_exec("cd /srv/ysu-web/ && git describe");?></small>
                            </div>
                        </div>
                        <div class="col-sm-7">
                             <?php echo elgg_view_menu('footer', array('sort_by' => 'priority', 'class' => 'elgg-menu-hz')); ?>
                        </div>
                        <div class="col-sm-3">
                            <h6>Estadísticas</h6>
                            <ul class="address">
                                <?php
                                $stats = get_entity_statistics();
                                $distancias = ysu_calcula_distancia(ysu_punto_actual());
                                $distancia_total = floor(($distancias[0] / 1000));
                                $distancia_rec = floor(($distancias[1] / 1000));
                                ?>
                                <li><?php echo $distancia_total ?> km. a recorrer</li>
                                <?php if ($distancia_rec != 0) { ?>
                                <li><?php echo $distancia_rec ?> km. ya recorridos</li>
                                <?php } ?>
                                <li><?php echo $stats['group']['__base__'] ?> Puntos</li>
                                <!-- <li><?php echo $stats['object']['event'] ?> Activaciones</li> -->
                                <li><?php echo get_number_users() ?> Seres</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
            <footer id='footer' class="footer-3" style="background-color: black;">
              <a id='logo-arsayian' target="_blank" href="http://www.fundacionarsayian.org/"><img title='Fundacion Arsayian' src='/mod/ysu_theme/graphics/arsayian.png' /></a>
            </footer>
        </div>

        <!-- Placed at the end of the document so the pages load faster -->
