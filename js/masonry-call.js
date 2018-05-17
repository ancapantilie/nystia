/**
 * masonry-call.js
 *
 * Call Masonry.
 */

( function ($) {

        $( '.blog .hestia-blogs .blog-posts-wrap .card-blog' ).addClass( 'col-md-6 col-xs-12' );
        $( '.archive .hestia-blogs .archive-post-wrap .card-blog' ).addClass( 'col-md-6 col-xs-12' );
        $( window ).load(
            function() {
                if ( $( '.blog .hestia-blogs .blog-posts-wrap' ).length > 0 ) {

                    $( '.blog .hestia-blogs .blog-posts-wrap' ).masonry(
                        {
                            itemSelector: '.card-blog'
                        }
                    );
                }

                if ($( '.archive .hestia-blogs .archive-post-wrap' ).length > 0 ){

                    $( '.archive .hestia-blogs .archive-post-wrap' ).masonry (
                        {
                            itemSelector: '.card-blog'
                        }
                    );
                }

            }
        );

    }
)( jQuery );

