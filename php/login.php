<?php
include("connection.php");

$email = $password = "";
$emailErr = $passwordErr = "";

if (isset($_POST['login'])) {
    $email = test_input($_POST['email']);
    $password = test_input($_POST['password']);

    // Validation for Email
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
    }

    // Validation for Password
    if (empty($password)) {
        $passwordErr = "Password is required";
    }

    // If there are no validation errors, proceed with login
    if ($emailErr === "" && $passwordErr === "") {
        // Check if user exists in the database
        $query = "SELECT * FROM registration WHERE Email='$email'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            // Verify password
            if ($password===$user['Password']) {
                // Password is correct, set session variables and redirect
                session_start();
                // $_SESSION['user_id'] = $user['Id'];
                $_SESSION['email'] = $user['Email']; // Storing email in session
                header("Location: dashboard.php"); // Redirect to dashboard or any other page
                exit();
            } else {
                // Password is incorrect
                $passwordErr = "Incorrect password";
            }
        } else {
            // User not found
            $emailErr = "User not found";
        }
    }
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Codingkart</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;1,500;1,600;1,700;1,900&display=swap" rel="stylesheet">
     <link href="css/font-awesome.min.css" type="text/css" rel="stylesheet">
     <link href="css/bootstrap.min.css" type="text/css" rel="stylesheet">
    <link href="css/global_fonts_style.css" type="text/css" rel="stylesheet">
     <link href="css/style.css" type="text/css" rel="stylesheet">
     <link href="css/responsive.css" type="text/css" rel="stylesheet">
</head>
<body>
    
    
    <section class="main-banner">
        <div class="container">
            <div class="row">
               <div class="col-md-12">
                   <h1>Codingkart Test</h1>
                </div>
            </div>
        </div>
    </section>
    
    <section class="nav-banner">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="navs">
                        <ul>
                        <li><a href="signup.php">Sign Up</a></li>
                         <li><a href="login.php"  class="active">Login</a></li>
                         <li><a href="property.php">Add Property</a></li>
                         <li><a href="property-list.php" >List Property</a></li>
                         <li><a href="search-page.php">Search Property</a></li>
                         <li><a href="dashboard.php">Dashboard</a></li>
                        </ul>
                        <a href="#" class="mobile-icon"><i class="fa fa-bars" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section class="main-content paddnig80">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="main-width">
                        <h2>Login</h2>
                        <form class="login-form" method="POST" action="login.php">
                            <div class="form-field">
                                <label>Email Address*</label>
                                <input type="email" name="email" placeholder="Enter your Email Address">
                                <span class="error"><?php echo isset($emailErr) ? $emailErr : ''; ?></span>
                            </div>
                            <div class="form-field">
                                <label>Password*</label>
                                <input type="password" name="password" placeholder="Enter Password">
                                <span class="error"><?php echo isset($passwordErr) ? $passwordErr : ''; ?></span>
                                <div class="formcheck">
                                    <input type="checkbox" id="remember" name="remember" checked>
                                    <label for="remember">Remember me</label>
                                </div>
                                <a href="#" class="forgetpwd">Forgot password?</a>
                            </div>
                            <div class="form-field">
                                <input type="submit" name="login" value="Login"> 
                            </div>
                            <p class="alredy-sign">Don't have an account? <a href="signup.html"><u>Sign up now</u></a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>    
    
    <script src="js/jquery-3.5.1.min.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
 <script src="js/script.js" type="text/javascript"></script>
    </body>
</html>



