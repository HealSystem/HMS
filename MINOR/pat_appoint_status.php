<?php
session_start(); // Start the session

// Check if the patient is logged in
if (!isset($_SESSION['patientid'])) {
    echo '<script>alert("Please log in first.");</script>';
    echo "<meta http-equiv='refresh' content='0;url=login.html'>";
    exit();
}

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

// Fetch the logged-in patient's details
$patientid = $_SESSION['patientid'];
$query = "SELECT patientid, patientName, phoneNumber, specialization, doctorName, reason, appointmentDate, appointmentTime, status FROM appointment WHERE patientid = ?";
$stmt = mysqli_prepare($connection, $query);
mysqli_stmt_bind_param($stmt, "s", $patientid);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Check if there are any results
if (mysqli_num_rows($result) === 0) {
    mysqli_stmt_close($stmt);
    mysqli_close($connection);
    echo '<script>alert("No appointment found for the logged-in patient.");</script>';
    echo "<meta http-equiv='refresh' content='0;url=login.html'>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Details</title>
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
            <li><a href="appoint.html">Back</a></li>
           
        </ul>
    </nav>
</div>
<div class="details-container">
   <center> <h1>Appointment Status</h1></center>
    <table class="styled-table">
        <thead>
            <tr>
                <th>Patient ID</th>
                <th>Patient Name</th>
                <th>Phone Number</th>
                <th>Specialization</th>
                <th>Doctor Name</th>
                <th>Reason</th>
                <th>Appointment Date</th>
                <th>Appointment Time</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['patientid']); ?></td>
                    <td><?php echo htmlspecialchars($row['patientName']); ?></td>
                    <td><?php echo htmlspecialchars($row['phoneNumber']); ?></td>
                    <td><?php echo htmlspecialchars($row['specialization']); ?></td>
                    <td><?php echo htmlspecialchars($row['doctorName']); ?></td>
                    <td><?php echo htmlspecialchars($row['reason']); ?></td>
                    <td><?php echo htmlspecialchars($row['appointmentDate']); ?></td>
                    <td><?php echo htmlspecialchars($row['appointmentTime']); ?></td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php
mysqli_stmt_close($stmt);
mysqli_close($connection);
?>
</body>
</html>
