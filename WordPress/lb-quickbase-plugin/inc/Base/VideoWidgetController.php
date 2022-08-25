<?php
/**
 * @package lb-quickbase-plugin
 *
 */

namespace Inc\Base;

use Inc\API\SettingsApi;
use Inc\Base\BaseController;
use Inc\API\Callbacks\AdminCallbacks;

class VideoWidgetController extends BaseController
{

    public $callbacks;

	public $subpages = array();

	public function register()
	{
        if ( ! $this->activated( 'video_widget' ) ) return;

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
				'page_title' => 'Video Widget', 
				'menu_title' => 'Video Widget', 
				'capability' => 'manage_options', 
				'menu_slug' => 'manage_video', 
				'callback' => array( $this->callbacks, 'environmentsPage' )
			)
		);
	}
}