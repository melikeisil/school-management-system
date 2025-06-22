<?php

$conn = mysqli_connect("localhost", "root", "", "school");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

session_start();
if (!isset($_SESSION["user"])) {
    header("Location: index.php");
    exit;
}

$logged_in_user = $_SESSION["user"];
$course = $logged_in_user["course"];


$students = [];
if ($course) {
    $sql = "SELECT * FROM $course ORDER BY stu_id ASC";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $grade = ($row['stu_mid'] * 0.4) + ($row['stu_final'] * 0.6);
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

            $row['stu_grade'] = $grade;
            $row['stu_grade_letter'] = $grade_letter;
            $students[] = $row;
        }
    } else {
        echo "No data found.";
    }
}


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["update_student"])) {
    $stu_id = $_POST["stu_id"];
    $stu_mid = (int) $_POST["stu_mid"];
    $stu_final = (int) $_POST["stu_final"];



    if ($stu_mid < 0 || $stu_mid > 100) {
        echo "<script>alert('The midterm grade must be between 0 and 100.');</script>";
    } elseif ($stu_final < 0 || $stu_final > 100) {
        echo "<script>alert('The final grade must be between 0 and 100.');</script>";
    } else {



        $update_sql = "UPDATE $course SET stu_mid = $stu_mid, stu_final = $stu_final WHERE stu_id = $stu_id";
        if (mysqli_query($conn, $update_sql) === TRUE) {

            echo "<script>alert('Student information has been updated successfully.');</script>";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {

            echo "<script>alert('Error " . mysqli_error($conn) . "');</script>";
        }
    }
}







mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecturer Panel</title>
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

            .button-container {
                text-align: center;
            }

            .button {
                display: inline-block;
                padding: 10px 20px;
                font-size: 16px;
                color: white;
                background-color: #4CAF50;
                text-decoration: none;
                border-radius: 5px;
                border: none;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }

            .button-container a {
                padding: 8px 15px;
                font-size: 14px;
            }
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 20px;
        }

        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 900px;
            margin: 0 auto;
        }

        h1 {
            color: #1976d2;
            text-align: center;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #1976d2;
            color: white;
        }

        td {
            background-color: #f9f9f9;
        }

        .button {
            padding: 10px 15px;
            background-color: #1976d2;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .button:hover {
            background-color: #1565c0;
        }

        .edit-form {
            margin-top: 30px;
            padding: 20px;
            background-color: #e3f2fd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .edit-form label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        .edit-form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .edit-form input[readonly] {
            background-color: #f1f1f1;
        }

        .back-button {
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 15px;
            cursor: pointer;
        }

        .back-button:hover {
            background-color: #d32f2f;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Students</h1>


        <?php if (!empty($students)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Surname</th>
                        <th>Midterm</th>
                        <th>Final</th>
                        <th>Calculated Grade</th>
                        <th>Grade Letter</th>

                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $student): ?>
                        <tr>
                            <td><?php echo $student['stu_id']; ?></td>
                            <td><?php echo $student['stu_name']; ?></td>
                            <td><?php echo $student['stu_surname']; ?></td>
                            <td><?php echo $student['stu_mid']; ?></td>
                            <td><?php echo $student['stu_final']; ?></td>
                            <td><?php echo number_format($student['stu_grade'], 2); ?></td>
                            <td><?php echo $student['stu_grade_letter']; ?></td>
                            <!--<td><?php echo $student['absent_days']; ?></td>-->

                            <td>
                                <button class="button"
                                    onclick="editStudent(<?php echo $student['stu_id']; ?>, '<?php echo $student['stu_name']; ?>', '<?php echo $student['stu_surname']; ?>', <?php echo $student['stu_mid']; ?>, <?php echo $student['stu_final']; ?>)">
                                    Edit
                                </button>


                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="button-container">
                <button class="button" onclick="window.location.href='lecturerLogin.php';">Log Out</button>
            </div>

        <?php else: ?>
            <p>No data found for this lecture.</p>
        <?php endif; ?>


        <div id="edit-form" class="edit-form" style="display: none;">
            <h3>Edit Student Information</h3>
            <form action="" method="POST">
                <input type="hidden" name="stu_id" id="stu_id">

                <label for="stu_name">Name:</label>
                <input type="text" id="stu_name" name="stu_name" readonly><br>

                <label for="stu_surname">Surname:</label>
                <input type="text" id="stu_surname" name="stu_surname" readonly><br>

                <label for="stu_mid">Midterm:</label>
                <input type="number" id="stu_mid" name="stu_mid" required><br>

                <label for="stu_final">Final:</label>
                <input type="number" id="stu_final" name="stu_final" required><br>




                <button type="submit" name="update_student" class="button">Update</button>
                <br>
                <br>

            </form>
            <button class="back-button" onclick="cancelEdit()">Back</button>
        </div>
    </div>

    <script>
        function editStudent(stu_id, stu_name, stu_surname, stu_mid, stu_final) {
            document.getElementById("stu_id").value = stu_id;
            document.getElementById("stu_name").value = stu_name;
            document.getElementById("stu_surname").value = stu_surname;
            document.getElementById("stu_mid").value = stu_mid;
            document.getElementById("stu_final").value = stu_final;
            document.getElementById("edit-form").style.display = "block";
        }

        function cancelEdit() {
            document.getElementById("edit-form").style.display = "none";
        }
    </script>
</body>

</html>