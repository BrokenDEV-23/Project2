<?php
session_start();

$name = $_POST["name"];
$password = $_POST["password"];
$role = $_POST["role"];

$conn = mysqli_connect("localhost", "root", "", "payroll_db");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT *FROM employee_login JOIN employees ON employee_login.employee_id = employees.id WHERE employees.name = '$name' AND employees.role = '$role'";
$result = mysqli_query($conn, $sql);

if($result AND mysqli_num_rows($result) > 0){
    $row = mysqli_fetch_assoc($result);
    if(password_verify($password, $row['password'])){
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['role'] = $row['role'];
        switch ($role) {
            case 'boss':
                header("Location: boss_dashboard.php");
                break;
            case 'manager':
                header("Location: manager_dashboard.php");
                break;
            case 'worker':
                header("Location: worker_dashboard.php");
                break;
            default:
                echo "Unknown role.";
                break;
        }
        exit();
    }
    else{
        echo "password incorrect";
    }
}
else{
    echo "user not found";
}

mysqli_close($conn);
?>
