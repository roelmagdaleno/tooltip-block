<div class="wrap">
    <h1>Tooltips</h1>

    <p style="margin-bottom: 2rem;">
        Powered by <a href="https://atomiks.github.io/tippyjs/" target="_blank">Tippy.js</a>
    </p>

	<div class="wp-tooltip__admin-settings" style="display: flex;">
		<form method="POST" action="options.php" style="flex: 2;" novalidate>
			<?php

			settings_fields( 'tooltips_group' );
			do_settings_sections( 'tooltips' );

			submit_button();

			?>
		</form>

		<div
            class="wp-tooltip__preview"
            style="flex: 1; position: sticky; align-self: flex-start; top: 80px;"
        >
			<h2 style="margin-bottom: 0;">Preview</h2>
			<p style="margin-top: 0;">Don't forget to save changes after modify your settings.</p>

			<div style="background-color: white; padding: 2rem; border-radius: 4px;">
				<p>This is my <span class="wp-tooltip" data-tooltip-id="0">tooltip</span>.</p>
			</div>

			<div style="display: none;">
				<div id="wp-tooltip-0">
					Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
				</div>
			</div>
		</div>
	</div>
</div>
