<?php
$host = "localhost";
$db = "dog_grooming_center";
$user = "root";
$password = "";

$conn = new mysqli($host, $user, $password, $db, 3307);
if ($conn->connect_errno) {
    exit("Invalid connection: error> " . $conn->connect_error . ", error code>" . $conn->connect_errno);
}