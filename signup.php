<?php include 'db.php'; session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
    <style>
        body { font-family: sans-serif; background: #fff5f8; padding: 40px; }
        form { max-width: 400px; margin: auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        input { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 6px; }
        button { background: #ff2e63; color: white; padding: 10px; border: none; border-radius: 6px; cursor: pointer; }
    </style>
</head>
<body>
<form method="post">
    <h2>Create Account</h2>
    <input type="text" name="username" placeholder="Username" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button name="signup">Signup</button>
    <p>Already have an account? <a href="login.php">Login</a></p>
</form>
<?php
if(isset($_POST['signup'])){
    $u = $_POST['username'];
    $e = $_POST['email'];
    $p = md5($_POST['password']);
    $conn->query("INSERT INTO users(username,email,password) VALUES('$u','$e','$p')");
    echo "<script>window.location.href='login.php'</script>";
}
?>
</body>
</html>
