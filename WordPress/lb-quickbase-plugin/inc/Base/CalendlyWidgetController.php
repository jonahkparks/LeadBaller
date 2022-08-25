<?php
/**
 * @package lb-quickbase-plugin
 *
 */

namespace Inc\Base;

use Inc\API\SettingsApi;
use Inc\Base\BaseController;
use Inc\API\Callbacks\AdminCallbacks;

class CalendlyWidgetController extends BaseController
{

    public $callbacks;

	public $subpages = array();

	public function register()
	{
        if ( ! $this->activated( 'calendly_widget' ) ) return;

		$this->settings = new SettingsApi();

		$this->callbacks = new AdminCallbacks();

		$this->setSubpages();

		$this->settings->addSubPages( $this->subpages )->register();
	}

    public function setSubpages()
	{
		$this->subpages = array(
			array(
				'parent_slug' => 'qb_settings_admin', 
				'page_title' => 'Calendly Widget', 
				'menu_title' => 'Calendly Widget', 
				'capability' => 'manage_options', 
				'menu_slug' => 'manage_calendly', 
				'callback' => array( $this->callbacks, 'environmentsPage' )
			)
		);
	}
}