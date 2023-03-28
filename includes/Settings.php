<?php

namespace WP\Tooltip;

use Roel\WP\Settings\Elements\Checkbox;
use Roel\WP\Settings\Elements\Number;
use Roel\WP\Settings\Elements\Select;
use Roel\WP\Settings\Elements\Text;
use Roel\WP\Settings\Group;

class Settings {
    /**
     * The page slug.
     *
     * @since 1.0.0
     *
     * @var   string   $page   The page slug.
     */
    protected string $page = 'tooltips';

    /**
     * Register the action and filter hooks to start the functionality.
     *
     * @since 1.0.0
     */
    public function hooks(): void {
        add_action( 'admin_menu', array( $this, 'register_menu' ) );
        add_action( 'admin_init', array( $this, 'register_settings' ) );
    }

    /**
     * Register the submenu page.
     * The submenu page will include the plugin's options page.
     *
     * @since 1.0.0
     */
    public function register_menu(): void {
        add_submenu_page(
            'options-general.php',
            'Tooltips',
            'Tooltips',
            'manage_options',
            $this->page,
            array( $this, 'render' )
        );
    }

    /**
     * Register the settings to render in the options page.
     * Each setting must be a component instance.
     *
     * @since 1.0.0
     */
    public function register_settings(): void {
        register_setting( 'tooltips_group', 'tooltips_settings' );

        add_settings_section(
            $this->page,
            'Settings',
            null,
            $this->page
        );

        $group = new Group( array(
            new Checkbox( 'arrow', array(
                'label'       => 'Show arrow',
                'description' => 'Determines if the tippy has an arrow.',
            ) ),
            new Number( 'delay', array(
                'label'       => 'Delay',
                'description' => 'Delay in ms once a trigger event is fired before a tooltip shows or hides.',
            ) ),
            new Number( 'duration', array(
                'label'       => 'Duration',
                'description' => 'Duration in ms of the transition animation.',
            ) ),
            new Checkbox( 'hideOnClick', array(
                'label'       => 'Hide on click',
                'description' => 'Determines if the tooltip hides upon clicking the reference or outside of the tooltip. The behavior can depend upon the trigger events used.',
            ) ),
            new Checkbox( 'interactive', array(
                'label'       => 'Interactive',
                'description' => 'Determines if the tooltip has interactive content inside of it, so that it can be hovered over and clicked inside without hiding.',
            ) ),
            new Number( 'interactiveBorder', array(
                'label'       => 'Interactive border',
                'description' => 'Determines the size of the invisible border around the tooltip that will prevent it from hiding if the cursor left it.',
            ) ),
            new Number( 'maxWidth', array(
                'label'       => 'Max width',
                'description' => 'Specifies the maximum width of the tippy. Useful to prevent it from being too horizontally wide to read.',
            ) ),
            new Number( 'offsetSkidding', array(
                'label'       => 'Offset skidding',
                'description' => 'Displaces the tippy from its reference element in pixels (skidding).',
            ) ),
            new Number( 'offsetDistance', array(
                'label'       => 'Offset distance',
                'description' => 'Displaces the tippy from its reference element in pixels (distance).',
            ) ),
            new Select( 'placement', array(
                'label'         => 'Placement',
                'description'   => 'The preferred placement of the tooltip.',
                'default_value' => 'top',
                'options'       => array(
                    'top'          => array( 'label' => 'top' ),
                    'top-start'    => array( 'label' => 'top-start' ),
                    'top-end'      => array( 'label' => 'top-end' ),
                    'right'        => array( 'label' => 'right' ),
                    'right-start'  => array( 'label' => 'right-start' ),
                    'right-end'    => array( 'label' => 'right-end' ),
                    'bottom'       => array( 'label' => 'bottom' ),
                    'bottom-start' => array( 'label' => 'bottom-start' ),
                    'bottom-end'   => array( 'label' => 'bottom-end' ),
                    'left'         => array( 'label' => 'left' ),
                    'left-start'   => array( 'label' => 'left-start' ),
                    'left-end'     => array( 'label' => 'left-end' ),
                    'auto'         => array( 'label' => 'auto' ),
                    'auto-start'   => array( 'label' => 'auto-start' ),
                    'auto-end'     => array( 'label' => 'auto-end' ),
                ),
            ) ),
            new Select( 'trigger', array(
                'label'         => 'Trigger',
                'description'   => 'Determines the events that cause the tippy to show. Multiple event names are separated by spaces.',
                'default_value' => 'mouseenter-focus',
                'options'       => array(
                    'mouseenter-focus' => array( 'label' => 'mouseenter focus' ),
                    'click'            => array( 'label' => 'click' ),
                    'focusin'          => array( 'label' => 'focusin' ),
                    'mouseenter-click' => array( 'label' => 'mouseenter click' ),
                ),
            ) ),
            new Number( 'zIndex', array(
                'label'       => 'Z-index',
                'description' => 'Specifies the z-index CSS on the root popper node.',
            ) ),
        ), 'tooltips_settings' );

        foreach ( $group->elements() as $setting ) {
            add_settings_field(
                $setting->id(),
                $setting->label(),
                array( $setting, 'print' ),
                $this->page,
                $this->page
            );
        }
    }

    /**
     * Render the plugin's options page.
     * It contains all plugin's settings.
     *
     * @since 1.0.0
     */
    public function render() : void {
        include_once dirname( __DIR__ ) . '/admin/views/options-page.php';
    }
}
