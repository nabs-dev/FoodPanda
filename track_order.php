<?php include 'db.php'; session_start(); if(!isset($_SESSION['user'])) header("Location: login.php"); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Track Order</title>
    <style>
        body { font-family: sans-serif; background: #e6f2ff; padding: 20px; }
        .order { background: white; padding: 15px; margin-bottom: 10px; border-radius: 6px; box-shadow: 0 0 5px #ccc; }
    </style>
</head>
<body>
<h2>Track Your Orders</h2>
<?php
$uid = $_SESSION['user']['id'];
$orders = $conn->query("SELECT orders.id, menu.item_name, orders.status FROM orders JOIN menu ON orders.item_id = menu.id WHERE orders.user_id=$uid ORDER BY orders.id DESC");
while($o = $orders->fetch_assoc()){
    echo "<div class='order'><strong>{$o['item_name']}</strong> - Status: {$o['status']}</div>";
}
?>
</body>
</html>
