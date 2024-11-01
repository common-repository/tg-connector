<?php

if(!defined("ABSPATH"))die;

class TGC_Options_Panel
{
	/**
	 * Holds the values to be used in the fields callbacks
	 */
	private $options;

	/**
	 * Start up
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'page_init' ) );
	}

	/**
	 * Add options page
	 */
	public function add_plugin_page() {
		// This page will be under "Settings"
		add_options_page(
			__("Telegram Connector","easy-telegram-connector"),
			__("Telegram Connector","easy-telegram-connector"),
			'manage_options',
			'tg-settings-admin',
			array( $this, 'create_admin_page' )
		);
	}

	/**
	 * Options page callback
	 */
	public function create_admin_page() {
		// Set class property
		$this->options = get_option( 'tgc_option_name' );
		?>
		<div class="wrap">
			<h1><? _e("Telegram Connector","easy-telegram-connector") ?></h1>
			<form method="post" action="options.php">
				<?php
				// This prints out all hidden setting fields
				settings_fields( 'tgc_option_group' );
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
	public function page_init() {
		register_setting(
			'tgc_option_group', // Option group
			'tgc_option_name' // Option name
			//array( $this, 'sanitize' ) // Sanitize
		);

            add_settings_section(
                'setting_section_id', // ID
	            __("Telegram Bot settings","easy-telegram-connector"), // Title
                array( $this, 'print_section_info' ), // Callback
                'my-setting-admin' // Page
            );

                add_settings_field(
                    'id_chat', // ID
	                __("Chat ID","easy-telegram-connector"), // Title
                    array( $this, 'text_input_callback' ), // Callback
                    'my-setting-admin', // Page
                    'setting_section_id', // Section
                    [
                        "name" => 'tgc_id_chat', // ID
                    ]
                );

                add_settings_field(
                    'token',
	                __("Bot Token","easy-telegram-connector"),
                    array( $this, 'text_input_callback' ),
                    'my-setting-admin',
                    'setting_section_id',
                    [
                        "name" => 'tgc_token', // ID
                    ]
                );

            add_settings_section(
                'proxy_setting_section', // ID
	            __("Proxy settings","easy-telegram-connector"), // Title
                array( $this, 'print_section_info' ), // Callback
                'my-setting-admin' // Page
            );

                add_settings_field(
                    'proxy_host', // ID
	                __('Proxy host',"easy-telegram-connector"), // Title
                    array( $this, 'text_input_callback' ), // Callback
                    'my-setting-admin', // Page
                    'proxy_setting_section', // Section
                    [
                        "name" => 'tgc_proxy_host', // ID
                    ]
                );

                add_settings_field(
                    'proxy_port', // ID
	                __('Proxy port',"easy-telegram-connector"), // Title
                    array( $this, 'text_input_callback' ), // Callback
                    'my-setting-admin', // Page
                    'proxy_setting_section', // Section
                    [
                        "name" => 'tgc_proxy_port', // ID
                    ]
                );

                add_settings_field(
                    'proxy_login', // ID
	                __('Proxy login',"easy-telegram-connector"), // Title
                    array( $this, 'text_input_callback' ), // Callback
                    'my-setting-admin', // Page
                    'proxy_setting_section', // Section
                    [
                        "name" => 'tgc_proxy_login', // ID
                    ]
                );

                add_settings_field(
                    'proxy_pass', // ID
	                __('Proxy password',"easy-telegram-connector"), // Title
                    array( $this, 'text_input_callback' ), // Callback
                    'my-setting-admin', // Page
                    'proxy_setting_section', // Section
                    [
                        "name" => 'tgc_proxy_pass', // ID
                    ]
                );

	}

	/**
	 * Sanitize each setting field as needed
	 *
	 * @param array $input Contains all settings fields as array keys
	 */
	public function sanitize( $input ) {
		$new_input = array();
		if( isset( $input['id_chat'] ) )
			$new_input['id_chat'] = absint( sanitize_text_field($input['id_chat']) );

		$fields = ["tgc_token","tgc_proxy_host","tgc_proxy_port","tgc_proxy_login","tgc_proxy_password"];

		foreach ($fields as $field):
			if( isset( $input[$field] ) )
			    $new_input[$field] = sanitize_text_field( $input[$field] );
		endforeach;

		return $new_input;
	}

	/**
	 * Print the Section text
	 */
	public function print_section_info() {
		print __('Enter your settings below:',"easy-telegram-connector");
	}

	/**
	 * Get the settings option array and print one of its values
	 */
	public function text_input_callback($args) {
		printf(
			'<input type="text" id="%s" name="tgc_option_name[%s]" value="%s" />',
			$args["name"], $args["name"], isset( $this->options[$args["name"]] ) ? esc_attr( $this->options[$args["name"]]) : ''
		);
	}

}

add_action('init','tgc_options_panel');

function tgc_options_panel(){
    $my_settings_page = new TGC_Options_Panel();
}
