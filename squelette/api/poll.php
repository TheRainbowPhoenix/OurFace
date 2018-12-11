<?php
require_once '../lib/core.php';

/*
 * I ran into many problems of "blocking" with classes
 * the only solution was thoses good ol' functions 
 */

if (empty($_REQUEST['from'])) {
	$id = 0;
} else {
	$id = (int)$_REQUEST['from'];
}

$dbc = new dbconnection();

$db = new PDO('pgsql:host='.HOST.';dbname='.DB, USER, PASS, array(
	PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
));

function fetch($id = 0, $limit = 10) {
	//global $db;
	global $dbc;

	return $dbc->doQuery("SELECT * FROM fredouil.post WHERE id > ".$id." ORDER BY id DESC LIMIT ".$limit);
	/*$stmt = $db->prepare("SELECT * FROM fredouil.post WHERE id > ".$id." ORDER BY id DESC LIMIT ".$limit);
	$stmt->execute();

	return $stmt->fetchAll();*/
}

function output($val = array()) {
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($val);
	exit;
}

set_time_limit(45);

$ret = fetch($id);

if (empty($ret)) {
	$db->exec('LISTEN post');
	$r = $db->pgsqlGetNotify(PDO::FETCH_ASSOC, 30000);
	if ($r === false) {
		output();
	}
	$ret = fetch($id);
}

output($ret);
