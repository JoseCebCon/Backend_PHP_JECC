<?php

$db_host = 'localhost';
$db_username = 'sysAdm';
$db_password = 'Srw!HL31uLPlL0W3';
$db_database = 'alumnos';

$db = new mysqli($db_host,  $db_username, $db_password, $db_database);
mysqli_query($db, "SET NAMES 'utf8'");

if($db->connect_errno > 0) {
    die('No es posible conectarse a la base de datos ['.$db->connect_error .']');
}

