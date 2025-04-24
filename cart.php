<?php include 'db.php'; session_start(); if(!isset($_SESSION['user'])) header("Location: login.php");
$uid = $_SESSION['user']['id'];
if(isset($_GET['add'])){
    $item = $_GET['add'];
    $conn->query("INSERT INTO cart(user_id, item_id) VALUES($uid, $item)");
}
if(isset($_GET['remove'])){
    $conn->query("DELETE FROM cart WHERE id={$_GET['remove']}");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cart</title>
    <style>
        body { font-family: sans-serif; background: #fff0f5; padding: 20px; }
        .cart-item { background: white; padding: 10px; margin-bottom: 10px; border-radius: 6px; box-shadow: 0 0 5px #ccc; }
        button { background: #ff2e63; color: white; padding: 8px 10px; border: none; border-radius: 4px; }
    </style>
</head>
<body>
<h2>Your Cart</h2>
<?php
$items = $conn->query("SELECT cart.id AS cid, menu.item_name, menu.price FROM cart JOIN menu ON cart.item_id = menu.id WHERE cart.user_id=$uid");
$total = 0;
while($i = $items->fetch_assoc()){
    echo "<div class='cart-item'>";
    echo "{$i['item_name']} - Rs.{$i['price']}";
    echo "<button onclick=\"window.location.href='cart.php?remove={$i['cid']}'\">Remove</button>";
    echo "</div>";
    $total += $i['price'];
}
echo "<h3>Total: Rs.$total</h3>";
?>
<button onclick="location.href='place_order.php'">Place Order</button>
</body>
</html>
