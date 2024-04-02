<?php
session_start();
include 'connection.php'; // Assuming this file contains your database connection code

$propertyId = ""; // Define propertyId variable

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['Property_Id'])) {
    $propertyId = $_GET['Property_Id']; // Get propertyId from GET request
    $select = "SELECT * FROM property WHERE Property_Id = '$propertyId'";
    $result = mysqli_query($conn, $select);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        if ($row) {
            // Assign values to variables
            $propertyName = $row['propertyName'];
            $propertyType = $row['propertyType'];
            $propertyPrice = $row['propertyPrice'];
            $propertyLocation = $row['propertyLocation'];
            $propertyDescription = $row['propertyDescription'];
            $propertyImg = $row['propertyImg'];

            // Inserting records
            if (isset($_POST['submit'])) {
                // If no file is uploaded
                if ($_FILES["propertyImg"]["name"] == "") {
                    $updatequery = "UPDATE property SET propertyName='$propertyName', propertyType='$propertyType', propertyPrice='$propertyPrice', propertyLocation='$propertyLocation', propertyDescription='$propertyDescription' WHERE Property_Id='$propertyId'";

                    if (mysqli_query($conn, $updatequery)) {
                        echo '<script>window.location.href = "../php/property-list.php";</script>';
                        exit(); // Make sure to exit after redirect
                    } else {
                        echo "Error inserting record: " . mysqli_error($conn);
                    }
                } else {
                    $filename = basename($_FILES["propertyImg"]["name"]);
                    $tempname = $_FILES["propertyImg"]["tmp_name"];
                    $targetDir = "../propertyimg/" . $filename;

                    // Check for file upload errors
                    if ($_FILES["propertyImg"]["error"] != UPLOAD_ERR_OK) {
                        echo "File upload error: " . $_FILES["propertyImg"]["error"];
                        exit();
                    }

                    if (move_uploaded_file($tempname, $targetDir)) {
                        $updatequery = "UPDATE property SET propertyName='$propertyName', propertyType='$propertyType', propertyPrice='$propertyPrice', propertyLocation='$propertyLocation', propertyDescription='$propertyDescription', propertyImg='$filename' WHERE Property_Id='$propertyId'";

                        if (mysqli_query($conn, $updatequery)) {
                            $old_file_path = "../propertyimg/" . $propertyImg;

                            if (file_exists($old_file_path)) {
                                if (unlink($old_file_path)) {
                                    echo "File deleted successfully.";
                                } else {
                                    echo "Error deleting file.";
                                }
                            }
                        } else {
                            // If file is uploaded but data not inserted then deleting uploaded file
                            if (file_exists($targetDir)) {
                                if (unlink($targetDir)) {
                                    echo "File deleted successfully.";
                                } else {
                                    echo "Error deleting file.";
                                }
                            }
                            echo "Error inserting record: " . mysqli_error($conn);
                        }
                    }
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Codingkart Test</title>
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
                        <li><a href="property.php">Add Property</a></li>
                        <li><a href="property-list.php" class="active">List Property</a></li>
                        <li><a href="search-page.html">Search Property</a></li>
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
                    <form class="Property-form" method="POST" action='/test/php/updateproperty.php' enctype="multipart/form-data">
                        <div class="wd70">
                            <div class="form-field">
                                <label>Property Name*</label>
                                <input type="text" placeholder="Enter Property Name" name="propertyName" value="<?php echo isset($propertyName) ? $propertyName : ''; ?>">
                            </div>
                            <div class="form-field">
                                <label>Property Type*</label>
                                <select name="propertyType">
                                    <option value="">Property Type</option>
                                    <option value="Rent" <?php if(isset($propertyType) && $propertyType == 'Rent') echo 'selected'; ?>>Rent</option>
                                    <option value="Sell" <?php if(isset($propertyType) && $propertyType == 'Sell') echo 'selected'; ?>>Sell</option>
                                </select>
                            </div>
                        </div>

                        <div class="wd30">
                            <div class="upload-picture">
                                <label for="file-upload" id="file-upload-label">Property Image</label>
                                <input type="file" id="file-upload" class="upload" name="propertyImg" style="display: none;" onchange="displayImage(event)" />
                                <?php if(isset($propertyImg) && $propertyImg != '') echo '<img src="../propertyimg/'.$propertyImg.'" alt="property image" class="property-img" style="max-width: 100%; height: auto;">'; ?>
                            </div>
                        </div>

                        <div class="form-field">
                            <label>Property Price*</label>
                            <input type="number" placeholder="Enter Property Price" name="propertyPrice" value="<?php echo isset($propertyPrice) ? $propertyPrice : ''; ?>">
                        </div>
                        <div class="form-field">
                            <label>Property Location*</label>
                            <input type="text" placeholder="Enter Location" name="propertyLocation" value="<?php echo isset($propertyLocation) ? $propertyLocation : ''; ?>">
                        </div>

                        <div class="form-field">
                            <label>Property Description* </label>
                            <textarea placeholder="Enter Description" name="propertyDescription"><?php echo isset($propertyDescription) ? $propertyDescription : ''; ?></textarea>
                        </div>

                        <input type="hidden" name="propertyId" value="<?php echo isset($propertyId) ? $propertyId : ''; ?>">

                        <div class="form-field">
                            <input type="submit" value="Submit" name="submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="../js/jquery-3.5.1.min.js" type="text/javascript"></script>
<script src="../js/bootstrap.min.js" type="text/javascript"></script>
<script src="../js/script.js" type="text/javascript"></script>
<script>
    function displayImage(event) {
        var image = document.getElementById('property-img');
        image.src = URL.createObjectURL(event.target.files[0]);
    }
</script>
</body>
</html>


