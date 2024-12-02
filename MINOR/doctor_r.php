<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Doctor Information Form</title>
<link rel="stylesheet" href="style.css">
<style>
      body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
        }


    form {
        max-width: 600px;
        margin: 0 auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-top: 10px;
    }

    h1 {
        text-align: center;
    }

    .confidential {
        text-align: center;
        font-style: italic;
        margin-bottom: 20px;
    }

    input[type="text"],
    input[type="email"],
    input[type="tel"],
    input[type="date"],
    textarea,
    select {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
        box-sizing: border-box;
    }

    .btn-container {
        text-align: center;
    }

    .btn-container button {
        padding: 10px 20px;
        margin: 5px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .btn-container button[type="submit"] {
        background-color: #4CAF50;
        color: white;
    }

    .btn-container button[type="reset"] {
        background-color: #f44336;
        color: white;
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

<?php
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "admindb";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    function generateUniqueDoctorID($conn) {
        do {
            $uniqueID = "DOC" . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);
            $checkQuery = "SELECT COUNT(*) AS count FROM doctor WHERE doctorid='$uniqueID'";
            $result = $conn->query($checkQuery);
            $row = $result->fetch_assoc();
        } while ($row['count'] > 0);

        return $uniqueID;
    }

    $doctorid = generateUniqueDoctorID($conn);

    $stmt = $conn->prepare("INSERT INTO doctor (doctorid, fname, mname, lname, dob, email, phone, gender, city, state, education, specialization, previousClinics, surgeries) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssssss", $doctorid, $firstname, $middlename, $lastname, $dob, $email, $phone, $gender, $city, $state, $education, $specialization, $previousclinics, $surgeries);
    
    $firstname = $_POST["firstName"];
    $middlename = $_POST["middleName"];
    $lastname = $_POST["lastName"];
    $dob = $_POST["dob"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $gender = $_POST["gender"];
    $city = $_POST["city"];
    $state = $_POST["state"];
    $education = $_POST["education"];
    $specialization = $_POST["specialization"];
    $previousclinics = $_POST["previousClinics"];
    $surgeries = $_POST["surgeries"];
    
    if ($stmt->execute() === TRUE) {
        $message = "Welcome to Healsys family! Your doctor ID is: $doctorid";
    } else {
        $message = "Error: " . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();
}
?>

<?php if ($message): ?>
    <div class="success-message">
        <?php echo htmlspecialchars($message); ?>
    </div>
<?php endif; ?>

<form action="doctor_r.php" method="post">
    <h1>Doctor Information Form</h1>
    <p class="confidential">All information is strictly confidential.</p>
    <label for="firstName">First Name:</label>
    <input type="text" id="firstName" name="firstName" required><br>

    <label for="middleName">Middle Name:</label>
    <input type="text" id="middleName" name="middleName"><br>

    <label for="lastName">Last Name:</label>
    <input type="text" id="lastName" name="lastName" required><br><br>

    <label for="dob">Date of Birth:</label>
    <input type="date" id="dob" name="dob" required><br><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br>

    <label for="phone">Phone Number:</label>
    <input type="tel" id="phone" name="phone" pattern="[0-9]{10}" required><br>

    <label for="gender">Gender:</label>
    <select id="gender" name="gender" required>
        <option value="">Select</option>
        <option value="male">Male</option>
        <option value="female">Female</option>
        <option value="other">Other</option>
    </select><br>
   
    <label for="city">City:</label>
    <input type="text" id="city" name="city" required><br>

    <label for="state">State/Province:</label>
    <input type="text" id="state" name="state" required><br>

    <label for="education">Education:</label>
    <textarea id="education" name="education" rows="3" required></textarea><br>

    <label for="specialization">Specialization:</label>
    <textarea id="specialization" name="specialization" rows="3" required></textarea><br>

    <label for="previousClinics">Previous Clinics Worked At:</label>
    <textarea id="previousClinics" name="previousClinics" rows="3" required></textarea><br>

    <label for="surgeries">Surgeries Operated Before (General):</label>
    <textarea id="surgeries" name="surgeries" rows="3" required></textarea><br>

    <div class="btn-container">
        <button type="submit">Submit</button>
        <button type="reset">Reset</button>
    </div>
</form>

</body>
</html>