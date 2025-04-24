<?php include 'db.php'; session_start(); if(!isset($_SESSION['user'])) header("Location: login.php"); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Order History</title>
    <style>
        body { font-family: sans-serif; background: #f4f9ff; padding: 20px; }
        .history { background: white; padding: 15px; margin: 10px 0; border-radius: 6px; box-shadow: 0 0 5px #ccc; }
    </style>
</head>
<body>
<h2>Your Order History</h2>
<?php
$uid = $_SESSION['user']['id'];
$orders = $conn->query("SELECT menu.item_name, orders.status FROM orders JOIN menu ON orders.item_id = menu.id WHERE orders.user_id=$uid");
while($o = $orders->fetch_assoc()){
    echo "<div class='history'><strong>{$o['item_name']}</strong> - {$o['status']}</div>";
}
?>
</body>
</html>
