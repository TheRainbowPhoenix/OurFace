<?php

define ('HOST', 'localhost') ;
define ('USER', 'uapv1701795'  ) ;
define ('PASS', '4hp6jc' ) ;
define ('DB', 'etd' ) ;

if (empty($_REQUEST['since_id'])) {
    $since_id = 0;
} else {
    $since_id = (int)$_REQUEST['since_id'];
}

$db = new PDO('pgsql:host='.HOST.';dbname='.DB, USER, PASS, array(
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
));

function retrieve($since_id = 0, $limit = 10) {
    global $db;

    $stmt = $db->prepare("SELECT * FROM fredouil.post WHERE id > :since_id ORDER BY id DESC LIMIT :limit");
    $stmt->bindValue(':since_id', $since_id);
    $stmt->bindValue(':limit', $limit);
    $stmt->execute();

    return $stmt->fetchAll();
}

function output($val = array()) {
    header('Content-type: application/json');
    echo json_encode($val);
    exit;
}

set_time_limit(45);

$timeline = retrieve($since_id);

if (empty($timeline)) {
    $db->exec('LISTEN post');
    $result = $db->pgsqlGetNotify(PDO::FETCH_ASSOC, 30000);
    if ($result === false) {
        output();
    }
    $timeline = retrieve($since_id);
}

output($timeline);
