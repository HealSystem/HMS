<?php
session_start();

// Database credentials
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

// Check if all required POST data is set
if (!isset($_POST['patientid'], $_POST['patientName'], $_POST['appointmentDate'], $_POST['doctorId'], $_POST['doctorName'], $_POST['Allergies'], $_POST['diagnosis'])) {
    $_SESSION['error'] = "All form fields are required.";
    header("Location: add-prescription.php?patientid=" . $_POST['patientid'] . "&patientName=" . $_POST['patientName'] . "&appointmentDate=" . $_POST['appointmentDate'] . "&doctorId=" . $_POST['doctorId']);
    exit();
}

// Get data from the form
$patientid = $conn->real_escape_string($_POST['patientid']);
$patientName = $conn->real_escape_string($_POST['patientName']);
$appointmentDate = $conn->real_escape_string($_POST['appointmentDate']);
$doctorId = $conn->real_escape_string($_POST['doctorId']);
$doctorName = $conn->real_escape_string($_POST['doctorName']);
$prescription = $conn->real_escape_string($_POST['Allergies']);
$diagnosis = $conn->real_escape_string($_POST['diagnosis']);

// Insert data into the database
$sql = "INSERT INTO prescription (patientid, patientName, appointmentDate, doctorId, doctorName, prescription, diagnosis) 
        VALUES ('$patientid', '$patientName', '$appointmentDate', '$doctorId', '$doctorName', '$prescription', '$diagnosis')";

if ($conn->query($sql) === TRUE) {
    // Redirect back to the form with success message
    $_SESSION['success'] = "<center>Prescription added successfully.</center>";
} else {
    // Log detailed error message
    $_SESSION['error'] = "Error: " . $conn->error . ". SQL: " . $sql;
}

$conn->close();
header("Location: add-prescription.php?patientid=$patientid&patientName=$patientName&appointmentDate=$appointmentDate&doctorId=$doctorId");
exit();
?>
