<?php

namespace WP\Tooltip;

class Tooltip {
	/**
	 * The custom post type.
	 *
	 * @since 1.0.0
	 *
	 * @var   PostType   $post_type   The custom post type.
	 */
	protected PostType $post_type;

	/**
	 * Register the action and filter hooks to start the functionality.
	 *
	 * @since 1.0.0
	 */
	public function hooks(): void {
		$this->post_type = new PostType();
		$this->post_type->hooks();

		add_action( 'wp_enqueue_scripts', array( $this, 'add_assets' ) );
		add_action( 'wp_footer', array( $this, 'render_templates' ) );

        if ( ! is_admin() ) {
            return;
        }

        ( new Settings() )->hooks();
	}

    public function default_settings(): array {
        $option_name = 'tooltips_settings';
        $settings    = get_option( $option_name, array() );

        if ( ! empty( $settings ) ) {
            return;
        }

        $settings = array(
            'theme' => 'light',
            'placement' => 'top',
            'arrow' => true,
            'animation' => 'shift-away',
            'duration' => 300,
            'delay' => 0,
            'interactive' => false,
            'trigger' => 'mouseenter focus',
            'hideOnClick' => true,
            'multiple' => false,
            'sticky' => false,
            'allowHTML' => false,
            'maxWidth' => 350,
            'zIndex' => 9999,
        );

        update_option( $option_name, $settings );
    }

    /**
     * Render the tooltips templates.
     * These templates will be used by Tippy.js to render the tooltips.
     *
     * @since 1.0.0
     */
	public function render_templates(): void {
		global $post;

		if ( ! $post ) {
			return;
		}

        $tooltips_ids = tt_get_tooltips_ids_from_content( $post->post_content );

        if ( empty( $tooltips_ids ) ) {
            return;
        }

		$tooltips = $this->post_type->in( $tooltips_ids );

		if ( empty( $tooltips ) ) {
			return;
		}

        $template = '<div style="display: none;">';

        foreach ( $tooltips as $tooltip ) {
            $template .= '<div id="wp-tooltip-' . $tooltip->ID . '">';
            $template .= $tooltip->post_content;
            $template .= '</div>';
        }

        $template .= '</div>';

        echo $template;
	}

    /**
     * Add the assets to the frontend.
     * It includes the Tippy.js library and the custom script.
     *
     * @since 1.0.0
     */
	public function add_assets(): void {
		global $post;

		if ( ! $post || ! tt_has_tooltips( $post->post_content ) ) {
			return;
		}

		wp_enqueue_style(
			'tooltip-block',
			plugins_url( 'build/style-index.css', dirname( __FILE__ ) ),
			null,
			TOOLTIP_BLOCK_VERSION
		);

        wp_enqueue_script(
            'wp-tooltip__popper',
            plugins_url( 'assets/js/vendor/popper.min.js', dirname( __FILE__ ) ),
            null,
            '2.11.6',
            true
        );

        wp_enqueue_script(
            'wp-tooltip__tippy',
            plugins_url( 'assets/js/vendor/tippy-bundle.umd.min.js', dirname( __FILE__ ) ),
            array( 'wp-tooltip__popper' ),
            '6.3.7',
            true
        );

        wp_enqueue_script(
            'wp-tooltip',
            plugins_url( 'assets/js/wp-tooltip.js', dirname( __FILE__ ) ),
            array( 'wp-tooltip__tippy' ),
            TOOLTIP_BLOCK_VERSION,
            true
        );
	}
}
