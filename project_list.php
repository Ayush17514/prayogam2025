<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();



// Restrict access to only admins and judges
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'judge')) {
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

$search = isset($_GET['search']) ? $_GET['search'] : '';
$judge_id = $_SESSION['user_id'];

// Fetch judge's assigned domain
$judge_query = "SELECT project_domain FROM users WHERE id = '$judge_id'";
$judge_result = mysqli_query($conn, $judge_query);
$judge_data = ($judge_result && mysqli_num_rows($judge_result) > 0) ? mysqli_fetch_assoc($judge_result) : [];
$judge_domain = $judge_data['project_domain'] ?? null;

// Fetch projects
$sql = "SELECT id,table_number, name, branch, project_name, project_domain FROM users WHERE user_type = 'participant' AND project_domain LIKE '%$judge_domain%'";

if (!empty($search)) {
    $sql .= " AND (project_name LIKE '%$search%' OR name LIKE '%$search%' OR project_domain LIKE '%$search%' OR table_number LIKE '%$search%')";
}

$result = mysqli_query($conn, $sql);
$projects = ($result && mysqli_num_rows($result) > 0) ? mysqli_fetch_all($result, MYSQLI_ASSOC) : [];

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project List</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 0; }
        .container { width: 90%; max-width: 1200px; margin: 30px auto; padding: 20px; background: white; border-radius: 10px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); }
        .search-bar { display: flex; justify-content: center; margin-bottom: 20px; }
        .search-bar input { flex: 1; max-width: 800px; padding: 12px; border: 2px solid #ddd; border-radius: 20px; font-size: 1rem; }
        .search-bar button { background: #3e0e12; color: #fff; padding: 12px 20px; border: none; border-radius: 20px; cursor: pointer; }
        .search-bar button:hover { background: #72383d; }
        .table-container {
    width: 100%;
    overflow-x: auto; /* Enables horizontal scrolling */
    border-radius: 10px;
}

.project-table {
    width: 100%;
    min-width: 600px; /* Prevents table from shrinking too much */
    border-collapse: collapse;
}

.project-table th, .project-table td {
    white-space: nowrap; /* Prevents text from wrapping */
}

        .project-table { width: 100%; border-collapse: collapse; margin-top: 20px; border-radius: 10px; overflow: hidden; }
        .project-table th, .project-table td { padding: 15px; text-align: left; border-bottom: 1px solid #ddd; }
        .project-table th { background-color: #3e0e12; color: white; }
        .project-table tr:hover { background: #e3f2fd; }
        .evaluate-btn { background: #007bff; color: white; padding: 8px 12px; border: none; cursor: pointer; border-radius: 5px; }
        .evaluate-btn:hover { background: #0056b3; }
        .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); align-items: center; justify-content: center; }
        .modal-content { background: white; padding: 20px; width: 50%; border-radius: 10px; position: relative; }
        .close-btn { position: absolute; top: 10px; right: 15px; font-size: 20px; cursor: pointer; }

        @media (max-width: 768px) {
        .container { width: 95%; padding: 15px; }
        .search-bar { flex-direction: column; align-items: center; }
        .search-bar input { width: 100%; margin-bottom: 10px; }
        .search-bar button { width: 100%; }
        .project-table th, .project-table td { padding: 10px; font-size: 0.9rem; }
        .modal-content { width: 80%; }
    }

    @media (max-width: 480px) {
        .container { padding: 10px; }
        .search-bar input { font-size: 0.9rem; padding: 10px; }
        .search-bar button { font-size: 0.9rem; padding: 10px; }
        .project-table th, .project-table td { font-size: 0.8rem; padding: 8px; }
        .modal-content { width: 90%; }
    }
    </style>
</head>
<body>
    <div class="container">
        <form method="GET" action="project_list.php" class="search-bar">
            <input type="text" name="search" placeholder="Search projects..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Search</button>
        </form>
<div class="table-container">
        <table class="project-table">
            <thead>
                <tr>
                    <th>Table Number</th>
                    <th>Participant Name</th>
                    <th>Branch</th>
                    <th>Project Name</th>
                    <th>Project Domain</th>
                    <th>Evaluate</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($projects)): ?>
                    <?php foreach ($projects as $project): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($project['table_number']); ?></td>
                            <td><?php echo htmlspecialchars($project['name']); ?></td>
                            <td><?php echo htmlspecialchars($project['branch']); ?></td>
                            <td><?php echo htmlspecialchars($project['project_name']); ?></td>
                            <td><?php echo htmlspecialchars($project['project_domain']); ?></td>
                            <td>
                                <?php if ($_SESSION['role'] == 'judge' || $project['project_domain'] == $judge_domain): ?>
                                    <button class="evaluate-btn" onclick="openModal(<?php echo $project['table_number']; ?>)">Evaluate</button>

                                <?php else: ?>
                                    <span style="color: grey;">Not Allowed</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align: center;">No projects found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Evaluation Modal -->
    <div id="evaluationModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <iframe id="evaluationFrame" src="" width="100%" height="400px" frameborder="0"></iframe>
        </div>
    </div>

    <script>
        function openModal(tableNumber) {
            let frame = document.getElementById('evaluationFrame');
            frame.src = 'evaluate_project.php?table_number=' + tableNumber;
            document.getElementById('evaluationModal').style.display = 'flex';
        }

        function closeModal() {
            let modal = document.getElementById('evaluationModal');
            modal.style.display = 'none';
            document.getElementById('evaluationFrame').src = '';  // Clear iframe
        }

        // Close modal on background click
        window.onclick = function(event) {
            let modal = document.getElementById('evaluationModal');
            if (event.target === modal) {
                closeModal();
            }
        };
    </script>
</body>
</html>