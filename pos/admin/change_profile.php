<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();

// Function to check password strength
function is_strong_password($password) {
    return preg_match('/[A-Z]/', $password) &&    // At least one uppercase letter
           preg_match('/[a-z]/', $password) &&    // At least one lowercase letter
           preg_match('/[0-9]/', $password) &&    // At least one number
           preg_match('/[\W_]/', $password) &&     // At least one special character
           strlen($password) >= 8;                 // Minimum length of 8 characters
}

// Update Profile
if (isset($_POST['ChangeProfile'])) {
    $admin_id = $_SESSION['admin_id'];
    $admin_name = $_POST['admin_name'];
    $admin_email = $_POST['admin_email'];
    $Qry = "UPDATE rpos_admin SET admin_name =?, admin_email =? WHERE admin_id =?";
    $postStmt = $mysqli->prepare($Qry);
    // Bind parameters
    $rc = $postStmt->bind_param('ssi', $admin_name, $admin_email, $admin_id);
    $postStmt->execute();
    
    // Variable to be passed to alert function
    if ($postStmt) {
        $success = "Account Updated";
        header("refresh:1; url=dashboard.php");
    } else {
        $err = "Please Try Again Or Try Later";
    }
}

// Change Password
if (isset($_POST['changePassword'])) {
    $error = 0;

    // Old Password
    if (isset($_POST['old_password']) && !empty($_POST['old_password'])) {
        $old_password = mysqli_real_escape_string($mysqli, trim(sha1(md5($_POST['old_password']))));
    } else {
        $error = 1;
        $err = "Old Password Cannot Be Empty";
    }

    // New Password
    if (isset($_POST['new_password']) && !empty($_POST['new_password'])) {
        $new_password = $_POST['new_password'];
    } else {
        $error = 1;
        $err = "New Password Cannot Be Empty";
    }

    // Confirm Password
    if (isset($_POST['confirm_password']) && !empty($_POST['confirm_password'])) {
        $confirm_password = $_POST['confirm_password'];
    } else {
        $error = 1;
        $err = "Confirmation Password Cannot Be Empty";
    }

    // Check for strong password
    if (!$error && !is_strong_password($new_password)) {
        $error = 1;
        $err = "Password must be at least 8 characters long and include at least (one uppercase letter, one lowercase letter, one number, and one special character.)";
    }

    if (!$error) {
        $admin_id = $_SESSION['admin_id'];
        $sql = "SELECT * FROM rpos_admin WHERE admin_id = '$admin_id'";
        $res = mysqli_query($mysqli, $sql);

        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            if ($old_password != $row['admin_password']) {
                $err = "Please Enter Correct Old Password";
            } elseif ($new_password != $confirm_password) {
                $err = "Confirmation Password Does Not Match";
            } else {
                // Hash the new password
                $new_password = sha1(md5($new_password));

                // Update the new password
                $query = "UPDATE rpos_admin SET admin_password =? WHERE admin_id =?";
                $stmt = $mysqli->prepare($query);
                $rc = $stmt->bind_param('si', $new_password, $admin_id);
                $stmt->execute();

                // Variable to be passed to alert function
                if ($stmt) {
                    $success = "Password Changed";
                    header("refresh:1; url=dashboard.php");
                } else {
                    $err = "Please Try Again Or Try Later";
                }
            }
        }
    }
}

require_once('partials/_head.php');
?>

<body>
  <!-- Sidenav -->
  <?php require_once('partials/_sidebar.php'); ?>
  <!-- Main content -->
  <div class="main-content">
    <!-- Top navbar -->
    <?php require_once('partials/_topnav.php'); ?>
    
    <?php
    $admin_id = $_SESSION['admin_id'];
    $ret = "SELECT * FROM rpos_admin WHERE admin_id = '$admin_id'";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute();
    $res = $stmt->get_result();
    
    while ($admin = $res->fetch_object()) {
    ?>
      <!-- Header -->
      <div class="header pb-8 pt-5 pt-lg-8 d-flex align-items-center" style="min-height: 600px; background-image: url(assets/img/theme/restro00.jpg); background-size: cover; background-position: center top;">
        <span class="mask bg-gradient-default opacity-8"></span>
        <div class="container-fluid d-flex align-items-center">
          <div class="row">
            <div class="col-lg-7 col-md-10">
              <h1 class="display-2 text-white">Hello <?php echo $admin->admin_name; ?></h1>
            </div>
          </div>
        </div>
      </div>
      <!-- Page content -->
      <div class="container-fluid mt--8">
        <div class="row">
          <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
            <div class="card card-profile shadow">
              <div class="row justify-content-center">
                <div class="col-lg-3 order-lg-2">
                  <div class="card-profile-image">
                    <a href="#">
                      <img src="assets/img/theme/user-a-min.png" class="rounded-circle">
                    </a>
                  </div>
                </div>
              </div>
              <div class="card-body pt-0 pt-md-4 text-center">
                <h3><?php echo $admin->admin_name; ?></h3>
                <div class="h5 font-weight-300">
                  <i class="ni location_pin mr-2"></i><?php echo $admin->admin_email; ?>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-8 order-xl-1">
            <div class="card bg-secondary shadow">
              <div class="card-header bg-white border-0">
                <h3 class="mb-0">My account</h3>
              </div>
              <div class="card-body">
                <form method="post">
                  <h6 class="heading-small text-muted mb-4">User information</h6>
                  <div class="pl-lg-4">
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label class="form-control-label" for="input-username">User Name</label>
                          <input type="text" name="admin_name" value="<?php echo $admin->admin_name; ?>" id="input-username" class="form-control form-control-alternative">
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label class="form-control-label" for="input-email">Email address</label>
                          <input type="email" id="input-email" value="<?php echo $admin->admin_email; ?>" name="admin_email" class="form-control form-control-alternative">
                        </div>
                      </div>
                      <div class="col-lg-12">
                        <div class="form-group">
                          <input type="submit" id="input-email" name="ChangeProfile" class="btn btn-success form-control-alternative" value="Submit">
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
                <hr>
                <form method="post">
                  <h6 class="heading-small text-muted mb-4">Change Password</h6>
                  <div class="pl-lg-4">
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="form-group">
                          <label class="form-control-label" for="input-old-password">Old Password</label>
                          <input type="password" name="old_password" id="input-old-password" class="form-control form-control-alternative">
                        </div>
                      </div>
                      <div class="col-lg-12">
                        <div class="form-group">
                          <label class="form-control-label" for="input-new-password">New Password</label>
                          <input type="password" name="new_password" class="form-control form-control-alternative">
                        </div>
                      </div>
                      <div class="col-lg-12">
                        <div class="form-group">
                          <label class="form-control-label" for="input-confirm-password">Confirm New Password</label>
                          <input type="password" name="confirm_password" class="form-control form-control-alternative">
                        </div>
                      </div>
                      <div class="col-lg-12">
                        <div class="form-group">
                          <input type="submit" id="input-email" name="changePassword" class="btn btn-success form-control-alternative" value="Change Password">
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- Footer -->
        <?php require_once('partials/_footer.php'); ?>
      </div>
    </div>
    <?php } ?>
  </div>
  <!-- Argon Scripts -->
  <?php require_once('partials/_sidebar.php'); ?>
</body>

</html>
