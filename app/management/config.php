<?php
if(!defined('IN_INDEX')) { die('Sorry, you cannot access this file.'); }
#Please fill this all out.

#NOTE: To set up TheHabbos.ORG's API go to wwwroot/mysite/thehabbos_api for IIS, OR, htdocs/thehabbos_api for XAMPP and others.

/*
*
*	MySQL management
*
*/

$_CONFIG['mysql']['connection_type'] = 'pconnect'; //Type of connection: It must be connect, or pconnect: if you want a persistent connection.

$_CONFIG['mysql']['hostname'] = 'localhost'; //MySQL host - Localhost, Hamachi IP, VPS or Dedi's IP

$_CONFIG['mysql']['username'] = 'root'; //Phpmyadmin username

$_CONFIG['mysql']['password'] = 'root'; //Phpmyadmin password

$_CONFIG['mysql']['database'] = 'del_revcms'; //Phpmyadmin database name

$_CONFIG['mysql']['port'] = '3306'; //MySQL's port

/*
*
*	Hotel management  - All URLs do not end with an "/"
*
*/

$_CONFIG['hotel']['server_ip'] = 'localhost'; //Localhost, Hamachi IP, VPS or Dedi's IP

$_CONFIG['hotel']['url'] = 'http://localhost'; //URL to your hotel, does not end with a "/"

$_CONFIG['hotel']['name'] = 'RevCMS 1.9.9.9'; // Your Hotel's Name

$_CONFIG['hotel']['desc'] = 'Swf Pack & CMS pack by Delirious'; //Hotel's description 

$_CONFIG['hotel']['email'] = 'delirious_gaming@hotmail.com'; //Email for users to submit help requests to

$_CONFIG['hotel']['in_maint'] = false; //false for no maintenance mode & true for maintenance mode

$_CONFIG['hotel']['motto'] = 'I <3 ' . $_CONFIG['hotel']['name']; //Starting motto for new users

$_CONFIG['hotel']['credits'] = 0; //How many coins new users get

$_CONFIG['hotel']['pixels'] = 0; //How many pixels new users get

$_CONFIG['hotel']['figure'] = '-'; //Default figure users will register with.

$_CONFIG['hotel']['web_build'] = '63_1dc60c6d6ea6e089c6893ab4e0541ee0/527'; //Web_Build

$_CONFIG['hotel']['external_vars'] = 'http://localhost/r63/external_variables.txt'; //External Vars [Don't edit]

$_CONFIG['hotel']['external_texts'] = 'http://localhost/r63/external_flash_texts'; //External Flash Texts [Don't edit]

$_CONFIG['hotel']['product_data'] = 'http://localhost/r63/productdata.txt'; //Product Data [Don't edit]

$_CONFIG['hotel']['furni_data'] = 'http://localhost/r63/furnidata.txt'; //Furni Data [Don't edit]

$_CONFIG['hotel']['swf_folder'] = 'http://localhost/r63/swf'; //SWF Folder [Don't edit]

/*
*
*	Templating management - Pick one of our default styles or make yours by following our examples!
*
*/

#RevCMS has 2 default styles, 'Mango' by dannyy94 and 'Priv' by joopie - Others styles are to come, such as RastaLulz's ProCMS style and Nominal's PhoenixCMS 4.0 style.

$_CONFIG['template']['style'] = 'Mango'; 

/*
*
*	Other topsites.. thing
*
*/

$_CONFIG['thehabbos']['username'] = 'Kryptos';
$_CONFIG['retro_top']['user'] = 'Kryptos'; 

/*
*
*	Recaptcha management - Fill the information below if you have one, else leave it like that and don't worry, be happy.
*
*/

$_CONFIG['recaptcha']['priv_key'] = '6LcZ58USAAAAABSV5px9XZlzvIPaBOGA6rQP2G43';
$_CONFIG['recaptcha']['pub_key'] = '6LcZ58USAAAAAAQ6kquItHl4JuTBWs-5cSKzh6DD';


/*
*
*	Social Networking stuff
*
*/

$_CONFIG['social']['twitter'] = 'TwitterAccount'; //Hotel's Twitter account

$_CONFIG['social']['facebook'] = 'FacebookAccount'; //Hotel's Facebook account

?>