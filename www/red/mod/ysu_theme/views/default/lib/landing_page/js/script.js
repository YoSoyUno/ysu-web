function fadedEls(el, shift) {
    el.css('opacity', 0);

    switch (shift) {
        case undefined: shift = 0;
        break;
        case 'h': shift = el.eq(0).outerHeight();
        break;
        case 'h/2': shift = el.eq(0).outerHeight() / 2;
        break;
    }

    $(window).resize(function() {
        if (!el.hasClass('ani-processed')) {
            el.eq(0).data('scrollPos', el.eq(0).offset().top - $(window).height() + shift);
        }
    }).scroll(function() {
        if (!el.hasClass('ani-processed')) {
            if ($(window).scrollTop() >= el.eq(0).data('scrollPos')) {
                el.addClass('ani-processed');
                el.each(function(idx) {
                    $(this).delay(idx * 200).animate({
                        opacity : 1
                    }, 1000);
                });
            }
        }
    });
};

(function($) {
    $(".elgg-form-register").validate({
      rules: {
        email: {
          required: true,
          email: true
        },
        password: "required",
        password2: {
          equalTo: "#password"
        }
      }
    });
    $(".elgg-form-login").validate();
    
    $('.go-login').on('click', function() {
        $.scrollTo($('.login'), {
            axis : 'y',
            duration : 500
        });
        $(".elgg-form-login#username").focus()
        return false;
    });


    $(function() {
        $("#bgVideo").YTPlayer({
        fitToBackground: false,
        videoId: 'EyEyojMvveY',
        pauseOnScroll: false,
        playerVars: {
          modestbranding: 0,
          autoplay: 1,
          controls: 0,
          showinfo: 0,
          wmode: 'transparent',
          branding: 0,
          rel: 0,
          autohide: 0,
          origin: window.location.origin
        }
      });
        // Sections height & scrolling
        $(window).resize(function() {
            var sH = $(window).height();
            $('section.header-10-sub').css('height', (sH - $('header').outerHeight()) + 'px');
           // $('section:not(.header-10-sub):not(.content-11)').css('height', sH + 'px');
        });        

        // Parallax
        $('.header-10-sub, .content-23').each(function() {
            $(this).parallax('50%', 0.3, true);
        });

        /* For the section content-8 */
        if ($('.content-8').length > 0) {
            fadedEls($('.content-8'), 300);
        }


       
        (function(el) {
            el.css('left', '-100%');

            $(window).resize(function() {
                if (!el.hasClass('ani-processed')) {
                    el.data('scrollPos', el.offset().top - $(window).height() + el.outerHeight());
                }
            }).scroll(function() {
                if (!el.hasClass('ani-processed')) {
                    if ($(window).scrollTop() >= el.data('scrollPos')) {
                        el.addClass('ani-processed');
                        el.animate({
                            left : 0
                        }, 500);
                    }
                }
            });
        })($('.content-11 > .container'));

        $(window).resize().scroll();

    });

    $(window).load(function() {
        $('html').addClass('loaded');
        $(window).resize().scroll();
    });
})(jQuery);

