<?php
include("connection.php");

session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    echo "Property ID not provided..";
    exit();
}

$property_id = $_GET['id'];

$query = "SELECT * FROM property WHERE Property_Id = '$property_id'";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "Property not found........";
    exit();
}

$row = mysqli_fetch_assoc($result);

$email = $_SESSION['email'];
$user_query = "SELECT * FROM registration WHERE Email='$email'";
$user_result = mysqli_query($conn, $user_query);
$userdata = mysqli_fetch_assoc($user_result);
$user_id = $userdata['Id'];

if ($row['Id'] != $user_id) {
    echo "You do not have permission to edit this property.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
                    $update_image_query = "UPDATE property SET Property_Image = '$destination' WHERE Property_Id = '$property_id'";
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

    // Update Property Details
    $property_name = $_POST['property_name'];
    $type = $_POST['type'];
    $price = $_POST['price'];
    $location = $_POST['location'];
    $description = $_POST['description'];

    $update_query = "UPDATE property SET 
        Property_Name = '$property_name',
        Property_Type = '$type',
        Property_Price = '$price',
        Property_Location = '$location',
        Property_Description = '$description'
        WHERE Property_Id = '$property_id'";

    if (mysqli_query($conn, $update_query)) {
        $isSubmit = "Successfully Updated";
    } else {
        echo "Error updating property details: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Property</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            padding: 20px;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        form {
            margin-top: 20px;
        }
        form label {
            font-weight: bold;
        }
        .error {
            color: red;
        }
        .success {
            color: green;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Update Property</h2>
        <?php if(isset($isSubmit)) { ?>
            <div class="success"><?php echo $isSubmit; ?></div>
        <?php } ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $property_id; ?>" enctype="multipart/form-data">
            <div class="form-group">
                <label for="property_name">Property Name:</label>
                <input type="text" class="form-control" id="property_name" name="property_name" value="<?php echo $row['Property_Name']; ?>">
            </div>
            <div class="form-group">
    <label for="type">Property Type:</label>
    <select class="form-control" id="type" name="type">
        <option value="Rent" <?php if($row['Property_Type'] == 'Rent') echo 'selected'; ?>>Rent</option>
        <option value="Farmhouse" <?php if($row['Property_Type'] == 'Farmhouse') echo 'selected'; ?>>Farmhouse</option>
        <option value="Apartments" <?php if($row['Property_Type'] == 'Apartments') echo 'selected'; ?>>Apartments</option>
        <option value="Villa" <?php if($row['Property_Type'] == 'Villa') echo 'selected'; ?>>Villa</option>
        <option value="Bungalow" <?php if($row['Property_Type'] == 'Bungalow') echo 'selected'; ?>>Bungalow</option>
    </select>
</div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="text" class="form-control" id="price" name="price" value="<?php echo $row['Property_Price']; ?>">
            </div>
            <div class="form-group">
                <label for="location">Location:</label>
                <input type="text" class="form-control" id="location" name="location" value="<?php echo $row['Property_Location']; ?>">
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description"><?php echo $row['Property_Description']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="image">Upload Image:</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="property-list.php" class="btn btn-secondary">Back</a>
        </form>
    </div>
</body>
</html>
