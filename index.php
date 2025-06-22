<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = mysqli_connect("localhost", "root", "", "school");
    if (!$conn) {
        die("<script>alert('Database connection failed');</script>");
    }

    $name = trim($_POST['name']);
    $surname = trim($_POST['surname']);


    $sql = "SELECT * FROM advanced_programming WHERE stu_name = ? AND stu_surname = ?";
    $stmt = $conn->prepare($sql);


    $stmt->bind_param("ss", $name, $surname);


    $stmt->execute();
    $result = $stmt->get_result();


    if ($result->num_rows > 0) {

        echo "<script>window.location.href = 'studentDashboard.php?name=" . urlencode($name) . "&surname=" . urlencode($surname) . "';</script>";
    } else {

        echo "<script>alert('Student not found');</script>";
    }



    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
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
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f3f4f6;
            background-image: url('20_Istanbul-Aydin-University_Campus.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .login-container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .login-container h1 {
            margin-bottom: 20px;
            font-size: 24px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-group button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        .form-group button:hover {
            background-color: #0056b3;
        }

        .button-container {
            margin-top: 20px;
            text-align: center;
        }

        .button-container a {
            display: inline-block;
            padding: 10px 20px;
            color: white;
            background-color: #6c757d;
            text-decoration: none;
            border-radius: 5px;
            margin: 5px;
        }

        .button-container a:hover {
            background-color: #5a6268;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h1>Student Login</h1>
        <form method="POST">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="surname">Surname</label>
                <input type="text" id="surname" name="surname" required>
            </div>
            <div class="form-group">
                <button type="submit">Login</button>
            </div>
        </form>
        <div class="button-container">
            <a href="adminLogin.php">Admin Login</a>
            <a href="lecturerLogin.php">Lecturer Login</a>
        </div>
    </div>
</body>

</html>