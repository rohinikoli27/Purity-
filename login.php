<?php include("header.php"); ?>
<?php include("db.php"); ?>

<?php
$loginError = "";
$registerError = "";
$registerSuccess = "";

// LOGIN HANDLING
if(isset($_POST['login_submit'])){
    $email = $_POST['login_email'];
    $password = $_POST['login_password'];

    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE email=?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if($user && password_verify($password, $user['password'])){
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        header("Location: index.php");
        exit();
    } else {
        $loginError = "Invalid email or password.";
    }
}

// REGISTER HANDLING
if(isset($_POST['register_submit'])){
    $name = $_POST['reg_name'];
    $email = $_POST['reg_email'];
    $password = $_POST['reg_password'];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $check = mysqli_prepare($conn, "SELECT id FROM users WHERE email=?");
    mysqli_stmt_bind_param($check, "s", $email);
    mysqli_stmt_execute($check);
    mysqli_stmt_store_result($check);

    if(mysqli_stmt_num_rows($check) > 0){
        $registerError = "An account with this email already exists.";
    } else {
        $stmt = mysqli_prepare($conn, "INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sss", $name, $email, $hashedPassword);

        if(mysqli_stmt_execute($stmt)){
            $registerSuccess = "Account created successfully! Please login.";
        } else {
            $registerError = "Something went wrong. Please try again.";
        }
    }
}
?>

<main>
<section class="auth-section">

    <div class="auth-card">

        <div class="auth-logo">
            <img src="assets/images/logo.png" alt="Purity">
            <h2>PURITY</h2>
        </div>

        <!-- TAB SWITCHER -->
        <div class="auth-tabs">
            <button id="tabLogin" class="tab-btn active" onclick="showLogin()">Login</button>
            <button id="tabRegister" class="tab-btn" onclick="showRegister()">Register</button>
        </div>

        <!-- LOGIN FORM -->
        <div id="loginBox" class="auth-box">

            <h3>Welcome Back</h3>
            <p class="auth-subtext">Login to continue shopping handmade treasures.</p>

            <?php if($loginError): ?>
                <p class="auth-error"><i class="fa fa-circle-exclamation"></i> <?php echo $loginError; ?></p>
            <?php endif; ?>

            <?php if($registerSuccess): ?>
                <p class="auth-success"><i class="fa fa-circle-check"></i> <?php echo $registerSuccess; ?></p>
            <?php endif; ?>

            <form method="POST" action="login.php">

                <div class="input-group">
                    <i class="fa fa-envelope"></i>
                    <input type="email" name="login_email" placeholder="Email Address" required>
                </div>

                <div class="input-group">
                    <i class="fa fa-lock"></i>
                    <input type="password" name="login_password" id="loginPassword" placeholder="Password" required>
                    <i class="fa fa-eye toggle-eye" onclick="togglePassword('loginPassword', this)"></i>
                </div>

                <div class="form-options">
                    <label><input type="checkbox"> Remember me</label>
                    <a href="#" class="forgot-link">Forgot Password?</a>
                </div>

                <button type="submit" name="login_submit" class="btn-submit">Login</button>

            </form>

        </div>

        <!-- REGISTER FORM -->
        <div id="registerBox" class="auth-box" style="display:none;">

            <h3>Create Your Account</h3>
            <p class="auth-subtext">Join Purity and discover handcrafted favorites.</p>

            <?php if($registerError): ?>
                <p class="auth-error"><i class="fa fa-circle-exclamation"></i> <?php echo $registerError; ?></p>
            <?php endif; ?>

            <form method="POST" action="login.php">

                <div class="input-group">
                    <i class="fa fa-user"></i>
                    <input type="text" name="reg_name" placeholder="Full Name" required>
                </div>

                <div class="input-group">
                    <i class="fa fa-envelope"></i>
                    <input type="email" name="reg_email" placeholder="Email Address" required>
                </div>

                <div class="input-group">
                    <i class="fa fa-lock"></i>
                    <input type="password" name="reg_password" id="regPassword" placeholder="Create Password" required>
                    <i class="fa fa-eye toggle-eye" onclick="togglePassword('regPassword', this)"></i>
                </div>

                <p class="terms-text">By registering, you agree to our Terms & Privacy Policy.</p>

                <button type="submit" name="register_submit" class="btn-submit">Create Account</button>

            </form>

        </div>

    </div>

</section>
</main>

<?php include("footer.php"); ?>

<script>
function showRegister(){
    document.getElementById('loginBox').style.display = 'none';
    document.getElementById('registerBox').style.display = 'block';
    document.getElementById('tabLogin').classList.remove('active');
    document.getElementById('tabRegister').classList.add('active');
}

function showLogin(){
    document.getElementById('registerBox').style.display = 'none';
    document.getElementById('loginBox').style.display = 'block';
    document.getElementById('tabRegister').classList.remove('active');
    document.getElementById('tabLogin').classList.add('active');
}

function togglePassword(fieldId, icon){
    const field = document.getElementById(fieldId);
    if(field.type === 'password'){
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

<?php if($registerError || isset($_POST['register_submit'])): ?>
showRegister();
<?php endif; ?>
</script>