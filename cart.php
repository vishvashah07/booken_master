<?php
include 'config.php';
session_start();

$user_id=$_SESSION['user_id'];

if(!isset($user_id)){
  header('location:login.php');
}

if(isset($_POST['update_cart'])){
  $cart_id=$_POST['cart_id'];
  $cart_quantity=$_POST['cart_quantity'];
  mysqli_query($conn,"UPDATE `cart` SET quantity='$cart_quantity' WHERE id='$cart_id'") or die('query failed');
  $message[]='Cart Quantity Updated';
}

if(isset($_GET['delete'])){
  $delete_id=$_GET['delete'];
  mysqli_query($conn,"DELETE FROM `cart` WHERE id='$delete_id'") or die('query failed');
  header('location:cart.php');
}

if(isset($_GET['delete_all'])){
  mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
  header('location:cart.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cart Page</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="home.css">

<style>
     <link rel="stylesheet" href="./assets/css/style.css">
  /* Global Styles */
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
    color: #333;
    min-height: 100vh;
  }

  .shopping_cart {
    max-width: 1200px;
    max-height:900px;
    margin: 60px auto;
    padding: 30px;
    border-radius: 20px;
    background: rgba(255, 255, 255, 0.7);
    backdrop-filter: blur(20px);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
  }

  .shopping_cart h1 {
    text-align: center;
    font-size: 38px;
    font-weight: 700;
    margin-bottom: 40px;
    color: #2c3e50;
  }

  .cart_box_cont {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 25px;
  }

  .cart_box {
    background: rgba(255, 255, 255, 0.9);
    border-radius: 15px;
    padding: 20px;
    text-align: center;
    position: relative;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s ease-in-out;
  }

  .cart_box:hover {
    transform: translateY(-5px);
  }

  .cart_box img {
    width: 100%;
    height: 200px;
    object-fit: contain;
    margin-bottom: 15px;
    border-radius: 10px;
  }

  .cart_box h3 {
    font-size: 22px;
    font-weight: 600;
    margin-bottom: 10px;
    color: #34495e;
  }

  .cart_box p {
    font-size: 16px;
    color: #555;
    margin: 6px 0;
  }

  .cart_box form {
    margin-top: 10px;
  }

  .cart_box input[type="number"] {
    width: 70px;
    padding: 8px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 15px;
    color:black;
    margin-right: 10px;
  }

  .product_btn {
    padding: 10px 16px;
    background: linear-gradient(135deg, #00c6ff, #0072ff);
    color: #fff;
    border: none;
    border-radius: 30px;
    cursor: pointer;
    font-size: 15px;
    transition: 0.3s ease;
    text-decoration: none;
    display: inline-block;
    margin-top: 10px;
  }

  .product_btn:hover {
    background: linear-gradient(135deg, #0072ff, #00c6ff);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
  }

  .product_btn.disabled {
    background: #ccc;
    pointer-events: none;
    box-shadow: none;
  }

  .fas.fa-times {
    position: absolute;
    top: 15px;
    right: 20px;
    color: #e74c3c;
    font-size: 18px;
    cursor: pointer;
    transition: 0.3s;
  }

  .fas.fa-times:hover {
    transform: scale(1.2);
  }

  .cart_total {
    margin-top: 50px;
    padding-top: 30px;
    border-top: 1px solid #ccc;
    text-align: center;
  }

  .cart_total h2 {
    font-size: 26px;
    color: #2c3e50;
    margin-bottom: 20px;
  }

  .btns_cart {
    display: flex;
    justify-content: center;
    gap: 20px;
    flex-wrap: wrap;
  }

  .empty {
    text-align: center;
    font-size: 22px;
    font-weight: 500;
    color: #888;
    grid-column: 1 / -1;
    margin-top: 20px;
  }

  @media (max-width: 600px) {
    .cart_box_cont {
      grid-template-columns: 1fr;
    }

    .cart_box input[type="number"] {
      width: 100%;
      color:black;
      /* height: 100%; */
      margin: 10px 0;
    }

    .product_btn {
      width: 100%;
    }
  }
</style>

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













<?php
?>

<section class="shopping_cart">
  <h1>Products Added</h1>

  <div class="cart_box_cont">
    <?php
    $grand_total=0;
    $select_cart=mysqli_query($conn, "SELECT * FROM `cart` where user_id='$user_id'") or die('query failed');

    if(mysqli_num_rows($select_cart)>0){
      while($fetch_cart=mysqli_fetch_assoc(($select_cart))){


    ?>
    <div class="cart_box">
      <a href="cart.php?delete=<?php echo $fetch_cart['id'];?>" class="fas fa-times" onclick="return confirm('Are you sure you want to delete this product from cart');"></a>
      <img src="./assets/images/<?php echo $fetch_cart['image'];?>" alt="">
      <h3><?php echo $fetch_cart['name']; ?></h3>
      <p>Rs. <?php echo $fetch_cart['price']; ?>/-</p>

      <form action="" method="post">
        <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id'];?>">
        <input type="number" name="cart_quantity" min="1" value="<?php echo $fetch_cart['quantity'];?>">
        <input type="submit" value="Update" name="update_cart" class="product_btn">
      </form>
      <p>Total : <span>$<?php echo $sub_total = ($fetch_cart['quantity'] * $fetch_cart['price']); ?>/-</span></p>
    </div>
    <?php
    $grand_total+=$sub_total;
      }
    }else{
      echo '<p class="empty">Your Cart is Empty!</p>';
    }
    ?>
  </div>

  <div class="cart_total">
    <h2>Total Cart Price : <span>$ <?php echo $grand_total;?>/-</span></h2>
    <div class="btns_cart">
    <a href="cart.php?delete_all" class="product_btn <?php echo ($grand_total > 1)?'':'disabled'; ?>" onclick="return confirm('Are you sure you want to delete all cart items from cart?');">Delete All</a>
      <a href="shop1.php" class="product_btn">Continue Shopping</a>
      <a href="checkout.php" class="product_btn <?php echo ($grand_total > 1)?'':'disabled'; ?>">Checkout</a>
    </div>
  </div>
    
</section>

<?php
include 'footer.php';
?>
<script src="https://kit.fontawesome.com/eedbcd0c96.js" crossorigin="anonymous"></script>

<script src="script.js"></script>

</body>
</html>