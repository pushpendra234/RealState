

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
                         <li><a href="login.php">Login</a></li>
                         <li><a href="property.php">Add Property</a></li>
                         <li><a href="property-list.php">List Property</a></li>
                         <li><a href="search-page.php"  class="active">Search Property</a></li>
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
                    <h2>Property Search Form</h2>
                    <form  action="search.php" method="POST" enctype="multipart/form-data">
                        <div class="form-field width50">
                            <label>Property Name</label>
                            <input type="text" name="property_name" placeholder="Search by property name">
                        </div>
                        <div class="form-field width50">
                            <label>Property Type</label>
                            <select name="property_type">
                            <option value="property-type">Rent</option>
                            <option value="Rent">Rent</option>
                                <option value="Apartment">Apartment</option>
                                <option value="House">House</option>
                                <option value="Villa">Villa</option>
                                <!-- Add more options as needed -->
                            </select>
                        </div>
                        <div class="form-field width50">
                            <label>Enter minimum price</label>
                            <input type="number" name="min_price" placeholder="Enter minimum price">
                        </div>
                        <div class="form-field width50">
                            <label>Enter maximum price</label>
                            <input type="number" name="max_price" placeholder="Enter maximum price">
                        </div>
                        <div class="form-field">
                            <label>Property Location</label>
                            <input type="text" name="property_location" placeholder="Search by location">
                        </div>
                        <div class="form-field">
                            <input type="submit" value="Search">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script src="js/jquery-3.5.1.min.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    <script src="js/script.js" type="text/javascript"></script>
</body>
</html>




