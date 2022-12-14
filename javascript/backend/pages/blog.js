/* ========================================================================
 * blog.js
 * Page/renders: page-blog-*.html
 * Plugins used: owl carousel, shuffle
 * ======================================================================== */

'use strict';

(function (factory) {
    if (typeof define === 'function' && define.amd) {
        define([
            'owl-carousel',
            'shuffle'
        ], factory);
    } else {
        factory();
    }
}(function () {

    $(function () {
        // Owl carousel
        // ================================
        if ($('#carousel1').length > 0) {
            $('#carousel1').owlCarousel({
                lazyLoad: true,
                slideSpeed: 300,
                paginationSpeed: 400,
                singleItem: true,
                autoPlay: true,
                stopOnHover: true
            });
        }
        if ($('#carousel2').length > 0) {
            $('#carousel2').owlCarousel({
                lazyLoad: true,
                slideSpeed: 300,
                paginationSpeed: 400,
                singleItem: true,
                pagination: false,
                navigation: true,
                autoPlay: true,
                stopOnHover: true
            });
        }

        // Shuffle
        // ================================
        if ($('#shuffle-grid').length > 0) {
            // Shuffle
            // ================================
            var $grid   = $('#shuffle-grid'),
                $sizer  = $grid.find('shuffle-sizer');
            
            // instatiate shuffle
            $grid.shuffle({
                itemSelector: '.post',
                sizer: $sizer
            });

            // Update shuffle on sidebar minimize/maximize
            $('html')
                .on('fa.sidebar.minimize', function () { $grid.shuffle('update'); })
                .on('fa.sidebar.maximize', function () { $grid.shuffle('update'); });
        }

        // Ajax form : On success / done
        // ================================
        $('html').on('fa.formajax.done', function (event, data) {
            // construct bootstrap alert with some css animation
            var bsalert = '';
                bsalert += '<div class="alert alert-success animation animating flipInX">';
                bsalert += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>';
                bsalert += '<h4 class="semibold mb5">Success!</h4>';
                bsalert += '<p class="nm">'+data.response.text+'</p>';
                bsalert += '</div>';

            // append to affected form
            data.element
                .find('.message-container')
                .html(bsalert);
        });
    });

}));