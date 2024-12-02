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

// Assuming you have a database connection established, proceed with the login logic

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $did = $_POST["did"];
    $password = $_POST["pswd"];

    // Use prepared statement to prevent SQL injection
    $query = "SELECT * FROM doctor WHERE doctorid = ? AND dob = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "ss", $did, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        // Login successful
        $_SESSION['did'] = $did; // Set the doctor's ID in the session
        header("Location: doc_dash.php"); // Redirect to doctor dashboard
        exit();
    } else {
        // Incorrect Patient ID or password
        echo '<script>alert("Invalid ID or Password");</script>';
        // Add a redirect if needed
        // echo "<meta http-equiv='refresh' content='0;url=login.html'>";
    }

    mysqli_stmt_close($stmt);
}

// Close the database connection
mysqli_close($connection);
?>