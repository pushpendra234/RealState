<?php
include("connection.php");
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id']) && isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $property_id = mysqli_real_escape_string($conn, $_GET['id']);
    $user_query = "SELECT * FROM registration WHERE Email='$email'";
$user_result = mysqli_query($conn, $user_query);
$userdata = mysqli_fetch_assoc($user_result);
$id = $userdata['Id'];

$query = "SELECT * FROM property WHERE Property_Id = '$property_id'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
if ($id != $row['Id']) {
    
    $success = 0;
    echo '<script>alert("You are not authorized to delete someone property");</script>';
    
    header("Location: property-list.php?success=$success");
    exit();
}

    $sql = "DELETE FROM property WHERE Property_Id = ?";
    
    
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        
        mysqli_stmt_bind_param($stmt, "i", $property_id);
        
        if (mysqli_stmt_execute($stmt)) {
          
            header("Location: property-list.php?success=$property_id");
            exit();
        } else {

            echo "Error: Unable to delete the property.";
        }
        mysqli_stmt_close($stmt);
    } else {

        echo "Error: Unable to prepare the statement.";
    }
} else {
    echo "Error";
}
?>