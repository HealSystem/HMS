<?php
session_start();

// Check if the patient is logged in by verifying if patientid is set in the session
if (!isset($_SESSION['patientid'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

$patientId = $_SESSION['patientid'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "admindb";

// Create a new database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute the SQL statement to retrieve prescription details
$stmt = $conn->prepare("SELECT * FROM prescription WHERE patientid = ?");
$stmt->bind_param("s", $patientId);
$stmt->execute();
$result = $stmt->get_result();

// Check if any rows are returned
if ($result === false) {
    die("Error in query execution: " . $conn->error);
}

$prescriptions = [];
while ($row = $result->fetch_assoc()) {
    $prescriptions[] = $row;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Prescription Details - HealSys</title>
    <link rel="stylesheet" href="style.css">
    <style>
         body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
        }

        .top-taskbar {
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .top-taskbar h1 {
            margin: 0;
        }

        .welcome {
            background-color: #4CAF50;
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

        .styled-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
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
        .search-container {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
            padding-right: 20px;
        }
        .search-container form {
            display: flex;
        }
        .search-container input[type="text"] {
            padding: 10px;
            font-size: 17px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-right: 10px;
            
        }
        .search-container button {
            padding: 10px;
            font-size: 17px;
            border: none;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            border-radius: 4px;
            height: 40px;
            width: 100px; 
        }
        .search-container button:hover {
            background-color: #45a049;
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
                <li><a href="home.html">Back</a></li>
            </ul>
        </nav>
    </div>

        <center><h2>Prescription Details</h2></center>
        <?php if (count($prescriptions) > 0): ?>
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Patient ID</th>
                        <th>Patient Name</th>
                        <th>Doctor ID</th>
                        <th>Doctor Name</th>
                        <th>Appointment Date</th>
                        <th>Prescription</th>
                        <th>Diagnosis</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($prescriptions as $prescription): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($prescription['patientid']); ?></td>
                            <td><?php echo htmlspecialchars($prescription['patientName']); ?></td>
                            <td><?php echo htmlspecialchars($prescription['doctorId']); ?></td>
                            <td><?php echo htmlspecialchars($prescription['doctorName']); ?></td>
                            <td><?php echo htmlspecialchars($prescription['appointmentDate']); ?></td>
                            <td><?php echo htmlspecialchars($prescription['prescription']); ?></td>
                            <td><?php echo htmlspecialchars($prescription['diagnosis']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
           <center> <p>No prescription details found for this patient.</p></center>
        <?php endif; ?>
    </div>
</body>
</html>