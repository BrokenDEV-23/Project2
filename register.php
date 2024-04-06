<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input data
    $username = trim($_POST["username"]);
    $password = $_POST["password"]; // We'll hash the password for security
    $role = $_POST["role"]; // Get the selected role from the form
    
    // Validate input (you can add more validation as needed)
    if (empty($username) || empty($password) || empty($role)) {
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

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Prepare and bind SQL statement
    $sql = "INSERT INTO employees (name, role, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $role, $hashed_password); // Bind the role variable
    
    // Execute the statement
    if ($stmt->execute()) {
        echo "Employee record inserted successfully.";
        
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    // Close the statement and connection
    $stmt->close();
    mysqli_close($conn);
}
?>
