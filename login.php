<?php
include 'config.php';
session_start();

$message = [];

if (isset($_POST['submit'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email)) {
        $message[] = "Email cannot be empty.";
    } elseif (empty($password)) {
        $message[] = "Password cannot be empty.";
    } elseif (strlen($password) < 4) {
        $message[] = "Password must be at least 4 characters.";
    } else {
        $emailsafe = mysqli_real_escape_string($conn, $email);
        $passwordsafe = mysqli_real_escape_string($conn, md5($password));

        $select_users = mysqli_query($conn, "SELECT * FROM register WHERE email='$emailsafe' AND password='$passwordsafe'") or die('query failed');

        if (mysqli_num_rows($select_users) > 0) {
            $row = mysqli_fetch_assoc($select_users);

            if ($row['user_type'] == 'admin') {
                $_SESSION['admin_name'] = $row['name'];
                $_SESSION['admin_email'] = $row['email'];
                $_SESSION['admin_id'] = $row['id'];
                header('location:admin_page.php');
            } 
            elseif ($row['user_type'] == 'user') {
                $_SESSION['user_name'] = $row['name'];
                $_SESSION['user_email'] = $row['email'];
                $_SESSION['user_id'] = $row['id'];
                header('location:index.php');
            }
        } else {
            $message[] = 'Incorrect email or password.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Animated Login</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            font-family: 'Times New Roman', serif;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(270deg,rgb(36, 27, 60),rgb(12, 251, 235),rgb(14, 139, 146),rgb(33, 23, 61));
            background-size: 800% 800%;
            animation: gradientShift 12s ease infinite;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .login_box {
            background: rgba(255, 255, 255, 0.95);
            padding: 50px 40px;
            border-radius: 24px;
            box-shadow: 0 90px 50px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            animation: slideIn 1s ease forwards;
            opacity: 0;
            transform: translateY(30px);
        }

        @keyframes slideIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login_box h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
            font-size: 28px;
            animation: fadeIn 1.2s ease forwards;
        }

        .inputbox {
            position: relative;
            margin-bottom: 25px;
        }

        .inputbox input {
            width: 100%;
            padding: 14px 12px;
            border: 2px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            transition: 0.3s;
            background: transparent;
        }

        .inputbox input:focus {
            border-color: #2575fc;
            box-shadow: 0 0 8px rgba(37, 117, 252, 0.4);
        }

        .inputbox span {
            position: absolute;
            top: 12px;
            left: 14px;
            padding: 0 5px;
            background: white;
            color: #777;
            font-size: 14px;
            transition: 0.3s ease;
            pointer-events: none;
        }

        .inputbox input:focus + span,
        .inputbox input:not(:placeholder-shown) + span {
            top: -10px;
            font-size: 12px;
            color: #2575fc;
        }

        .links {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .links a {
            color: #2575fc;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .links a:hover {
            color: #1a5edb;
            text-decoration: underline;
        }

        input[type="submit"] {
            width: 100%;
            background: #2575fc;
            border: none;
            padding: 14px;
            border-radius: 8px;
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        input[type="submit"]:hover {
            background: #1a5edb;
            transform: scale(1.03);
        }

        .message {
            background: #ffebee;
            color: #c62828;
            padding: 10px 15px;
            border-left: 4px solid #c62828;
            border-radius: 6px;
            margin-bottom: 15px;
            position: relative;
            animation: bounceIn 0.5s ease;
        }

        @keyframes bounceIn {
            0% { transform: scale(0.9); opacity: 0; }
            60% { transform: scale(1.05); opacity: 1; }
            100% { transform: scale(1); }
        }

        .message i {
            position: absolute;
            top: 10px;
            right: 12px;
            cursor: pointer;
        }

        @media (max-width: 480px) {
            .login_box {
                padding: 30px 20px;
            }
        }
    </style>
    <script src="https://kit.fontawesome.com/eedbcd0c96.js" crossorigin="anonymous"></script>
</head>
<body>

<?php
if (!empty($message)) {
    foreach ($message as $msg) {
        echo '
        <div class="message">
            <span>'.$msg.'</span>
            <i class="fa-solid fa-xmark" onclick="this.parentElement.remove();"></i>
        </div>
        ';
    }
}
?>

<div class="login_box">
    <form action="" method="post">
        <h2>Login</h2>
        <div class="inputbox">
            <input type="email" name="email" >
            <span>Email</span>
        </div>
        <div class="inputbox">
            <input type="password" name="password" >
            <span>Password</span>
        </div>
        <div class="links">
            <a href="#">Forgot Password</a>
            <a href="register.php">Sign Up</a>
        </div>
        <input type="submit" name="submit" value="Login">
    </form>
</div>

</body>
</html>
