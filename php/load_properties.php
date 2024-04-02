<?php
// Include connection.php to establish a database connection
include("connection.php");

// Define a limit and offset for fetching properties
$limit = 3; // Number of properties to fetch per request
$offset = isset($_GET['offset']) ? $_GET['offset'] : 0; // Offset for pagination

// Fetch properties from the database using LIMIT and OFFSET
$sql = "SELECT * FROM property LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $sql);

// Check if any properties are found
if (mysqli_num_rows($result) > 0) {
    // Output data of each property
    while($row = mysqli_fetch_assoc($result)) {
        // Output HTML for property listing
        echo '<div class="product-list">';
        echo '<img src="' . $row["Property_Image"] . '" alt="Property Image" class="property-img">';
        echo '<ul>';
        echo '<li><img src="images/icon-user.png" alt="user"><strong>Property Name:</strong> ' . $row["Property_Name"] . '</li>';
        echo '<li><img src="images/icon-home.png" alt="home"><strong>Property Type:</strong> ' . $row["Property_Type"] . '</li>';
        echo '<li><img src="images/icon-doller.png" alt="doller"><strong>Price:</strong> $' . $row["Property_Price"] . '</li>';
        echo '<li><img src="images/icon-location.png" alt="location"><strong>Location:</strong> ' . $row["Property_Location"] . '</li>';
        echo '</ul>';
        echo '<p>' . $row["Property_Description"] . '</p>';
        echo '</div>';
    }
} else {
    // No more properties found
    echo "No more properties available.";
}
?>
