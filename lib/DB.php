<?php

require_once './lib/config.php';

$conn = getDBConnection();
checkIfDBExists();


function getDBConnection() {
  $conn = new mysqli(MYSQL_HOST, MYSQL_BENUTZER, MYSQL_KENNWORT);
  if ($conn->connect_error) {
    global $notification;
    $notification = "Connection failed: " . $conn->connect_error; 
    exit();
  }
  $conn->select_db('buchladen');
  return $conn;
}

function checkIfDBExists() {
  global $conn;
  $sql = 'SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = "buchladen"';
  if ($conn->query($sql)->fetch_assoc() === null) {
    resetDB();
  }
}

function resetDB() {
  global $conn;
  global $notification;
  if (file_exists('./buchladen.sql') == true) {
    $filename = './buchladen.sql';
  } else {
    $notification = 'Error: Keine Datenbankdatei gefunden';
    return;
  }

  $tempLine = '';
  $lines = file($filename);
  foreach ($lines as $line) {
    if (substr($line, 0, 2) == '--' || $line == '')
      continue;
    $tempLine .= $line;
    if (substr(trim($line), -1, 1) == ';') {
      mysqli_query($conn, $tempLine) or print("Error in " . $tempLine . ":" . mysqli_error($conn));
      $tempLine = '';
    }
  }
  $notification = 'Datenbank zurückgesetzt';
}

?>