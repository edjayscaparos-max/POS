<?php
session_start();
include('config/config.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Initialize login data if not set
if (!isset($_SESSION['login_data'])) {
    $_SESSION['login_data'] = [];
}

// Set maximum allowed attempts and lockout duration
$max_attempts = 3;
$lockout_duration = 60; // in seconds

if (isset($_POST['login'])) {
    $admin_email = $_POST['admin_email'];
    $admin_password = sha1(md5($_POST['admin_password'])); // double encrypt for security

    // Check if this email is already in the session
    if (!isset($_SESSION['login_data'][$admin_email])) {
        $_SESSION['login_data'][$admin_email] = [
            'attempts' => 0,
            'lockout_time' => 0
        ];
    }

    // Check lockout status
    if ($_SESSION['login_data'][$admin_email]['lockout_time'] > time()) {
        $remaining_time = $_SESSION['login_data'][$admin_email]['lockout_time'] - time();
        $err = "Too many login attempts for this email. Please try again in " . ceil($remaining_time) . " seconds.";
    } else {
        // Prepare statement for user authentication
        $stmt = $mysqli->prepare("SELECT admin_email, admin_password, admin_id FROM rpos_admin WHERE admin_email = ? AND admin_password = ?");
        $stmt->bind_param('ss', $admin_email, $admin_password);
        $stmt->execute();
        $stmt->bind_result($db_email, $db_password, $admin_id);
        $rs = $stmt->fetch();

        if ($rs) {
            // Successful login
            $_SESSION['admin_id'] = $admin_id;
            $_SESSION['login_data'][$admin_email]['attempts'] = 0; // Reset attempts on success

            // Generate a verification code
            $verification_code = rand(100000, 999999);
            $_SESSION['verification_code'] = $verification_code;

            // Send the verification code to the user's email
            $mail = new PHPMailer(true);
            try {
                // Configure PHPMailer
                $mail->isSMTP();
                $mail->Host = 'smtp.example.com'; // Replace with your SMTP server
                $mail->SMTPAuth = true;
                $mail->Username = 'your-email@example.com'; // Replace with your email
                $mail->Password = 'your-email-password'; // Replace with your email password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('your-email@example.com', 'Your Name'); // Replace with your name
                $mail->addAddress($admin_email);
                $mail->Subject = 'Your Verification Code';
                $mail->Body = "Your verification code is: $verification_code";

                $mail->send();
                header("location:verify.php"); // Redirect to verification page
                exit();
            } catch (Exception $e) {
                $err = "Could not send verification email. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            // Incorrect credentials
            $_SESSION['login_data'][$admin_email]['attempts']++; // Increment attempts

            // Lockout user if attempts exceed max
            if ($_SESSION['login_data'][$admin_email]['attempts'] >= $max_attempts) {
                $_SESSION['login_data'][$admin_email]['lockout_time'] = time() + $lockout_duration; // Set lockout time
                $err = "Too many login attempts. Please try again in $lockout_duration seconds.";
            } else {
                $err = "Incorrect Authentication Credentials. Attempts left: " . ($max_attempts - $_SESSION['login_data'][$admin_email]['attempts']);
            }
        }
    }
}

require_once('partials/_head.php');
?>

<body class="bg-dark">
    <div class="main-content">
        <div class="header bg-gradient-primary py-7">
            <div class="container">
                <div class="header-body text-center mb-7">
                    <div class="row justify-content-center">
                        <div class="col-lg-5 col-md-6">
                            <h1 class="text-white">ADMIN LOGIN FORM</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mt--8 pb-5">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-7">
                    <div class="card bg-secondary shadow border-0">
                        <div class="card-body px-lg-5 py-lg-5">
                            <?php if (isset($err)): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo $err; ?>
                                </div>
                            <?php endif; ?>
                            <form method="post" role="form">
                                <div class="form-group mb-3">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                        </div>
                                        <input class="form-control" required name="admin_email" placeholder="Email" type="email">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                        </div>
                                        <input class="form-control" required name="admin_password" placeholder="Password" type="password">
                                    </div>
                                </div>
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input class="custom-control-input" id="customCheckLogin" type="checkbox">
                                    <label class="custom-control-label" for="customCheckLogin">
                                        <span class="text-muted">Remember Me</span>
                                    </label>
                                </div>
                                <div class="">
                                    <button type="submit" name="login" class="btn btn-primary my-4">Log In</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6">
                            <!-- <a href="forgot_pwd.php" class="text-light"><small>Forgot password?</small></a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once('partials/_footer.php'); ?>
    <?php require_once('partials/_scripts.php'); ?>
</body>
</html>
