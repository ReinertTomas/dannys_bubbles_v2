(function ($) {
    "use strict";
// TOP Menu Sticky
    $(window).on('scroll', function () {
        var scroll = $(window).scrollTop();
        if (scroll < 400) {
            $("#sticky-header").removeClass("sticky");
            $('#back-top').fadeIn(500);
        } else {
            $("#sticky-header").addClass("sticky");
            $('#back-top').fadeIn(500);
        }
    });


    $(document).ready(function () {

// mobile_menu
        var menu = $('ul#navigation');
        if (menu.length) {
            menu.slicknav({
                prependTo: ".mobile_menu",
                closedSymbol: '+',
                openedSymbol: '-'
            });
        }
        ;
// blog-menu
        // $('ul#blog-menu').slicknav({
        //   prependTo: ".blog_menu"
        // });

// review-active
        $('.slider_active').owlCarousel({
            loop: true,
            margin: 0,
            items: 1,
            autoplay: true,
            navText: ['<i class="ti-angle-left"></i>', '<i class="ti-angle-right"></i>'],
            nav: true,
            dots: false,
            autoplayHoverPause: true,
            autoplaySpeed: 800,
            responsive: {
                0: {
                    items: 1,
                    nav: false,
                },
                767: {
                    items: 1,
                    nav: false,
                },
                992: {
                    items: 1,
                    nav: false
                },
                1200: {
                    items: 1,
                    nav: false
                },
                1600: {
                    items: 1,
                    nav: true
                }
            }
        });

// review-active
        $('.testmonial_active ').owlCarousel({
            loop: true,
            margin: 0,
            items: 1,
            autoplay: true,
            navText: ['<i class="ti-angle-left"></i>', '<i class="ti-angle-right"></i>'],
            nav: true,
            dots: false,
            autoplayHoverPause: true,
            autoplaySpeed: 800,

            responsive: {
                0: {
                    items: 1,
                    dots: false,
                    nav: false,
                },
                767: {
                    items: 1,
                    dots: false,
                    nav: false,
                },
                992: {
                    items: 1,
                    nav: false
                },
                1200: {
                    items: 1,
                    nav: false
                },
                1500: {
                    items: 1
                }
            }
        });

// review-active
        $('.case_active').owlCarousel({
            loop: true,
            margin: 30,
            items: 1,
            autoplay: true,
            navText: ['<i class="ti-angle-left"></i>', '<i class="ti-angle-right"></i>'],
            nav: false,
            dots: true,
            autoplayHoverPause: true,
            autoplaySpeed: 800,
            responsive: {
                0: {
                    items: 1,
                    nav: false
                },
                767: {
                    items: 2,
                },
                992: {
                    items: 3
                },
                1200: {
                    items: 3
                },
                1500: {
                    items: 3
                }
            }
        });

// review-active
        $('.testmonial_active2').owlCarousel({
            loop: true,
            margin: 0,
            items: 1,
            autoplay: false,
            navText: ['<i class="ti-angle-left"></i>', '<i class="ti-angle-right"></i>'],
            nav: false,
            dots: true,
            autoplayHoverPause: true,
            autoplaySpeed: 800,
// dotsData: true,
            center: true,
            responsive: {
                0: {
                    items: 1,
                    nav: false
                },
                767: {
                    items: 1,
                    nav: false
                },
                992: {
                    items: 1
                },
                1200: {
                    items: 1
                },
                1500: {
                    items: 1
                }
            }
        });

        // filter items on button click
        $('.portfolio-menu').on('click', 'button', function () {
            var filterValue = $(this).attr('data-filter');
            $grid.isotope({filter: filterValue});
        });

        //for menu active class
        $('.portfolio-menu button').on('click', function (event) {
            $(this).siblings('.active').removeClass('active');
            $(this).addClass('active');
            event.preventDefault();
        });

        /* magnificPopup img view */
        $('.popup-image').magnificPopup({
            type: 'image',
            gallery: {
                enabled: true
            }
        });

        /* magnificPopup img view */
        $('.img-pop-up').magnificPopup({
            type: 'image',
            gallery: {
                enabled: true
            }
        });

        /* magnificPopup video view */
        $('.popup-video').magnificPopup({
            type: 'iframe'
        });


        // blog-page

        //brand-active
        $('.brand-active').owlCarousel({
            loop: true,
            margin: 30,
            items: 1,
            autoplay: true,
            nav: false,
            dots: false,
            autoplayHoverPause: true,
            autoplaySpeed: 800,
            responsive: {
                0: {
                    items: 1,
                    nav: false

                },
                767: {
                    items: 4
                },
                992: {
                    items: 7
                }
            }
        });

// blog-dtails-page

        //project-active
        $('.project-active').owlCarousel({
            loop: true,
            margin: 30,
            items: 1,
// autoplay:true,
            navText: ['<i class="Flaticon flaticon-left-arrow"></i>', '<i class="Flaticon flaticon-right-arrow"></i>'],
            nav: true,
            dots: false,
// autoplayHoverPause: true,
// autoplaySpeed: 800,
            responsive: {
                0: {
                    items: 1,
                    nav: false

                },
                767: {
                    items: 1,
                    nav: false
                },
                992: {
                    items: 2,
                    nav: false
                },
                1200: {
                    items: 1,
                },
                1501: {
                    items: 2,
                }
            }
        });

        if (document.getElementById('default-select')) {
            $('select').niceSelect();
        }

        //about-pro-active
        $('.details_active').owlCarousel({
            loop: true,
            margin: 0,
            items: 1,
// autoplay:true,
            navText: ['<i class="ti-angle-left"></i>', '<i class="ti-angle-right"></i>'],
            nav: true,
            dots: false,
// autoplayHoverPause: true,
// autoplaySpeed: 800,
            responsive: {
                0: {
                    items: 1,
                    nav: false

                },
                767: {
                    items: 1,
                    nav: false
                },
                992: {
                    items: 1,
                    nav: false
                },
                1200: {
                    items: 1,
                }
            }
        });

    });

})(jQuery);	