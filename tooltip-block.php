<?php

/**
 * Plugin Name:       Tooltip Block
 * Description:       Add tooltips to the WordPress block editor.
 * Requires at least: 6.2
 * Requires PHP:      7.4
 * Version:           1.0.0
 * Author:            Roel Magdaleno
 * Author URI:        https://roelmagdaleno.com
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       tooltip-block
 *
 * @package           Tooltip Block
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once 'vendor/autoload.php';

// Include constants that will be used inside the plugin.
require_once 'constants.php';
require_once 'helpers.php';

// Initialize the plugin functionality.
( new \WP\Tooltip\Tooltip() )->hooks();

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets, so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function create_tooltip_block_init() {
	register_block_type( __DIR__ . '/build' );
}

add_action( 'init', 'create_tooltip_block_init' );
