<?php include 'db.php'; session_start(); $uid = $_SESSION['user']['id'];
$items = $conn->query("SELECT item_id FROM cart WHERE user_id=$uid");
while($i = $items->fetch_assoc()){
    $conn->query("INSERT INTO orders(user_id, item_id, status) VALUES($uid, {$i['item_id']}, 'Preparing')");
}
$conn->query("DELETE FROM cart WHERE user_id=$uid");
echo "<script>alert('Order placed!'); window.location.href='track_order.php';</script>";
?>
