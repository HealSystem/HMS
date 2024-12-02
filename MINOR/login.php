<?php
session_start(); // Start the session

// Replace these variables with your actual database credentials
$host = "localhost";
$username = "root";
$password = "";
$database = "admindb";

// Create a connection to the database
$connection = mysqli_connect($host, $username, $password, $database);

// Check the connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patientid = $_POST["pid"];
    $password = $_POST["psw"];

    // Use prepared statement to prevent SQL injection
    $query = "SELECT * FROM patient WHERE patientid = ? AND dob = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "ss", $patientid, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        // Login successful
        $_SESSION['patientid'] = $patientid; // Store patient ID in session
        echo "<meta http-equiv='refresh' content='0;url=home.html'>";
        exit();
    } else {
        // Incorrect Patient ID or password
        echo '<script>alert("Invalid ID or Password");</script>';
        echo "<meta http-equiv='refresh' content='0;url=login.html'>";
    }

    mysqli_stmt_close($stmt);
}

// Close the database connection
mysqli_close($connection);
?>