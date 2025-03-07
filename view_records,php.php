<?php
// Database connection settings
$server="localhost";
$username="klmvjenl_jaincabs";
$password="v4TZnVWZbCuYyGY37Exy";
$db_name="klmvjenl_jaincabs";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch records
$sql = "SELECT * FROM users"; // Replace 'users' with your table name
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Records</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
    <h1>Registered Users</h1>

    <?php
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr>
                <th>ID</th>
                <th>Name</th>
                <th>Branch</th>
                <th>Registration ID</th>
                <th>Specialisation</th>
                <th>Project Name</th>
                <th>Project Type</th>
                <th>Project URL</th>
                <th>Project Domain</th>
                <th>Email</th>
                <th>Registered At</th>
              </tr>";

        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row['id'] . "</td>
                    <td>" . $row['name'] . "</td>
                    <td>" . $row['branch'] . "</td>
                    <td>" . $row['registration_id'] . "</td>
                    <td>" . $row['participant_course'] . "</td>
                    <td>" . $row['project_name'] . "</td>
                    <td>" . $row['project_type'] . "</td>
                    <td><a href='" . $row['project_url'] . "' target='_blank'>View Project</a></td>
                    <td>" . $row['project_domain'] . "</td>
                    <td>" . $row['email'] . "</td>
                    <td>" . $row['registered_at'] . "</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No records found.</p>";
    }

    // Close connection
    $conn->close();
    ?>
</body>
</html>
