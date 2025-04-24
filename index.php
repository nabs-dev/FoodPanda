<?php
include 'db.php';
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>FoodPanda Clone</title>
    <style>
        body { font-family: Arial; margin: 0; background: #f8f8f8; }
        header { background: #ff2e63; color: white; padding: 20px; text-align: center; font-size: 28px; }
        .container { padding: 20px; }
        .restaurant {
            background: white;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .filters {
            margin-bottom: 20px;
            text-align: right;
        }
        button {
            padding: 10px 15px;
            background: #ff2e63;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 10px;
            font-weight: bold;
        }
        button:hover {
            background: #e0275d;
        }
        .welcome {
            float: left;
            font-weight: bold;
            font-size: 16px;
            padding-top: 10px;
        }
        .topbar {
            overflow: auto;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<header>🍔 FoodPanda Clone</header>

<div class="container">
    <div class="topbar">
        <div class="welcome">
            <?php
            if (isset($_SESSION['username'])) {
                echo "👋 Welcome, " . htmlspecialchars($_SESSION['username']) . "!";
            }
            ?>
        </div>
        <div class="filters">
            <?php if (isset($_SESSION['user_id'])) { ?>
                <button onclick="goToPage('cart.php')">🛒 Cart</button>
                <button onclick="goToPage('orders.php')">📦 Order History</button>
                <button onclick="goToPage('logout.php')">🚪 Logout</button>
            <?php } else { ?>
                <button onclick="goToPage('login.php')">🔐 Login</button>
                <button onclick="goToPage('signup.php')">📝 Signup</button>
            <?php } ?>
        </div>
    </div>

    <?php
    $restaurants = $conn->query("SELECT * FROM restaurants");
    while($row = $restaurants->fetch_assoc()) {
        echo "<div class='restaurant'>";
        echo "<h3>{$row['name']}</h3>";
        echo "<p>Cuisine: {$row['cuisine']} | Rating: {$row['rating']} ⭐ | Delivery: {$row['delivery_time']} mins</p>";
        echo "<button onclick=\"goToMenu({$row['id']})\">View Menu</button>";
        echo "</div>";
    }
    ?>
</div>

<script>
    function goToMenu(id) {
        window.location.href = 'menu.php?rid=' + id;
    }
    function goToPage(page) {
        window.location.href = page;
    }
</script>

</body>
</html>
