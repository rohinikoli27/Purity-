<?php include("../db.php"); ?>

<?php
$error = "";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE email=? AND is_admin=1");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $admin = mysqli_fetch_assoc($result);
    var_dump($admin);
    var_dump($password);

    if($admin && password_verify($password, $admin['password'])){
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_name'] = $admin['name'];
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid admin credentials.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Login - Purity</title>
<link rel="stylesheet" href="../assets/css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body class="admin-body">

<div class="auth-section">
    <div class="auth-card">

        <h3 style="text-align:center;font-family:serif;color:#2b221c;margin-bottom:20px;">Purity Admin Login</h3>

        <?php if($error): ?>
            <p class="auth-error"><?php echo $error; ?></p>
        <?php endif; ?>

        <form method="POST" action="admin-login.php">

            <div class="input-group">
                <i class="fa fa-envelope"></i>
                <input type="email" name="email" placeholder="Admin Email" required>
            </div>

            <div class="input-group">
                <i class="fa fa-lock"></i>
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <button type="submit" class="btn-submit">Login</button>

        </form>

    </div>
</div>

</body>
</html>