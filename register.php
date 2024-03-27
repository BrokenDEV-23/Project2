<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input data
    $employee_id = trim($_POST["employee_id"]);
    $username = trim($_POST["username"]);
    $password = $_POST["password"]; // We'll hash the password for security
    
    // Validate input (you can add more validation as needed)
    if (empty($employee_id) || empty($username) || empty($password)) {
        echo "Please fill out all fields.";
        exit();
    }
    
    // Connect to the database (replace with your database credentials)
    $db_host = 'localhost';
    $db_username = 'root';
    $db_password = '';
    $db_name = 'payroll_db';
    $conn = mysqli_connect($db_host, $db_username, $db_password, $db_name);
    
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    // Check if the employee_id exists in the employees table
    $sql_check_employee = "SELECT id FROM employees WHERE id = ?";
    $stmt_check_employee = mysqli_prepare($conn, $sql_check_employee);
    mysqli_stmt_bind_param($stmt_check_employee, "s", $employee_id);
    mysqli_stmt_execute($stmt_check_employee);
    mysqli_stmt_store_result($stmt_check_employee);
    
    // If employee_id does not exist in employees table, show error message
    if (mysqli_stmt_num_rows($stmt_check_employee) == 0) {
        echo "Employee ID does not exist.";
        exit();
    }
    
    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Prepare and execute SQL statement to insert new employee login
    $sql_insert_login = "INSERT INTO employee_login (employee_id, username, password) VALUES (?, ?, ?)";
    $stmt_insert_login = mysqli_prepare($conn, $sql_insert_login);
    mysqli_stmt_bind_param($stmt_insert_login, "sss", $employee_id, $username, $hashed_password);
    
    if (mysqli_stmt_execute($stmt_insert_login)) {
        echo "Employee registered successfully.";
    } else {
        echo "Error registering employee: " . mysqli_error($conn);
    }
    
    // Close statements and connection
    mysqli_stmt_close($stmt_check_employee);
    mysqli_stmt_close($stmt_insert_login);
    mysqli_close($conn);
}
?>
