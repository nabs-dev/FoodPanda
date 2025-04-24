<?php
include 'db.php';
session_start();
if(!isset($_SESSION['user'])) header("Location: login.php");

if(!isset($_GET['rid'])) {
    echo "Restaurant not found!";
    exit;
}

$rid = $_GET['rid'];
$restaurant = $conn->query("SELECT * FROM restaurants WHERE id = $rid")->fetch_assoc();
$items = $conn->query("SELECT * FROM menu WHERE restaurant_id = $rid");
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($restaurant['name']); ?> | Menu</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #fdfdfd;
            padding: 0;
            margin: 0;
        }
        .topbar {
            background: #ff2e63;
            color: white;
            padding: 15px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .topbar h2 {
            margin: 0;
        }
        .topbar button {
            padding: 8px 14px;
            background: white;
            color: #ff2e63;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }
        .topbar button:hover {
            background: #ffe5ec;
        }
        .container {
            padding: 30px 20px;
        }
        h3 {
            margin-bottom: 10px;
            font-size: 24px;
        }
        .menu-items {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .item {
            background: white;
            width: 220px;
            border-radius: 10px;
            padding: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.08);
            transition: 0.3s;
        }
        .item:hover {
            transform: scale(1.03);
        }
        .item img {
            width: 100%;
            height: 140px;
            object-fit: cover;
            border-radius: 8px;
        }
        .item h4 {
            margin: 10px 0 5px;
            font-size: 18px;
        }
        .item p {
            margin: 0;
            color: #777;
        }
        .item form {
            margin-top: 10px;
        }
        .item button {
            background: #ff2e63;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .item button:hover {
            background: #e0275d;
        }
    </style>
</head>
<body>

<div class="topbar">
    <h2><?php echo htmlspecialchars($restaurant['name']); ?> | Menu</h2>
    <div>
        <button onclick="location.href='dashboard.php'">🏠 Home</button>
        <button onclick="location.href='cart.php'">🛒 Cart</button>
        <button onclick="location.href='logout.php'">🚪 Logout</button>
    </div>
</div>

<div class="container">
    <h3>🍽️ Available Items</h3>
    <div class="menu-items">
        <?php
        while($item = $items->fetch_assoc()){
            $img = !empty($item['image']) ? $item['image'] : 'https://source.unsplash.com/200x140/?' . urlencode($item['item_name']);
            echo "<div class='item'>";
            echo "<img src='$img' alt='Food'>";
            echo "<h4>" . htmlspecialchars($item['item_name']) . "</h4>";
            echo "<p>Rs " . $item['price'] . "</p>";
            echo "<form method='POST' action='add_to_cart.php'>";
            echo "<input type='hidden' name='item_id' value='{$item['id']}'>";
            echo "<input type='hidden' name='rid' value='{$rid}'>";
            echo "<button type='submit'>Add to Cart</button>";
            echo "</form>";
            echo "</div>";
        }
        ?>
    </div>
</div>

</body>
</html>
