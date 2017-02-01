define(function(require) {
    var elgg = require("elgg");
    var $ = require("jquery");

    jQuery(document).ready(function($){

      $( document ).tooltip();

      // Codigo redondo
      console.log('\n\
      Soy un perdido eléctrico\n\
      Del universo eléctrico,\n\
      Un multitudinario\n\
      Perdido y sin identidad.\n\
      \n\
      Cuido mi tubo-túnel\n\
      Con DDT galáctico.\n\
      Y aunque parezca un crimen\n\
      El monstruo no me muerde más.\n\
      \n\
      Yo soy, yo soy, yo soy nadie, yo soy.\n\
      Yo soy, yo soy, yo soy nadie, yo soy.\n\
      \n\
      Y así termina el juego.\n\
      Boda de los aliados.\n\
      Abuelitos perversos\n\
      Timbeándose la eternidad.\n\
      \n\
      Cuido mi tubo-túnel\n\
      Con DDT galáctico.\n\
      Y aunque parezca un crimen\n\
      El monstruo no me pisa más\n\
      \n\
      Yo soy, yo soy, yo soy nadie, yo soy.\n\
      Yo soy, yo soy, yo soy nadie, yo soy.\n\
      \n\
      \n\
      ');

        // $("#elgg-profile-actions").hide();

  		    $("#profile-button").click(function(){
  		        $("#profile-details-info").toggle();
  		        return false;
  		    });

  		     $("#profile-config-botom").click(function(){
  		        $("#elgg-profile-actions").toggle();
  		        return false;
  		    });


    	//cache some jQuery objects
    	var modalTrigger = $('.cd-modal-trigger'),
    		transitionLayer = $('.cd-transition-layer'),
    		transitionBackground = transitionLayer.children(),
    		modalWindow = $('.cd-modal');

    	var frameProportion = 1.78, //png frame aspect ratio
    		frames = 25, //number of png frames
    		resize = false;

    	//set transitionBackground dimentions
    	setLayerDimensions();
    	$(window).on('resize', function(){
    		if( !resize ) {
    			resize = true;
    			(!window.requestAnimationFrame) ? setTimeout(setLayerDimensions, 300) : window.requestAnimationFrame(setLayerDimensions);
    		}
    	});

    	// Muestra el modal al hacer click
    	modalTrigger.on('click', function(event){
    		event.preventDefault();
        var target = $(this).data('target');

        // Verifica si es el modal de la caja de login o cualquier otro
        if (target != 'modal-login') {
          // No es el login, se carga el contenido definido en las settings para ese campo
          elgg.action('ysu_theme/ink', {
            data: {
              setting_field: target
            },
            success: function (wrapper) {
              if (wrapper.output) {
                $( "#modal-inner-content" ).replaceWith( wrapper.output.page );
              } else {
                console.log('No existe ese campo de configuracion');
              }
            }
          })
          var modalWindow = $('.cd-modal-generic');
        } else {
          var modalWindow = $('.cd-modal-login');
        }

        // Efecto
        transitionLayer.addClass('visible opening');
    		var delay = ( $('.no-cssanimations').length > 0 ) ? 0 : 600;

        setTimeout(function(){
    			modalWindow.addClass('visible');
    		}, delay);
    	});

    	$(document).keyup(function(e) {
    	  	if (e.keyCode === 27) $('.modal-close').click();   // cierra el modal apretando ESC
    		});

    	// Boton de cierre
    	modalWindow.on('click', '.modal-close', function(event){
    		event.preventDefault();
    		transitionLayer.addClass('closing');
    		modalWindow.removeClass('visible');
    		transitionBackground.one('webkitAnimationEnd oanimationend msAnimationEnd animationend', function(){
    			transitionLayer.removeClass('closing opening visible');
    			transitionBackground.off('webkitAnimationEnd oanimationend msAnimationEnd animationend');
    		});
    	});

    	function setLayerDimensions() {
    		var windowWidth = $(window).width(),
    			windowHeight = $(window).height(),
    			layerHeight, layerWidth;

    		if( windowWidth/windowHeight > frameProportion ) {
    			layerWidth = windowWidth;
    			layerHeight = layerWidth/frameProportion;
    		} else {
    			layerHeight = windowHeight*1.2;
    			layerWidth = layerHeight*frameProportion;
    		}

    		transitionBackground.css({
    			'width': layerWidth*frames+'px',
    			'height': layerHeight+'px',
    		});

    		resize = false;
    	}
    });


});
