<?php
/*
Plugin Name: Platzi Badges
Plugin URI:  https://github.com/montalvomiguelo/Platzi-Badges-Plugin
Description: Provides both widgets and shortcodes to dislay your Platzi profile badges on your WordPress site
Version:     1.0
Author:      Montalvo Miguelo
Author URI:  http://montalvomiguelo.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: platzi-badges
*/

// If this file is called directly, abort
if ( ! defined( 'WPINC') ) {
    die;
}

/**
 * Add a link to our plugin in the admin menu
 * Admin > Settings > Platzi Badges
 *
 */
function platzi_badges_menu() {
    /**
     * Use the add_options_page function
     * add_options_page( $page_title, $menu_title, $capability, $menu-slug, $function );
     *
     */
    add_options_page( 'Platzi Badges Plgin', 'Platzi Badges', 'manage_options', 'platzi-badges', 'platzi_badges_options_page');
}
add_action( 'admin_menu', 'platzi_badges_menu' );

// Callback to create the plugin's options page
function platzi_badges_options_page() {
    // Checking user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    // Form was submited
    if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
        // username escaped for HTML blocks
        $platzi_username = esc_html( $_POST['username'] );
        $platzi_profile = platzi_badges_get_profile( $platzi_username );
        $platzi_request_method = ( isset( $_POST['_method'] ) ) ? $_POST['_method'] : '';

        if ( $platzi_profile ) {
            // Update or add 'platzi_badges' option to the wp_options database table
            update_option( 'platzi_badges', array(
                'platzi_username' => $platzi_username,
                'platzi_profile' => $platzi_profile,
                'updated_at' => time()
            ) );
        } else {
            $error = array();
            $error['message'] = 'Could not find user: ' . $platzi_username;
            $error['username'] = $platzi_username;
        }

        if ( empty( $platzi_username ) && $platzi_request_method == 'put' ) {
            delete_option( 'platzi_badges' );
            unset($error);
        }
    }

    // Get values for 'platzi_badges' from the options database table
    $options = get_option( 'platzi_badges' );

    if ( $options ) {
        $platzi_username = $options['platzi_username'];
        $platzi_profile = $options['platzi_profile'];
    }

    require( 'includes/options-page-wrapper.php');

}

/**
 * Get the username's profile from Platzi
 * @param string $platzi_username
 * @return object $platzi_profile or null
 *
 */
function platzi_badges_get_profile( $platzi_username ) {
    $url = 'http://platziprofile.herokuapp.com/' . $platzi_username;
    $args = array( 'timeout' => 120 );
    $response = wp_remote_get( $url, $args );
    $json = $response['body'];
    return json_decode( $json );
}

/**
 * Styles for admin
 *
 */
function platzi_badges_styles() {
    wp_enqueue_style( 'platzi_badges_backend_css', plugins_url( 'css/platzi-badges.css', __FILE__ ) );
}
add_action( 'admin_head', 'platzi_badges_styles' );

/**
 * Create a badges widget
 *
 */
class Platzi_Badges_Widget extends WP_Widget {

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        $widget_ops = array(
            'class_name' => 'platzi_badges_widget',
            'description' => 'Platzi Badges Widget',
        );
        parent::__construct( 'platzi_badges_widget', 'Platzi Badges Widget', $widget_ops );
    }

    /**
     * Outputs the content of the widget
     *
     * @param array $args
     * @param array $instance
     */
    public function widget( $args, $instance ) {
        extract ( $args );

        // outputs the content of the widget
        $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Platzi Badges' );

        /** This filter is documented in wp-includes/widgets/class-wp-widgets-pages.php */
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

        $number = $instance['number'];
        $show_careers = $instance['show_careers'];
        $show_courses = $instance['show_courses'];
        $show_titles = $instance['show_titles'];

        $options = get_option( 'platzi_badges' );

        $badges = $options['platzi_profile']->badges;
        $careers = isset( $badges->careers ) ? $badges->careers : [];
        $courses = isset( $badges->courses ) ? $badges->courses : [];

        $badges = array();

        if ( $show_careers ) {
            foreach ($careers as $badge) {
                $badges[] = $badge;
            }
        }

        if ( $show_courses ) {
            foreach ($courses as $badge) {
                $badges[] = $badge;
            }
        }

        include( 'includes/front-end-badges.php' );

    }

    /**
     * Outputs the options form on admin
     *
     * @param array $instance The widget options
     */
    public function form( $instance ) {
        // outputs the options form on admin
        $title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        $number = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
        $show_careers = isset( $instance['show_careers'] ) ? (bool) $instance['show_careers'] : false;
        $show_courses = isset( $instance['show_courses'] ) ? (bool) $instance['show_courses'] : false;
        $show_titles = isset( $instance['show_titles'] ) ? (bool) $instance['show_titles'] : false;

        $options = get_option( 'platzi_badges' );

        $badges = $options['platzi_profile']->badges;
        $careers = isset( $badges->careers ) ? $badges->careers : [];
        $courses = isset( $badges->courses ) ? $badges->courses : [];

        include( 'includes/widget-fields.php');

    }

    /**
     * Processing widget options on save
     *
     * @param array $new_instance The new options
     * @param array $old_instance The previous options
     */
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = sanitize_text_field( $new_instance['title'] );
        $instance['number'] = intval( $new_instance['number'] );
        $instance['show_careers'] = isset( $new_instance['show_careers'] ) ? (bool) $new_instance['show_careers'] : false;
        $instance['show_courses'] = isset( $new_instance['show_courses'] ) ? (bool) $new_instance['show_courses'] : false;
        $instance['show_titles'] = isset( $new_instance['show_titles'] ) ? (bool) $new_instance['show_titles'] : false;
        return $instance;
    }
}

/**
 * Registering the widget
 *
 */
function platzi_badges_widget() {
    register_widget( 'Platzi_Badges_Widget' );
}
add_action( 'widgets_init', 'platzi_badges_widget' );

/**
 * Frontend loading styles
 *
 */
add_action( 'wp_enqueue_scripts', 'platzi_badges_styles' );

/**
 * Badges shortcode
 * [platzi_badges number="8" show_carrers="true" show_courses="true" show_titles="false"]
 *
 */
function platzi_badges_shortcode( $atts, $content = null ) {
    extract( shortcode_atts( array(
        'number' => '8',
        'careers' => 'on',
        'courses' => 'on',
        'titles' => 'off'
    ), $atts ) );


    if ( $careers == 'on' ) {
        $show_careers = true;
    } else {
        $show_careers = false;
    }

    if ( $courses == 'on' ) {
        $show_courses = true;
    } else {
        $show_courses = false;
    }

    if ( $titles == 'on' ) {
        $show_titles = true;
    } else {
        $show_titles = false;
    }

    $options = get_option( 'platzi_badges' );

    $badges = $options['platzi_profile']->badges;
    $careers = isset( $badges->careers ) ? $badges->careers : [];
    $courses = isset( $badges->courses ) ? $badges->courses : [];

    $badges = array();

    if ( $show_careers ) {
        foreach ($careers as $badge) {
            $badges[] = $badge;
        }
    }

    if ( $show_courses ) {
        foreach ($courses as $badge) {
            $badges[] = $badge;
        }
    }

    ob_start();

    include( 'includes/front-end-badges.php' );

    return ob_get_clean();

}
add_shortcode( 'platzi_badges', 'platzi_badges_shortcode' );
