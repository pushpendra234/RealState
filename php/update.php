<?php
include("connection.php");

$first_nameErr = $last_nameErr = $phone_numberErr = $addressErr = "";

session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}
$email = $_SESSION['email'];
$query = "SELECT * FROM registration WHERE Email = '$email'";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if (isset($_POST['submit'])) {
    $success = '';
    $first_name = test_input($_POST['first_name']);
    $last_name = test_input($_POST['last_name']);
    $phone_number = test_input($_POST['phone_number']);
    $address = test_input($_POST['address']);

    if (empty($phone_number)) {
        $phone_numberErr = "Phone number is required";
    } elseif (!preg_match("/^\d{10}$/", $phone_number)) {
        $phone_numberErr = "Invalid phone number format";
    }

    if ($first_nameErr === "" && $last_nameErr === "" && $phone_numberErr === "" && $addressErr === "") {
        // Image Upload
        if (isset($_FILES["image"])) {
            $file = $_FILES["image"];

            if ($file["error"] === UPLOAD_ERR_OK) {
                $allowed_types = array("image/jpeg", "image/png", "image/gif");
                if (in_array($file["type"], $allowed_types)) {
                    $filename = uniqid() . '_' . basename($file["name"]);
                    $destination = "uploads/" . $filename;

                    if (move_uploaded_file($file["tmp_name"], $destination)) {
                        // Update image path in database
                        $update_image_query = "UPDATE registration SET property_image = '$destination' WHERE Email = '$email'";
                        if (mysqli_query($conn, $update_image_query)) {
                            $isImageUploaded = true;
                        } else {
                            echo "Error updating image path in database: " . mysqli_error($conn);
                        }
                    } else {
                        echo "Error uploading image.";
                    }
                } else {
                    echo "Invalid file type. Allowed types: jpg, jpeg, png, gif";
                }
            } else {
                echo "Error during file upload: " . $file["error"];
            }
        }

        // Update Profile Details
        $update_query = "UPDATE registration SET `First_name`='$first_name', `Last_name`='$last_name', `Phone_number`='$phone_number', `Address`='$address' WHERE `Email`='$email'";
        $res = mysqli_query($conn, $update_query);

        if ($res) {
            $success = 'Profile updated successfully';
            echo '<script>alert("Data updated")</script>';
        } else {
            $error = 'Failed to update profile';
            echo '<script>alert("Data not inserted")</script>';
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
    
    <title>Update Profile</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            margin-top: 20px;
        }
        .form-field {
            margin-bottom: 15px;
        }
        .form-field label {
            font-weight: bold;
        }
        .form-field input[type="text"], 
        .form-field input[type="email"], 
        .form-field input[type="password"], 
        .form-field textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .form-field input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .form-field input[type="submit"]:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            font-size: 14px;
        }
        .div{
            display:flex;
            /* justify-content:space-between; */
        a{
            display:flex;
            justify-content:center;
            align-items:center;
            /* padding-top:2px; */
            text-decoration:none;
            margin-left:20px;
            text-align : center;
            font-size: 16px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            background-color: red;
            color:white;
            display:block;
            height:90%;
            width:100%;
            border : 2px solid black;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Update Profile</h2>
        <h2 style="color:green"><?php echo isset($success) ? $success : ''; ?></h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-field">
                <label>First Name*</label>
                <input type="text" name="first_name" placeholder="Enter your First Name" required value="<?php echo isset($first_name) ? $first_name : $data['First_name'] ?>">
                <span class="error"><?php echo isset($first_nameErr) ? $first_nameErr : ''; ?></span>
            </div>
            <div class="form-field">
                <label>Last Name*</label>
                <input type="text" name="last_name" placeholder="Enter your Last Name" required value="<?php echo isset($last_name) ? $last_name : $data['Last_name'] ?>">
                <span class="error"><?php echo isset($last_nameErr) ? $last_nameErr : ''; ?></span>
            </div>
            <div class="form-field">
                <label>Email Address</label>
                <input type="email" name="email" value="<?php echo $_SESSION['email']; ?>" readonly>
            </div>
            <div class="form-field">
                <label>Address</label>
                <input type="text" name="address" value="<?php echo isset($address) ? $address : $data['Address'] ?>">
            </div>
            <div class="form-field">
                <label>Phone Number</label>
                <input type="text" name="phone_number" required value="<?php echo isset($phone_number) ? $phone_number : $data['Phone_number'] ?>">
                <span class="error"><?php echo isset($phone_numberErr) ? $phone_numberErr : ''; ?></span>
            </div>
            <div class="form-field">
                <label>Upload Image</label>
                <input type="file" name="image" accept="image/*">
            </div>
            <div class="div">
                <div class="form-field">
                    <input type="submit" name="submit" value="Update"> 
                </div>
                <div class="form-field">
                    <a href="dashboard.php">Back</a> 
                </div>
            </div>
        </form>
    </div>
</body>
</html>
