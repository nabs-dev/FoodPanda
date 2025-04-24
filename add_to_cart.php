<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['item_id']) && isset($_POST['rid'])) {
    $user_id = $_SESSION['user']['id'];
    $item_id = intval($_POST['item_id']);
    $rid = intval($_POST['rid']);

    // Check if item already exists in the cart
    $check = $conn->prepare("SELECT id FROM cart WHERE user_id = ? AND item_id = ?");
    $check->bind_param("ii", $user_id, $item_id);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows == 0) {
        $insert = $conn->prepare("INSERT INTO cart (user_id, item_id) VALUES (?, ?)");
        $insert->bind_param("ii", $user_id, $item_id);
        $insert->execute();
    }

    header("Location: menu.php?rid=" . $rid);
    exit;
} else {
    echo "Invalid request. Please go back.";
}
?>
