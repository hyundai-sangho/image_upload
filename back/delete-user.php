<?php
// CORS 문제 해결
header('Access-Control-Allow-Origin: *');


// Video 1 
header('content-type: application/json');
// header('Access-Control-Allow-Methods: DELETE');

if (!isset($_POST['id'])) {
  err('id가 없다.', __LINE__);
}
if (!ctype_digit($_POST['id'])) {
  err('유효한 아이디가 아니에요.', __LINE__);
}


// Video 2
require_once(__DIR__ . '/protected/database.php');

// Video 4
try {
  // Video 4
  $q = $db->prepare('DELETE FROM users WHERE id = :id');
  $q->bindValue(':id', $_POST['id']); // NO SQL INJECTION
  $q->execute();

  echo 'rowCount의 값은: ' . $q->rowCount() . PHP_EOL . PHP_EOL;

  if (!$q->rowCount()) {
    err('사용자가 존재하지 않습니다.', __LINE__);
  }

  echo '{"status": 1, "message":"사용자 삭제됨"}';
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