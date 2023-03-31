<?php

/**
 * Check if the content has tooltips.
 *
 * @since  1.0.0
 *
 * @param  string   $content   The content to search for tooltips.
 * @return bool                Whether the content has tooltips.
 */
function tt_has_tooltips( string $content ) : bool {
	return ! empty( tt_find_tooltips_in_content( $content ) );
}

/**
 * Find tooltips in the content.
 *
 * @since  1.0.0
 *
 * @param  string   $content   The content to search for tooltips.
 * @return array               The found tooltips.
 */
function tt_find_tooltips_in_content( string $content ) : array {
	if ( empty( $content ) ) {
		return array();
	}

	$regex = '/data-tooltip-id="(.*?)"/m';
	preg_match_all( $regex, $content, $matches, PREG_SET_ORDER );

	return $matches;
}

/**
 * Get the tooltips IDs from the content.
 *
 * @since  1.0.0
 *
 * @param  string   $content   The content to search for tooltips.
 * @return array               The found tooltips IDs.
 */
function tt_get_tooltips_ids_from_content( string $content ) : array {
    $tooltips = tt_find_tooltips_in_content( $content );

    if ( empty( $tooltips ) ) {
        return array();
    }

    $tooltips_ids = array_map( fn( $tooltip ) => (int) $tooltip[1] ?? 0, $tooltips );
    $tooltips_ids = array_unique( $tooltips_ids );

    return array_filter( $tooltips_ids ); // We don't need the tooltips with ID 0.
}

/**
 * Get the custom css from the settings.
 *
 * @since  1.0.0
 *
 * @param  array   $settings      The plugin's settings.
 * @param  bool    $as_template   Whether to return the CSS as a template string.
 * @return string                 The custom CSS.
 */
function tt_get_custom_css( array $settings, bool $as_template = false ): string {
    $background_color = $as_template ? '{{backgroundColor}}' : $settings['backgroundColor'] ?? '#333333';
    $text_color       = $as_template ? '{{textColor}}' : $settings['textColor'] ?? '#FFFFFF';
    $link_color       = $as_template ? '{{linkColor}}' : $settings['linkColor'] ?? '#58b4ff';
	$link_hover_color = $as_template ? '{{linkHoverColor}}' : $settings['linkHoverColor'] ?? '#58b4ff';

    return '
    .tippy-box[data-theme~="wp-tooltip"] {
        background-color: ' . $background_color . ';
        color: ' . $text_color . ';
    }
    
    .tippy-box[data-theme~="wp-tooltip"] a {
        color: ' . $link_color . ';
    }
    
    .tippy-box[data-theme~="wp-tooltip"] a:hover {
        color: ' . $link_hover_color . ';
    }
    
    .tippy-box[data-theme~="wp-tooltip"][data-placement^="top"] > .tippy-arrow::before {
        border-top-color: ' . $background_color . ';
    }
    
    .tippy-box[data-theme~="wp-tooltip"][data-placement^="bottom"] > .tippy-arrow::before {
      border-bottom-color: ' . $background_color . ';
    }
    
    .tippy-box[data-theme~="wp-tooltip"][data-placement^="left"] > .tippy-arrow::before {
      border-left-color: ' . $background_color . ';
    }
    
    .tippy-box[data-theme~="wp-tooltip"][data-placement^="right"] > .tippy-arrow::before {
      border-right-color: ' . $background_color . ';
    }
    ';
}
