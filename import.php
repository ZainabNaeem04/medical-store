<?php
$url = getenv('DATABASE_URL');

if(!$url){
    die("DATABASE_URL not found");
}

$parts = parse_url($url);

$conn = mysqli_connect(
    $parts['host'],
    $parts['user'],
    $parts['pass'],
    ltrim($parts['path'], '/'),
    $parts['port']
);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = file_get_contents("medical_store.sql");

if (mysqli_multi_query($conn, $sql)) {
    echo "Database Imported Successfully!";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>