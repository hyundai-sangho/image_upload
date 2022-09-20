<?php
// Video 1 
header('content-type: application/json');

if (!isset($_GET['id'])) {
  err('id가 없다.', __LINE__);
}
if (!ctype_digit($_GET['id'])) {
  err('유효한 아이디가 아니에요.', __LINE__);
}


// Video 2
require_once(__DIR__ . '/protected/database.php');

try {
  $q = $db->prepare('SELECT * FROM users WHERE id = :id LIMIT 1');
  $q->bindValue(':id', $_GET['id']); // NO SQL INJECTION
  $q->execute();
  $row = $q->fetch();
  if (!$row) {
    err('사용자가 존재하지 않습니다.', __LINE__);
  }

  echo '{"status": 1, "data": ' . json_encode($row) . '}';
  exit();
} catch (PDOException $e) {
  err('error executing query', __LINE__);
}


echo '{"status": 1, "data": {"id":1, "name":"조상호"}}';


// Video 3
function err($message = 'error', $debug = 0)
{
  echo '{"status":0,"message":"' . $message . '","debug":' . $debug . '}';
  exit();
}