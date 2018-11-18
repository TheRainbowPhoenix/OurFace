<?php
/*
 * Controler
 */ 
function goLogin() {
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'monApplication.php?action=login';
	header("Location: http://$host$uri/$extra");
}

function goIndex() {
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'monApplication.php';
	header("Location: http://$host$uri/$extra");
}


class mainController
{

	public static function login($request,$context)
	{
		$done = 0;
		$context->uname=(null !== @$request['username'])?@$request['username']:NULL;
		$context->pwd=(null !== @$request['password'])?@$request['password']:NULL;
		$context->trace = NULL;
		if (is_null($context->uname) || is_null($context->pwd)) {
			$context->trace = file_get_contents($context->nameApp.'/layout/Error.php');
			$_SESSION['logged'] = false;
			$context->empty = true;
			//return context::ERROR;
		} else {
			$context->empty = false;
			$context->_session = new utilisateurTable;
			$context->_getLP = $context->_session->getUserByLoginAndPass($context->_session->prepare($context->uname), $context->pwd);
			if(!$context->_getLP) {
				$context->trace = "Bad username / password !";
				$_SESSION['logged'] = false;
			} else {
				//var_dump($context->_getLP);
				$_SESSION['name'] =$context->_getLP['0']['nom'];
				$_SESSION['surname'] =$context->_getLP['0']['prenom'];
				$_SESSION['user'] = $context->uname;
				$_SESSION['user_var'] = $context->_getLP['0'];
				$_SESSION['logged'] = true;
				$done = 1;	
			}
			unset($context->pwd);
			unset($context->_session);
			unset($context->_getLP);
		}
		if ($done ==1) goIndex();
		/*else {
			echo $context->uname.' '.$context->pwd;
		}*/
		return context::SUCCESS;
	}

	public static function helloWorld($request,$context)
	{
		$context->mavariable="hello world";
		return context::SUCCESS;
	}

	public static function listUsers($request,$context)
	{
		$context->users = utilisateurTable::getUsersV2();
		return context::SUCCESS;
	}

	public static function listMessages($request,$context)
	{
		if(array_key_exists('user_var', $_SESSION))  {
			$stack = array();
			$_msgs = messageTable::getMessages();
			foreach ($_msgs as $msg) {
				//var_dump($msg);
				$_pst = postTable::getPostById($msg->id);
				$_emtr = utilisateurTable::getUserById($msg->emetteur);
				if(isset($_pst) && isset($_emtr)) {
					$tmp = new Compose($msg, $_pst, $_emtr);
					array_push($stack, $tmp);
				}
			}
			$context->messages = $stack;
			return context::SUCCESS;
		} else {
			goLogin();
			return;
		}
	}

	public static function BProfile($request, $context) {
		if(array_key_exists('user_var', $_SESSION))  {
			$context->current_user = $_SESSION['user_var'];
			$context->raw = true;
			return context::SUCCESS;
		} else {
			goLogin();
			return ;
		}
	}

	public static function superTest($request,$context)
	{
		$context->param1=(null !== @$request['param1'])?@$request['param1']:NULL;
		$context->param2=(null !== @$request['param2'])?@$request ['param2']:NULL;
		$context->trace = NULL;
		if (is_null($context->param1) || is_null($context->param2)) {
			$context->trace = file_get_contents($context->nameApp.'/layout/Error.php');
			//return context::ERROR;
		}
		return context::SUCCESS;
	}

	public static function index($request,$context)
	{
		if(!(array_key_exists('logged', $_SESSION))) return context::ERROR;
		return context::SUCCESS;
	}

	public static function logout($request,$context) {
		unset($_SESSION['user']);
		unset($_SESSION['name']);
		unset($_SESSION['surname']);
		$_SESSION['logged'] = false;
		return context::SUCCESS;
	}


}
