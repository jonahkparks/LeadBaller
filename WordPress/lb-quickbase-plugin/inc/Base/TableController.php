<?php
/**
 * @package lb-quickbase-plugin
 *
 */

namespace Inc\Base;

use Inc\API\SettingsApi;
use Inc\Base\BaseController;
use Inc\API\Callbacks\AdminCallbacks;
use Inc\API\Callbacks\TableCallbacks;

class TableController extends BaseController
{
    public $settings;

    public $callbacks;

    public $table_callbacks;

    public $subpages = array();

    public $tables = array();

    public function register()
    {
        if (! $this->activated('table_manager')) {
            return;
        }

        $this->settings = new SettingsApi();

        $this->callbacks = new AdminCallbacks();

        $this->table_callbacks = new TableCallbacks();

        $this->setSubpages();

        $this->setSettings();

        $this->setSections();

        $this->setFields();

        $this->settings->addSubPages($this->subpages)->register();

		$this->storeTables();

		if( !empty($this->tables ))
		{
			add_action( 'init', array($this, 'registerTables' ));
		}
    }

    public function setSubpages()
    {
        $this->subpages = array(
            array(
                'parent_slug' => 'qb_settings_admin',
                'page_title' => 'Tables',
                'menu_title' => 'Table Manager',
                'capability' => 'manage_options',
                'menu_slug' => 'manage_tables',
                'callback' => array( $this->callbacks, 'tablesPage' )
            )
        );
    }

    public function setSettings()
    {
        $args = array(
            array(
                'option_group' => 'table_option_group',
                'option_name' => 'qb_table_admin',
                'callback' => array( $this->table_callbacks, 'tableSanitize')
            )
        );

        $this->settings->setSettings($args);
    }

    public function setSections()
    {
        $args = array(
            array(
                'id' => 'table_section',
                'title' => 'Table Manager',
                'callback' => (array( $this->table_callbacks, 'tableSectionManager')),
                'page' => 'manage_tables'
            )
        );

        $this->settings->setSections($args);
    }

    public function setFields()
    {
        $args = array(
            array(
                'id' => 'table',
                'title' => 'Custom Table ID',
                'callback' => array( $this->table_callbacks, 'textField'),
                'page' => 'manage_tables',
                'section' => 'table_section',
                'args' => array(
                    'option_name' => 'qb_table_admin',
                    'label_for' => 'table',
                    'placeholder' => 'e.g. category',
                    'array' => 'taxonomy'
                )

            ),
			array(
				'id' => 'singular_name',
				'title' => 'Singular Name',
				'callback' => array( $this->table_callbacks, 'textField'),
				'page' => 'manage_tables',
				'section' => 'table_section',
				'args' => array(
					'option_name' => 'qb_table_admin',
					'label_for' => 'singular_name',
					'placeholder' => 'e.g. Category',
					'array' => 'taxonomy'
				)
			),
			array(
				'id' => 'plural_name',
				'title' => 'Plural Name',
				'callback' => array( $this->table_callbacks, 'textField'),
				'page' => 'manage_tables',
				'section' => 'table_section',
				'args' => array(
					'option_name' => 'qb_table_admin',
					'label_for' => 'plural_name',
					'placeholder' => 'e.g. Categories',
					'array' => 'taxonomy'
				)
			),
			array(
				'id' => 'hierarchical',
				'title' => 'Hierarchical',
				'callback' => array( $this->table_callbacks, 'checkboxField'),
				'page' => 'manage_tables',
				'section' => 'table_section',
				'args' => array(
					'option_name' => 'qb_table_admin',
					'label_for' => 'hierarchical',
					'class' => 'ui-toggle',
					'array' => 'taxonomy'
				)
			),
			array(
				'id' => 'objects',
				'title' => 'Post Types',
				'callback' => array( $this->table_callbacks, 'checkboxPostTypesField'),
				'page' => 'manage_tables',
				'section' => 'table_section',
				'args' => array(
					'option_name' => 'qb_table_admin',
					'label_for' => 'objects',
					'class' => 'ui-toggle',
					'array' => 'taxonomy'
				)
			)
        );

		$this->settings->setFields( $args );
    }

	public function storeTables()
	{
		$options = get_option('qb_table_admin') ?: array();

		foreach ($options as $option)
		{
			$labels = array(
				'name' 				=> $option['singular_name'],
				'singular_name' 	=> $option['singular_name'],
				'search_items' 		=> 'Search ' . $option['plural_name'],
				'all_items' 		=> 'All '. $option['plural_name'],
				'parent_item'		=> 'Parent ' . $option['singular_name'],
				'parent_item_colon'	=> 'Parent ' . $option['singular_name'] . ':',
				'edit_item'			=> 'Edit ' . $option['singular_name'],
				'update_item'		=> 'Update ' . $option['singular_name'],
				'add_new_item'		=> 'Add New ' . $option['singular_name'],
				'new_item_name' 	=> 'New ' . $option['singular_name'] . ' Name',
				'menu_name'			=> $option['singular_name'] 
			);

			$this->tables[] = array(
				'hierarchical' 		=> (isset($option['hierarchical']) && $option['hierarchical'] ? true : false),
				'labels'			=> $labels,
				'show_ui'			=> true,
				'show_admin_column'	=> true,
				'query_var'			=> true,
				'rewrite'			=> array( 'slug' => $option['table']),
				'objects'			=> (isset($option['objects']) ? $option['objects'] : null)
			);
		}
	}

	public function registerTables()
	{
		foreach ($this->tables as $table) 
		{
			$objects = isset($table['objects']) ? array_keys($table['objects']) : null;
			register_taxonomy( $table['rewrite']['slug'], $objects, $table );
		}
	}
}
