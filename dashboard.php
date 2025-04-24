<?php
include 'db.php';
session_start();
if(!isset($_SESSION['user'])) header("Location: login.php");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard | FoodPanda Clone</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #fefefe;
            margin: 0;
            padding: 0;
        }
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #ff2e63;
            padding: 15px 25px;
            color: white;
            font-size: 20px;
        }
        .topbar h2 {
            margin: 0;
            font-size: 22px;
        }
        .topbar button {
            margin-left: 10px;
            padding: 8px 15px;
            background: white;
            color: #ff2e63;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }
        .topbar button:hover {
            background: #ffe4ec;
        }

        .container {
            padding: 30px 20px;
        }

        .restaurant {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.07);
            margin-bottom: 30px;
            overflow: hidden;
        }

        .restaurant-header {
            display: flex;
            align-items: center;
            padding: 15px;
        }

        .restaurant-header img {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            object-fit: cover;
            margin-right: 15px;
        }

        .restaurant-header h3 {
            margin: 0;
        }

        .restaurant-header p {
            margin: 5px 0 0;
            color: #666;
        }

        .items-container {
            display: flex;
            flex-wrap: wrap;
            padding: 0 15px 15px;
            gap: 15px;
        }

        .item {
            background: #f9f9f9;
            border-radius: 8px;
            width: 180px;
            padding: 10px;
            box-shadow: 0 0 6px rgba(0,0,0,0.05);
            text-align: center;
        }

        .item img {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: 6px;
        }

        .item h4 {
            margin: 10px 0 5px;
            font-size: 16px;
            color: #333;
        }

        .item p {
            margin: 0;
            color: #888;
        }

        .item button {
            margin-top: 8px;
            background: #ff2e63;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        .item button:hover {
            background: #e0275d;
        }
    </style>
</head>
<body>

<div class="topbar">
    <div style="display: flex; align-items: center;">
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e8/Foodpanda_logo.svg/2560px-Foodpanda_logo.svg.png" alt="FoodPanda" style="height: 35px; margin-right: 15px;">
        <h2>FoodPanda Dashboard</h2>
    </div>
    <div>
        <span style="margin-right: 10px;">👋 <?php echo htmlspecialchars($_SESSION['user']['username']); ?></span>
        <button onclick="location.href='cart.php'">🛒 Cart</button>
        <button onclick="location.href='order_history.php'">📜 Orders</button>
        <button onclick="location.href='logout.php'">🚪 Logout</button>
    </div>
</div>

<div class="container">
<?php
$restaurants = $conn->query("SELECT * FROM restaurants");
while($r = $restaurants->fetch_assoc()){
    $res_id = $r['id'];
    $res_img = !empty($r['image']) ? $r['image'] : 'https://source.unsplash.com/100x100/?restaurant,' . urlencode($r['name']);
    
    echo "<div class='restaurant'>";
    echo "<div class='restaurant-header'>";
    echo "<img src='$res_img' alt='Restaurant'>";
    echo "<div>";
    echo "<h3>" . htmlspecialchars($r['name']) . "</h3>";
    echo "<p>" . htmlspecialchars($r['cuisine']) . " | ⭐ " . $r['rating'] . " | ⏱ " . $r['delivery_time'] . " mins</p>";
    echo "</div></div>";

    // Fetch food items from menu
    $items = $conn->query("SELECT * FROM menu WHERE restaurant_id = $res_id LIMIT 4");
    echo "<div class='items-container'>";
    while($item = $items->fetch_assoc()){
        $item_img = !empty($item['image']) ? $item['image'] : 'https://source.unsplash.com/200x200/?' . urlencode($item['item_name']);
        echo "<div class='item'>";
        echo "<img src='$item_img' alt='Item'>";
        echo "<h4>" . htmlspecialchars($item['item_name']) . "</h4>";
        echo "<p>Rs " . $item['price'] . "</p>";
        echo "<button onclick=\"location.href='menu.php?rid=$res_id'\">View</button>";
        echo "</div>";
    }
    echo "</div></div>";
}
?>
</div>

</body>
</html>
