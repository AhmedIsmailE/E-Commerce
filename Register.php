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
        <title>Register Page</title>
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
                            <h5 class="card-title text-center mb-4 fw-bold fs-4" style="font-weight: bold;">Create An Account <br><br>Please Enter Your Data</h5>
                            <form id="registerForm" method="post">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="fName" name = "fName" placeholder="name@example.com">
                                <label for="floatingInput">First Name</label>
                            </div>
                            <div class="text-danger mb-2" id="fNameError"></div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="lName" name = "lName"  placeholder="name@example.com">
                                <label for="floatingInput">Last Name</label>
                            </div>   
                            <div class="text-danger mb-2" id="lNameError"></div> 
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="email" name = "email"  placeholder="name@example.com">
                                <label for="floatingInput">Email Address</label>
                            </div>
                            <div class="text-danger mb-2" id="emailError"></div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="password" name = "password"  placeholder="Password">
                                <label for="floatingPassword">Password</label>
                            </div>
                            <div class="text-danger mb-2" id="passwordError"></div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="confirm_password" name = "confirm_password"  placeholder="Confirm Password">
                                <label for="floatingPassword">Confirm Password</label>
                            </div>
                            <div class="text-danger mb-2" id="confirmPasswordError"></div>
                            <div class="d-grid">
                                <button class="btn btn-primary btn-login text-uppercase fw-bold" type="submit">Register
                                </button>
                            </div>

                            <hr>
                            <p class="text-center text-muted mt-5 mb-0">Already have an account? <a href="Login.php"
                                class="fw-bold text-body"><u>Login here</u></a></p>
                            
                            </form>

                            <div id="errorBox" style="color:red;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    
   <script src="js/Register.js"></script>

 </html>