<div class="wrap">
    <h1>LeadBaller Email Landing Page plugin settings</h1>
    <br />
    <?php settings_errors(); ?>

    <ul class="nav nav-tabs">
		<li class="<?php echo !isset($_POST["edit_env"])  ? 'active' : '' ?>"><a href="#tab-1">Environments</a></li>
		<li class="<?php echo isset($_POST["edit_env"]) ? 'active' : '' ?>">
            <a href="#tab-2"><?php echo isset($_POST["edit_env"]) ? 'Edit' : 'Add' ?> Environment</a>
        </li>
		<li><a href="#tab-3">About</a></li>
	</ul>

    <div class="tab-content">
        <div id="tab-1" class="tab-pane <?php echo !isset($_POST["edit_env"]) ? 'active' : '' ?>">
            <h3>Manage your Environments</h3>

            <?php
                $options = get_option('email_landing_options') ?: array();

                echo '<table class="environment-table">';
                echo '<tr><th>Environment/App Name</th><th>Application Token</th><th>Realm</th><th>Prospects Table</th><th>Campaign Table</th><th>Active</th><th class="text-center">Actions</th></tr>';
                foreach ($options as $option) {
                    $active = isset($option['is_active']) ? 'Yes' : 'No';
                    
                    echo '<tr>';
                    echo '<td>' . $option['env_name'] . '</td>';
                    echo '<td>' . $option['app_token'] . '</td>';
                    echo '<td>' . $option['realm_name'] . '</td>';
                    echo '<td>' . $option['prospects_table'] . '</td>';
                    echo '<td>' . $option['campaign_table'] . '</td>';
                    echo '<td>' . $active . '</td>';
                    echo '<td class="text-center">';
                    
                    // Handle the Edit option
                    echo '<form method="post" action="" class="inline-block">';
                    echo '<input type="hidden" name="edit_env" value="' . $option['env_name'] . '">';
                    submit_button( 'Edit', 'primary small', 'submit', false );
                    echo '</form> ';

                    // Handle the Delete option
                    echo '<form method="post" action="options.php" class="inline-block">';
                    settings_fields('environment_settings_option_group');
                    echo '<input type="hidden" name="remove" value="' . $option['env_name'] . '">';
                    submit_button( 'Delete', 'delete small', 'submit', false, array(
                        'onClick' => 'return confirm("Are you sure you want to delete the ' . $option['env_name'] . ' configuration?");'
                    ) );
                    echo '</form></td>';
                    echo "</tr>";
                }
                echo '</table>';
            ?>
        </div>

        <div id="tab-2" class="tab-pane <?php echo isset($_POST["edit_env"] ) ? 'active' : '' ?>">
			<h3>Create new Environments</h3>
            <form method="post" action="options.php">
                <?php
                    settings_fields('environment_settings_option_group');
                    do_settings_sections('email_landing_settings');
                    submit_button();

                    if (isset($_POST["edit_env"])) {
                        echo '<input type="hidden" name="env_name" value="' . $_POST["edit_env"] . '">';
                    }
                ?>
            </form>
		</div>

		<div id="tab-3" class="tab-pane">
			<h3>About</h3>
		</div>
    </div>

   
</div>
