<!DOCTYPE html>
<html>
<head>
  <title>All Properties - Real Estate Hub</title>
  <style>
    nav { margin-bottom:30px; text-align:center;}
    nav a { color: #2c5282; text-decoration: none; padding: 8px 16px;}
    nav a:hover { text-decoration: underline; }
    table { border-collapse:collapse; width: 80%; margin: 30px auto;}
    th, td { border:1px solid #b7d2fe; padding:10px;}
    th {background:#4a90e2;color:#fff;}
  </style>
</head>
<body>
<nav>
  <a href="home.html">Home</a> |
  <a href="prgm09.php">Properties</a> |
  <a href="prgm10.php">Update</a> |
  <a href="prgmsix.php">Calculator</a> |
  <a href="pgm07.php">Forms Demo</a>
</nav>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "realestatehub";
$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }
// Create database
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
$conn->query($sql);
$conn->select_db($dbname);
// Create table
$sql = "CREATE TABLE IF NOT EXISTS properties (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    location VARCHAR(50) NOT NULL,
    type VARCHAR(50) NOT NULL,
    price DECIMAL(15,2) NOT NULL,
    status VARCHAR(20) NOT NULL
)";
$conn->query($sql);
// Sample data
$result = $conn->query("SELECT COUNT(*) AS cnt FROM properties");
$row = $result->fetch_assoc();
if ($row['cnt'] == 0) {
  $sql = "INSERT INTO properties (name, location, type, price, status) VALUES
  ('Sunset Villas', 'Goa', 'Villa', 15000000, 'For Sale'),
  ('Downtown Office Complex', 'Bangalore', 'Office', 420000, 'For Lease'),
  ('Greenwood Apartments', 'Chennai', 'Apartment', 35000, 'For Rent'),
  ('Skyline Towers', 'Mumbai', 'Villa', 23000000, 'For Sale'),
  ('Lakeview Homes', 'Kerala', 'Apartment', 22000, 'For Rent')";
  $conn->query($sql);
}
$sql = "SELECT * FROM properties";
$result = $conn->query($sql);
echo '<table><tr><th>ID</th><th>Name</th><th>Location</th><th>Type</th><th>Price (₹)</th><th>Status</th></tr>';
if ($result->num_rows) {
  while($row = $result->fetch_assoc()) {
    echo '<tr>';
    echo '<td>'.$row['id'].'</td>';
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
