<?php
session_start();
include("connection.php");

// Redirect to login page if user is not logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $property_name = $_POST['property_name'];
    $property_type = $_POST['property_type'];
    $property_price = $_POST['property_price'];
    $property_location = $_POST['property_location'];
    $property_description = $_POST['property_description'];
    
    $error = false;

    // Validate input fields
    if (empty($property_name)) {
        $_SESSION['error']['property_name'] = "Property Name is required.";
        $error = true;
    }

    if (empty($property_type)) {
        $_SESSION['error']['property_type'] = "Property Type is required.";
        $error = true;
    }

    if (empty($property_price)) {
        $_SESSION['error']['property_price'] = "Property Price is required.";
        $error = true;
    } elseif (!is_numeric($property_price)) {
        $_SESSION['error']['property_price'] = "Price must be a numeric value.";
        $error = true;
    }

    if (empty($property_location)) {
        $_SESSION['error']['property_location'] = "Property Location is required.";
        $error = true;
    }

    if (empty($property_description)) {
        $_SESSION['error']['property_description'] = "Property Description is required.";
        $error = true;
    }

    // Proceed if no validation errors
    if (!$error) {
        $email = $_SESSION['email'];
        $user_query = "SELECT Id FROM registration WHERE Email='$email'";
        $user_result = mysqli_query($conn, $user_query);

        if ($user_result && mysqli_num_rows($user_result) > 0) {
            $user_data = mysqli_fetch_assoc($user_result);
            $user_id = $user_data['Id'];

            // Image upload (improved validation)
            $targetDir = "uploads/"; // Directory where images will be stored
            $uploadOk = 1;

            if (isset($_FILES["property_image"]) && !empty($_FILES["property_image"]["tmp_name"])) {
                $targetFile = $targetDir . basename($_FILES["property_image"]["name"]);
                $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

                // Check if image file is a actual image or fake image
                $check = getimagesize($_FILES["property_image"]["tmp_name"]);
                if ($check !== false) {
                    $uploadOk = 1;
                } else {
                    $_SESSION['error']['property_image'] = "File is not an image.";
                    $uploadOk = 0;
                }

                // Check file size
                if ($_FILES["property_image"]["size"] > 500000) {
                    $_SESSION['error']['property_image'] = "Sorry, your file is too large.";
                    $uploadOk = 0;
                }

                // Allow certain file formats
                if (!in_array($imageFileType, ["jpg", "png", "jpeg", "gif"])) {
                    $_SESSION['error']['property_image'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    $uploadOk = 0;
                }

                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    $_SESSION['error']['property_image'] = "Sorry, your file was not uploaded.";
                } else {
                    if (move_uploaded_file($_FILES["property_image"]["tmp_name"], $targetFile)) {
                        // Insert property data into the database
                        $insert_query = "INSERT INTO property (Property_Name, Property_Type, Property_Price, Property_Location, Property_Description, Property_Image, Id) 
                                         VALUES ('$property_name', '$property_type', '$property_price', '$property_location', '$property_description', '$targetFile', '$user_id')";

                        if (mysqli_query($conn, $insert_query)) {
                            $_SESSION['success'] = "Property added successfully.";
                            header("Location: property.php");
                            exit;
                        } else {
                            $_SESSION['error']['property_insert'] = "Error: " . mysqli_error($conn);
                        }
                    } else {
                        $_SESSION['error']['property_image'] = "Sorry, there was an error uploading your file.";
                    }
                }
            } else {
                $_SESSION['error']['user'] = "User not found.";
            }
        } else {
            $_SESSION['error']['user'] = "User not found.";
        }
    }
}

// Display success message if any
$success_message = isset($_SESSION['success']) ? $_SESSION['success'] : '';
$error_message = isset($_SESSION['error']) ? $_SESSION['error'] : '';
unset($_SESSION['success']);
unset($_SESSION['error']); // Clear the session variables
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
        .error-message {
            color: red;
            font-size: 14px;
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
                            <li><a href="signup.php">Sign Up</a></li>
                            <li><a href="login.php">Login</a></li>
                            <li><a href="property.php" class="active">Add Property</a></li>
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
                        <h2>Property Form</h2>
                        <h2 style="color:green"><?php echo $success_message; ?></h2>
                        <form class="Property-form" method="post" action="property.php" enctype="multipart/form-data">
                            <div class="wd70">
                                <div class="form-field">
                                    <label>Property Name*</label>
                                    <input type="text" name="property_name" placeholder="Enter Property Name">
                                    <span class="error-message"><?php echo isset($error_message['property_name']) ? $error_message['property_name'] : ''; ?></span>
                                </div>
                                <div class="form-field">
                                    <label>Property Type*</label>
                                    <select name="property_type">
                                        <option value="Flat">Flat</option>
                                        <option value="Apartment">Apartment</option>
                                        <option value="Farmhouse">Farmhouse</option>
                                        <option value="Rent">Hotel</option>
                                        <option value="Bungalow">Bungalow</option>
                                    </select>
                                    <span class="error-message"><?php echo isset($error_message['property_type']) ? $error_message['property_type'] : ''; ?></span>
                                </div>
                            </div>
                            
                            <div class="wd30">
                                <div class="upload-picture">
                                    <div class="fileUpload">
                                        <input type="file" name="property_image" id="property_image" class="upload" />
                                    </div>
                                    <label id='label'>Property Image</label>
                                </div>
                                <p id="upload_status" style="text-align:center"></p>
                                <p id="upload_image_err" class="error"></p>
                            </div>
                            
                            <div class="form-field">
                                <label>Property Price*</label>
                                <input type="number" name="property_price" placeholder="Enter Property Price">
                                <span class="error-message"><?php echo isset($error_message['property_price']) ? $error_message['property_price'] : ''; ?></span>
                            </div>
                            <div class="form-field">
                                <label>Property Location*</label>
                                <input type="text" name="property_location" placeholder="Enter Location">
                                <span class="error-message"><?php echo isset($error_message['property_location']) ? $error_message['property_location'] : ''; ?></span>
                            </div>
                            
                            <div class="form-field">
                                <label>Property Description* </label>
                                <textarea name="property_description" placeholder="Enter Description"></textarea>
                                <span class="error-message"><?php echo isset($error_message['property_description']) ? $error_message['property_description'] : ''; ?></span>
                            </div>
                            
                            <div class="form-field">
                                <input type="submit" name="submit" value="Submit"> 
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <script>
        document.getElementById("property_image").addEventListener("change", function() {
            var fileInput = document.getElementById('property_image');
            var uploadStatus = document.getElementById('upload_status');
            var uploadImageErr = document.getElementById('upload_image_err');
            var label = document.getElementById('label');
            var file = fileInput.files[0];
            
            if(file) {
                var fileSize = file.size;
                var fileType = file.type;
                var validImageTypes = ["image/gif", "image/jpeg", "image/png"];

                if(validImageTypes.includes(fileType)) {
                    // Valid image file type
                    uploadStatus.innerText = 'Uploaded';
                    uploadStatus.style.color = 'green';
                    uploadImageErr.innerText = ''; // Clear any previous error message
                    label.innerText='';
                } else {
                    // Invalid image file type
                    uploadStatus.innerText = '';
                    uploadImageErr.innerText = 'Invalid file type. Only GIF, JPEG, and PNG are allowed.';
                }
            }
        });
    </script>
    <script src="js/jquery-3.5.1.min.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    <script src="js/script.js" type="text/javascript"></script>
</body>
</html>
