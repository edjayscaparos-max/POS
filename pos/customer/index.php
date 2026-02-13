<?php
session_start();
include('config/config.php');

// Initialize login attempts and lockout time if not set
if (!isset($_SESSION['customer_login_data'])) {
    $_SESSION['customer_login_data'] = []; // Store login data for each email
}

// Set maximum allowed attempts and lockout duration
$max_attempts = 3;
$lockout_duration = 60; // in seconds

// Login 
if (isset($_POST['login'])) {
    $customer_email = $_POST['customer_email'];
    $customer_password = sha1(md5($_POST['customer_password'])); // double encrypt for security

    // Check if this email is already in the session
    if (!isset($_SESSION['customer_login_data'][$customer_email])) {
        // Initialize login data for this email
        $_SESSION['customer_login_data'][$customer_email] = [
            'attempts' => 0,
            'lockout_time' => 0
        ];
    }

    // Check if the user is currently locked out
    if ($_SESSION['customer_login_data'][$customer_email]['lockout_time'] > time()) {
        $remaining_time = $_SESSION['customer_login_data'][$customer_email]['lockout_time'] - time();
        $err = "Too many login attempts. Please try again in " . ceil($remaining_time) . " seconds.";
    } else {
        // Prepare statement for user authentication
        $stmt = $mysqli->prepare("SELECT customer_email, customer_password, customer_id FROM rpos_customers WHERE customer_email = ? AND customer_password = ?");
        $stmt->bind_param('ss', $customer_email, $customer_password);
        $stmt->execute();
        $stmt->bind_result($db_email, $db_password, $customer_id);
        $rs = $stmt->fetch();

        if ($rs) {
            // Successful login
            $_SESSION['customer_id'] = $customer_id;
            $_SESSION['customer_login_data'][$customer_email]['attempts'] = 0; // Reset attempts on success
            header("location:dashboard.php");
            exit();
        } else {
            $_SESSION['customer_login_data'][$customer_email]['attempts']++; // Increment attempts

            // Lockout user if attempts exceed max
            if ($_SESSION['customer_login_data'][$customer_email]['attempts'] >= $max_attempts) {
                $_SESSION['customer_login_data'][$customer_email]['lockout_time'] = time() + $lockout_duration; // Set lockout time
                $err = "Too many login attempts. Please try again in $lockout_duration seconds.";
            } else {
                $err = "Incorrect Authentication Credentials. Attempts left: " . ($max_attempts - $_SESSION['customer_login_data'][$customer_email]['attempts']);
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
                            <h1 class="text-white">CUSTOMER LOGIN FORM</h1>
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
                                        <input class="form-control" required name="customer_email" placeholder="Email" type="email">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                        </div>
                                        <input class="form-control" required name="customer_password" placeholder="Password" type="password">
                                    </div>
                                </div>
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input class="custom-control-input" id="customCheckLogin" type="checkbox">
                                    <label class="custom-control-label" for="customCheckLogin">
                                        <span class="text-muted">Remember me</span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <div class="text-left">
                                        <button type="submit" name="login" class="btn btn-primary my-4">Log In</button>
                                        <a href="create_account.php" class="btn btn-success pull-right">Create Account</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6">
                            <!-- <a href="../admin/forgot_pwd.php" target="_blank" class="text-light"><small>Forgot password?</small></a> -->
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
