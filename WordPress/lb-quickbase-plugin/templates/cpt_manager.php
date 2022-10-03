<div class="wrap">
    <h1>Custom Post Type Settings</h1>
    <br />
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
                    submit_button( 'Edit', 'primary small', 'submit', false );
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

                    if (isset($_POST["edit_post"])) {
                        echo '<input type="hidden" name="table" value="' . $_POST["edit_post"] . '">';
                    }
                ?>
            </form>
		</div>

		<div id="tab-3" class="tab-pane">
			<h3>Export all Custom Post Types</h3>
            <?php foreach ($options as $option) { ?>
            <h3><?php echo $option['singular_name']; ?></h3>
            <pre class="prettyprint">
// Register Custom Post Type
function custom_post_type() {

	$labels = array(
		'name'                  => _x( '<?php echo $option['plural_name']; ?>', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( '<?php echo $option['singular_name']; ?>', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( '<?php echo $option['plural_name']; ?>', 'text_domain' ),
		'name_admin_bar'        => __( '<?php echo $option['singular_name']; ?>', 'text_domain' ),
		'archives'              => __( '<?php echo $option['singular_name']; ?> Archives', 'text_domain' ),
		'attributes'            => __( '<?php echo $option['singular_name']; ?>Attributes', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent <?php echo $option['singular_name']; ?>', 'text_domain' ),
		'all_items'             => __( 'All <?php echo $option['plural_name']; ?>', 'text_domain' ),
		'add_new_item'          => __( 'Add New <?php echo $option['singular_name']; ?>', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New <?php echo $option['singular_name']; ?>', 'text_domain' ),
		'edit_item'             => __( 'Edit <?php echo $option['singular_name']; ?>', 'text_domain' ),
		'update_item'           => __( 'Update <?php echo $option['singular_name']; ?>', 'text_domain' ),
		'view_item'             => __( 'View <?php echo $option['singular_name']; ?>', 'text_domain' ),
		'view_items'            => __( 'View <?php echo $option['plural_name']; ?>', 'text_domain' ),
		'search_items'          => __( 'Search <?php echo $option['plural_name']; ?>', 'text_domain' ),
		'not_found'             => __( 'No <?php echo $option['singular_name']; ?> found', 'text_domain' ),
		'not_found_in_trash'    => __( 'No <?php echo $option['singular_name']; ?> found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into <?php echo $option['singular_name']; ?>', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this <?php echo $option['singular_name']; ?>', 'text_domain' ),
		'items_list'            => __( '<?php echo $option['plural_name']; ?> list', 'text_domain' ),
		'items_list_navigation' => __( '<?php echo $option['plural_name']; ?> list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter <?php echo $option['plural_name']; ?> list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( '<?php echo $option['singular_name']; ?>', 'text_domain' ),
		'description'           => __( '<?php echo $option['plural_name']; ?> Custom Post Type', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => false,
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => <?php echo (isset($option['public']) && $option['public'] ? 'true' : 'false') ?>,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => <?php echo (isset($option['has_archive']) && $option['has_archive'] ? 'true' : 'false') ?>,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
	);
	register_post_type( '<?php echo $option['post_type']; ?>', $args );

}
add_action( 'init', 'custom_post_type', 0 );
            </pre>
            <?php } ?>
		</div>
    </div>
</div>
