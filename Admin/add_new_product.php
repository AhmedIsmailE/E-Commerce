<!-- <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script> -->
<!------ Include the above in your HEAD tag ---------->
<?php
    session_start();
    // if (isset($_GET['status']) && $_GET['status'] === 'success') {
    // echo "<script>alert('Product Added Successfully!');</script>";
    // }
    if (isset($_GET['mess'])) {
    $message = htmlspecialchars($_GET['mess']);
    echo "<script>alert('$message');</script>";
}
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
        header("Location: http://localhost/NTI/final_project/Home.php");
        exit();
    }
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

        
<form class="form-horizontal" action="../functions/addproductFunc.php" method="post" style="margin-left:50px;" enctype="multipart/form-data">
<fieldset>

<!-- Form Name -->
<h2 style="margin-top:20px;">Add Product</h2>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="product_name">Product name</label>  
  <div class="col-md-4">
  <input id="product_name" name="product_name" placeholder="Product name" class="form-control input-md" required="" type="text">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="product_name_fr">Product description </label>  
  <div class="col-md-4">
  <input id="product_name_fr" name="product_desc" placeholder="Product description " class="form-control input-md" required="" type="text">
    
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="product_category">Product category</label>
  <div class="col-md-4">
    <select id="product_category" name="category_id" class="form-control">
        <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['category_name']) ?></option>
        <?php endforeach; ?>
    </select>
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="available_quantity">Available quantity</label>  
  <div class="col-md-4">
  <input id="available_quantity" name="product_quantity" placeholder="Available quantity" class="form-control input-md" required="" type="text">
    
  </div>
</div>


<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="product_price">Product price</label>  
  <div class="col-md-4">
  <input id="product_price" name="product_price" placeholder="Product price" class="form-control input-md" required="" type="number">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="percentage_discount">Percentage discount</label>  
  <div class="col-md-4">
  <input id="percentage_discount" name="percentage_discount" placeholder="Percentage discount" class="form-control input-md" required="" type="text">
    
  </div>
</div>



<!-- Text input
<div class="form-group">
  <label class="col-md-4 control-label" for="online_date">ONLINE DATE</label>  
  <div class="col-md-4">
  <input id="online_date" name="online_date" placeholder="ONLINE DATE" class="form-control input-md" required="" type="text">
    
  </div>
</div> -->

 <!-- File Button --> 
<div class="form-group">
  <label class="col-md-4 control-label" for="filebutton">Main_image</label>
  <div class="col-md-4">
    <input id="filebutton" name="product_img" class="input-file" type="file">
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4">
    <button id="singlebutton" name="singlebutton" class="btn btn-primary" style="background-color:red;border-color:red;" type="submit" href ="add_new_product.php?status=success">Submit</button>
    <a id="singlebutton1" name="singlebutton1" class="btn btn-primary" style="background-color:red;border-color:red;" type="button" href ="AdminDashboard.php">Back</a>
  </div>
  </div>

</fieldset>
</form>

    </div>
    <!-- End of Page Wrapper -->

    
    

</body>

</html>








