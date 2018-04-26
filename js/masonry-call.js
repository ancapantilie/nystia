/**
 * masonry-call.js
 *
 * Call Masonry.
 */

jQuery(
    function ($) {

        $( window ).load(
            function() {
                if ( $( '.blog .container ' ).length > 0 ) {
                    $( '.container .blog-posts-wrap' ).masonry(
                        {
                            itemSelector: '.card-blog'
                        }
                    );
                }

            }
        );

    }
);
