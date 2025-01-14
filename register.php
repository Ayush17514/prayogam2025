<?php
$server="localhost";
$username="klmvjenl_jaincabs";
$password="v4TZnVWZbCuYyGY37Exy";
$db_name="klmvjenl_jaincabs";

$conn = mysqli_connect($server,$username,$password,$db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$user_type = $_POST['user_type'];
$name = $_POST['name'];
$branch = $_POST['branch'];
$registration_id = $_POST['registration_id'];
$email = $_POST['email'];

// Separate Visitor and Participant logic
if ($user_type == 'visitor') {
    $sql = "INSERT INTO users (name, branch, registration_id, email, user_type) 
            VALUES ('$name', '$branch', '$registration_id', '$email', '$user_type')";
} else {
    $participant_course = $_POST['participant_course'];
    $project_name = $_POST['project_name'];
    $project_type = $_POST['project_type'];
    $project_url = $_POST['project_url'];
    $project_domain = $_POST['project_domain'];

    $sql = "INSERT INTO users (name, branch, registration_id, participant_course, project_name, project_type, project_url, project_domain, email, user_type) 
            VALUES ('$name', '$branch', '$registration_id', '$participant_course', '$project_name', '$project_type', '$project_url', '$project_domain', '$email', '$user_type')";
}

// Execute query
if ($conn->query($sql) === TRUE) {
    echo "<script>
        alert('Registration successful!');
        window.location.href = '" . $_SERVER['HTTP_REFERER'] . "';
    </script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>


