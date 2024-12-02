<?php
ob_start(); // Start output buffering

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "admindb";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get form data
    $patientid = $_POST['patientid'];
    $firstName = $_POST['first-name'];
    $middleName = $_POST['middle-name'];
    $lastName = $_POST['last-name'];
    $dob = $_POST['dob'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $Bloodgroup = $_POST['BG'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phone-number'];
    $stateProvince = $_POST['stateProvince'];
    $city = $_POST['city'];
    $address = $_POST['address'];

    // Using prepared statements to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO patient (patientid, fname, mname, lname, dob, age, gender,BG,email, phone_number, stateProvince, city, address)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssssss", $patientid, $firstName, $middleName, $lastName, $dob, $age, $gender, $Bloodgroup,$email, $phoneNumber, $stateProvince, $city, $address);

    if ($stmt->execute()) {
        // Redirect to a success page
        header("Location: success.php?patientid=$patientid");
        exit();
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    $stmt->close();
    $conn->close();
}

// End output buffering and flush the output
ob_end_flush();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Registration - HealSys</title>
    <link rel="stylesheet" href="style.css">
    <style>
         body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
        }

        #p1{
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
            display: flex;
            justify-content: center;
            align-items: center;
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

        #form-container {
            margin-top:50px;
            background-color: cream;
            padding: 20px;
            border-radius: 10px;
            opacity: 2;
            font-size: 15px;
            box-shadow: 0 0 100px rgba(0, 0, 0, 0.3);
            margin-bottom:5px;
            width : 450px;
        
        }

        table {
            width: 100%;
        }

        table tr td {
            padding: 10px;
        }

        input[type="text"],input[type="email"],input[type="int"],input[type="date"],input[type="tel"],textarea,select {
            width: 200px;
         padding: 15px; /* Increase padding */
         margin-bottom: 10px;
        border: none;
        border-radius: 5px;
        font-size: 15x; /* Increase font size */
        background-color: gainsboro;
        }

        button{
            width:30%;
            height:25px;
    
        }
        .btn-container button[type="submit"] {
        background-color: #4CAF50;
        color: white;
    }

    .btn-container button[type="reset"] {
        background-color: #f44336;
        color: white;
    }

        

    </style>    
</head>
<div class="top-taskbar">
        <div class="welcome">
            <h2>Welcome to HealSys</h2>
            <p>"Your Health, Our Priority"</p>
        </div>
        <nav>
            <ul>
                <li><a href="index.html">Back</a></li>  
            </ul>
        </nav>
    </div>
    
<body>

    <div id="p1">
        <div id="form-container">
        <center><h2>Patient Registration Form</h2></center>
        <form id="patient-registration-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <table>
            <tr>
                    <td><label for="first-name">First Name:</label></td>
                    <td><input type="text" id="first-name" name="first-name" required></td>
                </tr>
                <tr>
                    <td><label for="middle-name">Middle Name:</label></td>
                    <td><input type="text" id="middle-name" name="middle-name"></td>
                </tr>
                <tr>
                    <td><label for="last-name">Last Name:</label></td>
                    <td><input type="text" id="last-name" name="last-name" required></td>
                </tr>
                <tr>
                    <td><label for="dob">DOB:</label></td>
                    <td><input type="date" id="dob" name="dob" required></td>
                </tr>
                <tr>
                    <td><label for="age">Age:</label></td>
                    <td><input type="int" id="age" name="age" required></td>
                </tr>
                <tr>
                    <td><label for="gender">Gender:</label></td>
                    <td><select name="gender" required>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td><label for="blood-group">Blood Group:</label></td>
                    <td>
                    <select name="BG" id="BG" class="form-control" required>
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
            </select>
             </td>
         </tr>
                <tr>
                    <td><label for="email">E-mail:</label></td>
                    <td><input type="email" id="email" name="email" required></td>
                </tr>
                <tr>
                    <td><label for="phone-number">Phone Number:</label></td>
                    <td><input type="tel" id="phone-number" name="phone-number" required></td>
                </tr>
                <tr>
                    <td><label for="stateProvince">State/Province:</label></td>
                    <td><input type="text" id="stateProvince" name="stateProvince" required></td>
                </tr>
                <tr>
                    <td><label for="city">City:</label></td>
                    <td><input type="text" id="city" name="city" required></td>
                </tr>
                <tr>
                    <td><label for="address">Address:</label></td>
                    <td><textarea id="address" name="address" rows="4" required></textarea></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="hidden" id="patientid" name="patientid" value=""></td>
                </tr>

            </table>
            <div class="btn-container">
        <button type="submit">Submit</button>
        <button type="reset">Reset</button>
    </div>
        </form>
    </div>
    </div>

    <script>
        // Function to set a unique ID before form submission
        document.getElementById('patient-registration-form').addEventListener('submit', function (event) {
            // Prevent the form from submitting before the unique ID is set
            event.preventDefault();

            var generatedUniqueId = generateUniqueId();
            document.getElementById('patientid').value = generatedUniqueId;

            // Now, submit the form
            this.submit();
        });

        function generateUniqueId() {
    // Get current timestamp
    var timestamp = Date.now().toString();

    // Extract the last 6 digits of the timestamp
    var shortenedTimestamp = timestamp.substr(-6);

    // Combine prefix with shortened timestamp
    return 'PAT' + shortenedTimestamp;
}

    </script>

</body>
</html>