<!DOCTYPE html>
<html>
<head>
  <title>All Properties - Real Estate Hub</title>
  <style>
    nav { margin-bottom:30px; text-align:center;}
    nav a { color: #2c5282; text-decoration: none; padding: 8px 16px;}
    nav a:hover { text-decoration: underline; }
    body { background: linear-gradient(to right, #e0f7fa, #f9f9f9); font-family: Segoe UI, Tahoma, Geneva, Verdana, sans-serif; margin: 0; color: #333; line-height: 1.6; padding: 20px;}
    table { border-collapse:collapse; width: 80%; margin: 20px auto; background: #fff; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border-radius: 8px; overflow: hidden;}
    th, td { border:1px solid #e2e8f0; padding:12px; text-align: left;}
    th {background: linear-gradient(to right, #2c5282, #4a90e2); color:#fff; font-weight: 600;}
    tr:nth-child(even) {background-color: #f7fafc;}
    tr:hover {background-color: #edf2f7;}
    h2 { text-align: center; color: #2c5282; margin-bottom: 20px;}
  </style>
</head>
<body>
<nav>
  <a href="home.html">Home</a> |
  <a href="properties.php">Properties</a> |
  <a href="update.php">Update</a> |
  <a href="calculator.php">Calculator</a> |
  <a href="contact.php">Contact & Search</a> 

</nav>
<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "realestatehub";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    $conn = new mysqli($servername, $username, $password);
} catch (mysqli_sql_exception $e) {
    die("Connection failed: " . $e->getMessage() . "<br><strong>Hint:</strong> Check your database username and password in the file. Current user: '$username', Password: " . ($password ? "SET" : "EMPTY"));
}
// Check connection (legacy check, though try-catch handles it for new mysqli)
if ($conn->connect_error) { 
    die("Connection failed: " . $conn->connect_error); 
}
// Create database
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) !== TRUE) {
    die("Error creating database: " . $conn->error);
}

if (!$conn->select_db($dbname)) {
    die("Error selecting database: " . $conn->error);
}

// Create table
$sql = "CREATE TABLE IF NOT EXISTS properties (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    location VARCHAR(50) NOT NULL,
    type VARCHAR(50) NOT NULL,
    price DECIMAL(15,2) NOT NULL,
    status VARCHAR(20) NOT NULL
)";
if ($conn->query($sql) !== TRUE) {
    die("Error creating table: " . $conn->error);
}

// Sample data
$result = $conn->query("SELECT COUNT(*) AS cnt FROM properties");
if (!$result) {
    die("Error checking table content: " . $conn->error);
}
$row = $result->fetch_assoc();
if ($row['cnt'] == 0) {
  $sql = "INSERT INTO properties (name, location, type, price, status) VALUES
  ('Sunset Villas', 'Goa', 'Villa', 15000000, 'For Sale'),
  ('Downtown Office Complex', 'Bangalore', 'Office', 420000, 'For Lease'),
  ('Greenwood Apartments', 'Chennai', 'Apartment', 35000, 'For Rent'),
  ('Skyline Towers', 'Mumbai', 'Villa', 23000000, 'For Sale'),
  ('Lakeview Homes', 'Kerala', 'Apartment', 22000, 'For Rent')";
  if ($conn->query($sql) !== TRUE) {
      die("Error inserting sample data: " . $conn->error);
  }
}
$sql = "SELECT * FROM properties";
$result = $conn->query($sql);

// Image mapping based on property name
$propertyImages = [
    'Sunset Villas' => 'https://images.unsplash.com/photo-1613490493576-7fde63acd811?auto=format&fit=crop&w=150&q=80',
    'Downtown Office Complex' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=150&q=80',
    'Greenwood Apartments' => 'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?auto=format&fit=crop&w=150&q=80',
    'Skyline Towers' => 'https://images.unsplash.com/photo-1479839672679-a46483c0e7c8?auto=format&fit=crop&w=150&q=80',
    'Lakeview Homes' => 'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?auto=format&fit=crop&w=150&q=80'
];
$defaultImage = 'https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&w=150&q=80';

echo '<table><tr><th>ID</th><th>Image</th><th>Name</th><th>Location</th><th>Type</th><th>Price (₹)</th><th>Status</th></tr>';
if ($result->num_rows) {
  while($row = $result->fetch_assoc()) {
    $imgUrl = isset($propertyImages[$row['name']]) ? $propertyImages[$row['name']] : $defaultImage;
    echo '<tr>';
    echo '<td>'.$row['id'].'</td>';
    echo '<td><img src="'.$imgUrl.'" style="width:100px;border-radius:6px;"></td>';
    echo '<td>'.htmlspecialchars($row['name']).'</td>';
    echo '<td>'.$row['location'].'</td>';
    echo '<td>'.$row['type'].'</td>';
    echo '<td>'.number_format($row['price'],2).'</td>';
    echo '<td>'.$row['status'].'</td>';
    echo '</tr>';
  }
} else { echo '<tr><td colspan="6">No property records found.</td></tr>'; }
echo '</table>';
$conn->close();
?>
</body>
</html>
