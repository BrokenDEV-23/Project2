<?php
// Start or resume the session
session_start();

// Database connection (replace with your database credentials)
$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'payroll_db';
$conn = mysqli_connect($db_host, $db_username, $db_password, $db_name);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Function to remove an employee from the job
if (isset($_POST['remove_employee'])) {
    $employee_id_to_remove = $_POST['employee_id_to_remove'];
    $sql_remove_employee = "DELETE employees, payroll FROM employees LEFT JOIN payroll ON employees.e_id = payroll.e_id WHERE employees.e_id = ?";
    $stmt_remove_employee = $conn->prepare($sql_remove_employee);
    $stmt_remove_employee->bind_param("s", $employee_id_to_remove);
    if ($stmt_remove_employee->execute()) {
        echo "Employee removed successfully.";
    } else {
        echo "Error: " . $sql_remove_employee . "<br>" . $conn->error;
    }
}

// Function to display all employee information
if (isset($_POST['display_employees'])) {
    $sql_display_employees = "SELECT * FROM employees";
    $result_display_employees = $conn->query($sql_display_employees);
    if ($result_display_employees->num_rows > 0) {
        while ($row_display_employees = $result_display_employees->fetch_assoc()) {
            echo "Employee ID: " . $row_display_employees['e_id'] . ", Name: " . $row_display_employees['name'] . ", Role: " . $row_display_employees['role'] . "<br>";
        }
    } else {
        echo "No employees found.";
    }
}

// Update hourly rate and total hours worked in the payroll table
if (isset($_POST['submit_payroll'])) {
    $employee_id = $_POST['employee_id'];
    $hourly_rate = $_POST['hourly_rate'];
    $total_hours_worked = $_POST['total_hours_worked'];

    $sql = "SELECT * FROM payroll where e_id = $employee_id;";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result)>0){
        $sql_update_payroll = "UPDATE payroll SET hourly_rate = ?, total_hours_worked = ? WHERE e_id = ?";
        $stmt_update_payroll = $conn->prepare($sql_update_payroll);
        $stmt_update_payroll->bind_param("dds", $hourly_rate, $total_hours_worked, $employee_id);
        if ($stmt_update_payroll->execute()) {
            echo "Payroll information updated successfully.";
        } else {
            echo "Error: " . $sql_update_payroll . "<br>" . $conn->error;
        }
    }
    else{
        // Insert hourly rate and total hours worked into the payroll table
if (isset($_POST['submit_payroll'])) {
    $employee_id = $_POST['employee_id'];
    $hourly_rate = $_POST['hourly_rate'];
    $total_hours_worked = $_POST['total_hours_worked'];

    $sql_insert_payroll = "INSERT INTO payroll (e_id, hourly_rate, total_hours_worked) VALUES (?, ?, ?)";
    $stmt_insert_payroll = $conn->prepare($sql_insert_payroll);
    $stmt_insert_payroll->bind_param("sdd", $employee_id, $hourly_rate, $total_hours_worked);
    if ($stmt_insert_payroll->execute()) {
        echo "Payroll information inserted successfully.";
    } else {
        echo "Error: " . $sql_insert_payroll . "<br>" . $conn->error;
    }
}
    }

}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Boss Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Welcome, Boss!</h2>
        <!-- Add content specific to the boss dashboard -->
        <p>You have access to boss functionalities.</p>
        <form method="post" action="">
            <label for="employee_id">Employee ID:</label>
            <input type="text" id="employee_id" name="employee_id" required><br>
            
            <label for="hourly_rate">Hourly Rate:</label>
            <input type="number" id="hourly_rate" name="hourly_rate" required><br>
            
            <label for="total_hours_worked">Total Hours Worked:</label>
            <input type="number" id="total_hours_worked" name="total_hours_worked" required><br>
            
            <input type="submit" name="submit_payroll" value="Update Payroll Information">
        </form>
        
        <form method="post" action="">
            <input type="submit" name="display_employees" value="Display All Employee Information">
        </form>

        <form method="post" action="">
            <label for="employee_id_to_remove">Enter Employee ID to Remove:</label>
            <input type="text" id="employee_id_to_remove" name="employee_id_to_remove" required><br>
            <input type="submit" name="remove_employee" value="Remove Employee">
        </form>
        
        <p><a href="logout.php">Logout</a></p>
    </div>
</body>
</html>
