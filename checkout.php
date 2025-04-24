<?php
include 'db.php';
session_start();
if(!isset($_SESSION['user'])) header("Location: login.php");

$user_id = $_SESSION['user']['id'];
$cart_items = $conn->query("SELECT c.*, m.item_name, m.price FROM cart c JOIN menu m ON c.item_id = m.id WHERE c.user_id = $user_id");

$total = 0;
$items = [];

while ($row = $cart_items->fetch_assoc()) {
    $items[] = $row;
    $total += $row['price'] * $row['quantity'];
}

// Handle order placement
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($items as $item) {
        $item_id = $item['item_id'];
        $qty = $item['quantity'];
        $conn->query("INSERT INTO orders (user_id, item_id, quantity) VALUES ($user_id, $item_id, $qty)");
    }
    $conn->query("DELETE FROM cart WHERE user_id = $user_id");
    header("Location: order_history.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <style>
        body { font-family: Arial, sans-serif; background: #fffaf8; margin: 0; padding: 0; }
        .header {
            background: #ff2e63;
            color: white;
            padding: 15px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h2 { margin: 0; }
        .header button {
            background: white;
            color: #ff2e63;
            border: none;
            padding: 8px 14px;
            border-radius: 5px;
            cursor: pointer;
        }
        .header button:hover { background: #ffe5ec; }
        .container {
            padding: 30px 20px;
            max-width: 800px;
            margin: auto;
        }
        h3 { margin-bottom: 20px; font-size: 26px; }
        .item {
            background: white;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 8px;
            box-shadow: 0 0 8px rgba(0,0,0,0.08);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .item-details {
            display: flex;
            flex-direction: column;
        }
        .item-name { font-weight: bold; font-size: 18px; }
        .price { color: #777; }
        .total-box {
            text-align: right;
            font-size: 20px;
            margin-top: 20px;
        }
        .checkout-btn {
            background: #ff2e63;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
        }
        .checkout-btn:hover {
            background: #e0275d;
        }
    </style>
</head>
<body>

<div class="header">
    <h2>🧾 Checkout</h2>
    <div>
        <button onclick="location.href='dashboard.php'">🏠 Home</button>
        <button onclick="location.href='logout.php'">🚪 Logout</button>
    </div>
</div>

<div class="container">
    <h3>Your Order Summary</h3>

    <?php if (count($items) == 0): ?>
        <p>Your cart is empty. <a href="dashboard.php">Go to Menu</a></p>
    <?php else: ?>
        <?php foreach ($items as $item): ?>
            <div class="item">
                <div class="item-details">
                    <span class="item-name"><?php echo htmlspecialchars($item['item_name']); ?></span>
                    <span class="price">Rs <?php echo $item['price']; ?> × <?php echo $item['quantity']; ?></span>
                </div>
                <div><strong>Rs <?php echo $item['price'] * $item['quantity']; ?></strong></div>
            </div>
        <?php endforeach; ?>
        <div class="total-box">
            Total: <strong>Rs <?php echo $total; ?></strong>
        </div>
        <form method="POST">
            <button class="checkout-btn" type="submit">✅ Place Order</button>
        </form>
    <?php endif; ?>
</div>

</body>
</html>
