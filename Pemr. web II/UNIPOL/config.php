<?php
// config.php

$host = 'localhost';
$user = 'root';
$pass = ''; // ubah jika perlu
$db   = 'unipol';

$mysqli = new mysqli($host, $user, $pass, $db);

if ($mysqli->connect_errno) {
    die("Koneksi gagal: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
}

$mysqli->set_charset("utf8mb4");
?>
