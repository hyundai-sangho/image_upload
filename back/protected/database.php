<?php

// Video 2
try {
  $dbUserName = 'root';
  $dbPassword = '';
  $dbConnection = 'mysql:host=localhost;dbname=company;charset=utf8;';
  $options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
  ];
  $db = new PDO($dbConnection, $dbUserName, $dbPassword, $options);
} catch (PDOException $ex) {
  echo '{
    "status":0, 
    "message":"cannot connect to db",
    "debug": ' . __LINE__ . '
  }';

  exit();
}