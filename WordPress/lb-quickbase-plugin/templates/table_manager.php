<div class="wrap">
    <h1>Table Manager</h1>
    <br />
    <?php settings_errors(); ?>

    <ul class="nav nav-tabs">
		<li class="<?php echo !isset($_POST["edit_table"])  ? 'active' : '' ?>"><a href="#tab-1">Tables</a></li>
		<li class="<?php echo isset($_POST["edit_table"]) ? 'active' : '' ?>">
            <a href="#tab-2"><?php echo isset($_POST["edit_table"]) ? 'Edit' : 'Add' ?> Tables</a>
        </li>
		<li><a href="#tab-3">Export</a></li>
	</ul>

    <div class="tab-content">
        <div id="tab-1" class="tab-pane <?php echo !isset($_POST["edit_table"]) ? 'active' : '' ?>">
            <h3>Manage your Tables</h3>

            <?php
                $options = get_option('qb_table_admin') ?: array();

                echo '<table class="cpt-table">';
                echo '<tr><th>ID</th><th>Singular Name</th><th>Plural Name</th><th class="text-center">Public</th><th class="text-center">Actions</th></tr>';
                foreach ($options as $option) {
                    echo '<tr>';
                    echo '<td>' . $option['table'] . '</td>';
                    echo '<td>' . $option['singular_name'] . '</td>';
                    echo '<td>' . $option['plural_name'] . '</td>';
                    echo '<td class="text-center">' . (isset($option['hierarchical']) && $option['hierarchical'] ? "Yes" : "No") . '</td>';
                    echo '<td class="text-center">';
                    
                    // Handle the Edit option
                    echo '<form method="post" action="" class="inline-block">';
                    echo '<input type="hidden" name="edit_table" value="' . $option['table'] . '">';
                    submit_button( 'Edit', 'primary small', 'submit', false );
                    echo '</form> ';

                    // Handle the Delete option
                    echo '<form method="post" action="options.php" class="inline-block">';
                    settings_fields('table_option_group');
                    //echo '<input type="hidden" name="remove" value="' . $option['table'] . '">';
                    submit_button( 'Delete', 'delete small', 'submit', false, array(
                        'onClick' => 'return confirm("Are you sure you want to delete the ' . $option['singular_name'] . ' Taxonomy?\nWARNING: No Posts associated with this Taxonomy will be removed.");'
                    ) );
                    echo '</form></td>';
                    echo "</tr>";
                }
                echo '</table>';
            ?>
        </div>

        <div id="tab-2" class="tab-pane <?php echo isset($_POST["edit_table"] ) ? 'active' : '' ?>">
			<h3>Create new Table</h3>
            <form method="post" action="options.php">
                <?php
                    settings_fields('table_option_group');
                    do_settings_sections('manage_tables');
                    submit_button();

                    if (isset($_POST["edit_table"])) {
                        echo '<input type="hidden" name="table" value="' . $_POST["edit_table"] . '">';
                    }
                ?>
            </form>
		</div>

		<div id="tab-3" class="tab-pane">
			<h3>Export all Tables</h3>
            <?php foreach ($options as $option) { ?>
            <h3><?php echo $option['singular_name']; ?></h3>
            <pre class="prettyprint">
// Register Taxonomy
function custom_taxonomy() {

    $labels = array(
        'name'              => '<?php echo $option['singular_name']; ?>',
        'singular_name'     => '<?php echo $option['singular_name']; ?>',
        'search_items'      => 'Search <?php echo $option['plural_name']; ?>',
        'all_items'         => 'All <?php echo $option['plural_name']; ?>',
        'parent_item'       => 'Parent <?php echo $option['singular_name']; ?>',
        'parent_item_colon' => 'Parent <?php echo $option['singular_name']; ?>:',
        'edit_item'         => 'Edit <?php echo $option['singular_name']; ?>',
        'update_item'       => 'Update <?php echo $option['singular_name']; ?>',
        'add_new_item'      => 'Add New <?php echo $option['singular_name']; ?>',
        'new_item_name'     => 'New <?php echo $option['singular_name']; ?> Name',
        'menu_name'         => '<?php echo $option['singular_name']; ?>' 
    );

    $rewrite = array(
        'slug'              => '<?php echo $option['table']; ?>' 
    );

    $args = array(
        'hierarchical'      => <?php echo (isset($option['hierarchical']) && $option['hierarchical'] ? 'true' : 'false') ?>,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => $rewrite
    );

    <?php if(isset($option['objects'])) { ?>
$objects = array(
    <?php foreach ($option['objects'] as $key => $value)
    { ?>
    '<?php echo $key ?>' => '<?php echo $value ?>',
    <?php } ?>
);
    <?php } ?>

    register_taxonomy( '<?php echo $option['table']; ?>', <?php echo (isset($option['objects']) ? '$objects' : 'null') ?>, $args );
}

add_action( 'init', 'custom_taxonomy', 0 );
            </pre>
            <?php } ?>
		</div>
    </div>
</div>
