<?php
/**
 * CT Support Panel - WordPress plugin
 *
 * @link              https://codetot.com
 * @since             1.0.0
 * @package           CT_Support_Panel
 *
 * @wordpress-plugin
 * Plugin Name:       CT - Support Panel
 * Plugin URI:        https://codetot.com/plugin/ct-support-panel
 * Description:       Enable Support Panel in Dashboard to help you send ticket and get support from CODE TOT JSC.
 * Version:           0.0.1
 * Author:            CODE TOT JSC
 * Author URI:        https://codetot.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ct-support-ticket
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define('CT_SUPPORT_PANEL_VERSION', '0.0.1');
define('CT_SUPPORT_PANEL_DIR', plugin_dir_path(__FILE__));
define('CT_SUPPORT_PANEL_URI', plugins_url('ct-support-panel'));

require_once CT_SUPPORT_PANEL_DIR . 'includes/init.php';

/**
 * Run init
 *
 * @return void
 */
function ct_support_panel_run() {
	$plugin = new CT_Support_Panel_Init();
}

ct_support_panel_run();
