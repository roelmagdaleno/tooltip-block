<?php

namespace Tooltip;

class Tooltip {
	/**
	 * Register the action and filter hooks to start the functionality.
	 *
	 * @since 1.0.0
	 */
	public function hooks() {
		if ( ! is_admin() ) {
			return;
		}

		( new PostType() )->hooks();
	}
}
