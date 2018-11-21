<?php
$nameApp = "Arch";

header('Content-Type: application/json;charset=utf-8');

require_once 'lib/core.php';
require_once $nameApp.'/layout/generator.php';
require_once $nameApp.'/_api/parser.php';
require_once $nameApp.'/_api/wrapper.php';
session_start();

$api = wrapper::getInstance();
$api->db=new dbconnection();

$api_call = strstr($_SERVER["REQUEST_URI"], 'api');

$baseF = strstr($api_call, '/');
$baseF = explode('?', $baseF)[0];
$baseF = substr($baseF, 1);
//echo $baseF.'<br>';
//var_dump($_SERVER["REQUEST_URI"]);
//echo explode('.', $_SERVER["REQUEST_URI"])[0];
$actions = explode('?', $_SERVER["REQUEST_URI"]);
$actions = ((array_key_exists(1, $actions))?($actions[1]):null);

$params = explode('&', $actions);
$funcs = array();
foreach ($params as $param => $val) {
	$vals = explode('=', $val);
	$funcs[$vals[0]] = ((array_key_exists(1, $vals))?$vals[1]:null);
	//$funcs[$vals[0]] = $vals[1];
}
//echo json_encode($funcs);
//$funcs = explode('=', $params);
//var_dump($functs);

//var_dump($baseF);

if(isset($baseF)) {
	$reponse=$api->parse($baseF, $funcs);
} else {
	$reponse = false;
}


if($reponse===false)
{
	echo '{}';
	die;
}

else {
	print $reponse;

}

?>
