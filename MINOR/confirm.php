<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "admindb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get appointment ID
$appointmentID = $_POST['appointmentID'];

// Update the appointment status to 'Confirmed'
$sql = "UPDATE appointment SET status='Confirmed' WHERE patientid='$appointmentID'";

if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();

// Redirect back to the appointment list
header("Location: appointment-list.php");
exit();
?>