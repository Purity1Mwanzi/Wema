<?php
session_start();
if (isset($_SESSION['SESSION_EMAIL'])) {
    header("Location: home.php");
    die();
}

include 'config.php';
$msg = "";


if (isset($_POST['submit'])) {
    // Validate name
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    if (empty($name) || !preg_match("/^[a-zA-Z ]*$/", $name)) {
        $msg = "<div class='alert alert-danger'>Invalid name format.</div>";
    } else {
        // Validate email
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $msg = "<div class='alert alert-danger'>Invalid email format.</div>";
        } else {
            // Check if the email address belongs to the domain gmail.com
            $domain = explode('@', $email)[1];
            if ($domain !== 'gmail.com') {
                $msg = "<div class='alert alert-danger'>Only email addresses from gmail.com are allowed.</div>";
            } else {
                // Validate password
                $password = mysqli_real_escape_string($conn, $_POST['password']);
                $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm-password']);
                if (empty($password)) {
                    $msg = "<div class='alert alert-danger'>Password cannot be empty.</div>";
                } elseif ($password !== $confirm_password) {
                    $msg = "<div class='alert alert-danger'>Password and Confirm Password do not match.</div>";
                } else {
                    // All fields are valid, proceed with registration
                    $password = md5($password); // Hash the password for storage
                    $sql = "INSERT INTO users (name, email, password) VALUES ('{$name}', '{$email}', '{$password}')";
                    $result = mysqli_query($conn, $sql);
                    if ($result) {
                        $msg = "<div class='alert alert-info'>Registration successful.</div>";
                    } else {
                        $msg = "<div class='alert alert-danger'>Something went wrong.</div>";
                    }
                }
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Rentals</title>
    <!-- Meta tag Keywords -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />
    <meta name="keywords" content="Login Form" />
    <!-- //Meta tag Keywords -->

    <link href="//fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!--/Style-CSS -->
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
    <!--//Style-CSS -->

    <script src="https://kit.fontawesome.com/af562a2a63.js" crossorigin="anonymous"></script>

</head>

<body>

    <!-- form section start -->
    <section class="w3l-mockup-form">
        <div class="container">
            <!-- /form -->
            <div class="workinghny-form-grid">
                <div class="main-mockup">

                    <div class="w3l_form align-self">

                        <div class="left_grid_info">
                            <img src="images\image.svg" alt="">
                        </div>
                    </div>
                    <div class="content-wthree">
                        <h2>Get Started</h2>
                        <?php echo $msg; ?>
                        <form action="" method="post">
                            <input type="text" class="name" name="name" placeholder="Enter Your Name"
                                value="<?php if (isset($_POST['submit'])) {
                                    echo $name;
                                } ?>" required>
                            <input type="email" class="email" name="email" placeholder="Enter Your Email"
                                value="<?php if (isset($_POST['submit'])) {
                                    echo $email;
                                } ?>" required>
                            <input type="password" class="password" name="password" placeholder="Enter Your Password"
                                required>
                            <input type="password" class="confirm-password" name="confirm-password"
                                placeholder="Enter Your Confirm Password" required>
                            <button name="submit" class="btn" type="submit">Register</button>
                        </form>
                        <div class="social-icons">
                            <p>Have an account! <a href="index.php">Login</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- //form -->
        </div>
    </section>
    <!-- //form section start -->

    <script src="js/jquery.min.js"></script>
    <script>
        $(document).ready(function (c) {
            $('.alert-close').on('click', function (c) {
                $('.main-mockup').fadeOut('slow', function (c) {
                    $('.main-mockup').remove();
                });
            });
        });
    </script>

</body>

</html>