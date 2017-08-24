<?php
/*
Plugin Name: Dynamics CRM Leads
Plugin URI: http://www.vicesoft.com/dynamics-crm-leads-wordpress/
Description: Extends WordPress by adding an opportunity to create leads into Dynamics CRM using Contact Form 7 plug-in
Version: 1.4
Author: Lyubomir Toshev, ViceSoft
Author URI: http://www.vicesoft.com/
*/

require 'plugin-update-checker-3.0/plugin-update-checker.php';
$MyUpdateChecker = PucFactory::buildUpdateChecker(
	'http://www.vicesoft.com/updates/?action=get_metadata&slug=vicesoft_crmlead', //Metadata URL.
	__FILE__, //Full path to the main plugin file.
	'vicesoft_crmlead'
);

add_action( 'wpcf7_mail_sent', 'vicesoft_crmlead_wpcf7_mail_sent_function' ); 
 
function vicesoft_crmlead_wpcf7_mail_sent_function( $contact_form ) {	
	$formId = $contact_form->id();
	$option = get_option( 'vicesoft_crm_leads' );
    $submission = WPCF7_Submission::get_instance();
	$url = 'http://dotwoodcrm.azurewebsites.net/api/CreateLead2';
	
    if ($submission && $option['contact_form_id'] == $formId) {
        $posted_data = $submission->get_posted_data();
		
		$data = array_keys($posted_data);
		$custom = array();
		
		foreach ($data as &$value) {			
			$idx = strrpos($value, "-custom-");
			if ($idx > 0)
			{
				$key = substr($value, $idx + strlen('-custom-'));
				$custom[$key] = $posted_data[$value];
			}
		}
		
		$body= json_encode(Array(
			"FirstName" => isset($posted_data['lead-fname']) ? $posted_data['lead-fname'] : '',
			"LastName" => isset($posted_data['lead-lname']) ? $posted_data['lead-lname'] : '',
			"MiddleName" => isset($posted_data['lead-mname']) ? $posted_data['lead-mname'] : '',
			"MobilePhone" => isset($posted_data['lead-mobile']) ? $posted_data['lead-mobile'] : '',
			"Email" => isset($posted_data['lead-email']) ? $posted_data['lead-email'] : '',
			"PostalCode" => isset($posted_data['lead-postcode']) ? $posted_data['lead-postcode'] : '',
			"Description" => isset($posted_data['lead-descr']) ? $posted_data['lead-descr'] : '',
			"ApiKey" => $option['api_key'],
			"Company" => isset($posted_data['lead-company']) ? $posted_data['lead-company'] : '',
			"Address" => isset($posted_data['lead-address']) ? $posted_data['lead-address'] : '',
			"Website" => isset($posted_data['lead-website']) ? $posted_data['lead-website'] : '',
			"City" => isset($posted_data['lead-city']) ? $posted_data['lead-city'] : '',
			"JobTitle" => isset($posted_data['lead-jobtitle']) ? $posted_data['lead-jobtitle'] : '',
			"Subject"=> isset($posted_data['lead-subject']) ? $posted_data['lead-subject'] : '',
			"LeadSourceCode"=> isset($posted_data['lead-source']) ? $posted_data['lead-source'] : '',
			"CampaignId"=> isset($posted_data['lead-campaignid']) ? $posted_data['lead-campaignid'] : '',
			"CustomSchema" => !empty($custom) ? $custom : '{}'
		));	
		
		$response = wp_remote_post( $url, array(
			'method' => 'POST',
			'timeout' => 45,
			'redirection' => 5,
			'blocking' => true,
			'headers' => array('Content-Type' => 'application/json'),
			'body' => $body,
			'cookies' => array())	
		);

		if ( is_wp_error( $response ) ) {
		   $error_message = $response->get_error_message();
		   error_log("Something went wrong: ".$error_message);
		} else {
		   error_log($response['body']);
		}
    }
}

class ViceSoftCrmLeadSettingsPage
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'Settings Admin', 
            'CRM Leads Settings', 
            'manage_options', 
            'my-setting-admin', 
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'vicesoft_crm_leads' );
        ?>
        <div class="wrap">
            <h2>CRM Leads Settings</h2>           
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'my_option_group' );   
                do_settings_sections( 'my-setting-admin' );
                submit_button(); 
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {        
        register_setting(
            'my_option_group', // Option group
            'vicesoft_crm_leads', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'setting_section_id', // ID
            'Settings', // Title
            array( $this, 'print_section_info' ), // Callback
            'my-setting-admin' // Page
        );  

        add_settings_field(
            'api_key', // ID
            'API Key', // Title 
            array( $this, 'api_key_callback' ), // Callback
            'my-setting-admin', // Page
            'setting_section_id' // Section           
        );      

        add_settings_field(
            'contact_form_id', 
            'Contact Form Id (number)', 
            array( $this, 'contact_form_id_callback' ), 
            'my-setting-admin', 
            'setting_section_id'
        );      
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
        if( isset( $input['api_key'] ) )
            $new_input['api_key'] = sanitize_text_field( $input['api_key'] );

        if( isset( $input['contact_form_id'] ) )
            $new_input['contact_form_id'] = sanitize_text_field( $input['contact_form_id'] );

        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Enter your settings below:';
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function api_key_callback()
    {
        printf(
            '<input type="text" id="api_key" name="vicesoft_crm_leads[api_key]" value="%s" />',
            isset( $this->options['api_key'] ) ? esc_attr( $this->options['api_key']) : ''
        );
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function contact_form_id_callback()
    {
        printf(
            '<input type="text" id="contact_form_id" name="vicesoft_crm_leads[contact_form_id]" value="%s" />',
            isset( $this->options['contact_form_id'] ) ? esc_attr( $this->options['contact_form_id']) : ''
        );
    }
}

if( is_admin() )
    $my_settings_page = new ViceSoftCrmLeadSettingsPage();
?>