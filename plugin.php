<?php

namespace Elementorcontact;

/**
 * Class Plugin
 *
 * Main Plugin class
 * @since 1.0.0
 */
class Plugin
{
    /**
     * Instance
     *
     * @since 1.0.0
     * @access private
     * @static
     *
     * @var Plugin The single instance of the class.
     */
    private static  $_instance = null ;
    /**
     * Instance
     *
     * Ensures only one instance of the class is loaded or can be loaded.
     *
     * @since 1.0.0
     * @access public
     *
     * @return Plugin An instance of the class.
     */
    public static function instance()
    {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    /**
     * Include Widgets files
     *
     * Load widgets files
     *
     * @since 1.0.0
     * @access private
     */
    private function include_widgets_files()
    {
        require_once __DIR__ . '/widgets/phone-widget.php';
        require_once __DIR__ . '/widgets/sms-widget.php';
        require_once __DIR__ . '/widgets/whatsapp-widget.php';
        require_once __DIR__ . '/widgets/email-widget.php';
        require_once __DIR__ . '/widgets/waze-widget.php';
        require_once __DIR__ . '/widgets/messenger-widget.php';
    }
    
    public function cwfe_register_options_page()
    {
        //create new top-level menu
        add_menu_page(
            __( 'Contact Widgets for elementor', 'wpex-elementor-contact-widgets' ),
            __( 'Contact Widgets', 'wpex-elementor-contact-widgets' ),
            'manage_options',
            'contact_widgets',
            'contact_widgets_admin',
            plugins_url( '/includs/contact-icons-16.png', __FILE__ )
        );
    }
    
    public function register_widgets()
    {
        // Its is now safe to include Widgets files
        $this->include_widgets_files();
        // Register Widgets
        \Elementor\Plugin::instance()->widgets_manager->register( new Widgets\WEX_Phone_Widget() );
        \Elementor\Plugin::instance()->widgets_manager->register( new Widgets\WEX_SMS_Widget() );
        \Elementor\Plugin::instance()->widgets_manager->register( new Widgets\WEX_Whatsapp_Widget() );
        \Elementor\Plugin::instance()->widgets_manager->register( new Widgets\WEX_Email_Widget() );
        \Elementor\Plugin::instance()->widgets_manager->register( new Widgets\WEX_Waze_Widget() );
        \Elementor\Plugin::instance()->widgets_manager->register( new Widgets\WEX_Messenger_Widget() );
    }
    
    public function elementor_init()
    {
        $elementor = \Elementor\Plugin::$instance;
        // Add element category in panel
        $elementor->elements_manager->add_category( 'contact-widgets', [
            'title' => __( 'Contact Widgets', 'wpex-elementor-contact-widgets' ),
            'icon'  => 'fa fa-plug',
        ], 1 );
    }
    
    public function init_controls()
    {
        // Include Control files
        //require_once( __DIR__ . '/controls/column-link.php' );
        // Register control
        //new controls\WEX_Column_Link();
    }
    
    /**
     *  Plugin class constructor
     *
     * Register plugin action hooks and filters
     *
     * @since 1.0.0
     * @access public
     */
    public function __construct()
    {
        // Register widgets
        add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );
        add_action( 'elementor/controls/controls_registered', [ $this, 'init_controls' ] );
        // Register scripts
        // Add new category for Elementor
        add_action( 'elementor/init', array( $this, 'elementor_init' ), 1 );
        // Add Admin Menu
        add_action( 'admin_menu', [ $this, 'cwfe_register_options_page' ] );
    }

}
// Instantiate Plugin Class
Plugin::instance();