<?php
$url = getenv('DATABASE_URL');

if(!$url){
    die("DATABASE_URL environment variable not found!");
}

$parts = parse_url($url);

$host = $parts['host'];
$port = $parts['port'];
$user = $parts['user'];
$pass = $parts['pass'];
$db   = ltrim($parts['path'], '/');

$conn = mysqli_connect($host, $user, $pass, $db, $port);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>