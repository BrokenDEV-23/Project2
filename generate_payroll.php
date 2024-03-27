<!DOCTYPE html>
<html>
<head>
    <title>Payroll Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
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
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        // Start session to access user information
        session_start();

        // Check if user is logged in
        if (!isset($_SESSION["user_id"])) {
            // Redirect to login page if not logged in
            header("Location: login.html");
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

        // Fetch employees' payroll information from the database
        $sql = "SELECT id, name, hourly_rate, total_hours_worked FROM employees";
        $result = mysqli_query($conn, $sql);

        // Check if there are any employees
        if (mysqli_num_rows($result) > 0) {
            // Display payroll information
            echo "<h2>Payroll Information</h2>";
            echo "<table>";
            echo "<tr><th>Employee ID</th><th>Name</th><th>Hourly Rate</th><th>Total Hours Worked</th><th>Total Pay</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                // Calculate total pay
                $total_pay = $row['hourly_rate'] * $row['total_hours_worked'];

                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>$" . $row['hourly_rate'] . "</td>";
                echo "<td>" . $row['total_hours_worked'] . "</td>";
                echo "<td>$" . $total_pay . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No employees found.";
        }

        // Close connection
        mysqli_close($conn);
        ?>
    </div>
</body>
</html>
