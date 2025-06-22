<?php
$conn = mysqli_connect("localhost", "root", "", "school");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

session_start();
$teacher_id = $_SESSION['teacher_id'];

$sql = "SELECT course_name FROM teacher_courses WHERE teacher_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$course_result = $stmt->get_result();

if ($course_result->num_rows > 0) {
    $course_row = $course_result->fetch_assoc();
    $course = $course_row['course_name'];
} else {
    die("No courses found for the lecturer.");
}

$stu_id = '';
if (isset($_GET['id'])) {
    $stu_id = $_GET['id'];
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($stu_id)) {
    $sql = "SELECT * FROM $course WHERE stu_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $stu_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
    } else {
        echo "No student found.";
        $student = null;
    }

    $attendance_table = $course . "_attendance";
    $attendance_sql = "SELECT week_no FROM $attendance_table WHERE stu_id = ?";
    $attendance_stmt = $conn->prepare($attendance_sql);
    $attendance_stmt->bind_param("i", $stu_id);
    $attendance_stmt->execute();
    $attendance_result = $attendance_stmt->get_result();

    $attendance_weeks = [];
    while ($attendance_row = $attendance_result->fetch_assoc()) {
        $attendance_weeks[] = $attendance_row['week_no'];
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['stu_id']) && isset($_POST['course'])) {
    $stu_id = $_POST['stu_id'];
    $stu_name = $_POST['stu_name'];
    $stu_surname = $_POST['stu_surname'];
    $stu_mid = $_POST['stu_mid'];
    $stu_final = $_POST['stu_final'];
    $course = $_POST['course'];

    $attendance_weeks = [];
    for ($i = 1; $i <= 15; $i++) {
        if (isset($_POST['attendance_' . $i])) {
            $attendance_weeks[] = $i;
        }
    }

    $sql = "UPDATE $course SET stu_name = ?, stu_surname = ?, stu_mid = ?, stu_final = ? WHERE stu_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssddi", $stu_name, $stu_surname, $stu_mid, $stu_final, $stu_id);
    $stmt->execute();

    $attendance_table = $course . "_attendance";
    $delete_sql = "DELETE FROM $attendance_table WHERE stu_id = ?";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bind_param("i", $stu_id);
    $delete_stmt->execute();

    $insert_sql = "INSERT INTO $attendance_table (stu_id, week_no) VALUES (?, ?)";
    $insert_stmt = $conn->prepare($insert_sql);
    foreach ($attendance_weeks as $week) {
        $insert_stmt->bind_param("ii", $stu_id, $week);
        $insert_stmt->execute();
    }

    echo "The student is updated successfully.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Student</title>
    <style>
        @media (max-width: 600px) {

            .form-container input,
            .form-container button {
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
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }

        h1,
        h2 {
            color: #333;
            text-align: center;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        input,
        button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }

        .back-button {
            width: auto;
            background-color: #f44336;
            margin: 20px 0;
            font-size: 16px;
        }

        .back-button:hover {
            background-color: #e53935;
        }

        .form-container {
            margin-bottom: 20px;
        }

        .form-container input {
            width: 80%;
        }

        .form-container button {
            width: 18%;
            background-color: #2196F3;
            font-size: 16px;
            padding: 12px 20px;
            text-align: center;
            border-radius: 5px;
        }

        .form-container button:hover {
            background-color: #1976D2;
        }

        .attendance-container {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 10px;
        }

        .attendance-container label {
            margin-right: 10px;
            font-size: 14px;
        }
    </style>
</head>

<body>

    <div class="container">

        <a href="landing.php">
            <button class="back-button">Back</button>
        </a>


        <div class="form-container">
            <h2>Search by Student ID</h2>
            <form action="editStudent.php" method="GET">
                <label for="stu_id">Student ID:</label>
                <input type="number" name="id" id="stu_id" required>
                <button type="submit">Bring the Student</button>
            </form>
        </div>


        <?php if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($student)): ?>
            <div class="form-container">
                <h1>Update Student Information</h1>
                <form action="editStudent.php" method="POST">
                    <input type="hidden" name="stu_id" value="<?php echo $student['stu_id']; ?>">
                    <input type="hidden" name="course" value="<?php echo $course; ?>">

                    <label for="stu_name">Name:</label>
                    <input type="text" name="stu_name" id="stu_name" value="<?php echo $student['stu_name']; ?>" required>

                    <label for="stu_surname">Surname:</label>
                    <input type="text" name="stu_surname" id="stu_surname" value="<?php echo $student['stu_surname']; ?>"
                        required>

                    <label for="stu_mid">Midterm:</label>
                    <input type="number" name="stu_mid" id="stu_mid" value="<?php echo $student['stu_mid']; ?>" required>

                    <label for="stu_final">Final:</label>
                    <input type="number" name="stu_final" id="stu_final" value="<?php echo $student['stu_final']; ?>"
                        required>

                    <div class="attendance-container">
                        <?php

                        for ($i = 1; $i <= 15; $i++) {

                            $checked = in_array($i, $attendance_weeks) ? 'checked' : '';
                            echo "<label><input type='checkbox' name='attendance_$i' $checked> Week $i</label>";
                        }
                        ?>
                    </div>

                    <button type="submit">Update Student</button>
                </form>
            </div>
        <?php endif; ?>
    </div>

</body>

</html>