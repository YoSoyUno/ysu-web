<?php



// If user logs in then forward to activity
if (elgg_is_logged_in()) {
    header("Location: activity");
}


//elgg_load_js('jquery');
// elgg_load_js('js_validate');
// elgg_load_js('bootstrap');
//elgg_load_js('modernizr');
// elgg_load_js('scrollTo');
// elgg_load_js('parallax');
// elgg_load_js('landing_page_startup');
// elgg_load_js('landing_page_script');

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

                            <h3><?php echo "Versión de pruebas" ?><br/>
                            <small><?php $conf['site_footer'] .= shell_exec("cd /srv/ysu-web/ && git log -1 --pretty=format:'%h (%ci)' --abbrev-commit"); $conf['site_footer'] .= '</em></p>';
echo $conf['site_footer']; ?></small></h3>
        		                <!-- <a href="#0" class="cd-btn cd-modal-trigger" data-target='modal-login'>Iniciar sesión</a>
                            <a href="#0" class="cd-btn cd-modal-trigger" data-target='ysu_settings_ayuda'>TEST</a> -->

                        </div>
                    </div>
                </div>
                <!-- <div class="content-11">
                    <div class="container">
                        <span><?php echo elgg_echo('landing_page:text2') ?></span>
                        <a class="btn btn-large btn-danger go-login" href="#"><?php echo elgg_echo('landing_page:try') ?></a>
                    </div>
                </div> -->
            </section>

             <!-- content-11  -->


            <!-- content-8  -->
            <!-- <section class="content-8 v-center">
                <div>
                    <div class="container">
                        <img src="/mod/ysu_theme/graphics/landing_page/responsive.png" width="512" height="355" alt="">

                        <h3><?php echo elgg_echo('landing_page:text3') ?></h3>

                        <div class="row">
                            <div class="col-sm-6 col-sm-offset-3">
                                <p><?php echo elgg_echo('landing_page:text4') ?>
                                </p>
                                <a class="btn btn-large btn-clear go-login" href="#"><?php echo elgg_echo('landing_page:try') ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </section> -->


             <!-- content-23  -->
            <!-- <section class="content-23 v-center bg-midnight-blue custom-bg">
                <div>
                    <div class="container">
                        <div class="hero-unit hero-unit-bordered">
                            <h1><?php echo elgg_echo('landing_page:text5') ?></h1>
                        </div>
                    </div>
                </div>
                <a class="control-btn" href="#"><i class="fa fa-lg fa-angle-double-down"></i></a>
            </section> -->

            <!-- content-7  -->
<!--
            <section class="header-10-sub v-center bg-midnight-blue">
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
            </section>
            -->




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
                            <a class="brand" href="#"><?php echo elgg_get_config('sitename') ?></a>
                        </div>
                        <div class="col-sm-7">
                             <?php echo elgg_view_menu('footer', array('sort_by' => 'priority', 'class' => 'elgg-menu-hz')); ?>
                        </div>
                        <div class="col-sm-3">
                            <h6>Estadísticas</h6>
                            <ul class="address">
                                <li>XX Puntos</li>
                                <li>XX Activaciones</li>
                                <li>XX Encuentros</li>
                                <li>XX Seres</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div>

        <!-- Placed at the end of the document so the pages load faster -->
