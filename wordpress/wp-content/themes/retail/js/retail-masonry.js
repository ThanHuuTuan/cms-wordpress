jQuery(document).ready( function($) {
    $('#grid-loop.masonry').imagesLoaded(function () {
        $('#grid-loop.masonry').masonry({
            itemSelector: 'article',
            gutter: 0,
            transitionDuration: 0,
        }).masonry('reloadItems');
    });
});

jQuery( document.body ).on( 'post-load', function ($) {
	jQuery('.infinite-wrap').imagesLoaded(function () {
		jQuery('.infinite-wrap').masonry({
			itemSelector: 'article',
			gutter: 0,
			transitionDuration: 0,
		}).masonry('reloadItems');
	});
});