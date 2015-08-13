<?php
/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package   TAP_Cookies
 * @author    Alain Sanchez <luka.ghost@gmail.com>
 * @license   GPL-2.0+
 * @link      http://www.linkedin.com/in/mrbrazzi/
 * @copyright 2014 Alain Sanchez
 */
?>

<div class="wrap">

	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

    <div class="wrap">
        <div class="icon32" id="icon-options-general"></div>

        <form method="post" action="options.php">
            <?php settings_fields(TAP_Cookies::get_instance()->get_plugin_slug() . '-settings' ); ?>
            <?php do_settings_sections( TAP_Cookies::get_instance()->get_plugin_slug() ."-options-page-slug" ); ?>

            <p class="submit">
                <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
            </p>

        </form>
    </div>

</div>
