<div class="wrap">
    <h1>Tooltips</h1>

    <p style="margin-bottom: 2rem;">
        Powered by <a href="https://atomiks.github.io/tippyjs/" target="_blank">Tippy.js</a>
    </p>

    <form method="POST" action="options.php" novalidate>
        <?php

        settings_fields( 'tooltips_group' );
        do_settings_sections( 'tooltips' );

        submit_button();

        ?>
    </form>
</div>
