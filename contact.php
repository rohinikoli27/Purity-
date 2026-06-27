<?php include("header.php"); ?>
<?php include("db.php"); ?>

<?php
$message = "";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $msg = $_POST['message'];

    $stmt = mysqli_prepare($conn, "INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sss", $name, $email, $msg);

    if(mysqli_stmt_execute($stmt)){
        $message = "✅ Thank you, " . htmlspecialchars($name) . "! Your message has been received.";
    } else {
        $message = "❌ Something went wrong. Please try again.";
    }

    mysqli_stmt_close($stmt);
}
?>

<main>
<section class="contact-section">

    <div class="contact-form-box">

        <h2>Get In Touch</h2>
        <p class="contact-sub">We'd love to hear from you. Fill out the form and we'll respond as soon as we can.</p>

        <?php if($message): ?>
            <p class="form-success"><?php echo $message; ?></p>
        <?php endif; ?>

        <form action="contact.php" method="POST">

            <label>Your Name</label>
            <input type="text" name="name" placeholder="Enter your name" required>

            <label>Email Address</label>
            <input type="email" name="email" placeholder="Enter your email" required>

            <label>Message</label>
            <textarea name="message" rows="5" placeholder="Write your message here..." required></textarea>

            <button type="submit" class="btn-submit">Send Message</button>

        </form>

        <div class="contact-info">
            <p><i class="fa fa-envelope"></i> purity.handmade@gmail.com</p>
            <p><i class="fa fa-phone"></i> +91 98765 43210</p>
            <p><i class="fa fa-location-dot"></i> Nagpur, Maharashtra, India</p>
        </div>

    </div>

    <div class="contact-map">
        <iframe
            src="https://maps.google.com/maps?q=Nagpur,Maharashtra&t=&z=12&ie=UTF8&iwloc=&output=embed"
            width="100%"
            height="100%"
            style="border:0;"
            allowfullscreen=""
            loading="lazy">
        </iframe>
    </div>

</section>
</main>

<?php include("footer.php"); ?>