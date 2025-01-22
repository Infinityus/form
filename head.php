<?php
include("config.php");

// Default values
$title = isset($title) ? $title : 'Default Title';  // Use the $title set in the page if available, otherwise use the default
$favicon = '/img/logo.png';

// Run the query to get the general title and favicon (if needed)
$query = "SELECT * FROM tbl_website WHERE id=1";
$result = mysqli_query($conn, $query);  // Execute the query

if ($result) {
    $row = mysqli_fetch_assoc($result);  // Fetch the result as an associative array
    if ($row) {
        $favicon = $row['favicon'];  // Assign the favicon value
    }
} else {
    // Handle query failure (optional)
    error_log("Error fetching favicon: " . mysqli_error($conn));
}
?>
<title><?php echo $title; ?></title>
<link rel="shortcut icon" type="image/png" href="<?php echo $favicon; ?>"/>
