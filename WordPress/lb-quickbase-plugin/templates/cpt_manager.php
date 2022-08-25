<div class="wrap">
    <h1>Custom Post Type Settings</h1>
    <?php settings_errors(); ?>

    <ul class="nav nav-tabs">
		<li class="<?php echo !isset($_POST["edit_post"])  ? 'active' : '' ?>"><a href="#tab-1">Custom Post Types</a></li>
		<li class="<?php echo isset($_POST["edit_post"]) ? 'active' : '' ?>">
            <a href="#tab-2"><?php echo isset($_POST["edit_post"]) ? 'Edit' : 'Add' ?> Custom Post Types</a>
        </li>
		<li><a href="#tab-3">Export</a></li>
	</ul>

    <div class="tab-content">
        <div id="tab-1" class="tab-pane <?php echo !isset($_POST["edit_post"]) ? 'active' : '' ?>">
            <h3>Manage your Custom Post Types</h3>

            <?php
                $options = get_option('qb_cpt_admin') ?: array();

                echo '<table class="cpt-table">';
                echo '<tr><th>ID</th><th>Singular Name</th><th>Plural Name</th><th class="text-center">Public</th><th class="text-center">Has Archive</th><th class="text-center">Actions</th></tr>';
                foreach ($options as $option) {
                    echo '<tr>';
                    echo '<td>' . $option['post_type'] . '</td>';
                    echo '<td>' . $option['singular_name'] . '</td>';
                    echo '<td>' . $option['plural_name'] . '</td>';
                    echo '<td class="text-center">' . (isset($option['public']) && $option['public'] ? "Yes" : "No") . '</td>';
                    echo '<td class="text-center">' . (isset($option['has_archive']) && $option['has_archive'] ? "Yes" : "No") . '</td>';
                    echo '<td class="text-center">';
                    
                    // Handle the Edit option
                    echo '<form method="post" action="" class="inline-block">';
                    echo '<input type="hidden" name="edit_post" value="' . $option['post_type'] . '">';
                    submit_button( 'Edit', 'edit small', 'submit', false );
                    echo '</form> ';

                    // Handle the Delete option
                    echo '<form method="post" action="options.php" class="inline-block">';
                    settings_fields('cpt_option_group');
                    echo '<input type="hidden" name="remove" value="' . $option['post_type'] . '">';
                    submit_button( 'Delete', 'delete small', 'submit', false, array(
                        'onClick' => 'return confirm("Are you sure you want to delete the ' . $option['singular_name'] . ' Post Type?\nWARNING: No Posts associated with this Post Type will be removed.");'
                    ) );
                    echo '</form></td>';
                    echo "</tr>";
                }
                echo '</table>';
            ?>
        </div>

        <div id="tab-2" class="tab-pane <?php echo isset($_POST["edit_post"] ) ? 'active' : '' ?>">
			<h3>Create new Custom Post Type</h3>
            <form method="post" action="options.php">
                <?php
                    settings_fields('cpt_option_group');
                    do_settings_sections('manage_cpt');
                    submit_button();
                ?>
            </form>
		</div>

		<div id="tab-3" class="tab-pane">
			<h3>Export all Custom Post Types</h3>
            <pre class="prettyprint">class Voila {
                public:
                // Voila
                static const string VOILA = "Voila";
                
                // will not interfere with embedded <a href="#voila2">tags</a>.
            }</pre>
		</div>
    </div>
</div>
