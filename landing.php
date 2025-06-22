<?php
$conn = mysqli_connect("localhost", "root", "", "school");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$course = '';
if (isset($_POST['course'])) {
    $course = $_POST['course'];
}

$students = [];
if (!empty($course)) {

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


            $update_sql = "UPDATE $course SET stu_grade = ?, stu_grade_letter = ? WHERE stu_id = ?";
            $stmt = mysqli_prepare($conn, $update_sql);
            mysqli_stmt_bind_param($stmt, "dsi", $grade, $grade_letter, $row['stu_id']);
            mysqli_stmt_execute($stmt);

            $students[] = $row;
        }
    } else {
        echo "No data found.";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Selection and Data Extraction</title>
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
            background-color: #e3f2fd;
            margin: 0;
            padding: 20px;
        }

        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 0 auto;
        }

        h1,
        h2 {
            color: #1976d2;
            text-align: center;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        select,
        button {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }

        button {
            background-color: #1976d2;
            color: white;
            border: none;
        }

        button:hover {
            background-color: #1565c0;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        table th {
            background-color: #1976d2;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tr:hover {
            background-color: #ddd;
        }

        .button-container {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;

            margin-bottom: 20px;
        }

        .button-container a {
            flex: 1;
            margin: 5px;
        }

        .button-container button {
            width: 32%;
        }

        .button-container a button {
            padding: 12px 20px;
            width: auto;
            font-size: 14px;
        }

        @media (max-width: 768px) {

            table th,
            table td {
                padding: 8px;
                font-size: 14px;
            }

            .container {
                padding: 15px;
            }

            button,
            select {
                padding: 14px;
                font-size: 14px;
            }

            .button-container a {
                flex: 1 1 100%;
            }

            .button-container button {
                width: 100%;
                padding: 14px;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Course Selection</h1>
        <form action="" method="POST">
            <label for="course">Choose a course:</label>
            <select name="course" id="course" required>
                <option value="web_programming" <?php if ($course == 'web_programming')
                    echo 'selected'; ?>>Web
                    Programming</option>
                <option value="advanced_programming" <?php if ($course == 'advanced_programming')
                    echo 'selected'; ?>>
                    Advanced Programming</option>
                <option value="machine_learning" <?php if ($course == 'machine_learning')
                    echo 'selected'; ?>>Machine
                    Learning</option>
            </select>
            <button type="submit">Show Course Info</button>
        </form>


        <div class="button-container">
            <a href="create.php">
                <button>Add Student</button>
            </a>
            <a href="update.php">
                <button>Edit Student</button>
            </a>
            <a href="delete.php">
                <button>Delete Student</button>
            </a>
        </div>
        <div class="button-container">
            <a href="adminLogin.php">
                <button>Log Out</button>
            </a>
        </div>

        <?php if (!empty($course)): ?>
            <h2><?php echo ucfirst(str_replace('_', ' ', $course)); ?> - Öğrenciler</h2>
            <?php if (!empty($students)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Surname</th>
                            <th>Midterm Score</th>
                            <th>Final Score</th>
                            <th>Calculated Grade</th>
                            <th>Grade Letter</th>
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
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No data found for this course.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>

</body>

</html>