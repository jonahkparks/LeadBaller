<?php
/**
 * @package email-landing-plugin
 *
 */

namespace Inc\Base;

use Inc\API\SettingsApi;
use Inc\Base\BaseController;
use Inc\API\Callbacks;

class Settings extends BaseController
{
    public $settings;
    public $pages = array();
    public $callbacks;
    public $callbacks_mgr;

    public function register() 
	{
		$this->settings = new SettingsApi();

		$this->callbacks = new Callbacks();

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
                'menu_title' => 'Landing Pages',
                'capability' => 'manage_options',
                'menu_slug' => 'email_landing_settings',
                'callback' => array($this->callbacks, 'settingsPage'),
                'icon_url' => 'dashicons-email-alt',
                'position' => 110
            )
        );
    }

    public function setSettings()
    {
        $args = array(
            $args[] = array(
                'option_group' => 'environment_settings_option_group',
                'option_name' => 'email_landing_options',
                'callback' => array( $this->callbacks, 'tableSanitize')
            )
        );

        $this->settings->setSettings($args);
    }

    public function setSections()
    {
        $args = array(
            array(
                'id' => 'environments_section',
                'title' => '',
                'callback' => array( $this->callbacks, 'adminSectionManager'),
                'page' => 'email_landing_settings'
            ),
            array(
                'id' => 'environments_prospect_section',
                'title' => 'Prospect Table',
                'callback' => array( $this->callbacks, 'prospectSectionManager'),
                'page' => 'email_landing_settings'
            ),
            array(
                'id' => 'environments_campaign_section',
                'title' => 'Campaign Table',
                'callback' => array( $this->callbacks, 'campaignSectionManager'),
                'page' => 'email_landing_settings'
            )
        );

        $this->settings->setSections($args);
    }
    
    public function setFields()
    {
        $args = array(
            array(
                'id' => 'env_name',
                'title' => 'Environment / App Name',
                'callback' => array( $this->callbacks, 'textField'),
                'page' => 'email_landing_settings',
                'section' => 'environments_section',
                'args' => array(
                    'option_name' => 'email_landing_options',
                    'label_for' => 'env_name',
                    'placeholder' => 'e.g. Production'
                )
            ),
            array(
                'id' => 'realm_name',
                'title' => 'Realm Name',
                'callback' => array( $this->callbacks, 'textField'),
                'page' => 'email_landing_settings',
                'section' => 'environments_section',
                'args' => array(
                    'option_name' => 'email_landing_options',
                    'label_for' => 'realm_name',
                    'placeholder' => 'e.g. fred.quickbase.com'
                )
            ),
            array(
                'id' => 'app_token',
                'title' => 'Application Token',
                'callback' => array( $this->callbacks, 'textField'),
                'page' => 'email_landing_settings',
                'section' => 'environments_section',
                'args' => array(
                    'option_name' => 'email_landing_options',
                    'label_for' => 'app_token',
                    'placeholder' => 'Token ID'
                )
            ),
            array(
                'id' => 'is_active',
                'title' => 'Active?',
                'callback' => array( $this->callbacks, 'checkboxField'),
                'page' => 'email_landing_settings',
                'section' => 'environments_section',
                'args' => array(
                    'option_name' => 'email_landing_options',
                    'label_for' => 'is_active',
                    'class' => 'ui-toggle'
                )
            ),
            array(
                'id' => 'prospects_table',
                'title' => 'Prospects table ID',
                'callback' => array( $this->callbacks, 'textField'),
                'page' => 'email_landing_settings',
                'section' => 'environments_section',
                'args' => array(
                    'option_name' => 'email_landing_options',
                    'label_for' => 'prospects_table',
                    'placeholder' => 'e.g. abc12345'
                )
            ),
            array(
                'id' => 'merge_url_field',
                'title' => 'Merge URL field ID',
                'callback' => array( $this->callbacks, 'textField'),
                'page' => 'email_landing_settings',
                'section' => 'environments_prospect_section',
                'args' => array(
                    'option_name' => 'email_landing_options',
                    'label_for' => 'merge_url_field',
                    'class' => 'subgroup'
                )
            ),
            array(
                'id' => 'video_url_field',
                'title' => 'Video URL field ID',
                'callback' => array( $this->callbacks, 'textField'),
                'page' => 'email_landing_settings',
                'section' => 'environments_prospect_section',
                'args' => array(
                    'option_name' => 'email_landing_options',
                    'label_for' => 'video_url_field',
                    'class' => 'subgroup'
                )
            ),
            array(
                'id' => 'related_campaign_field',
                'title' => 'Related Campaign ID',
                'callback' => array( $this->callbacks, 'textField'),
                'page' => 'email_landing_settings',
                'section' => 'environments_prospect_section',
                'args' => array(
                    'option_name' => 'email_landing_options',
                    'label_for' => 'related_campaign_field',
                    'class' => 'subgroup'
                )
            ),
            array(
                'id' => 'campaign_table',
                'title' => 'Campaigns table ID',
                'callback' => array( $this->callbacks, 'textField'),
                'page' => 'email_landing_settings',
                'section' => 'environments_section',
                'args' => array(
                    'option_name' => 'email_landing_options',
                    'label_for' => 'campaign_table',
                    'placeholder' => 'e.g. abc12345'
                )
            ),
            array(
                'id' => 'campaign_id',
                'title' => 'Campaign Record ID',
                'callback' => array( $this->callbacks, 'textField'),
                'page' => 'email_landing_settings',
                'section' => 'environments_campaign_section',
                'args' => array(
                    'option_name' => 'email_landing_options',
                    'label_for' => 'campaign_id',
                    'class' => 'subgroup'
                )
            ),
            array(
                'id' => 'client_logo',
                'title' => 'Client Logo field ID',
                'callback' => array( $this->callbacks, 'textField'),
                'page' => 'email_landing_settings',
                'section' => 'environments_campaign_section',
                'args' => array(
                    'option_name' => 'email_landing_options',
                    'label_for' => 'client_logo',
                    'class' => 'subgroup'
                )
            ),
            array(
                'id' => 'calendly_field',
                'title' => 'Calendly field ID',
                'callback' => array( $this->callbacks, 'textField'),
                'page' => 'email_landing_settings',
                'section' => 'environments_campaign_section',
                'args' => array(
                    'option_name' => 'email_landing_options',
                    'label_for' => 'calendly_field',
                    'class' => 'subgroup'
                )
            )
        );

        $this->settings->setFields($args);
    }
}
