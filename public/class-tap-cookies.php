<?php
/**
 * Plugin Name.
 *
 * @package   TAP_Cookies
 * @author    Alain Sanchez <asanchezg@inetzwerk.com>
 * @license   GPL-2.0+
 * @link      http://www.inetzwerk.com
 * @copyright 2014 Alain Sanchez
 */

/**
 * Plugin class. This class should ideally be used to work with the
 * public-facing side of the WordPress site.
 *
 * If you're interested in introducing administrative or dashboard
 * functionality, then refer to `class-tap-cookies-admin.php`
 *
 *
 * @package TAP_Cookies
 * @author  Your Name <email@example.com>
 */
class TAP_Cookies {

    var $information_box_title = 'Politica de Cookies';
    var $information_box_text = 'Este sitio web utiliza cookies propias y de terceros que nos permiten ofrecer nuestros servicios. Al utilizar nuestros servicios, aceptas el uso que hacemos de las cookies. <a href="http://todoapuestas.org/blog/politica-de-cookies/" rel="nofollow" target="_blank">Mas informacion</a>';
    var $information_box_position = 'bottom-full-width';
    var $cookies = array(
        array(
            "name"			=> "__utma",
            "description" 	=> "",
            "group"			=> "Google Analytics"
        ),

        array(
            "name"			=> "__utmb",
            "description" 	=> "",
            "group"			=> "Google Analytics"
        ),

        array(
            "name"			=> "__utmc",
            "description" 	=> "",
            "group"			=> "Google Analytics"
        ),

        array(
            "name"			=> "__utmv",
            "description" 	=> "",
            "group"			=> "Google Analytics"
        ),

        array(
            "name"			=> "__utmz",
            "description" 	=> "",
            "group"			=> "Google Analytics"
        ),

        array(
            "name"			=> "wp-settings-time-1",
            "description" 	=> "",
            "group"			=> "WordPress"
        ),

        array(
            "name"			=> "wp-settings-1",
            "description" 	=> "",
            "group"			=> "WordPress"
        ),

        array(
            "name"			=> "wordpress_test_cookie",
            "description" 	=> "Wordpress test cookie",
            "group"			=> "WordPress"
        ),
    );

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	const VERSION = '1.0.0';

	/**
	 *
	 * Unique identifier for your plugin.
	 *
	 *
	 * The variable name is used as the text domain when internationalizing strings
	 * of text. Its value should match the Text Domain file header in the main
	 * plugin file.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'tap-cookies';

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// Activate plugin when new blog is added
		add_action( 'wpmu_new_blog', array( $this, 'activate_new_site' ) );

		// Load public-facing style sheet and JavaScript.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

        /* Define custom functionality.
         * Refer To http://codex.wordpress.org/Plugin_API#Hooks.2C_Actions_and_Filters
         *
         * add_action ( 'hook_name', 'your_function_name', [priority], [accepted_args] );
         *
         * add_filter ( 'hook_name', 'your_filter', [priority], [accepted_args] );
         */
        add_action('wp_footer', array($this, 'enqueue_scripts_footer'), 20);

        /**
         * Create "tap_cookies" shortcode
         *
         *  [tap_cookies]
         */
        add_shortcode('tap_cookies', array($this, 'cookies_table'));

        /**
         * Create "tap-cookies" shortcode
         *
         *  [tap-cookies]
         */
        add_shortcode('tap-cookies', array($this, 'cookies_table'));

        // allow shortcodes in widgets
        add_filter('widget_text', 'do_shortcode');
	}

	/**
	 * Return the plugin slug.
	 *
	 * @since    1.0.0
	 *
	 * @return    Plugin slug variable.
	 */
	public function get_plugin_slug() {
		return $this->plugin_slug;
	}

    /**
     * Get cookies
     *
     * @since     1.0.0
     *
     * @return array
     */
    public function get_cookies()
    {
        return get_option('tap_cookies_list', $this->cookies);
    }

    /**
     * Get cookie message title
     *
     * @since     1.2.0
     *
     * @return string
     */
    public function get_information_box_title()
    {
        return get_option( 'tap_cookies_information_box_title', $this->information_box_title ) ;
    }


    /**
     * Get cookie message text
     *
     * @since     1.2.0
     *
     * @return string
     */
    public function get_information_box_text()
    {
        return get_option( 'tap_cookies_information_box_text', $this->information_box_text );
    }

    /**
     * Get cookie message text
     *
     * @since     1.2.0
     *
     * @return string
     */
    public function get_information_box_position()
    {
        return get_option( 'tap_cookies_information_box_position', $this->information_box_position );
    }

    /**
     * Get unknown cookies array
     *
     * @since     1.0.0
     *
     * @return array
     */
    public function get_unknown_cookies()
    {
        $unknown_cookies = array();
        $cookies = $this->get_cookies();
        if(is_array($cookies) && !empty($cookies)) {
            foreach($cookies as $x) {
                if(!empty($x['name']))
                    $cookie_names[] = $x['name'];
            }
        }

        if(is_array($_COOKIE)) {
            foreach($_COOKIE as $k=>$v) {
                if(!in_array($k, $cookie_names)) {
                    $unknown_cookies[] = $k;
                }
            }
        }

        return $unknown_cookies;
    }

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Fired when the plugin is activated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses
	 *                                       "Network Activate" action, false if
	 *                                       WPMU is disabled or plugin is
	 *                                       activated on an individual blog.
	 */
	public static function activate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide  ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_activate();

					restore_current_blog();
				}

			} else {
				self::single_activate();
			}

		} else {
			self::single_activate();
		}

	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses
	 *                                       "Network Deactivate" action, false if
	 *                                       WPMU is disabled or plugin is
	 *                                       deactivated on an individual blog.
	 */
	public static function deactivate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_deactivate();

					restore_current_blog();

				}

			} else {
				self::single_deactivate();
			}

		} else {
			self::single_deactivate();
		}

	}

	/**
	 * Fired when a new site is activated with a WPMU environment.
	 *
	 * @since    1.0.0
	 *
	 * @param    int    $blog_id    ID of the new blog.
	 */
	public function activate_new_site( $blog_id ) {

		if ( 1 !== did_action( 'wpmu_new_blog' ) ) {
			return;
		}

		switch_to_blog( $blog_id );
		self::single_activate();
		restore_current_blog();

	}

	/**
	 * Get all blog ids of blogs in the current network that are:
	 * - not archived
	 * - not spam
	 * - not deleted
	 *
	 * @since    1.0.0
	 *
	 * @return   array|false    The blog ids, false if no matches.
	 */
	private static function get_blog_ids() {

		global $wpdb;

		// get an array of blog ids
		$sql = "SELECT blog_id FROM $wpdb->blogs
			WHERE archived = '0' AND spam = '0'
			AND deleted = '0'";

		return $wpdb->get_col( $sql );

	}

	/**
	 * Fired for each blog when the plugin is activated.
	 *
	 * @since    1.2.0
	 */
	private static function single_activate() {
        if(!get_option('tap_cookies_information_box_title'))
            add_option('tap_cookies_information_box_title', self::get_instance()->get_information_box_title());

        if(!get_option('tap_cookies_information_box_text'))
            add_option('tap_cookies_information_box_text', self::get_instance()->get_information_box_text());

        if(!get_option('tap_cookies_information_box_position'))
            add_option('tap_cookies_information_box_position', self::get_instance()->get_information_box_position());

        if(!get_option('tap_cookies_list'))
            add_option('tap_cookies_list', self::get_instance()->get_cookies());
	}

	/**
	 * Fired for each blog when the plugin is deactivated.
	 *
	 * @since    1.2.0
	 */
	private static function single_deactivate() {
        remove_action("init", array(self::get_instance(), 'init'));

        delete_option('tap_cookies_information_box_title');
        delete_option('tap_cookies_information_box_text');
        delete_option('tap_cookies_information_box_position');
        delete_option('tap_cookies_list');
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		$domain = $this->plugin_slug;
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, FALSE, basename( plugin_dir_path( dirname( __FILE__ ) ) ) . '/languages/' );

	}

	/**
	 * Register and enqueue public-facing style sheet.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
        wp_enqueue_style($this->plugin_slug . '-toastr', plugins_url( 'assets/css/toastr.min.css', __FILE__ ), array(), '2.0.1');
		wp_enqueue_style( $this->plugin_slug . '-plugin-styles', plugins_url( 'assets/css/tap-cookies.css', __FILE__ ), array(), self::VERSION );
	}

	/**
	 * Register and enqueues public-facing JavaScript files.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script('jquery.cookies', plugins_url( 'assets/js/jquery.cookie.js', __FILE__ ), array( 'jquery' ), self::VERSION, true );
        wp_enqueue_script('toastr', plugins_url( 'assets/js/toastr.min.js', __FILE__ ), array( 'jquery' ), self::VERSION, true );
	}

    /**
     * Add scripts to footer
     *
     * @since     1.2.0
     */
    public function enqueue_scripts_footer() { ?>  <script type="text/javascript">
        var TAP_Cookies = function(){
            var cookie_name = '_tap_cookie';
            var information_box_title = '<?php echo $this->get_information_box_title(); ?>';
            var information_box_text = '<?php echo $this->get_information_box_text(); ?>';
            var position = '<?php echo $this->get_information_box_position(); ?>';

            var create_cookie = function(){
                jQuery.cookie(cookie_name, 1, { expires: 365, path: '/' });
            }

            var clear_cookies = function() {
                var all_cookies = document.cookie.split(";");

                for(var i = 0; i < all_cookies.length; i++){
                    jQuery.cookie(all_cookies[i].split("=")[0], null, { expires: -365, path: '/' } );
                }
            }

            return {
                init: function(){
                    toastr.options = {
                        "closeButton": true,
                        "debug": true,
                        "positionClass": "toast-"+position,
                        "showDuration": "10000000",
                        "hideDuration": "10000000",
                        "timeOut": "10000000",
                        "extendedTimeOut": "10000000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut",
                        onHidden: function() {
                            create_cookie();
                        }
                    }

                    var cookie_value = jQuery.cookie(cookie_name);
                    if(cookie_value == null || !cookie_value){
                        clear_cookies();
                    }

                    if(cookie_value){
                        toastr.clear();
                    }else{
                        toastr.info(information_box_text, information_box_title);
                    }
                }

            }

        }();

        (function ( $ ) {
            "use strict";

            $(function () {

                TAP_Cookies.init();

            });

        }(jQuery));
    </script>
<?php
    }

    /**
     * Create "tap_cookies" or "tap-cookies" shortcode
     *
     * @since     1.0.0
     *
     * @param $atts
     * @return string
     */
    function cookies_table($atts = null) {
        $cookies = $this->get_cookies();
        if(is_array($cookies) && !empty($cookies)) {
            ob_start(); ?>
            <table class="table table-striped table-condensed tap-cookies-table">
                <thead>
                    <tr>
                        <th><?php _e('Name', $this->plugin_slug) ?></th>
                        <th><?php _e('Group', $this->plugin_slug) ?></th>
                        <th><?php _e('Description', $this->plugin_slug) ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php
                foreach($cookies as $x):
                    if(!empty($x['name'])) : ?>
                        <tr >
                            <td><?php print $x['name'] ?></td>
                            <td><?php print isset($x['group']) ? $x['group'] : ''; ?></td>
                            <td><?php print isset($x['description']) ? $x['description'] : ''; ?></td>
                        </tr>
<?php               endif;
                endforeach; ?>
                </tbody>
            </table>
            <?php
            $string=ob_get_contents();
            ob_end_clean();
        }

        return $string;
    }

}
