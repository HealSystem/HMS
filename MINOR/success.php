<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Successful - HealSys</title>
    <style>
        body {
            background: url('success_background.jpg') center/cover;
            height: 100vh;
            width: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            text-align: center;
        }

        #success-container {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 20px;
            border-radius: 10px;
        }
    </style>
</head>

<body>
    <div id="success-container">
        <h2>Registration Successful</h2>
        <?php
        // Retrieve the unique ID from the query parameter
        $patientid = isset($_GET['patientid']) ? $_GET['patientid'] : '';
        echo "<p>Your Patient ID is: $patientid</p>";
        ?>
        <p>Thank you for registering with HealSys.</p>
        <p>
        <a href="index.html"><button>OK</button></a>
    </div>
</body>

</html>