<?php

namespace Tooltip;

class PostType {
	/**
	 * Register the action and filter hooks to start the functionality.
	 *
	 * @since 1.0.0
	 */
	public function hooks() {
		add_action( 'init', array( $this, 'register' ) );
	}

	/**
	 * Register the post type.
	 * The post type only includes the title and editor.
	 *
	 * @since 1.0.0
	 */
	public function register() : void {
		$labels = array(
			'name'                  => 'Tooltips',
			'singular_name'         => 'Tooltip',
			'menu_name'             => 'Tooltips',
			'name_admin_bar'        => 'Tooltip',
			'add_new'               => __( 'Add New', 'tooltip-block' ),
			'add_new_item'          => __( 'Add New Tooltip', 'tooltip-block' ),
			'new_item'              => __( 'New Tooltip', 'tooltip-block' ),
			'edit_item'             => __( 'Edit Tooltip', 'tooltip-block' ),
			'view_item'             => __( 'View Tooltip', 'tooltip-block' ),
			'all_items'             => __( 'All Tooltips', 'tooltip-block' ),
			'search_items'          => __( 'Search Tooltips', 'tooltip-block' ),
			'parent_item_colon'     => __( 'Parent Tooltips:', 'tooltip-block' ),
			'not_found'             => __( 'No Tooltips Found.', 'tooltip-block' ),
			'not_found_in_trash'    => __( 'No Tooltip Found in Trash.', 'tooltip-block' ),
		);

		$args = array(
			'public'              => true,
			'exclude_from_search' => true,
			'show_in_rest'        => true,
			'labels'              => $labels,
			'menu_icon'           => 'dashicons-format-status',
			'rewrite'             => array( 'slug' => 'tooltip' ),
			'supports'            => array( 'title', 'editor' ),
		);

		register_post_type( TOOLTIP_BLOCK_POST_TYPE_NAME, $args );
	}
}
