<?php
// Database Connection
$server = "localhost";
$username = "klmvjenl_jaincabs";
$password = "v4TZnVWZbCuYyGY37Exy";
$db_name = "klmvjenl_jaincabs";

$conn = mysqli_connect($server, $username, $password, $db_name);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get search query if provided
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Fetch projects from database
$sql = "SELECT table_number, name, branch, project_name, project_domain 
        FROM users 
        WHERE user_type = 'participant'";

// Apply search filter
if (!empty($search)) {
    $sql .= " AND (project_name LIKE '%$search%' 
              OR name LIKE '%$search%' 
              OR project_domain LIKE '%$search%' 
              OR table_number LIKE '%$search%')";
}

$result = $conn->query($sql);

// Check if results exist
$projects = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $projects[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project List</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Inline Custom Styles for this page */
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .search-bar {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .search-bar input {
            flex: 1;
            max-width: 800px;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }

        .search-bar button {
            background: #3e0e12;
            color: #fff;
            width: 15%;
            border: none;
            padding: 10px 20px;
            margin-left: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .search-bar button:hover {
            background: #72383d;
        }

        .project-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .project-table th, .project-table td {
            padding: 15px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .project-table th {
            background-color: #3e0e12;
            color: white;
        }

        .project-table tr:nth-child(even) {
            background: #f9f9f9;
        }

        .project-table tr:hover {
            background: #e3f2fd;
        }
    </style>
</head>
<body>

    <!-- Header Section (from styles.css) -->
    <header>
        <div class="logo">
            <img src="Prayogamlogo.png" alt="Logo">
        </div>
        <nav class="navbar">
            <a href="#home" style="background-color:#c5b264;">Home</a>
            <a href="#about">About</a>
            <a href="#speakers">Speakers</a>
            <a href="#gallery">Gallery</a>
            <a href="#projects">Projects</a>
            <a href="#contact">Contact</a>
        </nav>
    </header>

    <!-- Main Container -->
    <div class="container">
        <form method="GET" action="project_list.php" class="search-bar">
            <input type="text" name="search" placeholder="Search projects by name, participant, domain, or table number" value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Search</button>
        </form>

        <table class="project-table">
            <thead>
                <tr>
                    <th>Table Number</th>
                    <th>Participant Name</th>
                    <th>Branch</th>
                    <th>Project Name</th>
                    <th>Project Domain</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($projects) > 0): ?>
                    <?php foreach ($projects as $project): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($project['table_number']); ?></td>
                            <td><?php echo htmlspecialchars($project['name']); ?></td>
                            <td><?php echo htmlspecialchars($project['branch']); ?></td>
                            <td><?php echo htmlspecialchars($project['project_name']); ?></td>
                            <td><?php echo htmlspecialchars($project['project_domain']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center;">No projects found. Please try another search.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Footer Section -->
    <section id="contact">
        <div class="footer" style="background-color: #3e0e12; color: #fff;">
            <div class="content">
                <div class="links">
                    <h4>Useful Links</h4>
                    <p><a href="#home">Home</a></p>
                    <p><a href="#registration">Registration</a></p>
                    <p><a href="#about">About</a></p>
                    <p><a href="#livechat">Live Chat</a></p>
                </div>
                <div class="contact-info">
                    <h4>Contact Information</h4>
                    <p>Poornima University, Jaipur</p>
                    <p>Phone: <a href="tel:+919826054814" style="color: #c5b264;">+91 9826054814</a></p>
                    <p>Email: <a href="mailto:pratish.rawat@poornima.edu.in" style="color: #c5b264;">pratish.rawat@poornima.edu.in</a></p>
                </div>
                <div class="coordinators">
                    <h4>Coordinators</h4>
                    <p>Dr. Ajay Khunteta</p>
                    <p>Mr. Pratish Rawat</p>
                    <p>Mrs. Megha Nain</p>
                    <p>Mrs. Gurvita Rai</p>
                </div>
            </div>
            <footer>
                <div class="credit">
                    © 2025 PRAYOGAM. All rights reserved.
                </div>
            </footer>
        </div>
    </section>

    <script src="script.js"></script>
</body>
</html>
