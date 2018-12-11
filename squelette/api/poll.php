<?php
require_once '../lib/core.php';
//require_once '../Arch/model/postTable.class.php';

/*
 * I ran into many problems of "blocking" with classes
 * the only solution was thoses good ol' functions 
 */

$trigger = 'chat';

if (empty($_REQUEST['from'])) {
	$id = 0;
} else {
	$id = (int)$_REQUEST['from'];
}

//PS : I REALLY TRIED - LIKE 5 times

$dbc = new dbconnection();

function fetch($id = 0, $limit = 10) {
	global $dbc;
	global $trigger;
	return $dbc->doQuery("SELECT * FROM fredouil.".$trigger." WHERE id > ".$id." ORDER BY id DESC LIMIT ".$limit);
}

function output($val = array()) {
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($val);
	exit;
}

set_time_limit(45);

$ret = fetch($id);

if (empty($ret)) {
	$dbc->doRawExec('LISTEN '.$trigger);
	$r = $dbc->getNotify(30000);
	if ($r === false) {
		output(); // []
	}
	$ret = fetch($id);
}
//$p = postTable::getPostById($id); TODO: Fix this !
output($ret);
