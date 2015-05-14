<?php

$database_address = '195.178.235.60';
$database_name = 'm11k5638';
$username = 'm11k5638';
$password = 'jonasremgard';

$link = mysqli_connect($database_address, $username, $password);
if (!$link) {
  echo('Unable to connect to the database server.');
  exit();
}

if (!mysqli_set_charset($link, 'utf8')) {
  echo('Unable to set database connection encoding.');
  exit();
}

if (!mysqli_select_db($link, $database_name)) {
  echo('Unable to locate the company database.');
  exit();
}
?>
