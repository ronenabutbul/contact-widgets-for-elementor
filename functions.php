<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * Enqueue icon font into your website.
 * Before adding this code, please ensure that you put Fontawesome CSS and webfont into fontawesome folder in your theme.
 */
// ENQUEUE // Enqueueing Frontend stylesheet and scripts.
add_action( 'elementor/editor/before_enqueue_scripts', function () {
    wp_enqueue_style( 'wpexicon', plugins_url( 'includs/style.css', __FILE__ ) );
} );
// FRONTEND // After Elementor registers all styles.
add_action( 'elementor/frontend/after_enqueue_styles', function () {
    wp_enqueue_style( 'wpexicon', plugins_url( 'includs/style.css', __FILE__ ) );
} );
/*function wpex_modify_controls( $controls_registry ) {
	// Get existing icons
	$icons = $controls_registry->get_control( 'icon' )->get_settings( 'options' );
	// Append new icons
	$new_icons = array_merge(
	$icons,
		array(
			'wpex-icon-waze' => 'waze',
	   	    'wpex-icon-sms-1' => 'sms-1',
			'wpex-icon-sms-2' => 'sms-2',
			'wpex-icon-sms-3' => 'sms-3',
			'wpex-icon-facebook-messenger' => 'facebook-messenger',
			'wpex-icon-close' => 'close',
			'wpex-icon-close-2' => 'close-2',
			'wpex-icon-contact-icons' => 'contact-icons',
			
		)
		
	);
	// Then we set a new list of icons as the options of the icon control
	$controls_registry->get_control( 'icon' )->set_settings( 'options', $new_icons );
}


add_action( 'elementor/controls/controls_registered', 'wpex_modify_controls', 10, 1 );*/
//New icons
add_filter( 'elementor/icons_manager/additional_tabs', function ( $cwfe_icon_sets ) {
    // define your own Set
    $cwfe_custom_set = [
        'name'          => 'wpex_icons',
        'label'         => 'Contact Widgets Icons',
        'url'           => plugins_url( 'includs/style.css', __FILE__ ),
        'enqueue'       => [],
        'prefix'        => '',
        'displayPrefix' => '',
        'labelIcon'     => 'wpex-icon-contact-icons',
        'ver'           => '1.0.0',
        'fetchJson'     => plugins_url( 'includs/js/contact-widgets-icons.js', __FILE__ ),
        'icons'         => [
        'wpex-icon-waze',
        'wpex-icon-sms-1',
        'wpex-icon-sms-2',
        'wpex-icon-sms-3',
        'wpex-icon-facebook-messenger',
        'wpex-icon-close',
        'wpex-icon-close-2',
        'wpex-icon-contact-icons'
    ],
    ];
    // add your own Set
    $cwfe_icon_sets[$cwfe_custom_set['name']] = $cwfe_custom_set;
    return $cwfe_icon_sets;
} );
// Admin Page
function contact_widgets_admin()
{
    ?>
  <div>
  <h1><?php 
    print esc_html__( 'Contact Widgets For Elementor', 'wpex-elementor-contact-widgets' );
    ?></h1>
  <h2><?php 
    print esc_html__( 'The easiest way to add contact links to your elementor project', 'wpex-elementor-contact-widgets' );
    ?></h2>
  <h3><?php 
    print esc_html__( 'You are all set, open elementor and enjoy the new widgets (under "contact Widgets" category)', 'wpex-elementor-contact-widgets' );
    ?></h3>
  <p><?php 
    print esc_html__( 'Video Tutorials will be available soom...', 'wpex-elementor-contact-widgets' );
    ?></p>

  </div>
<?php 
}
