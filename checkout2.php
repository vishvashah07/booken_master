<?php
include 'config.php';
session_start();

$user_id=$_SESSION['user_id'];

if(!isset($user_id)){
  header('location:login.php');
}

if(isset($_POST['order_btn'])){
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $number = $_POST['number'];
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $method = mysqli_real_escape_string($conn, $_POST['method']);
  $address = mysqli_real_escape_string($conn, $_POST['address']);
  $placed_on = date('d-M-Y');

  $cart_total = 0;
  $cart_products[] = '';

  $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
   if(mysqli_num_rows($cart_query) > 0){
      while($cart_item = mysqli_fetch_assoc($cart_query)){
         $cart_products[] = $cart_item['name'].' ('.$cart_item['quantity'].') ';
         $sub_total = ($cart_item['price'] * $cart_item['quantity']);
         $cart_total += $sub_total;
      }
   }

   $total_products = implode(' ',$cart_products);

   $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE name = '$name' AND number = '$number' AND email = '$email' AND method = '$method' AND address = '$address' AND total_products = '$total_products' AND total_price = '$cart_total'") or die('query failed');

   if($cart_total == 0){
      $message[] = 'your cart is empty';
   }else{
      if(mysqli_num_rows($order_query) > 0){
         $message[] = 'order already placed!'; 
      }else{
         mysqli_query($conn, "INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on) VALUES('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$cart_total', '$placed_on')") or die('query failed');
         $message[] = 'order placed successfully!';
         mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
      }
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <style>
.display_order{
 
  display: flex;
  flex-direction: column;
  gap: 1rem;
  justify-content: center;
  align-items: center;
}
.display_order h2{
  color: #C1121F;
  margin-top: 1rem;
}

.single_order_product{
   background-color:white;
  width: 50%;
  height: 120px;
  display: flex;
  margin-bottom: 1rem;
  padding: 1rem;
  box-shadow: 2px 2px 10px gray;
  gap: 1rem;
  align-items: center;
}

.single_order_product img{
  width: 10%;
  height: 100%;
}

.single_order_product .single_des h3{
  color: #003049;
}

.single_order_product .single_des p{
  color: rgb(65, 65, 65);
}
.single_order_product .single_des p:nth-child(odd){
  color: black;
}
.checkout_grand_total{
  font-size: 1.5rem;
  color:rgb(246, 241, 242);
  font-weight: 900;
  letter-spacing: 1px;
}

.contact_us{
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  margin: 2rem;
}
.contact_us form{
  background-color:white;
  width: 60%;
  display: flex;
  flex-direction: column;
  gap: 1rem;
  padding: 2rem;
  box-shadow: 2px 2px 20px gray;
  justify-content: center;
  align-items: center;
}

.contact_us form h2{
  font-size: 1.5rem;
  color: #003049;
  text-align: center;

}
.contact_us form input,
.contact_us form textarea,
.contact_us form select{
  width: 80%;
  padding: 0.2rem;
  font-size: 1rem;
  box-shadow: 2px 2px 10px gray;
  border: none;
  color:black;
}
.contact_us form input:focus,
.contact_us form textarea:focus,
.contact_us form select:focus{
  outline: none;
}




  </style>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout Page</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- <link rel="stylesheet" href="style.css"> <link rel="stylesheet" href="home.css"> -->

</head>
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
<!-- //header end -->









<?php
// include 'user_header.php';
?>

<section class="display_order">
  <h2>Ordered Products</h2>
  <?php
    $grand_total=0;
    $select_cart=mysqli_query($conn,"SELECT * FROM `cart` WHERE user_id='$user_id'") or die('query failed');

    if(mysqli_num_rows($select_cart)>0){
      while($fetch_cart=mysqli_fetch_assoc($select_cart)){
        $total_price=($fetch_cart['price'] * $fetch_cart['quantity']);
        $grand_total+=$total_price;
      
  ?>
  <div class="single_order_product">
    <img src="./assets/images/<?php echo$fetch_cart['image'];?>" alt="">
    <div class="single_des">
    <h3><?php echo $fetch_cart['name'];?></h3>
    <p>Rs. <?php echo $fetch_cart['price'];?></p>
    <p>Quantity : <?php echo $fetch_cart['quantity'];?></p>
    </div>

  </div>
  

  <?php
  }
}else{
  echo '<p class="empty">your cart is empty</p>';
}
  ?>
  <div class="checkout_grand_total"> GRAND TOTAL : <span>RS<?php echo $grand_total; ?>/-</span> </div>
</section>
<section class="contact_us">

<form action="" method="post">
   <h2>Add Your Details</h2>
   <input type="text" name="name" required placeholder="Enter your name" >

   <input type="phone" name="number" required placeholder="Enter your number">

   <input type="email" name="email" required placeholder="Enter your email">

   <select name="method" id="">
    <option value="cash on delivery">cash on delivery</option>
    <option value="gpay">gpay</option>
   </select>
  
   <textarea name="address" placeholder="Enter your address" id="" cols="30" rows="10"></textarea>
   <br>
   <input type="submit" value="Place Your Order" name="order_btn" class="product_btn">
</form>
</section><br><br>



















<?php
include 'footer.php';
?>
<script src="https://kit.fontawesome.com/eedbcd0c96.js" crossorigin="anonymous"></script>

<script src="script.js"></script>

</body>
</html>

















