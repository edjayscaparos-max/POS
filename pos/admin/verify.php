<?php
session_start();

if (isset($_POST['verify'])) {
    $input_code = $_POST['verification_code'];

    if ($input_code == $_SESSION['verification_code']) {
        // Successful verification
        echo "Welcome! You are now logged in.";
        // Redirect to the admin dashboard or home page
        // header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid verification code.";
    }
}
?>

<!-- Verification Form -->
<form method="post">
    <input type="text" name="verification_code" required placeholder="Enter Verification Code">
    <button type="submit" name="verify">Verify</button>
</form>
