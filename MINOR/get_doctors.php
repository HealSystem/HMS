<?php
// Database connection parameters
$servername = "localhost"; // Change this to your MySQL server address
$username = "root"; // Change this to your MySQL username
$password = ""; // Change this to your MySQL password
$dbname = "admindb"; // Change this to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch doctors based on selected specialization
if(isset($_POST['specialization'])) {
    $specialization = $_POST['specialization'];
    $sql = "SELECT fname FROM doctor WHERE specialization = '$specialization'";
    $result = $conn->query($sql);

    $data = array();
    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            $data[] = $row['fname']; // Only add doctor name to the array
        }
    } else {
        $data[] = "No doctors available"; // Provide a default message
    }

    // Set content type to JSON
    header('Content-Type: application/json');

    // Output JSON data
    echo json_encode($data);
}

// Close connection
$conn->close();
?>