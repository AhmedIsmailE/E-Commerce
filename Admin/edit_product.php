<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: http://localhost/NTI/final_project/Home.php");
    exit();
}
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid product ID.");
}

$productID = intval($_GET['id']);
$apiURL = "http://localhost/NTI/Final_Project/APIs/ProductsAPI.php?id=" . $productID;
$productData = file_get_contents($apiURL);
$product = json_decode($productData, true);

// If API error
if (!isset($product['data'][0])) {
    die("Product not found or API error.");
}
$product = $product['data'][0];  // Get the first product row

// Fetch categories for dropdown
require_once("../APIs/dbConnection.php");
$conn = get_db_connection();
$categories = [];
$result = $conn->query("SELECT id, category_name FROM categories");
while ($row = $result->fetch_assoc()) {
    $categories[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.css" rel="stylesheet">
    <style>
    .profile-page {
      font-family: Arial, sans-serif;
      background-color: #f0f4f8;
      padding: 40px;
    }

    .card {
      max-width: 500px;
      margin: auto;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      padding: 20px 30px;
    }

    .row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 16px;
      border-bottom: 1px solid #f0f0f0;
      padding-bottom: 6px;
    }

    .label {
      font-weight: bold;
      color: #555;
    }

    .value {
      color: #333;
    }

    .edit-button {
      margin-top: 20px;
      display: inline-block;
      background-color: #d46a4fff;
      color: white;
      padding: 8px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      text-align: center;
      text-decoration: none;
    }

    .edit-button:hover {
      background-color: #7a170aff;
    }
  </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="AdminDashboard.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Admin Dashboard</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="../Home.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Home</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <!-- <div class="sidebar-heading">
                Manage Users
            </div> -->
            <li class="nav-item active">
                <a class="nav-link" href="get_all_users.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Manage Users</span></a>
            </li>
            <!-- Nav Item - Utilities Collapse Menu -->
            <!-- <li class="nav-item">
                <a class="nav-link" href="#"">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Manage Users</span>
                </a>
                
                
            </li> -->

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item active">
                <a class="nav-link" href="add_new_product.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Add Products</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="get_all_products.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Manage Products</span></a>
            </li>

            <!-- Nav Item - Tables -->

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <li class="nav-item active">
                <a class="nav-link" href="../Logout.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Log out</span></a>
            </li>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

        
<form class="form-horizontal" style="margin-left:50px;" action="../functions/updateproductFunc.php?id=<?= $productID ?>" method="POST" enctype="multipart/form-data">
<fieldset>

<h2 style="margin-top:20px;">Edit product</h2>

<div class="form-group">
  <label class="col-md-4 control-label" for="product_name">Product name</label>  
  <div class="col-md-4">
  <input id="product_name" name="product_name" value="<?= htmlspecialchars($product['product_name']) ?>" class="form-control input-md" required type="text">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="product_desc">Product description</label>  
  <div class="col-md-4">
  <input id="product_desc" name="product_desc" value="<?= htmlspecialchars($product['product_desc']) ?>" class="form-control input-md" required type="text">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="product_categorie">Product category</label>
  <div class="col-md-4">
    <select id="product_categorie" name="category_id" class="form-control">
        <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['id'] ?>" <?= ($cat['id'] == $product['category_id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($cat['category_name']) ?>
            </option>
        <?php endforeach; ?>
    </select>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="product_quantity">Available quantity</label>  
  <div class="col-md-4">
  <input id="product_quantity" name="product_quantity" value="<?= $product['product_quantity'] ?>" class="form-control input-md" required type="number">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="product_price">Product price</label>  
  <div class="col-md-4">
  <input id="product_price" name="product_price" value="<?= $product['product_price'] ?>" class="form-control input-md" required type="number" step="0.01">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="percentage_discount">Percentage discount</label>  
  <div class="col-md-4">
  <input id="percentage_discount" name="percentage_discount" value="<?= $product['percentage_discount'] ?>" class="form-control input-md" required type="number">
  </div>
</div>


<div class="form-group">
  <label class="col-md-4 control-label" for="product_img">Main image</label>
  <div class="col-md-4">
    <input id="product_img" name="product_img" class="input-file" type="file">
    <input type="hidden"name="old_img"value="<?= htmlspecialchars($product['product_img']) ?>">
    <p>Current Image: <?= htmlspecialchars($product['product_img']) ?></p>
    <img src="../uploads/<?= htmlspecialchars($product['product_img']) ?>" width="150" alt="Current Product Image">
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4">
    <button id="singlebutton" name="singlebutton" class="btn btn-primary" style="background-color:red;border-color:red;" type="submit">Submit</button>
    <a id="singlebutton1" name="singlebutton1" class="btn btn-primary" style="background-color:red;border-color:red;" type="button" href ="get_all_products.php">Back</a>
  </div>
  </div>

</fieldset>
</form>

    </div>
    <!-- End of Page Wrapper -->
</body>

</html>

