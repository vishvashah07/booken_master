<?php //emaillefttosend
if (isset($_POST['submit'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars($_POST['message']);
    $errors = [];
    
    if (empty($name)) {
        $errors[] = "Name is required.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required.";
    }
    if (empty($message)) {
        $errors[] = "Message cannot be empty.";
    }
    
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="contact.css">
    <style>      
  a:hover
  {
text-decoration:underline;
  }
  
  .menu-btn {
          background-color:rgb(16, 43, 60); 
          height:30px;
            color: white;
            border: none;
            padding: 1px 15px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }

        /* Popup Menu Styling */
        .popup-menu {
            display: none;
            position: absolute;
            background: white;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            padding: 10px;
            width: 150px;
            top: 50px;
            right: 20px;
        }

        .popup-menu button {
            background: green;
            border: none;
            padding: 8px;
            width: 100%;
            text-align: left;
            cursor: pointer;
            font-size: 14px;
        }

        .popup-menu button:hover {
            background:rgb(252, 8, 8);
        }
    </style>
   <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>

<script>
        // Toggle Popup Visibility
        function togglePopup() {
            var popup = document.getElementById("popupMenu");
            popup.style.display = (popup.style.display === "block") ? "none" : "block";
        }

        // Confirm Logout
        function confirmLogout() {
            let confirmAction = confirm("Are you sure you want to log out?");
            if (confirmAction) {
                alert("Logging out...");
                // Redirect to logout.php or perform logout action
                window.location.href = "logout.php";
            }
        }

        // Close the popup when clicking outside
        window.onclick = function(event) {
            let popup = document.getElementById("popupMenu");
            let button = document.querySelector(".menu-btn");
            if (event.target !== button && event.target !== popup) {
                popup.style.display = "none";
            }
        };
    </script>




  <!-- 
    - #HEADER
  -->

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

          <span class="span">+91-8866977---</span>
        </a>

      </div>
    </div>

    <div class="overlay" data-overlay data-nav-toggler></div>
  </header>
  <main>
    <article>


<br><br><br><br><br><br><br><br><br><br><br>

<div class="div1">

    <div class="container">
        <img src="logo.svg" alt="Company Logo" class="logo">
         <!-- <H1>BOOKEN</H1> -->
        <h2>Contact Us</h2>
        <form action="" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" >
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email">
            
            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="5" ></textarea>
            
            <button type="submit">Send Message</button>
        </form>
    </div>
    </div>
<br><br>
















    <footer class="footer has-bg-image" style="background-image: url('./assets/images/section-bg.jpg')">

    <div class="footer-top section">
      <div class="container grid-list">

        <div class="footer-brand">

          <a href="#" class="logo">
            <img src="./assets/images/logo.svg" width="138" height="28" alt="booken home">
          </a>

          <p class="footer-text">
            "Fall in love one page at a time—because the best relationships start between the covers! 📖❤️"
          </p>

          <ul class="social-list">

            <li>
              <a href="#" class="social-link">
                <ion-icon name="logo-facebook"></ion-icon>
              </a>
            </li>

            <li>
              <a href="#" class="social-link">
                <ion-icon name="logo-twitter"></ion-icon>
              </a>
            </li>

            <li>
              <a href="#" class="social-link">
                <ion-icon name="logo-instagram"></ion-icon>
              </a>
            </li>

            <li>
              <a href="#" class="social-link">
                <ion-icon name="logo-youtube"></ion-icon>
              </a>
            </li>

            <li>
              <a href="#" class="social-link">
                <ion-icon name="logo-pinterest"></ion-icon>
              </a>
            </li>

          </ul>

        </div>

        <ul class="footer-list">

          <li>
            <p class="footer-list-title">Corporate</p>
          </li>

          <li>
            <a href="#" class="footer-link">Careers</a>
          </li>

          <li>
            <a href="#" class="footer-link">About Us</a>
          </li>

          <li>
            <a href="#" class="footer-link">Contact Us</a>
          </li>

          <li>
            <a href="#" class="footer-link">FAQs</a>
          </li>

          <li>
            <a href="#" class="footer-link">Vendors</a>
          </li>

        </ul>

        <ul class="footer-list">

          <li>
            <p class="footer-list-title">Information</p>
          </li>

          <li>
            <a href="#" class="footer-link">Online Store</a>
          </li>

          <li>
            <a href="#" class="footer-link">Privacy Policy</a>
          </li>

          <li>
            <a href="#" class="footer-link">Refund Policy</a>
          </li>

          <li>
            <a href="#" class="footer-link">Shipping Policy</a>
          </li>

          <li>
            <a href="#" class="footer-link">Terms of Service</a>
          </li>

        </ul>

        <ul class="footer-list">

          <li>
            <p class="footer-list-title">Services</p>
          </li>

          <li>
            <a href="#" class="footer-link">Grooming</a>
          </li>

          <li>
            <a href="#" class="footer-link">Positive Dog Training</a>
          </li>

          <li>
            <a href="#" class="footer-link">Veterinary Services</a>
          </li>

          <li>
            <a href="#" class="footer-link">Insurance</a>
          </li>

          <li>
            <a href="#" class="footer-link">Book Writing</a>
          </li>

        </ul>

      </div>
    </div>

    <div class="footer-bottom">
      <div class="container">

        <p class="copyright">
          Copyright 2025 | Made With Love by vishva shah
        </p>

        <img src="./assets/images/payment-mehtod.png" width="311" height="30" loading="lazy" alt="Payment method"
          class="w-100">

      </div>
    </div>

  </footer>





  <!-- 
    - #BACK TO TOP
  -->

  <a href="#top" class="back-top-btn" aria-label="back to top" data-back-top-btn>
    <ion-icon name="chevron-up" aria-hidden="true"></ion-icon>
  </a>





  <!-- 
    - custom js link
  -->
  <script src="./assets/js/script.js" defer></script>

  <!-- 
    - ionicon link
  -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>
</html>