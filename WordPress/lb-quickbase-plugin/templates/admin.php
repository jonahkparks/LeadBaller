<div class="wrap">
    <h1>QuickBase Plugin Settings</h1>
    <?php settings_errors(); ?>

    <form method="post" action="options.php">
        <?php 
            settings_fields( 'settings_option_group' );
            do_settings_sections( 'settings-admin' );
            submit_button();
        ?>
    </form>
</div>
