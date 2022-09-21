<?php
// CORS 문제 해결
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE,OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Video 1
header('content-type: application/json');

// Validate name
if (!isset($_POST['name'])) {
  err('이름이 없다.', __LINE__);
}
if (strlen($_POST['name']) < 2) {
  err('이름은 최소 2자 이상이어야 합니다.', __LINE__);
}
if (strlen($_POST['name']) > 100) {
  err('이름은 최대 5자 이하여야 합니다.', __LINE__);
}

// Validate id
if (!isset($_POST['id'])) {
  err('id missing', __LINE__);
}

if (!ctype_digit($_POST['id'])) {
  err('id는 숫자여야만 합니다.', __LINE__);
}

// Video 2
require_once(__DIR__ . '/protected/database.php');

try {
  $query = $db->prepare('UPDATE users SET name=:name WHERE id=:id');
  $query->bindValue(':name', $_POST['name']);
  $query->bindValue(':id', $_POST['id']);
  $query->execute();

  if (!$query->rowCount()) {
    err('사용자를 찾을 수 없습니다.', __LINE__);
  }
  echo '{"status": 1, "message": "사용자 이름 업데이트됨"}';
  exit();
} catch (PDOException $e) {
  err('사용자 생성이 불가능합니다.', __LINE__);
}


// Video 3
function err($message = 'error', $debug = 0)
{
  echo '{"status":0,"message":"' . $message . '","debug":' . $debug . '}';
  exit();
}