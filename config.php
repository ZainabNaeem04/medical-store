<?php
$url = getenv('DATABASE_URL'); // Railway injects the full URL
if(!$url){
    die("DATABASE_URL environment variable not found!");
}
$parts = parse_url($url);
if(!$parts){
    die("Failed to parse DATABASE_URL");
}
$conn = mysqli_connect(
    getenv('DB_HOST'),
    getenv('DB_USER'),
    getenv('DB_PASS'),
    getenv('DB_NAME')
);
if(!$conn){ die("DB connection failed: " . mysqli_connect_error()); }
?>