<?php
/**
 * @package lb-quickbase-plugin
 *
 */

namespace Inc\Pages;

use Inc\API\SettingsApi;
use Inc\Base\BaseController;
use Inc\API\Callbacks\AdminCallbacks;

class Admin extends BaseController
{
    public $settings;
    public $pages = array();
    public $subpages = array();
    public $callbacks;

    public function register()
    {
        $this->settings = new SettingsApi();
        $this->callbacks = new AdminCallbacks();

        $this->setPages();
        $this->setSubPages();

        $this->setSettings();
        $this->setSections();
        $this->setFields();

        $this->settings->addPages($this->pages)->withSubPage('Settings')->addSubPages($this->subpages)->register();
    }

    public function setPages()
    {
        $this->pages = array(
            array(
                'page_title' => 'LB QuickBase Plugin',
                'menu_title' => 'QuickBase',
                'capability' => 'manage_options',
                'menu_slug' => 'settings-admin',
                'callback' => array($this->callbacks, 'adminDashboard'),
                'icon_url' => 'dashicons-database',
                'position' => 110
            )
        );
    }

    public function setSubPages()
    {
        $this->subpages = array(
            array(
                'parent_slug' => 'settings-admin',
                'page_title' => 'Environments',
                'menu_title' => 'Environments',
                'capability' => 'manage_options',
                'menu_slug' => 'lb_envs',
                'callback' => array($this->callbacks, 'environmentsPage')
            ),
            array(
                'parent_slug' => 'settings-admin',
                'page_title' => 'Tables',
                'menu_title' => 'Tables',
                'capability' => 'manage_options',
                'menu_slug' => 'lb_tables',
                'callback' => array($this->callbacks, 'tablesPage')
            )
        );
    }

    public function setSettings()
    {
        $args = array(
            array(
                'option_group' => 'settings_option_group',
                'option_name' => 'settings_option_name',
                'callback' => array( $this->callbacks, 'optionsGroup')
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
                'callback' => array( $this->callbacks, 'adminSection'),
                'page' => 'settings-admin'
            )
        );

        $this->settings->setSections($args);
    }

    public function setFields()
    {
        $args = array(
            array(
                'id' => 'text_example',
                'title' => 'Text Example',
                'callback' => array( $this->callbacks, 'textExample'),
                'page' => 'settings-admin',
                'section' => 'settings_setting_section'
            ),
            array(
                'id' => 'first_name',
                'title' => 'First Name',
                'callback' => array( $this->callbacks, 'firstName'),
                'page' => 'settings-admin',
                'section' => 'settings_setting_section'
            ),
            array(
                'id' => 'environment_choice',
                'title' => 'Environment',
                'callback' => array( $this->callbacks, 'environmentChoice'),
                'page' => 'settings-admin',
                'section' => 'settings_setting_section'
            )
        );

        $this->settings->setFields($args);
    }
}
