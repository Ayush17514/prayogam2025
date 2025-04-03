<?php
$server = "localhost";
$username = "klmvjenl_jaincabs";
$password = "v4TZnVWZbCuYyGY37Exy";
$db_name = "klmvjenl_jaincabs";

$conn = new mysqli($server, $username, $password, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Common password
$common_password = "Pass@123";
$hashed_password = password_hash($common_password, PASSWORD_BCRYPT);

// Define users
$users = [
    ['username' => 'judge1', 'role' => 'judge'],
    ['username' => 'judge2', 'role' => 'judge'],
    ['username' => 'judge3', 'role' => 'judge'],
    ['username' => 'judge4', 'role' => 'judge'],
    ['username' => 'judge5', 'role' => 'judge'],
    ['username' => 'admin1', 'role' => 'admin'],
    ['username' => 'admin2', 'role' => 'admin'],
    ['username' => 'admin3', 'role' => 'admin'],
    ['username' => 'admin4', 'role' => 'admin'],
    ['username' => 'admin5', 'role' => 'admin'],
];

// Insert users
foreach ($users as $user) {
    $username = $user['username'];
    $role = $user['role'];
    
    $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$hashed_password', '$role')";
    
    if ($conn->query($sql) === TRUE) {
        echo "User '$username' added successfully.<br>";
    } else {
        echo "Error adding user '$username': " . $conn->error . "<br>";
    }
}

$conn->close();
?>
