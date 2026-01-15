/**
 * JavaScript principal pour le thème GreenTech Solutions
 */

(function($) {
    'use strict';
    
    $(document).ready(function() {
        
        // Menu mobile toggle
        $('.mobile-menu-toggle').on('click', function() {
            $('.main-navigation').slideToggle(300);
            $(this).toggleClass('active');
        });
        
        // Fermer le menu mobile lors du clic sur un lien
        $('.main-navigation a').on('click', function() {
            if ($(window).width() <= 768) {
                $('.main-navigation').slideUp(300);
                $('.mobile-menu-toggle').removeClass('active');
            }
        });
        
        // Smooth scroll pour les liens d'ancre
        $('a[href*="#"]').not('[href="#"]').not('[href="#0"]').on('click', function(e) {
            if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') 
                && location.hostname === this.hostname) {
                
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                
                if (target.length) {
                    e.preventDefault();
                    
                    var headerHeight = $('.site-header').outerHeight();
                    var targetOffset = target.offset().top - headerHeight;
                    
                    $('html, body').animate({
                        scrollTop: targetOffset
                    }, 800);
                }
            }
        });
        
        // Animation au scroll (fade-in)
        function checkScroll() {
            $('.service-card, .projet-card').each(function() {
                var elementTop = $(this).offset().top;
                var elementBottom = elementTop + $(this).outerHeight();
                var viewportTop = $(window).scrollTop();
                var viewportBottom = viewportTop + $(window).height();
                
                if (elementBottom > viewportTop && elementTop < viewportBottom) {
                    $(this).addClass('in-view');
                }
            });
        }
        
        // Vérifier au chargement et au scroll
        checkScroll();
        $(window).on('scroll', checkScroll);
        
        // Ajouter une classe au header lors du scroll
        $(window).on('scroll', function() {
            if ($(this).scrollTop() > 50) {
                $('.site-header').addClass('scrolled');
            } else {
                $('.site-header').removeClass('scrolled');
            }
        });
        
    });
    
})(jQuery);