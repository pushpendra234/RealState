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
        /* .property-img {
          max-width: 15%; 
          height: auto; 
        } */
        .property-img {
            height : 200px;
    position: absolute;
    right: 0px;
    top: 41px;
}
        .action-buttons {
          margin-top: 20px; 
        }
        .btn {
          display: inline-block;
          padding: 10px 16px;
          background-color: #007bf;
          color: #fff;
          text-decoration: none;
          border-radius: 10px;
        }
        .btn + .btn {
          margin-left: 10px;
        }
        .update-btn {
          border-radius:5px;
          margin-top: 10px;
          margin-right: 35px;
          padding:6px;
          background-color: #45a049;
          color: white;
        }
        .delete-btn {
          border-radius:5px;
          padding:6px;
          background-color: red;
          color: white;
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
                         <li><a href="property.php">Add Property</a></li>
                         <li><a href="property-list.php" class="active">List Property</a></li>
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
                    <h2>Property Listings</h2>

                      <div class="product-list">
    <?php                        
    session_start();
    include("connection.php");

    if (!isset($_SESSION['email'])) {
        header("Location: login.php");
        exit();
    }
    $sql = "SELECT * FROM property";
    $result = $conn->query($sql);
    
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="product-list">';
            echo '<img src="' . $row["Property_Image"] . '" alt="Image" class="property-img">';
            echo '<ul>';
            echo '<li><img src="images/icon-user.png" alt="user"><strong>Property Name:</strong> ' . $row["Property_Name"] . '</li>';
            echo '<li><img src="images/icon-home.png" alt="home"><strong>Property Type:</strong> ' . $row["Property_Type"] . '</li>';
            echo '<li><img src="images/icon-doller.png" alt="doller"><strong>Price:</strong> ' . $row["Property_Price"] . '</li>';
            echo '<li><img src="images/icon-location.png" alt="location"><strong>Location:</strong> ' . $row["Property_Location"] . '</li>';
            echo '</ul>';
            echo '<p>' . $row["Property_Description"] . '</p>';
            echo '<div class="action-buttons">';
            echo '<a href="update_property.php?id=' . $row["Property_Id"] . '" class="update-btn">Update</a>';
            echo '&nbsp;';
            echo '<a href="#" class="delete-btn" onclick="return confirmDelete(' . $row["Property_Id"] . ')">Delete</a>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo "0 results";
    }
    ?>  
    <script>
        function confirmDelete(property_id) {
            var confirmed = confirm("Are you sure you want to delete this property?");
            if (confirmed) {
            
                window.location.href = "delete_property.php?id=" + property_id;
            }
            return false;
        }
    </script>
                       
    <a href="#" class="load-btn">Load More</a>
                     
    </div>
        </div>
            </div>
                </div>
                    </section>
    
                    <?php
  
    if (isset($_GET['success']) && $_GET['success']) {
        echo '<script>alert("Property deleted successfully!");</script>';
    }
    else if(isset($_GET['success']) && $_GET['success']==0)
    echo '<script>alert("You are not authorized to delete someone property");</script>';
?>

    
    <script src="js/jquery-3.5.1.min.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    <script src="js/script.js" type="text/javascript"></script>
</body>
</html>
