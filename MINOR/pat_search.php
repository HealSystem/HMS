<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Patient List</title>
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
            <li><a href="patient_list.php">Back</a></li>
              
            </ul>
        </nav> 
    </div>

    <div>
        <center>
            <h1>Search Results</h1>
        </center>
        
    </div>

    <!-- Patient List Container -->
    <div class="patient-list-container">
    <?php
// Database connection
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$database = "admindb";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the search form has been submitted
if (isset($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
    
    // SQL query to fetch data based on Patient-ID or Name
    $sql = "SELECT patientid, fname, mname, lname, dob, age, gender, BG, email, phone_number, stateProvince, city, address 
            FROM patient 
            WHERE patientid LIKE '%$search%' 
            OR fname LIKE '%$search%' 
            OR lname LIKE '%$search%'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table class='styled-table'>
        <thead>
        <tr>
        <th>Patient-ID</th>
        <th>Name</th>
        <th>DOB</th>
        <th>Age</th>
        <th>Gender</th>
        <th>Blood Group</th>
        <th>Email</th>
        <th>Phone Number</th>
        <th>Location</th>
        </tr>
        </thead>";
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tbody><tr>";
            echo "<td>" . $row["patientid"] . "</td>";
            echo "<td>" . $row["fname"] . ".";
            echo  $row["mname"] . ".";
            echo  $row["lname"] . "</td>";
            echo "<td>" . $row["dob"] . "</td>";
            echo "<td>" . $row["age"] . "</td>";
            echo "<td>" . $row["gender"] . "</td>";
            echo "<td>" . $row["BG"] . "</td>";
            echo "<td>" . $row["email"] . "</td>";
            echo "<td>" . $row["phone_number"] . "</td>";
            echo "<td>" . $row["stateProvince"] . ",";
            echo  $row["city"] . ",";
            echo $row["address"] . "</td>";
            echo "</tr></tbody>";
        }
        echo "</table>";
    } else {
        echo "<center>No results found.</center>";
    }
} else {
    echo "Please enter a search term.";
}

$conn->close();
?>


    </div>
</body>
</html>