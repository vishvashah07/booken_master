<?php
// Start output buffering — prevents "headers already sent" warnings
ob_start();
include 'config.php';

// 🧩 Add Product Logic
if (isset($_POST['add_products_btn'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = './assets/images/' . $image;

    $insert_query = mysqli_query($conn, "INSERT INTO products(name, price, image) VALUES('$name', '$price', '$image')") or die('query failed');

    if ($insert_query) {
        move_uploaded_file($image_tmp_name, $image_folder);
        echo "<script>alert('Product added successfully'); window.location.href='admin_products.php';</script>";
    } else {
        echo "<script>alert('Failed to add product');</script>";
    }
}

// 🧩 Update Product Logic
if (isset($_POST['update_product'])) {
    $update_p_id = $_POST['update_p_id'];
    $update_name = $_POST['update_name'];
    $update_price = $_POST['update_price'];
    $update_old_img = $_POST['update_old_img'];

    $update_image = $_FILES['update_image']['name'];
    $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
    $update_image_folder = './assets/images/' . $update_image;

    if (!empty($update_image)) {
        if (file_exists('./assets/images/' . $update_old_img)) {
            unlink('./assets/images/' . $update_old_img);
        }
        move_uploaded_file($update_image_tmp_name, $update_image_folder);
        $update_query = mysqli_query($conn, "UPDATE products SET name='$update_name', price='$update_price', image='$update_image' WHERE id='$update_p_id'") or die('query failed');
    } else {
        $update_query = mysqli_query($conn, "UPDATE products SET name='$update_name', price='$update_price' WHERE id='$update_p_id'") or die('query failed');
    }

    if ($update_query) {
        echo "<script>alert('Product updated successfully!'); window.location.href='admin_products.php';</script>";
    } else {
        echo "<script>alert('Failed to update product');</script>";
    }
}

// 🧩 Delete Product Logic
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_image_query = mysqli_query($conn, "SELECT image FROM products WHERE id='$delete_id'") or die('query failed');
    $fetch_delete_image = mysqli_fetch_assoc($delete_image_query);
    if (file_exists('./assets/images/' . $fetch_delete_image['image'])) {
        unlink('./assets/images/' . $fetch_delete_image['image']);
    }
    mysqli_query($conn, "DELETE FROM products WHERE id='$delete_id'") or die('query failed');
    header('Location: admin_products.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin - Manage Products</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <style>
       * {
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      margin: 0;
      padding: 0;
      background-color: #f4f6f9;
    }

    header {
      background-color: #1f2d3d;
      color: white;
      padding: 20px;
      text-align: center;
    }

    .admin_add_products,
    .show_products,
    .edit_product_form {
      padding: 30px;
      max-width: 1200px;
      margin: auto;
    }

    form {
      background-color: white;
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      margin-bottom: 30px;
    }

    form h3 {
      margin-bottom: 20px;
      color: #333;
    }

    .admin_input {
      width: 100%;
      padding: 12px;
      margin-bottom: 15px;
      border-radius: 8px;
      border: 1px solid #ccc;
      transition: border-color 0.3s ease;
    }

    .admin_input:focus {
      border-color: #007bff;
      outline: none;
    }

    .product_btn {
      padding: 10px 20px;
      background-color: #007bff;
      color: white;
      text-decoration: none;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      margin: 5px;
    }

    .product_del_btn {
      background-color: #e74c3c;
    }

    .product_box_cont {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 20px;
    }

    .product_box {
      background: white;
      padding: 15px;
      border-radius: 12px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      text-align: center;
    }

    .product_box img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-radius: 8px;
      margin-bottom: 15px;
    }

    .product_name {
      font-size: 18px;
      font-weight: 600;
      color: #2c3e50;
    }

    .product_price {
      color: #27ae60;
      font-size: 16px;
      margin: 10px 0;
    }

    .empty {
      text-align: center;
      font-size: 18px;
      color: #888;
      padding: 20px;
    }

    @media (max-width: 600px) {
      .admin_input {
        font-size: 14px;
      }

      .product_box img {
        height: 160px;
      }
    }
    
    * {
        box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 0;
        padding: 0;
    }

    body {
        background-color: #f4f6f9;
    }

    header {
        background-color: #1f2d3d;
        color: white;
        padding: 25px 20px;
        text-align: center;
        font-size: 28px;
        font-weight: 600;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    nav {
        background-color: rgb(27, 104, 108);
        padding: 12px 20px;
        display: flex;
        justify-content: flex-end;
        gap: 15px;
    }

    nav a {
        color: #ffffff;
        text-decoration: none;
        padding: 10px 18px;
        border-radius: 8px;
        background-color: #3498db;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    nav a:hover {
        background-color:rgb(255, 55, 0);
    }

    .dashboard {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        padding: 30px;
    }

    .card {
        background: white;
        padding: 25px 20px;
        border-radius: 15px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        text-align: center;
        transition: transform 0.2s;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .card h3 {
        font-size: 22px;
        margin-bottom: 10px;
        color: #27ae60;
    }

    .card p {
        font-size: 16px;
        color: #7f8c8d;
    }

    @media (max-width: 600px) {
        nav {
            flex-direction: column;
            align-items: flex-end;
        }

        nav a {
            width: 100%;
            text-align: center;
        }
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

<section class="admin_add_products">
    <form action="" method="post" enctype="multipart/form-data">
      <h3>Add New Product</h3>
      <input type="text" name="name" class="admin_input" placeholder="Product Name" required>
      <input type="number" min="0" name="price" class="admin_input" placeholder="Product Price" required>
      <input type="file" name="image" class="admin_input" accept="image/jpg, image/jpeg, image/png" required>
      <input type="submit" name="add_products_btn" class="product_btn" value="Add Product">
    </form>
</section>

<section class="show_products">
    <div class="product_box_cont">
      <?php
        $select_products = mysqli_query($conn, "SELECT * FROM products") or die('query failed');
        if (mysqli_num_rows($select_products) > 0) {
          while ($fetch_products = mysqli_fetch_assoc($select_products)) {
      ?>
        <div class="product_box">
          <img src="./assets/images/<?php echo $fetch_products['image']; ?>" alt="Product Image">
          <div class="product_name"><?php echo $fetch_products['name']; ?></div>
          <div class="product_price">Rs. <?php echo $fetch_products['price']; ?> /-</div>
          <a href="admin_products.php?update=<?php echo $fetch_products['id']; ?>" class="product_btn">Update</a>
          <a href="admin_products.php?delete=<?php echo $fetch_products['id']; ?>" class="product_btn product_del_btn" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
        </div>
      <?php
          }
        } else {
          echo '<p class="empty">No Product added!</p>';
        }
      ?>
    </div>
</section>

<section class="edit_product_form">
    <?php
    if (isset($_GET['update'])) {
        $update_id = $_GET['update'];
        $update_query = mysqli_query($conn, "SELECT * FROM products WHERE id='$update_id'") or die('query failed');
        if (mysqli_num_rows($update_query) > 0) {
            while ($fetch_update = mysqli_fetch_assoc($update_query)) {
    ?>
    <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['id']; ?>">
      <input type="hidden" name="update_old_img" value="<?php echo $fetch_update['image']; ?>">
      <img src="./assets/images/<?php echo $fetch_update['image']; ?>" alt="" style="width:150px; height:150px; margin-bottom:15px;">
      <input type="text" name="update_name" value="<?php echo $fetch_update['name']; ?>" class="admin_input update_box" required>
      <input type="number" name="update_price" min="0" value="<?php echo $fetch_update['price']; ?>" class="admin_input update_box" required>
      <input type="file" name="update_image" class="admin_input update_box" accept="image/jpg, image/jpeg, image/png">
      <input type="submit" value="Update" name="update_product" class="product_btn">
      <input type="reset" value="Cancel" id="close_update" class="product_btn product_del_btn">
    </form>
    <?php
            }
        }
    } else {
        echo "<script>document.querySelector('.edit_product_form').style.display='none';</script>";
    }
    ?>
</section>

</body>
</html>

<?php
// End output buffering
ob_end_flush();
?>
