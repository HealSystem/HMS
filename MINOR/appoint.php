<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli('localhost', 'root', '', 'admindb');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve form data
    $patientID = $_POST['patientID'];
    $patientName = $_POST['patientName'];
    $phoneNumber = $_POST['phoneNumber'];
    $specialization = $_POST['specialization'];
    $doctorFullName = $_POST['doctor'];
    $reason = $_POST['reason'];
    $appointmentDate = $_POST['appointmentDate'];
    $appointmentTime = $_POST['appointmentTime'];

    // Split the full name into parts (assuming it's in the format "First Middle Last")
    $nameParts = explode(" ", $doctorFullName);
    $doctorFirstName = $nameParts[0];
    $doctorMiddleName = isset($nameParts[1]) ? $nameParts[1] : ""; // Check if middle name is provided
    $doctorLastName = end($nameParts);

 // Fetch doctor ID from the doctor table based on the selected doctor first name and specialization
$getDoctorIDQuery = "SELECT doctorid FROM doctor WHERE fname = '$doctorFirstName' AND specialization = '$specialization'";

    $doctorResult = $conn->query($getDoctorIDQuery);
    if ($doctorResult->num_rows > 0) {
        $row = $doctorResult->fetch_assoc();
        $doctorID = $row['doctorid'];

        // Insert the form data into the appointments table including the doctorID
        $insertQuery = "INSERT INTO appointment (patientid, patientName, phoneNumber, specialization, doctorName, doctorid, reason, appointmentDate, appointmentTime) 
                        VALUES ('$patientID', '$patientName', '$phoneNumber', '$specialization', '$doctorFullName', '$doctorID', '$reason', '$appointmentDate', '$appointmentTime')";
        if ($conn->query($insertQuery) === TRUE) {
            echo "Appointment created successfully";
        } else {
            echo "Error: " . $insertQuery . "<br>" . $conn->error;
        }
    } else {
        echo "Error: Doctor not found";
    }

    // Close database connection
    $conn->close();
}
?>