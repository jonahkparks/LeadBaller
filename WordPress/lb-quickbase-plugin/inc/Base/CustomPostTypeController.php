<?php
/**
 * @package lb-quickbase-plugin
 *
 */

namespace Inc\Base;

use Inc\API\SettingsApi;
use Inc\Base\BaseController;
use Inc\API\Callbacks\AdminCallbacks;

class CustomPostTypeController extends BaseController
{

    public $callbacks;

	public $subpages = array();

	public function register()
	{
        if ( ! $this->activated( 'cpt_manager' ) ) return;

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
				'page_title' => 'Custom Post Types', 
				'menu_title' => 'CPT Manager', 
				'capability' => 'manage_options', 
				'menu_slug' => 'manage_cpt', 
				'callback' => array( $this->callbacks, 'environmentsPage' )
			)
		);
	}

    public function activate() 
    {
        register_post_type( 'leadballer_clients', array(
            'labels' => array(
                'name' => 'Clients',
                'singular_name' => 'Client'
            ),
            'public' => true,
            'has_archive' => true
        ));
    }
}