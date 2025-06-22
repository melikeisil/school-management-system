<?php
$conn = mysqli_connect("localhost", "root", "", "school");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$student = null;
$error = null;
$advance_programming_name = null;


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search_id'])) {
    $stu_id = intval($_POST['search_id']);


    $sql = "SELECT * FROM advanced_programming WHERE stu_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $stu_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();


        $advance_sql = "SELECT stu_name FROM advanced_programming WHERE stu_id = ?";
        $advance_stmt = $conn->prepare($advance_sql);
        $advance_stmt->bind_param("i", $stu_id);
        $advance_stmt->execute();
        $advance_result = $advance_stmt->get_result();

        if ($advance_result->num_rows > 0) {
            $advance_programming_name = $advance_result->fetch_assoc()['stu_name'];
        }
    } else {
        $error = "No student found with ID: " . $stu_id;
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete'])) {
    $stu_id = intval($_POST['stu_id']);


    $tables_to_delete_from = [

        "students",
        "students_attendance",
        "web_programming",
        "web_programming_attendance",
        "machine_learning",
        "machine_learning_attendance",
        "advanced_programming",
        "advanced_programming_attendance"

    ];


    foreach ($tables_to_delete_from as $table) {
        $sql = "DELETE FROM $table WHERE stu_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $stu_id);
        if (!$stmt->execute()) {
            echo "Error deleting from $table: " . $conn->error;
            $stmt->close();
            $conn->close();
            exit;
        }
        $stmt->close();
    }

    header("Location: landing.php");
    exit;

}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Student</title>
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
            flex-direction: column;
            height: 100vh;
            margin: 0;
            background-color: #f8f9fa;
        }

        .delete-container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            text-align: center;
        }

        .delete-container h1 {
            font-size: 20px;
            margin-bottom: 20px;
        }

        .delete-container form {
            margin-top: 20px;
        }

        .delete-container input[type="text"] {
            width: 80%;
            padding: 8px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .delete-container button {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .delete-container .search-btn {
            background-color: #007bff;
            color: white;
        }

        .delete-container .delete-btn {
            background-color: #dc3545;
            color: white;
        }

        .delete-container .back-btn {
            background-color: #6c757d;
            color: white;
        }

        .delete-container button:hover {
            opacity: 0.9;
        }
    </style>
</head>

<body>
    <div class="delete-container">
        <h1>Delete Student</h1>

        <?php if (!$student && !$error): ?>
            <form method="POST">
                <label for="search_id">Enter Student ID:</label><br>
                <input type="text" id="search_id" name="search_id" required>
                <button type="submit" class="search-btn">Search</button>
            </form>
        <?php elseif ($error): ?>
            <p style="color: red;"><?php echo $error; ?></p>
            <form method="POST">
                <label for="search_id">Enter Student ID:</label><br>
                <input type="text" id="search_id" name="search_id" required>
                <button type="submit" class="search-btn">Search</button>
            </form>
        <?php elseif ($student): ?>
            <p><strong>ID:</strong> <?php echo $student['stu_id']; ?></p>
            <p><strong>Name:</strong> <?php echo $student['stu_name']; ?></p>
            <p><strong>Surname:</strong> <?php echo $student['stu_surname']; ?></p>
            <?php if ($advance_programming_name): ?>

            <?php endif; ?>
            <form method="POST">
                <input type="hidden" name="stu_id" value="<?php echo $student['stu_id']; ?>">
                <button type="submit" name="confirm_delete" class="delete-btn">Yes, Delete</button>
            </form>
        <?php endif; ?>

        <form action="landing.php" method="GET">
            <button type="submit" class="back-btn">Back to Landing</button>
        </form>
    </div>
</body>

</html>