<?php
include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
  header('location:login.php');
}

if (isset($_POST['order_btn'])) {
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $number = $_POST['number'];
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $method = $_POST['method'];
  $address = mysqli_real_escape_string($conn, $_POST['address']);

  $placed_on = date('d-M-Y');

  $cart_total = 0;
  $cart_products = [];

  $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'");
  if (mysqli_num_rows($cart_query) > 0) {
    while ($cart_item = mysqli_fetch_assoc($cart_query)) {
      $cart_products[] = $cart_item['name'] . ' (' . $cart_item['quantity'] . ')';
      $sub_total = ($cart_item['price'] * $cart_item['quantity']);
      $cart_total += $sub_total;
    }
  }

  $total_products = implode(', ', $cart_products);

  $payment_ss = '';
  if ($method === 'gpay') {
    $payment_ss = $_FILES['payment_ss']['name'];
    $payment_ss_tmp = $_FILES['payment_ss']['tmp_name'];
   if( move_uploaded_file($payment_ss_tmp, 'assets/images/' . $payment_ss))$payment_status='done';
  }

  mysqli_query($conn, "INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on, payment_status,payment_ss) 
  VALUES('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$cart_total', '$placed_on','$payment_status','$payment_ss')") or die('query failed');

  mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'");

  echo "<script>alert('Order placed successfully!'); window.location.href='orders.php';</script>";
}
?>


<style>
/* Only middle section styles */
.checkout_order_display {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  justify-content: center;
  align-items: center;
}
.checkout_order_display h2 {
  color: #C1121F;
  margin-top: 1rem;
}
.checkout_order_product {
  background-color: white;
  width: 50%;
  height: 120px;
  display: flex;
  margin-bottom: 1rem;
  padding: 1rem;
  box-shadow: 2px 2px 10px gray;
  gap: 1rem;
  align-items: center;
}
.checkout_order_product img {
  width: 10%;
  height: 100%;
}
.checkout_order_product .single_des h3 {
  color: #003049;
}
.checkout_order_product .single_des p {
  color: rgb(65, 65, 65);
}
.checkout_order_product .single_des p:nth-child(odd) {
  color: black;
}
.checkout_total_display {
  font-size: 1.5rem;
  color: rgb(246, 241, 242);
  font-weight: 900;
  letter-spacing: 1px;
}
/* .checkout_user_form {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  margin: 2rem;
}
.checkout_user_form form {
  background-color: white;
  width: 60%;
  display: flex;
  flex-direction: column;
  gap: 1rem;
  padding: 2rem;
  box-shadow: 2px 2px 20px gray;
  justify-content: center;
  align-items: center;
}
.checkout_user_form form h2 {
  font-size: 1.5rem;
  color: #003049;
  text-align: center;
}
.checkout_user_form form input,
.checkout_user_form form textarea,
.checkout_user_form form select {
  width: 80%;
  padding: 0.2rem;
  font-size: 1rem;
  box-shadow: 2px 2px 10px gray;
  border: none;
  color: black;
}
.checkout_user_form form input:focus,
.checkout_user_form form textarea:focus,
.checkout_user_form form select:focus {
  outline: none;
}
#checkout_gpay_section {
  display: none;
  background-color:rgb(14, 5, 62);
  padding: 1rem;
  border-radius: 8px;
  width: 80%;
  box-shadow: 2px 2px 10px gray;
}
#checkout_gpay_section p {
color:white;
  font-weight: bold;
  margin-bottom: 0.5rem;
} */

 .checkout_user_form {
  display: flex;
  justify-content: center;
  align-items: center;
  margin: 3rem auto;
  padding: 2rem;
  max-width: 1000px;
}

.checkout_user_form form {
  background-color: #ffffff;
  width: 100%;
  max-width: 600px;
  padding: 2.5rem;
  border-radius: 12px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
  display: flex;
  flex-direction: column;
  gap: 1.2rem;
}

.checkout_user_form form h2 {
  font-size: 1.8rem;
  color: #003049;
  text-align: center;
  margin-bottom: 1rem;
}

.checkout_user_form form input,
.checkout_user_form form textarea,
.checkout_user_form form select {
color:black;
  width: 100%;
  padding: 0.75rem 1rem;
  font-size: 1rem;
  border: 1px solid #ccc;
  border-radius: 8px;
  transition: all 0.2s ease-in-out;
  background-color: #f9f9f9;
}

.checkout_user_form form input:focus,
.checkout_user_form form textarea:focus,
.checkout_user_form form select:focus {
  outline: none;
  border-color: #003049;
  background-color: #fff;
  box-shadow: 0 0 0 2px rgba(0, 48, 73, 0.2);
}

.checkout_user_form form textarea {
  resize: vertical;
  min-height: 100px;
}

.checkout_user_form form .product_btn {
  background-color: #003049;
  color: white;
  padding: 0.75rem;
  border: none;
  font-size: 1rem;
  border-radius: 8px;
  cursor: pointer;
  transition: background-color 0.3s ease-in-out;
}

.checkout_user_form form .product_btn:hover {
  background-color: #005f73;
}

#checkout_gpay_section {
  color:black;
  display: none;
  background-color: #f1faff;
  border: 1px solid #cce5ff;
  padding: 1rem;
  border-radius: 8px;
  box-shadow: 0 0 5px rgba(0, 112, 243, 0.2);
}

#checkout_gpay_section p {
  color:black;
  font-weight: bold;
  margin-bottom: 0.5rem;
}

#checkout_gpay_section input[type="file"] {
  color:black;
  border: none;
  padding: 0.25rem;
  background-color: transparent;
}

</style>
<body>
    
    <header class="header" data-header>
    <div class="header-top">
      <div class="container">

        <a href="#" class="logo">
          <img src="./assets/images/logo.svg" width="138" height="28" alt="booken home">
        </a>

        <div class="input-wrapper">
          <input type="search" name="search" placeholder="Search our store" class="input-field">

          <button class="btn btn-primary">Search</button>
        </div>

        <div class="header-action">
          <a href="cart.php">CART</a>
          <button class="header-action-btn" aria-label="cart" title="Cart" >
            <span class="span">0</span>

            <ion-icon name="bag-handle-outline" aria-hidden="true"></ion-icon>
          </button>

          <!-- <button class="nav-open-btn" aria-label="open menu" title="Open Menu" data-nav-toggler>
            <ion-icon name="menu-outline" aria-hidden="true"></ion-icon>
          </button> -->

          <button class="header-action-btn" aria-label="user" title="User">   
            <button class="menu-btn" onclick="togglePopup()">=<ion-icon name="person-outline" aria-hidden="true"></ion-icon></button>
            <div class="popup-menu" id="popupMenu">
              <button onclick="confirmLogout()">Logout</button>
             </div>
            
          </button>

        </div>

      </div>
    </div>

    <div class="header-bottom" data-navbar>
      <div class="container">

        <nav class="navbar">

          <button class="nav-close-btn" data-nav-toggler aria-label="clsoe menu" title="Clsoe Menu">
            <ion-icon name="close-outline" aria-hidden="true"></ion-icon>
          </button>

          <div class="navbar-top">
            <input type="search" name="search" placeholder="Search our store" class="input-field">

            <button class="search-btn" aria-label="Search">
              <ion-icon name="search-outline" aria-hidden="true"></ion-icon>
            </button>
          </div>

          <ul class="navbar-list">

            <li>
              <a href="index.php" class="navbar-link">Home</a>
            </li>

           

            <li>
              <a href="shop1.php" class="navbar-link">Shop</a>
            </li>

            <li>
              <a href="about.php" class="navbar-link">About Us</a>
            </li>

            <li>
              <a href="contact.php" class="navbar-link">Contact</a>
            </li>

          </ul>

        </nav>

        <a href="tel:+0123456789" class="header-contact-link">
          <ion-icon name="headset-outline" aria-hidden="true"></ion-icon>

          <span class="span">+91-886697756899</span>
        </a>

      </div>
    </div>

    <div class="overlay" data-overlay data-nav-toggler></div>
  </header>
  <main>
    <article>


<br><br><br><br><br>
</body>

<section class="checkout_order_display">
  <h2>Ordered Products</h2>
  <?php
    $grand_total = 0;
    $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id='$user_id'") or die('query failed');
    if (mysqli_num_rows($select_cart) > 0) {
      while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
        $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
        $grand_total += $total_price;
  ?>
  <div class="checkout_order_product">
    <img src="./assets/images/<?php echo $fetch_cart['image']; ?>" alt="">
    <div class="single_des">
      <h3><?php echo $fetch_cart['name']; ?></h3>
      <p>Rs. <?php echo $fetch_cart['price']; ?></p>
      <p>Quantity: <?php echo $fetch_cart['quantity']; ?></p>
    </div>
  </div>
  <?php }} else { echo '<p class="empty">Your cart is empty</p>'; } ?>
  <div class="checkout_total_display"> GRAND TOTAL : <span>Rs. <?php echo $grand_total; ?>/-</span> </div>
</section>

<section class="checkout_user_form">
  <form action="" method="post" enctype="multipart/form-data">
    <h2>Add Your Details</h2>
    <input type="text" name="name" required placeholder="Enter your name">
    <input type="phone" name="number" required placeholder="Enter your number">
    <input type="email" name="email" required placeholder="Enter your email">
    <select name="method" required>
      <option value="cash on delivery">Cash on Delivery</option>
      <option value="gpay">GPay</option>
    </select>
    <textarea name="address" placeholder="Enter your address" cols="30" rows="10" required></textarea>
    
    <div id="checkout_gpay_section">
      <p>Pay ₹<?php echo $grand_total; ?> to UPI ID: <strong>booken@upi</strong></p>
      <label>Upload Payment Screenshot:</label>
      <input type="file" name="payment_ss" accept="image/*" required>
    </div>

    <input type="submit" value="Place Your Order" name="order_btn" class="product_btn">
  </form>
</section>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const paymentMethod = document.querySelector('select[name="method"]');
    const gpaySection = document.getElementById('checkout_gpay_section');

    paymentMethod.addEventListener("change", function () {
      if (this.value === "gpay") {
        gpaySection.style.display = "block";
      } else {
        gpaySection.style.display = "none";
      }
    });
  });
</script>

<?php include 'footer.php'; 
if(isset($_POST['order_btn']))
{

// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

// Include PHPMailer files (adjust path as per your structure)
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

// Only send mail if order was placed successfully
if (mysqli_num_rows($order_query) == 0) {
    mysqli_query($conn, "INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on) 
    VALUES('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$cart_total', '$placed_on')") or die('query failed');

    mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');

    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';  // Use your SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'vishvashah1512@gmail.com'; // Your Gmail
        $mail->Password   = 'vishva';    // Gmail app password, NOT your normal password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        //Recipients
        $mail->setFrom('vishvashah1512@gmail.com', 'Online Bookstore');
        $mail->addAddress($email, $name);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Order Confirmation - Online Bookstore';
        $mail->Body    = "<h2>Thank you, $name!</h2>
                          <p>Your order has been placed successfully on <strong>$placed_on</strong>.</p>
                          <p><strong>Items Ordered:</strong><br>$total_products</p>
                          <p><strong>Total Amount:</strong> ₹$cart_total</p>
                          <p>We’ll process your order soon. Happy reading!</p>
                          <br><em>- Online Bookstore Team</em>";

        $mail->send();
        $message[] = 'Order placed & email sent!';
    } catch (Exception $e) {
        $message[] = 'Order placed but email could not be sent. Mailer Error: ' . $mail->ErrorInfo;
    }
}}
?>