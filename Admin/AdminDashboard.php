<?php
session_start();
if (!isset($_SESSION['user_id'])||!($_SESSION['role']==="admin")){
    header("location:../Home.php");
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

        

                    

                    
                            

                <!-- Begin Page Content -->
                <div class="container-fluid">

                <div class="card" style="margin-top: 50px;">
                <div class="row">
                <div class="label">First Name</div>
                <div class="value"><?php echo htmlspecialchars($_SESSION['fname']); ?></div>
                </div>
                <div class="row">
                <div class="label">Last Name</div>
                <div class="value"><?php echo htmlspecialchars($_SESSION['lname']); ?></div>
                </div>
                <div class="row">
                <div class="label">Email</div>
                <div class="value"><?php echo htmlspecialchars($_SESSION['email']); ?></div>
                </div>
                <!-- <div class="row">
                <div class="label">Password</div>
                <div class="value"><?php echo htmlspecialchars($_SESSION['password']); ?></div>
                </div> -->
                
                <a type="button" style="text-decoration: none; color: white;" class="edit-button" href="edit_admin.php">Edit Info</a>
            </div>



                </div>
                <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    
    

</body>

</html>