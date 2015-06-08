<?php
include_once 'storage.php';

$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

if (!$mysqli || $mysqli->connect_errno) {
  echo "Error connecting to MySQLi Session(".$mysqli->connect_errno."): ".$mysqli->connect_error;
}

if ($mysqli->connect_errno > 0) {
  die('Unable to connect to database [' . $mysqli->connect_error . ']');
}
?>
