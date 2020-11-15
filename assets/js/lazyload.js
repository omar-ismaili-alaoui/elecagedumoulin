$(document).ready(function() {
    /*global LazyLoad: false*/
    "use strict";

    var myLazyLoad = new LazyLoad({
        class_loaded:      'loaded',
        data_src:          'src',
        data_srcset:       'srcset',
        elements_selector: '.lazy',
    });

    // fix for carousel images
    $('.carousel')
        .on('slide.bs.carousel', function (e) {// before
            $(e.relatedTarget).find('[data-srcset]').each(function() {
//console.log('srcset change');
                $(this).attr('srcset', $(this).data('srcset'));
            });

            $(e.relatedTarget).find('[data-src]').each(function() {
//console.log('src change');
                $(this).attr('src', $(this).data('src'));
            });
        })
        .on('slid.bs.carousel', function (e) {// after
            $(e.relatedTarget).find('[data-srcset]').each(function() {
//console.log('srcset delete');
                $(this).removeAttr('data-srcset');
            });

            $(e.relatedTarget).find('[data-src]').each(function() {
//console.log('srcset delete');
                $(this).removeAttr('data-src');
            });
        })
    ;
});
