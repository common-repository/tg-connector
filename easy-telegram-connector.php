<?php

/*
Plugin Name: Easy Telegram Connector
Version: 1.0.0
Description: Telegram Connector Plugin does exactly what it’s name implies - it connects your Wordpress website with Telegram.
Text Domain: easy-telegram-connector
Author URI: https://tessellastudio.com/
Author: Tessella Design Studio
*/

if(!defined("ABSPATH"))die;

require_once(__DIR__."/inc/options-panel.php");
require_once(__DIR__."/inc/telegram-manager.php");
require_once(__DIR__."/inc/cf7-fields.php");

add_action( 'wpcf7_mail_sent' , 'tgc_send_telegram_notification' , 10 , 1 );


function tgc_send_telegram_notification($contact_form){

	$options = get_option("tgc_option_name");

	if(isset($options["tgc_proxy_host"])){
		define('WP_PROXY_HOST', $options["tgc_proxy_host"]);
		define('WP_PROXY_PORT', $options["tgc_proxy_port"]);

		if(isset($options["tgc_proxy_login"])){
			define('WP_PROXY_USERNAME', $options["tgc_proxy_login"]);
			define('WP_PROXY_PASSWORD', $options["tgc_proxy_pass"]);
		}
	}

	$postmeta = get_post_meta($contact_form->id());

	$token = isset($postmeta['tgc-token'][0]) && $postmeta['tgc-token'][0] ? $postmeta['tgc-token'][0] : $options['tgc_token'];
	$chatid = isset($postmeta['tgc-chatid'][0]) && $postmeta['tgc-chatid'][0] ? $postmeta['tgc-chatid'][0] : $options['tgc_id_chat'];

	$telegram = new TGC_Telegram_Manager($token,$chatid);

	if(isset($postmeta['tgc-template'][0]) && $postmeta['tgc-template'][0]){

		$message = $postmeta['tgc-template'][0];

		foreach($contact_form->scan_form_tags() as $tag){
			if($tag->type != "submit" && $_REQUEST[$tag->name]){
				$name = $tag->name;
				$message = str_replace("%$name%",sanitize_text_field($_REQUEST[$name]),$message);
			}
		}
	}
	else{
		$message = "***".__("New message from ","easy-telegram-connector").$contact_form->title()."***\n\n";

		foreach($contact_form->scan_form_tags() as $tag){
			if($tag->type != "submit" && $_REQUEST[$tag->name]){
				$name = $tag->name;
				$message.=$name." : ".sanitize_text_field($_REQUEST[$name])."\n";
			}
		}
	}

	$telegram->sendMessage($message);

}