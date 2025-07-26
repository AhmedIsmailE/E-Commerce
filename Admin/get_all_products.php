<?php
session_start();
if (isset($_GET['deleted']) && $_GET['deleted'] === 'success') {
    echo "<script>alert('Product deleted successfully!');</script>";
}
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: http://localhost/NTI/final_project/Home.php");
    exit();
}

$apiURL = "http://localhost/NTI/Final_Project/APIs/ProductsAPI.php";
$productData = file_get_contents($apiURL);
$product = json_decode($productData, true);

if (!isset($product['data'][0])) {
    die("Product not found or API error.");
}
$products = $product['data'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Admin Dashboard</title>

    <!-- Bootstrap & Fonts -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script> -->
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../css/sb-admin-2.css" rel="stylesheet">
    <style>
        /* Layout Flex Styling */
        #wrapper {
            display: flex;
            min-height: 100vh;
        }

        #accordionSidebar {
            width: 30%;
            min-height: 100vh;
        }

        #main-content {
            width: 70%;
            padding: 30px;
            background-color: #f8f9fc;
        }

        @media (max-width: 768px) {
            #accordionSidebar,
            #main-content {
                width: 100%;
            }
        }

        /* Table Styling */
        .table thead th {
            background-color: #4e73df;
            color: white;
            text-align: center;
        }

        .table td,
        .table th {
            vertical-align: middle;
            text-align: center;
        }

        .table img {
            border-radius: 6px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .btn-primary,
        .btn-danger {
            padding: 4px 10px;
            font-size: 14px;
        }

        .legend {
            font-size: 24px;
            font-weight: bold;
            color: #4e73df;
            margin-bottom: 20px;
            text-align: center;
        }

        .table-responsive {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body id="page-top">
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
   
<div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="main-content">
            <form class="form-horizontal" action="edit_product.php" method="GET" enctype="multipart/form-data">
                <fieldset>
                    <div class="legend" style="width:1065px;">All Products</div>
                    <div class="table-responsive" style="width:1065px;">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Quantity</th>
                                    <th>Price Before Sale</th>
                                    <th>Sale (%)</th>
                                    <th>Price After Sale</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($products as $product): ?>
                                    <tr>
                                        <td><?= $product['id'] ?></td>
                                        <td><?= htmlspecialchars($product['product_name']) ?></td>
                                        <td><?= htmlspecialchars($product['product_desc']) ?></td>
                                        <td><?= htmlspecialchars($product['product_quantity']) ?></td>
                                        <td><?= number_format($product['product_price'], 2) ?> EGP</td>
                                        <td><?= $product['percentage_discount'] ?>%</td>
                                        <td><?= number_format($product['price_after_sale'], 2) ?> EGP</td>
                                        <td>
                                            <img src="../uploads/<?= $product['product_img'] ?>" alt="Product Image" style="width: 60px; height: 60px;">
                                        </td>
                                        <td>
                                            <a href="edit_product.php?id=<?= $product['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                                            <a href="delete_product.php?id=<?= $product['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </fieldset>
            </form>
        </div>
        <!-- End Main Content -->
    </div>
                                </div>
</body>

</html>
