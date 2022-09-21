<?php
// CORS 문제 해결
header('Access-Control-Allow-Origin: *');


// Video 1
header('content-type: application/json');

// Video 2
require_once(__DIR__ . '/protected/database.php');


try {
  $q = $db->prepare('SELECT * FROM users');
  $q->execute();
  $rows = $q->fetchAll();

  echo '{"status": 1, "data": ' . json_encode($rows) . '}';
  exit();
} catch (PDOException $e) {
  err('error executing query', __LINE__);
}

// Video 3
function err($message = 'error', $debug = 0)
{
  echo '{"status":0,"message":"' . $message . '","debug":' . $debug . '}';
  exit();
}