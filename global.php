<?php

	// Special Functions
	
function filter($var)
{
    return addslashes(stripslashes(htmlspecialchars($var, ENT_QUOTES)));
}

if(!defined('IN_INDEX')) { die('Sorry, you cannot access this file.'); }
if(isset($_SERVER['HTTP_CF_CONNECTING_IP'])) { $_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_CF_CONNECTING_IP']; }
error_reporting(E_ALL ^ E_NOTICE);

define('A', 'app/');
define('I', 'interfaces/');
define('M', 'management/');
define('T', 'tpl/');


//REVOLUTION

use Revolution as Rev;


	//INTERFACES
	
		require_once A . I . 'interface.core.php';
		
		require_once A . I . 'interface.engine.php';
	
		require_once A . I . 'interface.users.php';
	
		require_once A . I . 'interface.template.php';
		
		//TPL
		
			require_once A . T . I . 'interface.forms.php';
			
			//HTML
			
				require_once A . T . I . 'interface.html.php';
				
			//CSS
				
				require_once A . T . I . 'interface.css.php';
				
			//JS
				
				require_once A . T . I . 'interface.js.php';
				
	
	//CLASSES
	
		//app
	
		require_once A . 'class.core.php';
		
		require_once A . 'class.engine.php';
		
		require_once A . 'class.users.php';
		
		require_once A . 'class.template.php';
		
		//MANAGEMENT
		
			require_once A . M . 'config.php';
			
			require_once A . M . 'recaptchalib.php';
				
		//TPL
		
			require_once A . T . 'class.forms.php';
			
			//HTML
				
				require_once A . T . 'class.html.php';
				
			//CSS
				
				require_once A . T . 'class.css.php';
				
			//JS
				
				require_once A . T . 'class.js.php'; 
		
		
	//OBJ
	
	$core = new Rev\core();
		
	$engine = new Rev\engine();	
		
	$users = new Rev\users();
		
	$template = new Rev\template();
		
	$template->form = new Rev\forms();
		
	$template->html = new Rev\html();
		
	$template->css = new Rev\css();
		
	$template->js = new Rev\js();
		
	//START	
	
	session_start();
	
$engine->Initiate();

$template->Initiate();

$pdo = $engine->getConnection();

function mysql_query($query)
{
    global $pdo;
    return $pdo->query($query);
}

function mysql_num_rows($result)
{
    return $result->rowCount();
}

function mysql_fetch_assoc($result)
{
    return $result->fetch(\PDO::FETCH_ASSOC);
}

function mysql_fetch_array($result, $type = \PDO::FETCH_BOTH)
{
    return $result->fetch($type);
}

function mysql_result($result, $row = 0, $field = 0)
{
    $data = $result->fetch(\PDO::FETCH_NUM);
    return $data[$field] ?? null;
}

function mysql_free_result($result)
{
    if($result instanceof \PDOStatement){
        $result->closeCursor();
    }
}

function mysql_real_escape_string($string)
{
    global $pdo;
    return substr($pdo->quote($string), 1, -1);
}
	
?>
