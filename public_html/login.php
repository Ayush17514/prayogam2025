<?php
session_start();
$server = "localhost";
$username = "klmvjenl_jaincabs";
$password = "v4TZnVWZbCuYyGY37Exy";
$db_name = "klmvjenl_jaincabs";

$conn = new mysqli($server, $username, $password, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password, $role);
        $stmt->fetch();
        
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;
            header("Location: project_list.php");
            exit();
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "User not found!";
    }
    $stmt->close();
}
$conn->close();
?>
 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');
    *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Poppins", sans-serif;
    }
    body{
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background: #23252a;
    }
    .box {
        position: relative;
        width: 380px;
        background: #1c1c1c;
        border-radius: 8px;
        overflow: hidden;
        padding: 20px;
    }
    .box form{
        background: #222;
        padding: 40px;
        border-radius: 8px;
        text-align: center;
    }
    .box form h2{
        color: #fff;
        font-weight: 500;
        margin-bottom: 20px;
    }
    .box form .inputBox{
        position: relative;
        margin-bottom: 20px;
    }
    .box form .inputBox input{
        width: 100%;
        padding: 10px;
        background: transparent;
        outline: none;
        border: none;
        color: #fff;
        font-size: 1em;
        border-bottom: 2px solid #45f3ff;
    }
    .box form .links{
        display: flex;
        justify-content: space-between;
    }
    .box form .links a{
        font-size: 0.85em;
        color: #8f8f8f;
        text-decoration: none;
    }
    .box form .links a:hover{
        color: #fff;
    }
    #submit{
        border: none;
        padding: 10px;
        cursor: pointer;
        font-size: 1em;
        border-radius: 4px;
        font-weight: 600;
        width: 100%;
        background: #45f3ff;
        color: #23252a;
    }
    #submit:active{
        opacity: 0.8;
    }
    </style>
</head>
<body>
    <div class="box">
        <form method="POST">
            <h2>Sign in</h2>
            
            <div class="inputBox">
            <span>Username</span>
                <input type="text" name="username" required>
            </div>
            <div class="inputBox">
            
                <input type="password" name="password" required>
            </div>
            <div class="links">
                <a href="#">Forgot Password</a>
            </div>
            <input type="submit" id="submit" value="Login">
        </form>
    </div>
</body>
</html>
