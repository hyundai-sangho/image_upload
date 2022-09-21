<?php
// CORS 문제 해결
header('Access-Control-Allow-Origin: *');


// Video 1
header('content-type: application/json');
// Validate picture 
if (!isset($_FILES['picture'])) {
  err('사진이 없네요.', __LINE__);
}


$extension = pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);

// validate extension
$allowedExtensions = ['png', 'jpg', 'gif'];

if (!in_array($extension, $allowedExtensions)) {
  err('사진은 ' . implode(', ', $allowedExtensions) . '만 가능합니다.');
}

// 크기를 확인하십시오.
if ($_FILES['picture']['size'] < 10) {
  err('사진 용량이 너무 작네요.', __LINE__);
}

if ($_FILES['picture']['size'] > 2000000) {
  err('사진 용량이 너무 크네요.', __LINE__);
}

// unique name for the image
$uniquePictureName = bin2hex(random_bytes(16)); // 32 long 문자 + 숫자
$uniquePictureName .= '.' . $extension;



// save data in the db
// move the tmp image to the final folder
// Video 2
require_once(__DIR__ . '/protected/database.php');

$replaceExtensions = ['.png', '.jpg', '.gif'];
$pictureName = str_replace($replaceExtensions, "_", $_FILES['picture']['name']);
try {
  $query = $db->prepare('UPDATE users SET picture_name=:picture_name WHERE id=:id');
  $query->bindValue(':picture_name', $pictureName . $uniquePictureName);
  $query->bindValue(':id', $_POST['id']);
  $query->execute();

  if (!$query->rowCount($_FILES['picture']['tmp_name'])) {
    err('사용자를 찾을 수 없습니다.', __LINE__);
  }

  $destinationFolder = __DIR__ . '/pictures/';
  $finalPath = $destinationFolder . $pictureName . $uniquePictureName;
  move_uploaded_file($_FILES['picture']['tmp_name'], $finalPath);

  echo '{"status": 1, "message": "사용자 사진 업데이트됨"}';
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