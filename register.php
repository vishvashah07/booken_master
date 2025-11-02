<?php
include 'config.php';

$message = [];

if(isset($_POST['submit'])){

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));
    $cpassword = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
    $user_type = "user";

    $select_users = mysqli_query($conn, "SELECT * FROM register WHERE email='$email' AND password='$password'") or die('query failed');

    if (mysqli_num_rows($select_users) > 0) {
        $message[] = 'User already exists!';
    } else if (empty($name)) {

        $message[] = "Name is required!";
    } else if (empty($email)) {

        $message[] = "Email is required!";
    } 
    
    elseif(empty($password))
    {
        $message[]="password is required";
    }
       
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message[] = "Invalid email format!";
    } 
    else if ($_POST['password'] !== $_POST['cpassword']) {
        $message[] = 'Confirm password not matched!';
    } 
    else {
     mysqli_query($conn, "INSERT INTO register(name, email, password, user_type) VALUES('$name','$email','$cpassword','$user_type')") or die('query failed');
       $message[] = 'Registered Successfully!';
        header('location:login.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(to right,rgb(38, 15, 62), #2575fc,rgb(38, 15, 62));
            font-family: 'Times New Roman', serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login_box {
            background: #fff;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 40px 24px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 420px;
            animation: fadeIn 0.6s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .login_box h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }
        .inputbox {
            margin-bottom: 20px;
            position: relative;
        }
        .inputbox input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            outline: none;
            transition: border-color 0.3s;
            font-size: 15px;
        }
        .inputbox input:focus {
            border-color: #2575fc;
        }
        .inputbox span {
            position: absolute;
            top: -10px;
            left: 10px;
            background: white;
            font-size: 13px;
            color: #666;
            padding: 0 5px;
        }
        .links {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .links a {
            color: #2575fc;
            text-decoration: none;
            font-size: 14px;
        }
        .links a:hover {
            text-decoration: underline;
        }
        input[type="submit"] {
            width: 100%;
            background: #2575fc;
            border: none;
            padding: 12px;
            border-radius: 6px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }
        input[type="submit"]:hover {
            background: #1a5edb;
        }
        .message {
            background: #ffdddd;
            color: #d8000c;
            padding: 10px 15px;
            border-left: 4px solid #d8000c;
            border-radius: 6px;
            margin-bottom: 15px;
            position: relative;
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
        <h2>User Register</h2>

        <div class="inputbox">
            <input type="text" name="name">
            <span>Name</span>
        </div>

        <div class="inputbox">
            <input type="email" name="email">
            <span>Email</span>
        </div>

        <div class="inputbox">
            <input type="password" name="password">
            <span>Password</span>
        </div>

        <div class="inputbox">
            <input type="password" name="cpassword">
            <span>Confirm Password</span>
        </div>

        <div class="links">
            <a href="#">Forgot Password</a>
            <a href="login.php">Login</a>
        </div>

        <input type="submit" name="submit" value="Register Now">
    </form>
</div>

</body>
</html>
