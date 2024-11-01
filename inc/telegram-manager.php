<?php

if(!defined('ABSPATH'))die;

class TGC_Telegram_Manager{

	public $token;
	public $chat_id;

	public $TG_API = "https://api.telegram.org/bot%token%/%method%";

	public function __construct($token,$chat_id){
		$this->token = $token;
		$this->chat_id = $chat_id;
	}

	public function sendMessage($text){
		$url = str_replace("%token%",$this->token,$this->TG_API);
		$url = str_replace("%method%","sendMessage",$url);
		$url .= '?parse_mode=markdown&chat_id='.$this->chat_id."&text=".$text;

		$result = wp_remote_get($url);

		return $result;

	}

}