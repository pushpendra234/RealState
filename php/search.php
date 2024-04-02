
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
            .property-img {
    position: absolute;
    right: 0px;
    top: 41px;
}
#a{
    height: 40px;
    width: 200px;
    border: 3px solid black;
    border-radius: 5px;
    padding: 10px;
    text-align: center;
    margin-top: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
}
h2{
    margin-bottom : 0px;
}
     </style>
</head>
<body>
<section class="main-content paddnig80">
    <div class="container">
    <h2>Search Result</h2>
        <div class="row">
            <div class="col-md-12">
                <div class="main-width">
                   
                    <!-- <div class="product-list"> -->
                        <?php
                        session_start();
                        include("connection.php");

                        // Check if form is submitted
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            $property_name = $_POST['property_name'];
                            $property_type = $_POST['property_type'];
                            $min_price = $_POST['min_price'];
                            $max_price = $_POST['max_price'];
                            $property_location = $_POST['property_location'];

                            // Build the query based on the search criteria
                            $query = "SELECT * FROM property WHERE 1=1";

                            if (!empty($property_name)) {
                                $query .= " AND Property_Name LIKE '%$property_name%'";
                            }

                            if ($property_type != 'property-type') {
                                $query .= " AND Property_Type = '$property_type'";
                            }

                            if (!empty($min_price)) {
                                $query .= " AND Property_Price >= '$min_price'";
                            }

                            if (!empty($max_price)) {
                                $query .= " AND Property_Price <= '$max_price'";
                            }

                            if (!empty($property_location)) {
                                $query .= " AND Property_Location LIKE '%$property_location%'";
                            }

                            // Execute the query
                            $result = mysqli_query($conn, $query);

                            // Check if any results are found
                            if (mysqli_num_rows($result) > 0) {
                                // Display the search results
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<div class="product-list" >';
                                    echo '<img src="' . $row["Property_Image"] . '" alt="Image" class="property-img">';
                                    echo '<ul>';
                                    echo '<li><img src="images/icon-user.png" alt="user"><strong>Property Name:</strong> ' . $row["Property_Name"] . '</li>';
                                    echo '<li><img src="images/icon-home.png" alt="home"><strong>Property Type:</strong> ' . $row["Property_Type"] . '</li>';
                                    echo '<li><img src="images/icon-doller.png" alt="doller"><strong>Price:</strong> ' . $row["Property_Price"] . '</li>';
                                    echo '<li><img src="images/icon-location.png" alt="location"><strong>Location:</strong> ' . $row["Property_Location"] . '</li>';
                                    echo '</ul>';
                                    echo '<p>' . $row["Property_Description"] . '</p>';
                                    
                                    echo '</div>';
                                }
                            } else {
                                echo "<p>No properties found matching your search criteria.</p>";
                            }
                        } else {
                            // Display all properties if no search is performed
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
                                   
                                    echo '</div>';
                                }
                            } else {
                                echo "0 results";
                            }
                        }
                        ?>
                    <!-- </div> -->
                   <div id="a"> <a href="search-page.php" >Back to search</a></div>
                    
                </div>
            </div>
        </div>
    </div>
</section>

</body>
</html>