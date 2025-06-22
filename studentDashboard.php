<?php

if (isset($_GET['name']) && isset($_GET['surname'])) {
    $name = $_GET['name'];
    $surname = $_GET['surname'];
    $conn = mysqli_connect("localhost", "root", "", "school");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $courses = ['web_programming', 'advanced_programming', 'machine_learning'];
    $studentData = [];

    foreach ($courses as $course) {

        $sql = "SELECT * FROM $course WHERE stu_name = ? AND stu_surname = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $name, $surname);
        $stmt->execute();
        $result = $stmt->get_result();


        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();


            $grade = $data['stu_mid'] * 0.4 + $data['stu_final'] * 0.6;


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


            $update_sql = "UPDATE $course SET stu_grade = ?, stu_grade_letter = ? WHERE stu_name = ? AND stu_surname = ?";
            $stmt_update = $conn->prepare($update_sql);
            $stmt_update->bind_param("dsss", $grade, $grade_letter, $name, $surname);
            $stmt_update->execute();


            $data['stu_grade'] = $grade;
            $data['stu_grade_letter'] = $grade_letter;
            $studentData[$course] = $data;

            $stmt_update->close();
        } else {
            $studentData[$course] = null;
        }

        $stmt->close();
    }


    $conn->close();
} else {
    echo "<script>alert('No student data received');</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
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
        }

        .dashboard-container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 900px;
        }

        .dashboard-container h1 {
            margin-bottom: 20px;
            font-size: 24px;
            text-align: center;
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
            background-color: #007bff;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tr:hover {
            background-color: #ddd;
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
            border: none;
            cursor: pointer;
        }

        .button-container a:hover {
            background-color: #5a6268;
        }
    </style>
</head>

<body>
    <div class="dashboard-container">
        <h1>Welcome, <?php echo htmlspecialchars($name) . ' ' . htmlspecialchars($surname); ?></h1>


        <table>
            <thead>
                <tr>
                    <th>Course</th>
                    <th>Midterm</th>
                    <th>Final</th>
                    <th>Grade</th>
                    <th>Grade Letter</th>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($studentData as $course => $data): ?>
                    <tr>
                        <td><?php echo ucfirst(str_replace('_', ' ', $course)); ?></td>
                        <?php if ($data): ?>
                            <td><?php echo htmlspecialchars($data['stu_mid']); ?></td>
                            <td><?php echo htmlspecialchars($data['stu_final']); ?></td>
                            <td><?php echo htmlspecialchars($data['stu_grade']); ?></td>
                            <td><?php echo htmlspecialchars($data['stu_grade_letter']); ?></td>
                            <!-- <td><?php echo htmlspecialchars($data['absent_days']); ?></td> -->

                        <?php else: ?>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="button-container">
            <a href="javascript:history.back()">Back</a>
        </div>

    </div>
</body>

</html>