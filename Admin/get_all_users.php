<?php
session_start();
if (isset($_GET['deleted']) && $_GET['deleted'] === 'success') {
    echo "<script>alert('User deleted successfully!');</script>";
}
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: http://localhost/NTI/final_project/Home.php");
    exit();
}

$apiURL = "http://localhost/NTI/Final_Project/APIs/UsersAPI.php";
$userData = file_get_contents($apiURL);
$user = json_decode($userData, true);

if (!isset($user['data'][0])) {
    die("user not found or API error.");
}
$users = $user['data'];
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
                <a class="nav-link" href="">
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
                    <div class="legend" style="width:1000px;">All Users</div>
                    <div class="table-responsive" style="width:1000px;">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>firstName</th>
                                    <th>lastName</th>
                                    <th>email</th>
                                    <th>role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><?= $user['id'] ?></td>
                                        <td><?= htmlspecialchars($user['firstName']) ?></td>
                                        <td><?= htmlspecialchars($user['lastName']) ?></td>
                                        <td><?= htmlspecialchars($user['email']) ?></td>
                                        <td><?= htmlspecialchars($user['role']) ?></td>
                                        <td>
                                            <a href="edit_user.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                                            <a href="delete_user.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
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
