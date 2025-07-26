<?php
session_start();
if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'customer'){
    header("location:Home.php");
}
elseif (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin'){
    header("location:Admin/AdminDashboard.php");
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>  
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login Page</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="css/RegisterLogin.css">
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-white">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="Home.php"><img src="assets/Screenshot 2025-07-20 233626.png" alt="icon" width="200px"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <!-- <li class="nav-item"><a class="nav-link" href="#!">Products</a></li> -->
                <li class="nav-item dropdown">
                    <!-- <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Categories
                    </a>
                    <ul class="dropdown-menu">
                        <?php foreach ($categories as $cat): ?>
                            <li><a class="dropdown-item" href="#cat<?= $cat['id'] ?>"><?= htmlspecialchars($cat['category_name']) ?></a></li>
                        <?php endforeach; ?>
                    </ul> -->
                </li>
                <!-- <li class="nav-item"><a class="nav-link" href="#!">About us</a></li> -->
            </ul>
            <!-- <form class="d-flex" role="search" style="width: 40%;">
                <input class="form-control m-1" type="search" placeholder="Search" aria-label="Search"/>
                <button class="btn btn-outline-danger m-1" type="submit">Search</button>
            </form> -->
            <?php
                if (!isset($_SESSION['user_id'])){
                    echo "<a class='nav-link active' aria-current='page' style ='margin-right: 10px;' href='Login.php'>Login</a>";
                echo "<a class='nav-link active' aria-current='page' style ='margin-right: 10px;' href='Register.php'>Register</a>";
                
            }
                elseif ($_SESSION['role']==='customer'){
                   echo "<a class='nav-link active' aria-current='page' style ='margin-right: 10px;' href='Logout.php'>Log out</a>";
                   echo "<a class='nav-link active' aria-current='page' style ='margin-right: 10px;' href='UserInfo.php'>My Info</a>";
                    
                }

                elseif ($_SESSION['role']==='admin'){
                    echo "<a class='nav-link active' aria-current='page' style ='margin-right: 10px;' href='Logout.php'>Log out</a>";
                   echo "<a class='nav-link active' aria-current='page' style ='margin-right: 10px;' href='Admin/AdminDashboard.php'>Dashboard</a>";
                    
                }
                else {
                    echo "<a class='nav-link active' aria-current='page' style ='margin-right: 10px;' href='Logout.php'>Log out</a>";
                   echo "<a class='nav-link active' aria-current='page' style ='margin-right: 10px;' href='UserInfo.php'>My Info</a>";
                }
                ?>
           
        </div>
    </div>
</nav>
        <div class="container">
            <div class="row">
                <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                    <div class="card border-0 shadow rounded-3 my-5">
                        <div class="card-body p-4 p-sm-5">
                            <h5 class="card-title text-center mb-4 fw-bold fs-4">Welcome Back <br><br>Please Enter Your Account</h5>
                            <form id="loginForm">
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com">
                                <label for="floatingInput">Email Address</label>
                                <div id="emailError" class="text-danger mt-1"></div>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                <label for="floatingPassword">Password</label>
                                <div id="passwordError" class="text-danger mt-1"></div>
                            </div>
                            
                            <p id="login_Error" name="login_Error" style="color: red; margin-top: 5px;"></p>
                            <div class="d-grid">
                                <button class="btn btn-primary btn-login text-uppercase fw-bold" type="submit">Sign
                                in</button>
                            </div>
                            <div id="generalError" class="text-danger mt-3 text-center"></div>
                            
                            <hr>
                            <p class="text-center text-muted mt-5 mb-0">Don't have an account? <a href="Register.php"
                                class="fw-bold text-body"><u>Register here</u></a></p>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script src="js/Login.js"></script>
 </html>