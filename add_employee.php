<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'payroll_db';

// Create a connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input data
    $name = trim($_POST["name"]);
    $role = trim($_POST["role"]);
    $hourly_rate = floatval($_POST["hourly_rate"]);
    $total_hours_worked = 0;
    
    // Prepare and execute SQL statement to insert new employee
    $sql = "INSERT INTO employees (name, role, hourly_rate, total_hours_worked) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    // Bind parameters
    $stmt->bind_param("ssdi", $name, $role, $hourly_rate, $total_hours_worked); // "ssdi" indicates string, string, double, integer
    
    if ($stmt->execute()) {
        echo "Employee inserted successfully.";
    } else {
        echo "Error inserting employee: " . $stmt->error;
    }
    
    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Employee</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f2f2f2;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
        }
        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4caf50;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add Employee</h2>
        <form method="post" action="add_employee.php">
            <label for="name">Name:</label><br>
            <input type="text" id="name" name="name" required><br><br>
            
            <label for="role">Role:</label><br>
            <select id="role" name="role">
                <option value="boss">Boss</option>
                <option value="manager">Manager</option>
                <option value="worker">Worker</option>
            </select><br><br>
            
            <label for="hourly_rate">Hourly Rate:</label><br>
            <input type="number" id="hourly_rate" name="hourly_rate" required><br><br>
            
            <input type="submit" value="Add Employee">
        </form>
    </div>
</body>
</html>
