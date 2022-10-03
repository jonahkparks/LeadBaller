<?php
/**
 * @package lb-quickbase-plugin
 *
 */

namespace Inc\Pages;

use Inc\API\SettingsApi;
use Inc\Base\BaseController;
use Inc\API\Callbacks\AdminCallbacks;
use Inc\API\Callbacks\ManagerCallbacks;

class Settings extends BaseController
{
    public $settings;
    public $pages = array();
    public $callbacks;
    public $callbacks_mgr;

    public function register() 
	{
		$this->settings = new SettingsApi();

		$this->callbacks = new AdminCallbacks();

		$this->callbacks_mgr = new ManagerCallbacks();

		$this->setPages();

		$this->setSettings();
		$this->setSections();
		$this->setFields();

		$this->settings->addPages( $this->pages )->withSubPage( 'Settings' )->register();
	}

    public function setPages()
    {
        $this->pages = array(
            array(
                'page_title' => 'LeadBaller Email Landing Plugin',
                'menu_title' => 'Email Settings',
                'capability' => 'manage_options',
                'menu_slug' => 'qb_settings_admin',
                'callback' => array($this->callbacks, 'adminDashboard'),
                'icon_url' => 'dashicons-database',
                'position' => 110
            )
        );
    }

    public function setSettings()
    {
        $args = array(
            $args[] = array(
                'option_group' => 'settings_option_group',
                'option_name' => 'qb_settings_admin',
                'callback' => array( $this->callbacks_mgr, 'checkboxSanitize')
            )
        );

        $this->settings->setSettings($args);
    }

    public function setSections()
    {
        $args = array(
            array(
                'id' => 'settings_setting_section',
                'title' => 'Settings',
                'callback' => array( $this->callbacks_mgr, 'adminSectionManager'),
                'page' => 'qb_settings_admin'
            )
        );

        $this->settings->setSections($args);
    }

    public function setFields()
    {
        $args = array();

        foreach ($this->managers as $key => $value) {
            $args[] = array(
                'id' => $key,
                'title' => $value,
                'callback' => array( $this->callbacks_mgr, 'checkboxField'),
                'page' => 'qb_settings_admin',
                'section' => 'settings_setting_section',
                'args' => array(
                    'option_group' => 'qb_settings_admin',
                    'label_for' => $key,
                    'class' => 'ui-toggle'
                )
            );
        }

        $this->settings->setFields($args);
    }
}
