<?php

$servername = "schoolconnect.online";
$username = "dbj94feydvxq";
$password = "20122020!Ama";
$dbname = "students";

$conn = mysqli_connect("localhost", "root", "", "school");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = $_POST['name'];
    $surname = $_POST['surname'];


    $courses = ["web_programming", "advanced_programming", "machine_learning"];



    //  $sql_students = "INSERT INTO students (stu_name, stu_surname) VALUES ('$name', '$surname')";
    //if ($conn->query($sql_students) !== TRUE) {
    //  echo "<script>alert('Error: Could not add student to students table'//);</script>";
// }



    foreach ($courses as $course) {

        $midterm = 0;
        $final = 0;


        $grade = ($midterm * 0.4) + ($final * 0.6);


        if ($grade >= 90 && $grade <= 100) {
            $grade_letter = 'AA';
        } elseif ($grade >= 85 && $grade < 90) {
            $grade_letter = 'BA';
        } elseif ($grade >= 80 && $grade < 85) {
            $grade_letter = 'BB';
        } elseif ($grade >= 75 && $grade < 80) {
            $grade_letter = 'CB';
        } elseif ($grade >= 70 && $grade < 75) {
            $grade_letter = 'CC';
        } elseif ($grade >= 60 && $grade < 70) {
            $grade_letter = 'DC';
        } elseif ($grade >= 50 && $grade < 60) {
            $grade_letter = 'DD';
        } elseif ($grade >= 40 && $grade < 50) {
            $grade_letter = 'FD';
        } else {
            $grade_letter = 'FF';
        }


        $sql = "INSERT INTO $course (stu_name, stu_surname)
                VALUES ('$name', '$surname')";

        if ($conn->query($sql) === TRUE) {

        } else {
            echo "<script>alert('Error: Could not add student to $course');</script>";
        }
    }

    echo "<script>alert('Student added successfully to all courses!');</script>";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <style>
        @media (max-width: 600px) {
            .login-container {
                padding: 15px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }

            .login-container h1 {
                font-size: 20px;
            }

            .form-group input,
            .form-group button {
                padding: 8px;
                font-size: 14px;
            }

            .button-container a {
                padding: 8px 15px;
                font-size: 14px;
            }
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .form-container h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-container form {
            display: flex;
            flex-direction: column;
        }

        .form-container label {
            margin-bottom: 5px;
        }

        .form-container input {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        .form-container button {
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .form-container button:hover {
            background-color: #0056b3;
        }

        .back-button {
            padding: 10px;
            background-color: #6c757d;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-align: center;
            text-decoration: none;
        }

        .back-button:hover {
            background-color: #5a6268;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h1>Add Student</h1>
        <form action="" method="POST">

            <label for="name">First Name</label>
            <input type="text" id="name" name="name" required>

            <label for="surname">Last Name</label>
            <input type="text" id="surname" name="surname" required>

            <button type="submit">Add Student</button>
        </form>
        <br>
        <br>

        <a href="landing.php" class="back-button">Back to Landing Page</a>
    </div>
</body>

</html>