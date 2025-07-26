<?php
session_start();
if (!isset($_SESSION['user_id'])){
    header("location:../Home.php");
}
if (isset($_SESSION['user_id'])&&($_SESSION['role']==="admin")){
    header("location:Admin\AdminDashboard.php");
}
$user_id = $_SESSION['user_id'];
$api_url = "http://localhost/NTI/Final_Project/APIs/OrderAPI.php?user_id=" . $user_id;
$response = file_get_contents($api_url);
$orders_data = json_decode($response, true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Info and Orders</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f9f9f9;
      padding: 50px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .card {
      background-color: #ffffff;
      border-radius: 12px;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
      max-width: 600px;
      width: 100%;
      padding: 30px 40px;
      margin-bottom: 50px;
    }

    .row {
      display: flex;
      justify-content: space-between;
      padding: 12px 0;
      border-bottom: 1px solid #eee;
    }

    .row:last-child {
      border-bottom: none;
    }

    .label {
      font-weight: 600;
      color: #333;
    }

    .value {
      color: #444;
      text-align: right;
    }

    .button-group {
      display: flex;
      justify-content: flex-start;
      gap: 10px;
      margin-top: 30px;
    }

    .btn {
      padding: 10px 20px;
      border: none;
      border-radius: 6px;
      font-size: 15px;
      font-weight: 500;
      cursor: pointer;
      transition: background-color 0.2s ease;
    }

    .btn.edit {
      background-color: #f39c12;
      color: #fff;
    }

    .btn.edit:hover {
      background-color: #e67e22;
    }

    .btn.back {
      background-color: #e74c3c;
      color: #fff;
    }

    .btn.back:hover {
      background-color: #c0392b;
    }

    .orders-section {
      max-width: 800px;
      width: 100%;
      text-align: center;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background-color: #fff;
      margin-top: 20px;
    }

    th, td {
      border: 1px solid #ccc;
      padding: 12px;
    }

    th {
      background-color: #f0f0f0;
      font-weight: bold;
    }
  </style>
</head>
<body>

  <!-- User Info Card -->
  <div class="card">
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
    <div class="button-group">
      <a class="btn edit" href="editMe.php" style="text-decoration: none;">Edit Info</a>
      <a class="btn back" href="Home.php" style="text-decoration: none;">Back</a>
    </div>
  </div>

  <!-- Orders Section -->
  <div class="orders-section">
    <h2>My Orders</h2>
    <table>
      <thead>
        <tr>
          <th>Order ID</th>
          <th>Product Name</th>
          <th>Quantity</th>
          <th>Total Price</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
          <?php
                if (isset($orders_data['data']) && count($orders_data['data']) > 0):
                    foreach ($orders_data['data'] as $order):
                ?>
                    <tr>
                        <td><?= htmlspecialchars($order['id']) ?></td>
                        <td><?= htmlspecialchars($order['product_name']) ?></td>
                        <td><?= htmlspecialchars($order['quantity']) ?></td>
                        <td>$<?= number_format($order['price']*$order['quantity']/1000,3,',','') ?></td>
                        <td><?= htmlspecialchars($order['status']) ?></td>
                    </tr>
                <?php
                    endforeach;
                else:
                ?>
                    <tr>
                        <td colspan="5">No orders found.</td>
                    </tr>
          <?php endif; ?>
      </tbody>
    </table>
  </div>

</body>
</html>
