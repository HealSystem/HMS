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
            <h1>Doctor List</h1>
        </center>
        <div class="search-container">
        <form action="doc_search.php" method="GET">
            <input type="text" name="search" placeholder="Doctor ID or Name" required>
            <button type="submit">Search</button>
        </form>
    </div>
    </div>

    <!-- Doctor List Container -->
    <div class="doctor-list-container">
    <?php
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "admindb";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL query to fetch all data from the database
    $sql = "SELECT * FROM doctor";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table class='styled-table'>
        <thead>
        <tr>
        <th>Doctor-ID</th>
        <th>Name</th>
        <th>DOB</th>
        <th>Email</th>
        <th>Phone Number</th>
        <th>Gender</th>
        <th>Location</th>
        <th>Education</th>
        <th>Specialisation</th>
        <th>Previous Clinics</th>
        <th>Surgeries</th>
        </tr>
        </thead><tbody>";
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["doctorid"] . "</td>";
            echo "<td>" . $row["fname"] . ".";
            echo  $row["mname"] . ".";
            echo  $row["lname"] . "</td>";
            echo "<td>" . $row["dob"] . "</td>";
            echo "<td>" . $row["email"] . "</td>";
            echo "<td>" . $row["phone"] . "</td>";
            echo "<td>" . $row["gender"] . "</td>";
            echo "<td>" . $row["city"] . ", " . $row["state"] . "</td>";
            echo "<td>" . $row["education"] . "</td>";
            echo "<td>" . $row["specialization"] . "</td>";
            echo "<td>" . $row["previousClinics"] . "</td>";
            echo "<td>" . $row["surgeries"] . "</td>";
            echo "</tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "0 results";
    }
    $conn->close();
    ?>
    </div>
</body>
</html>