<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="style.css"> -->
    <title>Doc Deletion</title>
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
        .search-container {
            text-align: center;
            margin-bottom: 20px;
            padding-top: 60px;
        }

        .search-container form {
            display: inline-block;
            border-radius: 4px;
            overflow: hidden;
        }

        .search-container label {
            display: block;
            padding: 10px;
        }

        .search-container input[type="text"] {
            padding: 10px;
            font-size: 16px;
            border: none;
            width: 200px;
        }

        .search-container button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        .search-container button:hover {
            background-color: #45a049;
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
            </ul>
        </nav>
    </div>

    <div>
        <p></p>
        <div class="search-container">
            <form method="post" action="">
                <b><label for="search-term">Enter Doctor ID or Name:</label></b>
                <input type="text" id="search-term" name="search_term" placeholder="Doctor-ID or Name" required>
                <button type="submit" name="search">Search</button>
            </form>
        </div>
    </div>
    <div class="doctor-info">
        <?php
        $conn = new mysqli('localhost', 'root', '', 'admindb');

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])) {
            $search_term = $_POST['search_term'];

            $sql = "SELECT * FROM doctor WHERE doctorid LIKE '%$search_term%' OR CONCAT(fname, ' ', mname, ' ', lname) LIKE '%$search_term%'";
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
                <th>Delete</th>
                </tr>
                </thead><tbody>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["doctorid"] . "</td>";
                    echo "<td>" . $row["fname"] . " " . $row["mname"] . " " . $row["lname"] . "</td>";
                    echo "<td>" . $row["dob"] . "</td>";
                    echo "<td>" . $row["email"] . "</td>";
                    echo "<td>" . $row["phone"] . "</td>";
                    echo "<td>" . $row["gender"] . "</td>";
                    echo "<td>" . $row["city"] . ", " . $row["state"] . "</td>";
                    echo "<td>" . $row["education"] . "</td>";
                    echo "<td>" . $row["specialization"] . "</td>";
                    echo "<td>" . $row["previousClinics"] . "</td>";
                    echo "<td>" . $row["surgeries"] . "</td>";
                    echo "<td>
                            <form method='post' action=''>
                                <input type='hidden' name='doctor_id' value='" . $row["doctorid"] . "'>
                                <button type='submit' name='delete' onclick=\"return confirm('Are you sure you want to delete this doctor\'s information?');\">Delete</button>
                            </form>
                          </td>";
                    echo "</tr>";
                }
                echo "</tbody></table>";
            } else {
                echo "<center><b><p>No doctor found with ID or Name '" . $search_term . "'</p></b></center>";
            }
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
            $doctor_id = $_POST['doctor_id'];

            $sql = "DELETE FROM doctor WHERE doctorid = '$doctor_id'";

            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Doctor information deleted successfully.'); window.location.href = window.location.href;</script>";
            } else {
                echo "<script>alert('Error deleting doctor information.'); window.location.href = window.location.href;</script>";
            }
        }

        $conn->close();
        ?>
    </div>
</body>
</html>