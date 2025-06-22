<?php
// Admin kullanıcı adı ve şifre
$correct_username = 'admin';
$correct_password = 'admin123';

// Başarılı giriş kontrolü
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === $correct_username && $password === $correct_password) {
        // Başarılı giriş
        header("Location: landing.php");
        exit();
    } else {
        $error = "Invalid username or password!";
       echo $error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
    
/* Mobile Styles */
@media (max-width: 600px) {
    .login-container {
        padding: 15px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .login-container h1 {
        font-size: 20px;
    }

    .form-group input, .form-group button {
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
            background-color: #343a40;
            color: #fff;
        }
        .login-container {
            background: #495057;
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
            color: #ddd;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #6c757d;
            border-radius: 5px;
            background-color: #6c757d;
            color: white;
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
        .back-button {
            margin-top: 10px;
            text-align: center;
        }
        .back-button a {
            color: white;
            text-decoration: none;
        }
        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Admin Login</h1>
        <!-- Eğer yanlış giriş yapılırsa hata mesajı göster -->
        <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        <form action="adminLogin.php" method="POST">
            <div class="form-group">
                <label for="admin-username">Admin Username</label>
                <input type="text" id="admin-username" name="username" required>
            </div>
            <div class="form-group">
                <label for="admin-password">Password</label>
                <input type="password" id="admin-password" name="password" required>
            </div>
            <div class="form-group">
                <button type="submit">Login</button>
            </div>
        </form>
        <div class="back-button">
            <a href="index.php">Back to Login Page</a>
        </div>
    </div>
</body>
</html>