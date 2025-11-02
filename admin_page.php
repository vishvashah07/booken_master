<?php
include 'config.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            margin: 0;
            background-color: rgb(246, 249, 251);
        }

        header {
            background-color: rgb(18, 5, 48);
            color: white;
            padding: 20px;
            text-align: center;
            position: relative;
        }

        nav {
            background-color: rgb(27, 104, 108);
            display: flex;
            justify-content: flex-end;
            padding: 10px 20px;
        }

        nav a {
            color: white;
            text-decoration: none;
            background-color: #3498db;;
            padding: 10px 15px;
            border-radius: 5px;
            margin-left: 10px;
            transition: background 0.3s;
        }

        nav a:hover {
            background-color: rgb(255, 0, 0);
        }

        .dashboard {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            padding: 30px;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgb(249, 6, 6);
            text-align: center;
            transition: transform 0.2s;
        }

        .card:hover {
            transform: scale(1.03);
        }

        .card h3 {
            font-size: 24px;
            margin: 10px 0;
            color: rgb(91, 214, 73);
        }

        .card p {
            font-size: 16px;
            color: #718093;
        }

        header {
      background-color: #1f2d3d;
      color: white;
      padding: 20px;
      text-align: center;
    }
    
    </style>
</head>
<body>

<header>
    <h1>Welcome, Admin!!</h1>
</header>

<nav>
<a href="admin_page.php">Home</a>
    <a href="admin_products.php">Add Product</a>
    <a href="logout.php">Logout</a>
</nav>

<div class="dashboard">
    <div class="card">
        <?php
        $total_pendings = 0;
        $select_pending = mysqli_query($conn, "SELECT total_price FROM orders WHERE payment_status = 'pending'") or die('query failed');
        if(mysqli_num_rows($select_pending) > 0){
            while($fetch_pendings = mysqli_fetch_assoc($select_pending)){
                $total_price = $fetch_pendings['total_price'];
                $total_pendings += $total_price;
            };
        };
        ?>
        <h3>Rs. <?php echo $total_pendings; ?></h3>
        <p>Total Payments Pending:</p>
    </div>

    <div class="card">
        <?php
        $total_completed = 0;
        $selectcompleted = mysqli_query($conn, "SELECT total_price FROM orders WHERE payment_status = 'completed'") or die('query failed');
        if(mysqli_num_rows($selectcompleted) > 0){
            while($fetch_completed = mysqli_fetch_assoc($selectcompleted)){
                $total_price = $fetch_completed['total_price'];
                $total_completed += $total_price;
            };
        };
        ?>
        <h3>Rs. <?php echo $total_completed; ?></h3>
        <p>Completed Payments</p>
    </div>

    <div class="card">
        <?php
        $select_orders = mysqli_query($conn, "SELECT * FROM orders") or die('query failed');
        $number_of_orders = mysqli_num_rows($select_orders);
        ?>
        <h3><?php echo $number_of_orders; ?></h3>
        <p>Orders Placed</p>
    </div>

    <div class="card">
        <?php
        $select_products = mysqli_query($conn, "SELECT * FROM products") or die('query failed');
        $number_of_products = mysqli_num_rows($select_products);
        ?>
        <h3><?php echo $number_of_products; ?></h3>
        <p>Products Added</p>
    </div>

    <div class="card">
        <?php
        $select_users = mysqli_query($conn, "SELECT * FROM register WHERE user_type='user'") or die('query failed');
        $number_of_users = mysqli_num_rows($select_users);
        ?>
        <h3><?php echo $number_of_users; ?></h3>
        <p>Users Present</p>
    </div>

    <div class="card">
        <?php
        $select_admin = mysqli_query($conn, "SELECT * FROM register WHERE user_type='admin'") or die('query failed');
        $number_of_admin = mysqli_num_rows($select_admin);
        ?>
        <h3><?php echo $number_of_admin; ?></h3>
        <p>Admins Present</p>
    </div>

    <div class="card">
        <?php
        $select_accounts = mysqli_query($conn, "SELECT * FROM register") or die('query failed');
        $number_of_accounts = mysqli_num_rows($select_accounts);
        ?>
        <h3><?php echo $number_of_accounts; ?></h3>
        <p>Total Accounts</p>
    </div>

    <div class="card">
        <?php
        $select_messages = mysqli_query($conn, "SELECT * FROM message") or die('query failed');
        $number_of_messages = mysqli_num_rows($select_messages);
        ?>
        <h3><?php echo $number_of_messages; ?></h3>
        <p>New Messages</p>
    </div>
</div>

</body>
</html>
