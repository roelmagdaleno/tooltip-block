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

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets_in_frontend' ) );
		add_action( 'wp_footer', array( $this, 'render_templates' ) );

        if ( ! is_admin() ) {
            return;
        }

		$file = dirname( __DIR__ ) . '/tooltip-block.php';
		register_activation_hook( $file, array( $this, 'default_settings' ) );

        ( new Settings() )->hooks();
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_assets_in_admin' ) );
	}

	/**
	 * Enqueue the assets in the admin.
	 *
	 * @since 1.0.0
	 *
	 * @param string   $hook   The current admin page.
	 */
	public function enqueue_assets_in_admin( string $hook ): void {
		if ( 'settings_page_tooltips' !== $hook ) {
			return;
		}

		$this->add_assets();

        wp_enqueue_style( 'wp-color-picker' );

		wp_enqueue_script(
			'wp-tooltip-admin',
			plugins_url( 'admin/assets/js/tooltip-admin.js', dirname( __FILE__ ) ),
			array( 'wp-tooltip', 'wp-color-picker' ),
			TOOLTIP_BLOCK_VERSION,
			true
		);
	}

	/**
	 * Enqueue the assets in the frontend.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_assets_in_frontend(): void {
		global $post;

		if ( ! $post || ! tt_has_tooltips( $post->post_content ) ) {
			return;
		}

		$this->add_assets();
	}

	/**
	 * Set the default settings.
	 * This method is executed when the plugin is activated.
	 *
	 * @since 1.0.0
	 */
    public function default_settings(): void {
        $option_name = 'tooltips_settings';
        $settings    = get_option( $option_name, array() );

        if ( ! empty( $settings ) ) {
            return;
        }

        $settings = array(
	        'allowHTML'         => true,
	        'arrow'             => true,
	        'delayShow'         => 0,
	        'delayHide'         => 0,
	        'durationShow'      => 300,
	        'durationHide'      => 250,
	        'hideOnClick'       => true,
	        'interactive'       => false,
	        'interactiveBorder' => 2,
	        'maxWidth'          => 350,
			'offsetSkidding'    => 0,
			'offsetDistance'    => 10,
	        'placement'         => 'top',
	        'trigger'           => 'mouseenter focus',
	        'zIndex'            => 9999,
            'backgroundColor'   => '#333333',
            'textColor'         => '#ffffff',
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
        $settings = get_option( 'tooltips_settings', array() );

		wp_enqueue_style(
			'tooltip-block',
			plugins_url( 'build/style-index.css', dirname( __FILE__ ) ),
			null,
			TOOLTIP_BLOCK_VERSION
		);

        if ( isset( $settings['backgroundColor'], $settings['textColor'] ) ) {
            wp_add_inline_style( 'tooltip-block', tt_get_custom_css( $settings ) );
        }

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

		/**
		 * Set the custom css to be used as template in JavaScript.
		 *
		 * @since 1.0.0
		 */
		$settings['customCSS'] = tt_get_custom_css( $settings, true );

		wp_localize_script( 'wp-tooltip', 'wpTooltip', $settings );
	}
}
