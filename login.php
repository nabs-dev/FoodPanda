<?php include 'db.php'; session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body { font-family: sans-serif; background: #f0f0ff; padding: 40px; }
        form { max-width: 400px; margin: auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        input { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 6px; }
        button { background: #ff2e63; color: white; padding: 10px; border: none; border-radius: 6px; cursor: pointer; }
    </style>
</head>
<body>
<form method="post">
    <h2>Login</h2>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button name="login">Login</button>
</form>
<?php
if(isset($_POST['login'])){
    $e = $_POST['email'];
    $p = md5($_POST['password']);
    $q = $conn->query("SELECT * FROM users WHERE email='$e' AND password='$p'");
    if($q->num_rows > 0){
        $_SESSION['user'] = $q->fetch_assoc();
        echo "<script>window.location.href='dashboard.php'</script>";
    } else {
        echo "<script>alert('Invalid credentials');</script>";
    }
}
?>
</body>
</html>
