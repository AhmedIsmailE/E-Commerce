<?php
session_start();
if (!isset($_SESSION['user_id'])){
    header("location:Home.php");
}
if (isset($_SESSION['user_id'])&&($_SESSION['role']==="admin")){
    header("location:Admin\AdminDashboard.php");
}



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
      <div class="value"><input name="fname" id="fname" value = "<?php echo htmlspecialchars($_SESSION['fname']); ?>"></div>
    </div>
    <div class="text-danger mb-2" id="fNameError"></div>
    <div class="row">
      <div class="label">Last Name</div>
      <div class="value"><input name="lname" id="lname" value = "<?php echo htmlspecialchars($_SESSION['lname']); ?>"></div>
    </div>
    <div class="text-danger mb-2" id="lNameError"></div>
    <div class="row">
      <div class="label">Email</div>
      <div class="value"><input name="email" id="email" disabled value = "<?php echo htmlspecialchars($_SESSION['email']); ?>"></div>
    </div>
    <div class="text-danger mb-2" id="emailError"></div>
    <div class="row">
      <div class="label">Password</div>
      <div class="value"><input name="password" id="password" value = "<?php echo htmlspecialchars($_SESSION['password']); ?>"></input></div>
    </div>
    <div class="text-danger mb-2" id="passwordError"></div>
    <input type="hidden" id="user_id" name="user_id" value="<?php echo htmlspecialchars($_SESSION['user_id']); ?>">
    <div class="button-group">
      <a class="btn edit" id="editBtn" style="text-decoration: none;">Confirm Edit</a>
      <a class="btn back" href="UserInfo.php" style="text-decoration: none;">Back</a>
    </div>
  </div>
  <script src="js/EditUser.js"></script>