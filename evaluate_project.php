<?php

session_start();
include 'db_connect.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database Connection
$server = "localhost";
$username = "klmvjenl_jaincabs";
$password = "v4TZnVWZbCuYyGY37Exy";
$db_name = "klmvjenl_jaincabs";

$conn = mysqli_connect($server, $username, $password, $db_name);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$judge_id = $_SESSION['user_id'];
$project_id = filter_input(INPUT_GET, 'table_number', FILTER_SANITIZE_NUMBER_INT);

if (!$project_id) {
    die("Invalid project selection.");
}

// Check if project exists
$project_check = $conn->prepare("SELECT project_name FROM users WHERE table_number = ?");
$project_check->bind_param("i", $project_id);
$project_check->execute();
$project_check->store_result();

if ($project_check->num_rows === 0) {
    die("Error: Selected project does not exist.");
}
$project_check->bind_result($project_name);
$project_check->fetch();
$project_check->close();

// Check if the judge has already evaluated this project
$check_query = "SELECT 1 FROM evaluations WHERE judge_id = ? AND project_id = ?";
$stmt = $conn->prepare($check_query);
$stmt->bind_param("ii", $judge_id, $project_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    //header("Location: project_list.php?msg=already_evaluated");
    echo '<h1 style="text-align:center;color:#01a901;margin-top:150px;">Already Evaluated</h1>';
    exit();
}
$stmt->close();

// If form is submitted, process the evaluation
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $innovation_creativity = filter_input(INPUT_POST, 'innovation_creativity', FILTER_VALIDATE_INT);
    $technical_execution = filter_input(INPUT_POST, 'technical_execution', FILTER_VALIDATE_INT);
    $presentation_communication_skills = filter_input(INPUT_POST, 'presentation_communication_skills', FILTER_VALIDATE_INT);
    $practical_relevance_impact = filter_input(INPUT_POST, 'practical_relevance_impact', FILTER_VALIDATE_INT);
    $understanding_learning = filter_input(INPUT_POST, 'understanding_learning', FILTER_VALIDATE_INT);

    // Validate that all scores are within 0-10
    $scores = [$innovation_creativity, $technical_execution, $presentation_communication_skills, $practical_relevance_impact, $understanding_learning];

    foreach ($scores as $score) {
        if ($score === false || $score < 0 || $score > 10) {
            die("Error: Invalid scores. Please enter values between 0 and 10.");
        }
    }

    // Calculate total score
    $total_score = array_sum($scores);

    // Insert evaluation into the database

    $sql = "INSERT INTO evaluations (judge_id, project_id,innovation_creativity,technical_execution,presentation_communication_skills, practical_relevance_impact, understanding_learning, total_score) VALUES ('$judge_id',' $project_id', '$innovation_creativity', '$technical_execution', '$presentation_communication_skills', '$practical_relevance_impact', '$understanding_learning', '$total_score')";
    
    if ($conn->query($sql) === TRUE) {
        echo '<h1 style="text-align:center;color:#01a901;margin-top:150px;">Successfully Evaluated. <br>Thankyou</h1>';
    exit();
    } else {
        die("Database Error: " . $stmt->error);
    }
    // $insert_query = "INSERT INTO evaluations (judge_id, project_id, creativity, teamwork, innovation, presentation, technical_complexity, total_score)
    //                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    // $stmt = $conn->prepare($insert_query);
    
    // $stmt->bind_param("iiiiiiii", $judge_id, $project_id, $creativity, $teamwork, $innovation, $presentation, $technical_complexity, $total_score);
    // print_r($stmt);
    // if ($stmt->execute()) {
    //     echo 'hello';
    //     print_r($stmt);
    // die;
    //     header("Location: project_list.php?msg=evaluation_success");
    //     exit();
    // } else {
    //     echo 'hello';
    //     print_r($stmt->error);
    // die;
    //     die("Database Error: " . $stmt->error);
    // }

    // $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluate Project</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 0; }
        .container { width: 40%; margin: 50px auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); }
        h2 { text-align: center; color: #3e0e12; }
        label { font-weight: bold; }
        select { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 5px; font-size: 16px; }
        button { width: 100%; background: #3e0e12; color: white; padding: 12px; border: none; border-radius: 5px; cursor: pointer; font-size: 18px; }
        button:hover { background: #72383d; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Evaluate Project: <?php echo htmlspecialchars($project_name); ?></h2>
        <form method="post">
            <label>Innovation & Creativity</label>
            <select name="innovation_creativity" required>
                <?php for ($i = 0; $i <= 10; $i++) echo "<option value='$i'>$i</option>"; ?>
            </select>

            <label>Technical Execution</label>
            <select name="technical_execution" required>
                <?php for ($i = 0; $i <= 10; $i++) echo "<option value='$i'>$i</option>"; ?>
            </select>

            <label>Presentation & Communication Skills</label>
            <select name="presentation_communication_skills" required>
                <?php for ($i = 0; $i <= 10; $i++) echo "<option value='$i'>$i</option>"; ?>
            </select>

            <label>Practical Relevance & Impact</label>
            <select name="practical_relevance_impact" required>
                <?php for ($i = 0; $i <= 10; $i++) echo "<option value='$i'>$i</option>"; ?>
            </select>

            <label>Understanding & Learning</label>
            <select name="understanding_learning" required>
                <?php for ($i = 0; $i <= 10; $i++) echo "<option value='$i'>$i</option>"; ?>
            </select>

            <button type="submit">Submit Evaluation</button>
        </form>
    </div>
</body>
</html>
