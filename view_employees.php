<!DOCTYPE html>
<html>
<head>
    <title>Employee Information</title>
    <style>
        .employee-table {
            width: 100%;
            border-collapse: collapse;
        }
        .employee-table th, .employee-table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .employee-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .employee-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
  <?php
// Start session to access user information
session_start();

// Check if user is logged in
if (!isset($_SESSION["user_id"])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Check if user has appropriate role (e.g., boss or manager)
if ($_SESSION["role"] != "boss" && $_SESSION["role"] != "manager") {
    // Redirect to unauthorized page
    header("Location: unauthorized.php");
    exit();
}

// Connect to the database
$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'payroll_db';
$conn = mysqli_connect($db_host, $db_username, $db_password, $db_name);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch employees' information from the database
$sql = "SELECT e_id, name, role FROM employees ORDER BY e_id ASC";
$result = mysqli_query($conn, $sql);

// Check if there are any employees
if (mysqli_num_rows($result) > 0) {
    // Display employee information
    echo "<h2>Employee Information</h2>";
    echo "<table class='employee-table'>";
    echo "<tr><th>Employee ID</th><th>Name</th><th>Role</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['e_id'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['role'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No employees found.";
}

// Close connection
mysqli_close($conn);
?>

</body>
</html>
