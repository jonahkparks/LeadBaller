<?php
/**
 * @package lb-quickbase-plugin
 *
 */

namespace Inc\Base;

use Inc\API\SettingsApi;
use Inc\Base\BaseController;
use Inc\API\Callbacks\AdminCallbacks;

class TableController extends BaseController
{

    public $callbacks;

	public $subpages = array();

	public function register()
	{
        if ( ! $this->activated( 'table_manager' ) ) return;

		$this->settings = new SettingsApi();

		$this->callbacks = new AdminCallbacks();

		$this->setSubpages();

		$this->settings->addSubPages( $this->subpages )->register();

		add_action( 'init', array( $this, 'activate' ) );
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
				'callback' => array( $this->callbacks, 'environmentsPage' )
			)
		);
	}

    public function activate() 
    {
        register_post_type( 'leadballer_tables', array(
            'labels' => array(
                'name' => 'Tables',
                'singular_name' => 'Table'
            ),
            'public' => true,
            'has_archive' => true
        ));
    }
}