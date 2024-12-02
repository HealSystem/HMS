<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Doctor List</title>
    <style>

body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
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
                <li><a href="admin-dashboard.html">Back</a></li>
                <li><a href="index.html">Logout</a></li>  
            </ul>
        </nav> 
    </div>

    <div>
        <center>
            <h1>Prescription List</h1>
        </center>
        


<?php
// Replace these variables with your actual database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "admindb";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Select data from the prescription table
$sql = "SELECT * FROM prescription";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    echo "<table class='styled-table'>
    <thead>
            <tr>
                <th>Patient ID</th>
                <th>Patient Name</th>
                <th>Appointment Date</th>
                <th>Doctor ID</th>
                <th>Prescription</th>
                <th>Diagnosis</th>
            </tr></thead>";
    while($row = $result->fetch_assoc()) {
        echo "<tbody><tr>
                <td>" . $row["patientid"] . "</td>
                <td>" . $row["patientName"] . "</td>
                <td>" . $row["appointmentDate"] . "</td>
                <td>" . $row["doctorId"] . "</td>
                <td>" . $row["prescription"] . "</td>
                <td>" . $row["diagnosis"] . "</td>
            </tr></tbody>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

$conn->close();
?>
  </div>
</body>
</html>