<?php
// Start session to access user information
session_start();

// Check if user is logged in
if (!isset($_SESSION["user_id"])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
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

// Fetch user's profile information from the database
$user_id = $_SESSION["user_id"];
$sql = "SELECT * FROM employees WHERE id = '$user_id'";
$result = mysqli_query($conn, $sql);

// Check if user exists
if (mysqli_num_rows($result) == 1) {
    // Display user's profile information
    $row = mysqli_fetch_assoc($result);
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Profile Information</title>
        <style>
            body {
                font-family: Arial, sans-serif;
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
            p {
                margin-bottom: 10px;
            }
            strong {
                font-weight: bold;
            }
        </style>
    </head>
    <body>
    <div class="container">
        <h2>Profile Information</h2>
        <p><strong>Employee ID:</strong> <?php echo $row['id']; ?></p>
        <p><strong>Name:</strong> <?php echo $row['name']; ?></p>
        <p><strong>Role:</strong> <?php echo $row['role']; ?></p>
        <!-- Add more fields as needed -->
    </div>
    </body>
    </html>
    <?php
} else {
    echo "User not found.";
}

// Close connection
mysqli_close($conn);
?>
