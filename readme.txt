=== Easy Telegram Connector ===
Contributors: timurkayzer
Tags: telegram , proxy , cf7
Requires at least: 4.0.1
Tested up to: 4.9
Requires PHP: 5.4
Stable tag: 4.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Easy Telegram Connector Plugin does exactly what it’s name implies - it connects your Wordpress website with Telegram.

== Description ==

Easy Telegram Connector Plugin does exactly what it’s name implies - it connects your Wordpress website with Telegram.

Functionality available:

* Sending messages to Telegram channels from contact forms;
* Different bots, templates and chants for each form;
* Connection through proxy;

Upcoming functionality:

* Autoposting

== Installation ==

After you install plugin via Wordpress plugin installer or upload and activate it manually, you have to set it up.

1. Create a bot
First of all, you need to create a bot, which will be used to interact with the user. If you already have a bot, you will need a token of existing bot.
To create a new bot, you will need to interact with BotFather - https://t.me/BotFather.

1. User ID
You need to know ID of a user who will be receiving messages. It is possible either using the https://t.me/ShowJsonBot, or sending message to your bot, then going to URL https://api.telegram.org/botbot_token/getUpdates (replace with your token). In both cases you will see a JSON object, where the ‘chat’ property will have id inside of it - this will be the user unique identifier.

1. Common settings
Insert collected data in plugin settings in Settings > Telegram Connector
You can also set proxy server parameters, if you have problems with connecting to Telegram servers.

1. Form Settings
In Contact Form you can override common settings and add message template, bot and user, who will receive message from form.

== Screenshots ==

1. Plugin Settings
2. Plugin Settings
3. Contact Form Settings

== Changelog ==

= 1.0 =
* First version of plugin published