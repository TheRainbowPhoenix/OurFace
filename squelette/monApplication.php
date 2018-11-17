<?php
//nom de l'application
$nameApp = "Arch";

//action par défaut
//$action = "superTest";
$action = "index";

if(key_exists("action", $_REQUEST))
$action =  $_REQUEST['action'];

require_once 'lib/core.php';
require_once $nameApp.'/controller/mainController.php';
require_once $nameApp.'/api/profile.php';
session_start();

$context = context::getInstance();
$context->init($nameApp);
$context->nameApp = $nameApp;

$context->db=new dbconnection() ;

$view=$context->executeAction($action, $_REQUEST);

$context->raw = false;

if($view===false)
{
	echo "Une grave erreur s'est produite, il est probable que l'action ".$action." n'existe pas...";
	die;
}

elseif($view!=context::NONE)
{
	$template_view=$nameApp."/view/".$action.$view.".php";
	if($context->raw==false)	include($nameApp."/layout/".$context->getLayout().".php");
	else {
		include($template_view);
		$context->raw = false;
	}
}

?>
