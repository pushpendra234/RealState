<?php
// Start session to access session variables
session_start();


if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

// Include database connection file
include("connection.php");

// Fetch user data from the database using the email stored in session
$email = $_SESSION['email'];
$query = "SELECT * FROM registration WHERE Email = '$email'";
$result = mysqli_query($conn, $query);

// Check if query executed successfully
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $first_name = $row['First_name'];
    $last_name = $row['Last_name'];
    $phone_number = $row['Phone_number'];
    $address = $row['Address'];
    // Add more fields as needed
} else {
    // Handle error if user data not found
    // For now, let's assume no error handling
}

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <style>
        
        .main-banner {
            background-color: #f0f0f0;
            padding: 20px 0;
        }

        .main-banner h1 {
            text-align: center;
            margin: 0;
            font-size: 24px;
            color: #333;
        }

        
        .nav-banner {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
        }

        .navs {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navs ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .navs ul li {
            display: inline-block;
            margin-right: 20px;
        }

        .navs ul li a {
            color: #fff;
            text-decoration: none;
            font-size: 16px;
        }

        .navs ul li a.active {
            font-weight: bold;
        }

        
        .main-content {
            padding: 80px 0;
        }

        .main-width {
            max-width: 800px;
            margin: 0 auto;
        }

        .profile-photo {
            float: right;
            margin-left: 20px;
        }

        .profile-photo img {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            border: 2px solid #333;
        }

        .user-data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .user-data th,
        .user-data td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .user-data th {
            text-align: left;
            background-color: #f0f0f0;
        }

        .user-data td {
            vertical-align: top;
        }

        
        @media (max-width: 768px) {
            .profile-photo {
                float: none;
                margin: 0 auto 20px;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <section class="main-banner">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Welcome, <?php echo $first_name; ?></h1>
                </div>
            </div>
        </div>
    </section>
    
    <section class="nav-banner">
        
    </section>
    
    <section class="main-content paddnig80">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="main-width">
                        <div class="profile-photo">
                            <!-- Display profile photo here -->
                            <img src="<?php echo $row['property_image']; ?>" alt="Profile Photo">
                        </div>
                        <h2>User Data</h2>
                        <table class="user-data">
                            <tr>
                                <th>First Name</th>
                                <td><?php echo $first_name; ?></td>
                            </tr>
                            <tr>
                                <th>Last Name</th>
                                <td><?php echo $last_name; ?></td>
                            </tr>
                            <tr>
                                <th>Phone Number</th>
                                <td><?php echo $phone_number; ?></td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td><?php echo $address; ?></td>
                            </tr>
                            <!-- Add more fields as needed -->
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div style="text-align: center; margin-top: 10px; margin-right:20px;">
        <button id="button" onclick="window.location.href = 'update.php';" style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;">
        Update Profile
    </button>
    <button id="backButton" onclick="window.location.href = 'property.php';" style="padding: 10px 20px; background-color: #ff0000; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;">
    Go to Property
</button>


</div>

    </section>
</body>
</html>
