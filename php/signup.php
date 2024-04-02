<?php
include("connection.php");

$first_nameErr = $last_nameErr = $emailErr = $passwordErr = $confirm_passwordErr = $phone_numberErr = $addressErr = $upload_imageErr = "";

$first_name = $last_name = $email = $password = $confirm_password = $phone_number = $address = $upload_image = $success = '';
$uploaded='';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = test_input($_POST['first_name']);
    $last_name = test_input($_POST['last_name']);
    $email = test_input($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $phone_number = test_input($_POST['phone_number']);
    $address = test_input($_POST['address']);

    // Image upload logic
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    // $uploaded = 'uploaded';
    if ($_FILES["profile_picture"]["name"] != '') {
        
        // Check if file is an image
        $check = getimagesize($_FILES["profile_picture"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
            
        } else {
            $upload_imageErr = "File is not an image.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["profile_picture"]["size"] > 500000) {
            $upload_imageErr = "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $upload_imageErr = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $upload_imageErr = "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
                $upload_image = "File " . htmlspecialchars(basename($_FILES["profile_picture"]["name"])) . " has been uploaded.";
                $uploaded='Uploaded';
            } else {
                $upload_imageErr = "Sorry, there was an error uploading your file.";
            }
        }
    }
    if (empty($first_name) || !preg_match("/^[a-zA-Z-' ]*$/", $first_name)) {
        $first_nameErr = "Only letters and white space allowed for First Name";
    }

    // Validation for Last Name
    if (empty($last_name) || !preg_match("/^[a-zA-Z-' ]*$/", $last_name)) {
        $last_nameErr = "Only letters and white space allowed for Last Name";
    }

    // Validation for Email
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
    } else {
        // Check if email is unique
        $check_email_query = "SELECT * FROM registration WHERE Email = '$email' LIMIT 1";
        $result = mysqli_query($conn, $check_email_query);
        $user = mysqli_fetch_assoc($result);

        if ($user) {
            $emailErr = "Email already exists";
        }
    }

    // Validation for Password
    if (empty($password)) {
        $passwordErr = "Password is required";
    }

    // Validation for Confirm Password
    if (empty($confirm_password) || $confirm_password !== $password) {
        $confirm_passwordErr = "Passwords do not match";
    }

    // Validation for Phone Number
    if (empty($phone_number) || !preg_match("/^\d{10}$/", $phone_number)) {
        $phone_numberErr = "Invalid phone number format";
    } else {
        // Check if phone number is unique
        $check_phone_query = "SELECT * FROM registration WHERE Phone_number = '$phone_number' LIMIT 1";
        $result = mysqli_query($conn, $check_phone_query);
        $user = mysqli_fetch_assoc($result);

        if ($user) {
            $phone_numberErr = "Phone number already exists";
        }
    }

    // Validation for Address
    if (empty($address)) {
        $addressErr = "Address is required";
    }
    // Validation and insertion code remains the same as before

    // Insert data if no errors
        if ($first_nameErr === "" && $last_nameErr === "" && $emailErr === "" && $passwordErr === "" && $confirm_passwordErr === "" && $phone_numberErr === "" && $addressErr === "" && $upload_imageErr === "")
         {
            $insertquery = "INSERT INTO registration (`First_name`, `Last_name`, `Phone_number`, `Address`, `Password`, `Confirm_password`, `Email`, `Property_image`)
                        VALUES ('$first_name', '$last_name', '$phone_number', '$address', '$password', '$confirm_password', '$email', '$target_file')";
            $res = mysqli_query($conn, $insertquery);

            if ($res) {
            $success='Registration Successful';
            // echo '<script>alert("Data inserted properly")</script>';
            $_POST['first_name'] = $_POST['last_name'] = $_POST['email']=$_POST['phone_number']=$_POST['address']="";

            } else {
        $success='Registration failed';
        // echo '<script>alert("Data not inserted")</script>';
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
  <style>
    .error {
      color: red;
    }
    #message{
      color:green;
      text-align : center;
      font-size : 30px;
    }
  </style>
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
                    <li><a href="signup.php" class="active">Sign Up</a></li>
                    <li><a href="login.php">Login</a></li>
                         <li><a href="property.php">Add Property</a></li>
                         <li><a href="property-list.php">List Property</a></li>
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
                <h2>Sign Up</h2>
                <h2 style="color:green"><?php echo isset($success) ? $success : '' ?></h2>
                <form class="signup-form" action="signup.php" method="POST" enctype="multipart/form-data">
                    <div class="wd70">
                        <div class="form-field">
                            <label>First Name*</label>
                            <input type="text" name="first_name" placeholder="Enter your First Name" value="<?php echo isset($_POST['first_name']) ? $_POST['first_name'] : ''; ?>">
                            <span class="error"><?php echo $first_nameErr; ?></span>
                        </div>
                        <div class="form-field">
                            <label>Last Name*</label>
                            <input type="text" name="last_name" placeholder="Enter your Last Name" value="<?php echo isset($_POST['last_name']) ? $_POST['last_name'] : ''; ?>">
                            <span class="error"><?php echo $last_nameErr; ?></span>
                        </div>
                    </div>
                    <div class="wd30">
                        <div class="upload-picture">
                            <div class="fileUpload">
                                <input type="file" class="upload" name="profile_picture" id="profile_picture"/>
                            </div>
                            <label>Upload Image</label>
                            <span class="error" id="upload_image_err"><?php echo $upload_imageErr; ?></span>
                            <span class="uploaded" id="upload_status"></span>
                        </div>
                    </div>
                    <div class="form-field">
                        <label>Email Address*</label>
                        <input type="email" name="email" placeholder="Enter your Email Address" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
                        <span class="error"><?php echo $emailErr; ?></span>
                    </div>
                    <div class="form-field">
                        <label>Password*</label>
                        <input type="password" name="password" placeholder="Enter Password">
                        <span class="error"><?php echo $passwordErr; ?></span>
                    </div>
                    <div class="form-field">
                        <label>Confirm Password*</label>
                        <input type="password" name="confirm_password" placeholder="Re-enter Password">
                        <span class="error"><?php echo $confirm_passwordErr; ?></span>
                    </div>
                    <div class="form-field">
                        <label>Phone Number* </label>
                        <input type="number" name="phone_number" placeholder="Enter your Phone Number" value="<?php echo isset($_POST['phone_number']) ? $_POST['phone_number'] : ''; ?>">
                        <span class="error"><?php echo $phone_numberErr; ?></span>
                    </div>
                    <div class="form-field">
                        <label>Address* </label>
                        <textarea name="address" placeholder="Enter your Address"><?php echo isset($_POST['address']) ? $_POST['address'] : ''; ?></textarea>
                        <span class="error"><?php echo $addressErr; ?></span>
                    </div>
                    <div class="form-field">
                        <input type="submit" name="submit" value="Submit"> 
                    </div>
                    <p class="alredy-sign">Already Sign up <a href="#"><u>Login Now</u></a></p>
                </form>
            </div>
        </div>
    </div>
</div>
</section>
<script>
document.getElementById("profile_picture").addEventListener("change", function() {
    var fileInput = document.getElementById('profile_picture');
    var uploadStatus = document.getElementById('upload_status');
    var uploadImageErr = document.getElementById('upload_image_err');
    var file = fileInput.files[0];
    
    if(file) {
        var fileSize = file.size;
        var fileType = file.type;
        var validImageTypes = ["image/gif", "image/jpeg", "image/png"];

        if(validImageTypes.includes(fileType)) {
            uploadStatus.innerText = 'Uploaded';
            uploadStatus.style.color = 'green';
            uploadImageErr.innerText = '';
        } else {
            uploadStatus.innerText = '';
            uploadImageErr.innerText = 'Invalid file type. Only GIF, JPEG, and PNG are allowed.';
        }
    }
});
</script>

</body>
</html>