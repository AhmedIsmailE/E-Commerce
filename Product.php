<!DOCTYPE html>
<?php
session_start();
$cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $product_id = intval($_POST['product_id']);
    $quantity = $_POST['quantity'];

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

    header("Location: Product.php?id=".$product_id); // or back to product list
    exit;
}
// if (!isset($_SESSION['cart'])) {
//     $_SESSION['cart'] = []; // Initialize empty cart
// }



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
require_once("functions/getrelatedFunc.php");
$related_products = getRelatedProducts($product['category_id'], $product['id']);
// Fetch categories for dropdown
require_once("APIs/dbConnection.php");
$conn = get_db_connection();
$categories = [];
$result = $conn->query("SELECT id, category_name FROM categories");
while ($row = $result->fetch_assoc()) {
    $categories[] = $row;
}
?>
<html lang="en">
    <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Product item</title>
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
        <!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-light bg-white">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="Home.php"><img src="assets/Screenshot 2025-07-20 233626.png" alt="icon" width="200px"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="Home.php">Home</a></li>
                        <!-- <li class="nav-item"><a class="nav-link" href="#!">Products</a></li>
                        <li class="nav-item"><a class="nav-link" href="#!">Services</a></li> -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Categories
                            </a>
                            <ul class="dropdown-menu">
                                <?php foreach ($categories as $cat): ?>
                                    <li><a class="dropdown-item" href="Home.php"><?= htmlspecialchars($cat['category_name']) ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                        <!-- <li class="nav-item"><a class="nav-link" href="#!">About</a></li> -->
                    </ul>
                    <!-- <form class="d-flex"role="search" style="width: 40%;" >
                        <input class="form-control m-1" type="search" placeholder="Search" aria-label="Search"/>
                        <button class="btn btn-outline-danger m-1" type="submit">Search</button>
                    </form> -->
                    <a href="cart.php" class="btn btn-outline-dark position-relative">
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
        <!-- Product section-->
        <section class="py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="row gx-4 gx-lg-5 align-items-center">
                    <div class="col-md-6">
                        <img class="card-img-top mb-5 mb-md-0" 
                                    src="uploads/<?= htmlspecialchars($product['product_img']) ?>" 
                                     alt="<?= htmlspecialchars($product['product_name']) ?>" 
                                     onerror="this.src='https://dummyimage.com/450x300/dee2e6/6c757d.jpg';"/>
                    </div>
                    <div class="col-md-6 p-3" style="">
                        <h1 class="display-5 fw-bolder mb-6"><?= htmlspecialchars($product['product_name']) ?></h1>
                        <p class="lead"><?= htmlspecialchars($product['product_desc']) ?></p>
                        <div class="fs-5 pt-3 pb-3">
                            <span class="text-decoration-line-through text-warning m-2"><?=($product['product_price']!=$product['price_after_sale'])?$product['product_price'] . ' EGP':''?></span>
                            <span class="text-success"><?=($product['product_price']!=$product['price_after_sale'])?$product['price_after_sale'].' EGP':$product['product_price'].' EGP'?></span>
                        </div>
                        <p class="fw-bold text-danger"><?="Only ".htmlspecialchars($product['product_quantity'])." left in stock - order soon." ?></p>
                        <?php
                            if($product['product_quantity']>0):
                        ?>
                        <form method="POST" action="Product.php" class="d-flex">
                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                            <input class="form-control text-center me-3" name="quantity" type="number" value="1" min="1" max="<?= $product['product_quantity'] ?>" style="max-width: 3rem" />
                            <button class="btn btn-outline-dark flex-shrink-0" type="submit" name="add_to_cart">
                                <i class="bi-cart-fill me-1"></i>
                                Add to cart
                            </button>
                        </form>
                    <?php
                        endif;
                    ?>
                    </div>
                </div>
            </div>
        </section>
        <!-- Related items section-->
<section class="py-5 bg-light">
    <div class="container px-4 px-lg-5 mt-5">
        <h2 class="fw-bolder mb-4">Related products</h2>
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
            <?php foreach ($related_products as $item): ?>
                <div class="col mb-5">
                    <div class="card h-100">
                        <!-- Product image -->
                        <img class="card-img-top" 
                             src="uploads/<?= htmlspecialchars($item['product_img']) ?>" 
                             alt="<?= htmlspecialchars($item['product_name']) ?>" 
                             onerror="this.src='https://dummyimage.com/450x300/dee2e6/6c757d.jpg';" />
                        
                        <!-- Product details -->
                        <div class="card-body p-4">
                            <div class="text-center">
                                <!-- Product name -->
                                <h5 class="fw-bolder"><?= htmlspecialchars($item['product_name']) ?></h5>
                                <!-- Product price -->
                                <span class="text-decoration-line-through text-muted">
                                    <?= ($item['product_price'] != $item['price_after_sale']) ? $item['product_price'] . ' EGP' : '' ?>
                                </span>
                                <span class="text-success">
                                    <?= ($item['product_price'] != $item['price_after_sale']) ? $item['price_after_sale'] . ' EGP' : $item['product_price'] . ' EGP' ?>
                                </span>
                            </div>
                        </div>
                        
                        <!-- Product actions -->
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                            <div class="text-center">
                                <a class="btn btn-outline-dark mt-auto" href="product.php?id=<?= $item['id'] ?>">View</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

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
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
