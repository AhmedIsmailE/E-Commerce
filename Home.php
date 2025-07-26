<?php
session_start();

$cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $product_id = intval($_POST['product_id']);
    $quantity = 1;

    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['product_id'] == $product_id) {
            $item['quantity'] += $quantity;
            $found = true;
            break;
        }
    }

    if (!$found) {
        $_SESSION['cart'][] = ['product_id' => $product_id, 'quantity' => $quantity];
    }

    header("Location: Home.php"); // or back to product list
    exit;
}

require_once("APIs/dbConnection.php");
$conn = get_db_connection();
$categories = [];
$result = $conn->query("SELECT id, category_name FROM categories");
while ($row = $result->fetch_assoc()) {
    $categories[] = $row;
}

// Function to fetch products for each category
function getProductsByCategory($categoryId) {
    $productsData = file_get_contents("http://localhost/NTI/Final_Project/APIs/ProductsAPI.php?category_id=" . $categoryId);
    $products = json_decode($productsData, true);
    return $products['data'] ?? [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Shop Homepage</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <link href="css/styles2.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@cartzilla/icons@1.0.1/cartzilla-icons.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-white">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="Home.php"><img src="assets/Screenshot 2025-07-20 233626.png" alt="icon" width="200px"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <!-- <li class="nav-item"><a class="nav-link" href="#!">Products</a></li> -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Categories
                    </a>
                    <ul class="dropdown-menu">
                        <?php foreach ($categories as $cat): ?>
                            <li><a class="dropdown-item" href="#cat<?= $cat['id'] ?>"><?= htmlspecialchars($cat['category_name']) ?></a></li>
                        <?php endforeach; ?>
                    </ul>
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
            <a href="cart.php" style="color:red; border-color:red;" class="btn btn-outline-dark position-relative">
            🛒 Cart
                <?php if ($cart_count > 0): ?>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        <?= $cart_count ?>
                    </span>
                <?php endif; ?>
            </a>
        </div>
    </div>
</nav>

<!-- Header -->
<div class="sec1">
    <div class="container px-4 px-lg-5 my-5 d-flex con1">
        <div class="text-center text-white txt-con">
            <p class="lead fw-normal text-white-50 mb-0">Deal of the week</p>
            <h1 class="display-4 fw-bolder">Apple 13-Inch iPad Pro</h1>
            <a type="button" href="http://localhost/NTI/final_project/Product.php?id=16" class="btn btn-dark p-3">Buy now</a>
        </div>
        <div class="img">
            <img src="assets/02.png" alt="">
        </div>
    </div>
</div>

<!-- service -->
    <section class="container mt-5">
        <div class="row row-cols-2 row-cols-md-4 g-4">
            <div class="col d-flex icn">
                <div class="d-flex text-dark-emphasis bg-body-tertiary rounded-circle p-4 mb-4">
                    <i><img src="assets/money (2).png" alt=""></i>
                </div>
                <div class="text-center text-xxl-start ps-xxl-3">
                    <h3 class="h6 mb-1">Free Shipping & Returns</h3>
                    <p class="fs-sm mb-0">For all orders over $199.00</p>
                </div>
            </div>
            <div class="col d-flex icn">
                <div class="d-flex text-dark-emphasis bg-body-tertiary rounded-circle p-4 mb-3 mb-xxl-0">
                    <i><img src="assets/credit-card.png" alt=""></i>
                </div>
                <div class="text-center text-xxl-start ps-xxl-3">
                    <h3 class="h6 mb-1">Secure Payment</h3>
                    <p class="fs-sm mb-0">We ensure secure payment</p>
                </div>
            </div>
            <div class="col d-flex icn">
                <div class="d-flex text-dark-emphasis bg-body-tertiary rounded-circle p-4 mb-3 mb-xxl-0">
                    <i><img src="assets/sync.png" alt=""></i>
                </div>
                <div class="text-center text-xxl-start ps-xxl-3">
                    <h3 class="h6 mb-1">Money Back Guarantee</h3>
                    <p class="fs-sm mb-0">Returning money 30 days</p>
                </div>
            </div>
            <div class="col d-flex icn">
                <div class="d-flex text-dark-emphasis bg-body-tertiary rounded-circle p-4 mb-3 mb-xxl-0">
                    <i><img src="assets/customer-support.png" alt=""></i>
                </div>
                <div class="text-center text-xxl-start ps-xxl-3">
                    <h3 class="h6 mb-1">24/7 Customer Support</h3>
                    <p class="fs-sm mb-0">Friendly customer support</p>
                </div>
            </div>
        </div>
        </section>
        <!-- sale -->
        <!-- <section class="container pt-5 mt-sm-2 mt-md-3 mt-lg-4 con1">
        <div class="row g-0">
            <div class="col-md-3 mb-n4 mb-md-0">
                <div class="position-relative z-1 display-1 text-nowrap mb-0">
                            20 
                        <span class="d-inline-block ms-n2">
                            <span class="d-block fs-1">%</span>
                            <span class="d-block fs-5">off</span>
                        </span>
                </div>
            </div>
        </div>
    </section> -->

<!-- Categories & Products Sections -->
<div class="container mt-5">
    <?php foreach ($categories as $cat): ?>
        <section id="cat<?= $cat['id'] ?>" class="mb-5">
            <h2 class="h3 mb-4"><?= htmlspecialchars($cat['category_name']) ?></h2><hr/>
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <?php
                $products = getProductsByCategory($cat['id']);
                if (!empty($products)):
                    foreach ($products as $product): ?>
                        <div class="col mb-5 ">
                            <div class="card h-100 p-3">
                                <img class="card-img-top"
                                     src="uploads/<?= htmlspecialchars($product['product_img']) ?>" 
                                     alt="<?= htmlspecialchars($product['product_name']) ?>" 
                                     onerror="this.src='https://dummyimage.com/450x300/dee2e6/6c757d.jpg';"/>
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <h5 class="fw-bolder"><?= htmlspecialchars($product['product_name']) ?></h5>
                                        <?php
                                        $formatted_price = number_format($product['product_price'] / 1000, 3, ',', ''); 
                                        ?>
                                        <div class="h5 lh-1 mb-0"><?= $formatted_price ?> EGP</div>
                                    </div>
                                </div>
                                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <a class="btn btn-danger btn-outline-light flex-shrink-0" href="Product.php?id=<?= $product['id'] ?>">View Details</a>
                                        <?php
                                        if($product['product_quantity']>0):
                                            ?>
                                        <form method="POST" action="Home.php">
                                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                            <button class="btn btn-outline-dark flex-shrink-0" type="submit" name="add_to_cart">Add</button>
                                        </form>
                                        <?php
                                         endif;
                                         ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach;
                else: ?>
                    <p class="text-muted">No products found in this category.</p>
                <?php endif; ?>
            </div>
        </section>
    <?php endforeach; ?>
</div>

 <!-- Footer-->
<div class=" ">

  <!-- Footer -->
  <footer
          class="text-center text-lg-start text-white p-4"
          style="background-image: linear-gradient(to left, rgba(0, 0, 0, 0.614), rgba(255,0,0,1));"
          >

    <!-- Section: Links  -->
    <section class="">
      <div class="container text-center text-md-start mt-5">
        <!-- Grid row -->
        <div class="row mt-3">
          <!-- Grid column -->
          <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
            <!-- Content -->
            <img src="assets/Screenshot 2025-07-20 233626.png" alt="" width="300px">
            <hr
                class="mb-4 mt-0 d-inline-block mx-auto"
                style="width: 60px; background-color: #7c4dff; height: 2px"
                />
            <p>
              Here you can use rows and columns to organize your footer
              content. Lorem ipsum dolor sit amet, consectetur adipisicing
              elit.
            </p>
          </div>
          <!-- Grid column -->

          <!-- Grid column -->
          <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
            <!-- Links -->
            <h6 class="text-uppercase fw-bold">Products</h6>
            <hr
                class="mb-4 mt-0 d-inline-block mx-auto"
                style="width: 60px; background-color: #7c4dff; height: 2px"
                />
            <p>
              <a href="#!" class="text-white">MDBootstrap</a>
            </p>
            <p>
              <a href="#!" class="text-white">MDWordPress</a>
            </p>
            <p>
              <a href="#!" class="text-white">BrandFlow</a>
            </p>
            <p>
              <a href="#!" class="text-white">Bootstrap Angular</a>
            </p>
          </div>
          <!-- Grid column -->

          <!-- Grid column -->
          <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
            <!-- Links -->
            <h6 class="text-uppercase fw-bold">Useful links</h6>
            <hr
                class="mb-4 mt-0 d-inline-block mx-auto"
                style="width: 60px; background-color: #7c4dff; height: 2px"
                />
            <p>
              <a href="#!" class="text-white">Your Account</a>
            </p>
            <p>
              <a href="#!" class="text-white">Become an Affiliate</a>
            </p>
            <p>
              <a href="#!" class="text-white">Shipping Rates</a>
            </p>
            <p>
              <a href="#!" class="text-white">Help</a>
            </p>
          </div>
          <!-- Grid column -->

          <!-- Grid column -->
          <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
            <!-- Links -->
            <h6 class="text-uppercase fw-bold">Contact</h6>
            <hr
                class="mb-4 mt-0 d-inline-block mx-auto"
                style="width: 60px; background-color: #7c4dff; height: 2px"
                />
            <p><i class="fas fa-home mr-3"></i> New York, NY 10012, US</p>
            <p><i class="fas fa-envelope mr-3"></i> info@example.com</p>
            <p><i class="fas fa-phone mr-3"></i> + 01 234 567 88</p>
            <p><i class="fas fa-print mr-3"></i> + 01 234 567 89</p>
          </div>
          <!-- Grid column -->
        </div>
        <!-- Grid row -->
      </div>
    </section>
    <!-- Section: Links  -->

    <!-- Copyright -->
    <div
         class="text-center p-3"
         style="background-color: rgba(0, 0, 0, 0.2)"
         >
      © 2020 Copyright:
      <a class="text-white" href="https://mdbootstrap.com/"
         >MDBootstrap.com</a
        >
    </div>
    <!-- Copyright -->
  </footer>
  <!-- Footer -->

</div>
<!-- End of .container -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/scripts.js"></script>
</body>
</html>
