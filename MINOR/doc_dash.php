<?php
session_start(); // Start the session

// Replace these variables with your actual database credentials
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

// Ensure the doctor is logged in
if (!isset($_SESSION['did'])) {
    echo '<script>alert("Please log in first.");</script>';
    echo "<meta http-equiv='refresh' content='0;url=login.html'>";
    exit();
}

// Retrieve doctor's appointments for today
$doctorId = $_SESSION['did'];
$today = date('Y-m-d'); // Date format is yyyy-mm-dd

$sql = "SELECT * FROM appointment WHERE doctorid = ? AND appointmentDate = ? AND status = 'confirmed'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $doctorId, $today);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
        }

        .confidential {
            text-align: center;
            font-style: italic;
            margin-bottom: 20px;
        }

        .top-taskbar {
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 99%;
        }

        .top-taskbar h1 {
            margin: 0;
        }

        .welcome {
            padding: 10px;
            text-align: center;
        }

        .welcome h2,
        .welcome p {
            margin: 0;
            color: white;
        }

        nav ul {
            list-style-type: none;
            display: flex;
        }

        nav li {
            margin: 0 15px;
        }

        nav a {
            text-decoration: none;
            color: white;
            font-weight: bold;
        }

        .success-message {
            text-align: center;
            padding: 10px;
            margin-top: 20px;
            background-color: #dff0d8;
            color: #3c763d;
            border: 1px solid #d6e9c6;
            border-radius: 5px;
        }

        .styled-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-bottom: 20px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        .styled-table thead th {
            background-color: #4CAF50;
            color: white;
            padding: 12px;
            text-align: left;
        }

        .styled-table tbody td {
            padding: 12px;
        }

        .styled-table tbody tr:nth-child(even) {
            background-color: #f5f5f5;
        }

        .styled-table tbody tr:hover {
            background-color: #e0e0e0;
            cursor: pointer;
        }

        form {
            display: inline;
        }

        input[type="submit"] {
            background-color: #4CAF50; /* Green */
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 4px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        input[type="submit"].reject {
            background-color: #f44336; /* Red */
        }

        input[type="submit"].reject:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>

<div class="top-taskbar">
    <div class="welcome">
        <h2>Welcome to HealSys</h2>
        <p>"Your Health, Our Priority"</p>
    </div>
    <nav>
        <ul>
           
            <li><a href="index.html">Logout</a></li>  
        </ul>
    </nav>
</div>
<div>
    <center>
        <h1> Today's Appointment List</h1>
    </center>
</div>

<?php
if ($result->num_rows > 0) {
    echo "<table class='styled-table'>
    <thead>
    <tr>
    <th>Patient ID</th>
    <th>Patient Name</th>
    <th>Reason</th>
    <th>Appointment Time</th>
    <th>Prescription</th>
    </tr></thead><tbody>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['patientid']) . "</td>";
        echo "<td>" . htmlspecialchars($row['patientName']) . "</td>";
        echo "<td>" . htmlspecialchars($row['reason']) . "</td>";
        echo "<td>" . htmlspecialchars($row['appointmentTime']) . "</td>";
        // Add prescription button with a link to the add prescription page
        echo "<td><a href='add-prescription.php?patientid=" . htmlspecialchars($row['patientid']) . "&patientName=" . htmlspecialchars($row['patientName']) . "&appointmentDate=" . htmlspecialchars($today) . "&doctorId=" . htmlspecialchars($doctorId) . "'>Add Prescription</a></td>";
        echo "</tr>";
    }
    echo "</tbody></table>";
} else {
    echo "<div class='success-message'>No appointments available today.</div>";
}

$stmt->close();
$conn->close();
?>
</body>
</html>
