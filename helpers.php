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
