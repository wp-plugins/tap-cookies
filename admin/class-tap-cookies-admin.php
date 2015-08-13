<?php
/**
 * Plugin Name.
 *
 * @package   TAP_Cookies_Admin
 * @author    Alain Sanchez <luka.ghost@gmail.com>
 * @license   GPL-2.0+
 * @link      http://www.linkedin.com/in/mrbrazzi/
 * @copyright 2014 Alain Sanchez
 */

/**
 * Plugin class. This class should ideally be used to work with the
 * administrative side of the WordPress site.
 *
 * If you're interested in introducing public-facing
 * functionality, then refer to `class-tap-cookies.php`
 *
 * @package TAP_Cookies_Admin
 * @author  Your Name <email@example.com>
 */
class TAP_Cookies_Admin {

    private $plugin_slug;

    /**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Initialize the plugin by loading admin scripts & styles and adding a
	 * settings page and menu.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		/*
		 */
		/* if( ! is_super_admin() ) {
			return;
		} */

		/*
		 * Call $plugin_slug from public plugin class.
		 *
		 */
		$plugin = TAP_Cookies::get_instance();
		$this->plugin_slug = $plugin->get_plugin_slug();

        /* Define custom functionality.
         * Refer To http://codex.wordpress.org/Plugin_API#Hooks.2C_Actions_and_Filters
         *
         * add_action ( 'hook_name', 'your_function_name', [priority], [accepted_args] );
         *
         * add_filter ( 'hook_name', 'your_filter', [priority], [accepted_args] );
         */
//        add_action("admin_init", array($this, 'init'));
        add_action("wp_dashboard_setup", array($this, "dashboard_setup"));

	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		/*
		 */
		/* if( ! is_super_admin() ) {
			return;
		} */

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

    /**
     * Return html list of unknown cookies detected
     *
     * @since     1.2.0
     *
     * @return string
     */
    public function unknown_cookies_detected(){
        $unknown_cookies = TAP_Cookies::get_instance()->get_unknown_cookies();
        if(is_array($unknown_cookies)) : ob_start();   ?>
        <?php _e('The following cookies were detected and are not declared', $this->plugin_slug)?>:</p>
        <ul style="padding-left: 15px; list-style: disc;">
        <?php foreach($unknown_cookies as $x): ?>
            <li><?php print $x; ?></li>
        <?php endforeach; ?>
        </ul><p><?php
        endif;
        $string = ob_get_contents();
        ob_end_clean();
        return $string;
    }

    /**
     * Show a widget area with list of unknown cookies detected
     *
     * @since     1.2.0
     */
    function unknown_cookies_detected_dashboard_widget() {
        $unknown_cookies = TAP_Cookies::get_instance()->get_unknown_cookies();
        if(is_array($unknown_cookies)) {
            ?>
            <p><?php _e('The following cookies were detected and are not declared', $this->plugin_slug)?>:</p>
            <ul style="padding-left: 15px; list-style: disc;">
                <?php
                foreach($unknown_cookies as $x) {
                    ?>
                    <li><?php print $x; ?></li>
                <?php
                }
                ?>
            </ul>
            <p><?php printf(__('To declare a cookie go to Settings > <a href="%1$s">TAP Cookies</a>', $this->plugin_slug), admin_url( 'options-general.php?page=' . $this->plugin_slug ))?>.</p>
        <?php
        }
    }

    /**
     * Register a widget on dashboard to show the list of unknown cookies detected
     *
     * @since 1.2.0
     */
    function dashboard_setup() {
        $unknown_cookies = TAP_Cookies::get_instance()->get_unknown_cookies();
        if(!empty($unknown_cookies))
            wp_add_dashboard_widget($this->plugin_slug.'-dashboard-widget', 'TAP Cookies Plugin', array($this, 'unknown_cookies_detected_dashboard_widget'));
    }
}
