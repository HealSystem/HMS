<?php
session_start();

// Retrieve passed data from the URL
$patientid = $_GET['patientid'];
$patientName = $_GET['patientName'];
$appointmentDate = $_GET['appointmentDate'];
$doctorId = $_GET['doctorId'];

// Database credentials
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

// Retrieve doctor's name
$sql = "SELECT fname, mname, lname FROM doctor WHERE doctorid = '$doctorId'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $doctorName = $row['fname'] . " " . $row['mname'] . " " . $row['lname'];
} else {
    $doctorName = "Unknown";
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Prescription</title>
    <style>
      
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
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



        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            text-align: center;
            color: #4CAF50;
        }

        table {
            width: 100%;
        }

        table tr {
            margin-bottom: 20px;
        }

        table td {
            padding: 10px;
            vertical-align: top;
        }

        table td label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        table td input[type="text"],
        table td textarea {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
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
                <li><a href="doc_dash.php">Back</a></li>
           
            </ul>
        </nav> 
    </div>

    <div class="container">
        <h1>Prescription</h1>

        <?php
        if (isset($_SESSION['success'])) {
            echo "<p style='color:green;'>" . $_SESSION['success'] . "</p>";
            unset($_SESSION['success']);
        }
        if (isset($_SESSION['error'])) {
            echo "<p style='color:red;'>" . $_SESSION['error'] . "</p>";
            unset($_SESSION['error']);
        }
        ?>

        <form action="save-prescription.php" method="post">
            <table>
                <tr>
                    <td><label for="patientid">Patient ID</label></td>
                    <td><input type="text" id="patientid" name="patientid" value="<?php echo $patientid; ?>" readonly></td>
                </tr>
                <tr>
                    <td><label for="patientName">Patient Name</label></td>
                    <td><input type="text" id="patientName" name="patientName" value="<?php echo $patientName; ?>" readonly></td>
                </tr>
                <tr>
                    <td><label for="appointmentDate">Appointment Date</label></td>
                    <td><input type="text" id="appointmentDate" name="appointmentDate" value="<?php echo $appointmentDate; ?>" readonly></td>
                </tr>
                <tr>
                    <td><label for="doctorId">Doctor ID</label></td>
                    <td><input type="text" id="doctorId" name="doctorId" value="<?php echo $doctorId; ?>" readonly></td>
                </tr>
                <tr>
                    <td><label for="doctorName">Doctor Name</label></td>
                    <td><input type="text" id="doctorName" name="doctorName" value="<?php echo $doctorName; ?>" readonly></td>
                </tr>
                <tr>
                    <td><label for="Allergies">Allergies</label></td>
                    <td><textarea id="Allergies" name="Allergies" rows="4" required></textarea></td>
                </tr>
                <tr>
                    <td><label for="diagnosis">Diagnosis</label></td>
                    <td><textarea id="diagnosis" name="diagnosis" rows="4" required></textarea></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" value="Save Prescription"></td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>
