<?php

/**
 * Plugin Name: Contact Widgets For Elementor
 * Plugin URI:			https://contactwidgets.com
 * Description:			Add contact widgets to the popular free page builder Elementor.
 * Version:				1.0.8
 * Author:				WPex - Ronen Abutbul
 * Author URI:			https://contactwidgets.com
 * Text Domain: 		wpex-elementor-contact-widgets
 * Domain Path: 	 	/languages
 */
if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if ( function_exists( 'cwfe_fs' ) ) {
    cwfe_fs()->set_basename( false, __FILE__ );
} else {
    
    if ( !function_exists( 'cwfe_fs' ) ) {
        // Create a helper function for easy SDK access.
        function cwfe_fs()
        {
            global  $cwfe_fs ;
            
            if ( !isset( $cwfe_fs ) ) {
                // Include Freemius SDK.
                require_once dirname( __FILE__ ) . '/freemius/start.php';
                $cwfe_fs = fs_dynamic_init( array(
                    'id'             => '3992',
                    'slug'           => 'contact-widgets-for-elementor',
                    'type'           => 'plugin',
                    'public_key'     => 'pk_af6da3d9b5ed6a459cd360e059830',
                    'is_premium'     => false,
                    'has_addons'     => false,
                    'has_paid_plans' => true,
                    'menu'           => array(
                    'slug' => 'contact_widgets',
                ),
                    'is_live'        => true,
                ) );
            }
            
            return $cwfe_fs;
        }
        
        // Init Freemius.
        cwfe_fs();
        // Signal that SDK was initiated.
        do_action( 'cwfe_fs_loaded' );
    }

}

/**
 * Main Wpexpress Contact Elementor Widgets
 *
 * The main class that initiates and runs the plugin.
 *
 * @since 1.0.0
 */
final class Wpex_Elementor_Contact_Widgets
{
    /**
     * Plugin Version
     *
     * @since 1.0.0
     * @var string The plugin version.
     */
    const  VERSION = '1.0.8' ;
    /**
     * Minimum Elementor Version
     *
     * @since 1.0.0
     * @var string Minimum Elementor version required to run the plugin.
     */
    const  MINIMUM_ELEMENTOR_VERSION = '3.1' ;
    /**
     * Minimum PHP Version
     *
     * @since 1.0.0
     * @var string Minimum PHP version required to run the plugin.
     */
    const  MINIMUM_PHP_VERSION = '7.0' ;
    /**
     * Constructor
     *
     * @since 1.0.0
     * @access public
     */
    public function __construct()
    {
        // Load translation
        add_action( 'init', array( $this, 'i18n' ) );
        // Init Plugin
        add_action( 'plugins_loaded', array( $this, 'init' ) );
    }
    
    /**
     * Load Textdomain
     *
     * Load plugin localization files.
     * Fired by `init` action hook.
     *
     * @since 1.0.0
     * @access public
     */
    public function i18n()
    {
        load_plugin_textdomain( 'wpex-elementor-contact-widgets', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
        //load_plugin_textdomain( 'wpex-elementor-contact-widgets' );
    }
    
    /**
     * Initialize the plugin
     *
     * Validates that Elementor is already loaded.
     * Checks for basic plugin requirements, if one check fail don't continue,
     * if all check have passed include the plugin class.
     *
     * Fired by `plugins_loaded` action hook.
     *
     * @since 1.0.0
     * @access public
     */
    public function init()
    {
        // Check if Elementor installed and activated
        
        if ( !did_action( 'elementor/loaded' ) ) {
            add_action( 'admin_notices', array( $this, 'admin_notice_missing_main_plugin' ) );
            return;
        }
        
        // Check for required Elementor version
        
        if ( !version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
            add_action( 'admin_notices', array( $this, 'admin_notice_minimum_elementor_version' ) );
            return;
        }
        
        // Check for required PHP version
        
        if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
            add_action( 'admin_notices', array( $this, 'admin_notice_minimum_php_version' ) );
            return;
        }
        
        // Once we get here, We have passed all validation checks so we can safely include our plugin
        require_once 'plugin.php';
        require_once 'functions.php';
    }
    
    /**
     * Admin notice
     *
     * Warning when the site doesn't have Elementor installed or activated.
     *
     * @since 1.0.0
     * @access public
     */
    public function admin_notice_missing_main_plugin()
    {
        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }
        $message = sprintf(
            /* translators: 1: Plugin name 2: Elementor */
            esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'wpex-elementor-contact-widgets' ),
            '<strong>' . esc_html__( 'Contact Widgets For Elementor', 'wpex-elementor-contact-widgets' ) . '</strong>',
            '<strong>' . esc_html__( 'Elementor', 'wpex-elementor-contact-widgets' ) . '</strong>'
        );
        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }
    
    /**
     * Admin notice
     *
     * Warning when the site doesn't have a minimum required Elementor version.
     *
     * @since 1.0.0
     * @access public
     */
    public function admin_notice_minimum_elementor_version()
    {
        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }
        $message = sprintf(
            /* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
            esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'wpex-elementor-contact-widgets' ),
            '<strong>' . esc_html__( 'Contact Widgets For Elementor', 'wpex-elementor-contact-widgets' ) . '</strong>',
            '<strong>' . esc_html__( 'Elementor', 'wpex-elementor-contact-widgets' ) . '</strong>',
            self::MINIMUM_ELEMENTOR_VERSION
        );
        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }
    
    /**
     * Admin notice
     *
     * Warning when the site doesn't have a minimum required PHP version.
     *
     * @since 1.0.0
     * @access public
     */
    public function admin_notice_minimum_php_version()
    {
        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }
        $message = sprintf(
            /* translators: 1: Plugin name 2: PHP 3: Required PHP version */
            esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'wpex-elementor-contact-widgets' ),
            '<strong>' . esc_html__( 'Contact Widgets For Elementor', 'wpex-elementor-contact-widgets' ) . '</strong>',
            '<strong>' . esc_html__( 'PHP', 'wpex-elementor-contact-widgets' ) . '</strong>',
            self::MINIMUM_PHP_VERSION
        );
        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }

}
// Instantiate Wpex_Elementor_Contact_Widgets.
new Wpex_Elementor_Contact_Widgets();