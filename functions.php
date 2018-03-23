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
        $custom_css .= '.hestia-pricing .hestia-table-one .card-pricing .category { color: ' . esc_html( $color_accent ) . '; }';
        $custom_css .= '.hestia-pricing .hestia-table-two .card-pricing { background-color: ' . esc_html( $color_accent ) . '; }';

        /* Categories */
        $custom_css .= '.entry-categories .label { background-color: ' . esc_html( $color_accent ) . ';}';

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

