<?php
if ( !defined( 'ABSPATH' ) ) exit;

if ( !function_exists( 'nystia_parent_css' ) ):
    function nystia_parent_css() {
        wp_enqueue_style( 'nystia_parent', trailingslashit( get_template_directory_uri() ) . 'style.css', array( 'bootstrap' ) );
        if( is_rtl() ) {
            wp_enqueue_style( 'nystia_parent_rtl', trailingslashit( get_template_directory_uri() ) . 'style-rtl.css', array( 'bootstrap' ) );
        }

    }
endif;
add_action( 'wp_enqueue_scripts', 'nystia_parent_css', 10 );

/**
 * Change default fonts
 *
 * @since 1.0.0
 */
function nystia_change_defaults( $wp_customize ) {

    /* Change default fonts */
    $nystia_headings_font = $wp_customize->get_setting( 'hestia_headings_font' );
    if ( ! empty( $nystia_headings_font ) ) {
        $nystia_headings_font->default = nystia_font_default_frontend();
    }
    $nystia_body_font = $wp_customize->get_setting( 'hestia_body_font' );
    if ( ! empty( $nystia_body_font ) ) {
        $nystia_body_font->default = nystia_font_default_frontend();
    }
}
add_action( 'customize_register', 'nystia_change_defaults', 99 );

/**
 * Change defaults on frontend
 */
function nystia_font_default_frontend() {
    return 'Open Sans';
}

add_filter( 'hestia_headings_default', 'nystia_font_default_frontend' );
add_filter( 'hestia_body_font_default', 'nystia_font_default_frontend' );

/**
 * Import options from the parent theme
 *
 * @since 1.0.0
 */
function nystia_get_parent_options() {
    $hestia_mods = get_option( 'theme_mods_hestia' );
    if ( ! empty( $hestia_mods ) ) {
        foreach ( $hestia_mods as $hestia_mod_k => $hestia_mod_v ) {
            set_theme_mod( $hestia_mod_k, $hestia_mod_v );
        }
    }
}
add_action( 'after_switch_theme', 'nystia_get_parent_options' );

/**
 * Remove boxed layout control
 *
 * @since 1.0.0
 */
function nystia_remove_boxed_layout( $wp_customize ) {
    $wp_customize->remove_control( 'hestia_general_layout' );
}
add_action( 'customize_register', 'nystia_remove_boxed_layout', 100 );

/**
 * Change default value of accent color
 *
 * @return string - default accent color
 * @since 1.0.0
 */
function nystia_accent_color() {
    return '#00afb5';
}
add_filter( 'hestia_accent_color_default', 'nystia_accent_color' );

/**
 * Change default value of gradient color
 *
 * @return string - default gradient color
 * @since 1.0.0
 */
function nystia_gradient_color() {
    return '#ff7700';
}
add_filter( 'hestia_header_gradient_default', 'nystia_gradient_color' );

/**
 * Add color_accent on some elements
 *
 * @since 1.0.0
 */
function nystia_inline_style() {

    $color_accent = get_theme_mod( 'accent_color', '#ff7700' );

    $custom_css = '';

    if ( ! empty( $color_accent ) ) {


        /* Pricing section */
        $custom_css .= '.hestia-pricing .hestia-table-one a.btn.btn-primary { color: ' . esc_html( $color_accent ) . '; background-color: #fff;}';

        /* Categories */
        $custom_css .= '.entry-categories .label { background-color: ' . esc_html( $color_accent ) . ';}';
        $custom_css .= '.authors-on-blog .card-profile .card-title { color: ' . esc_html( $color_accent ) . ';}';


        /* Tags*/
        $custom_css .= '.entry-tags .entry-tag { color:' . esc_html( $color_accent ) . ';}';

        /* Shop Sidebar Rating*/
        $custom_css .= '.woocommerce .star-rating { color: ' . esc_html( $color_accent ) . '; }';

        /* Single Product Page Rating */
        $custom_css .= '.woocommerce div.product p.stars span a:before { color: ' . esc_html( $color_accent ) . '; }';

        /* Cart action buttons */
        $custom_css .= '.woocommerce-cart table.shop_table tr td.actions input[type=submit] { background-color: ' . esc_html( $color_accent ) . '; }';
        $custom_css .= '.woocommerce-cart table.shop_table tr td.actions input[type=submit]:hover { background-color: ' . esc_html( $color_accent ) . '; }';

        /* WooCommerce message */
        $custom_css .= '.woocommerce-page .woocommerce-message { background-color: ' . esc_html( $color_accent ) . '; }';

        /* WooCommerce My Order Tracking Page */
        $custom_css .= '.track_order input[type=submit] { background-color: ' . esc_html( $color_accent ) . '; }';
        $custom_css .= '.track_order input[type=submit]:hover { background-color: ' . esc_html( $color_accent ) . '; }';

        /* WooCommerce tag widget */
        $custom_css .= 'div[id^=woocommerce_product_tag_cloud].widget a { background-color: ' . esc_html( $color_accent ) . '; }';

        /* WooCommerce Cart widget */
        $custom_css .= '.woocommerce.widget_shopping_cart .buttons > a.button { background-color: ' . esc_html( $color_accent ) . '; }';
        $custom_css .= '.woocommerce.widget_shopping_cart .buttons > a.button:hover { background-color: ' . esc_html( $color_accent ) . '; }';
    }

    wp_add_inline_style( 'nystia_parent', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'nystia_inline_style', 10 );


/**
 * Change default header image in Big Title Section
 *
 * @since 1.0.0
 * @return string - path to image
 */
function nystia_header_background_default() {
    return get_stylesheet_directory_uri() . '/assets/img/header.jpg';
}
add_filter( 'hestia_big_title_background_default', 'nystia_header_background_default' );

/**
 * Get the number of comments for a post
 *
 * @return string - number of comments
 */
function cwp_post_number_of_comments(){
    $comments_number = get_comments_number();
    if( 1 === (int)$comments_number ) {
        return sprintf( _x( 'One comment', 'comments_title', 'cwp') );
    } else if ( 0 === (int)$comments_number ) {
        return sprintf( _x( 'No comments', 'comments_title', 'cwp') );
    } else  {
        return sprintf(
            _nx(
                '%1$s Comment',
                '%1$s comments',
                $comments_number,
                'comments title',
                'cwp'
            ),
            number_format_i18n($comments_number)
        );
    }
}

/**
 * Display entry meta for post
 *
 * @param bool $show_gravatar - show post's author's image
 */
function nystia_display_entry_data( $show_gravatar = false ) {

    $categories_list = get_the_category_list( ', ');

    $m_time_g = get_the_modified_time( 'F j, Y' );
    $p_time = get_the_time('F j, Y');
    $date = sprintf(
        '<time class="entry-date" itemprop="dateModified" datetime="'. $m_time_g.'"> • On %1$s</time><meta itemprop="datePublished" content="' . $p_time.'">',
        $p_time
    );

    $author = sprintf('<span itemprop="author" itemscope="itemscope" itemtype="http://schema.org/Person"><span class="vcard author">%1$s</span>', get_the_author());
	$author_email = get_the_author_meta ('user_email');
	$avatar = get_avatar($author_email);
	$post_comments = cwp_post_number_of_comments();


	if ( $categories_list && $show_gravatar ) {
        $wrapping_text = '<span class = "author"><div class = "author-with-avatar">%1$s</div><span class = "post-author"<b>%2$s</b></span></span><span class="avatar-category"> • In %3$s </span> %4$s <span class = "number-of-comments" > • %5$s </span>';
    } else if ( $show_gravatar ) {
	    $wrapping_text = '<span class = "author"><div class = "author-with-avatar">%1$s</div><span class = "post-author"<b>%2$s</b></span></span> %4$s <span class = " number-of-comments" > • %5$s </span>';
	} else if ($categories_list) {
	    $wrapping_text = '<span class = "author"><div class = "vcard author"> by <b>%2$s</b> </div></span><span class="avatar-category">• In %3$s</span> %4$s <span class = "number-of-comments" > • %5$s </span>';
    } else {
	    $wrapping_text = '<span class = "author"><div class = "vcard author"> by <b>%2$s</b> </div></span> %4$s <span class = "number-of-comments" > • %5$s </span>';
    }

    printf (
            $wrapping_text,
            $avatar,
            $author,
            $categories_list,
            $date,
            $post_comments
    );

}

add_filter('hestia_blog_post_meta', 'nystia_display_entry_data');

/**
 * Define excerpt length.
 *
 * @since 1.0.0
 */

function nystia_excerpt_length( $length ) {
    if ( is_admin() ) {
        return $length;
    }
    if  ( 'page' === get_option( 'show_on_front' ) && is_front_page() )   {
        return 0;
    } elseif ( is_home() || is_single()) {
        if ( is_active_sidebar( 'sidebar-1' ) ) {
            return 20;
        } else {
            return 75;
        }
    } else {
        return 20;
    }
}

add_filter( 'excerpt_length', 'nystia_excerpt_length', 9999 );

/**
 * Enqueue scripts and styles.
 *
 * @since 1.0.0
 */

function nystia_scripts() {
//    if ( is_category() || is_search() || is_archive() || is_home() ) {

        $masonry_path = get_stylesheet_directory_uri() . '/js/masonry-call.js';

        wp_enqueue_script( 'nystia-masonry-call', $masonry_path, array( 'masonry' ), '20120206', true );
//    }

}
add_action( 'wp_enqueue_scripts', 'nystia_scripts' );
