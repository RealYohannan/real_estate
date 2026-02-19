<!DOCTYPE html>
<html>
<head>
  <title>Update Property - Real Estate Hub</title>
  <style>
    nav { margin-bottom:30px; text-align:center;}
    nav a { color: #2c5282; text-decoration: none; padding: 8px 16px;}
    nav a:hover { text-decoration: underline; }
    body { font-family: Arial,sans-serif; margin:20px;}
    label {display:inline-block; width:90px;}
    table { border-collapse:collapse; width: 70%; margin: 20px auto;}
    th, td { border:1px solid #b7d2fe; padding:10px;}
    th {background:#4a90e2;color:#fff;}
    .msg {margin:15px 0;padding:8px;}
    .success { background:#c9f7d2; color:#2b683b;}
    .error { background:#f9d6d5; color:#8a150f;}
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
<h2>Update Property Status/Price</h2>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "realestatehub";
$conn = new mysqli($servername, $username, $password, $dbname);

// Fetch property IDs and names for dropdown
$propOptions = '';
$result = $conn->query("SELECT id, name FROM properties");
if ($result && $result->num_rows) {
  while ($row = $result->fetch_assoc())
    $propOptions .= '<option value="'.$row['id'].'">'.$row['id'].' - '.htmlspecialchars($row['name']).'</option>';
}
?>

<form method="post">
  <label for="id">Property:</label>
  <select name="id" id="id" required>
    <option value="">Select</option>
    <?php echo $propOptions;?>
  </select>
  <label for="price">New Price:</label><input name="price" id="price" type="number" step="0.01" required>
  <label for="status">Status:</label>
  <select name="status" id="status">
    <option value="For Sale">For Sale</option>
    <option value="Sold">Sold</option>
    <option value="For Rent">For Rent</option>
    <option value="For Lease">For Lease</option>
  </select>
  <input type="submit" value="Update">
</form>
<?php
if($conn->connect_error) { die("<div class='msg error'>Connection failed: {$conn->connect_error}</div>"); }
if(isset($_POST['id']) && $_POST['id'] && isset($_POST['price']) && isset($_POST['status'])) {
  $id = intval($_POST['id']); $price = floatval($_POST['price']); $status = $_POST['status'];
  $sql = "UPDATE properties SET price=$price, status='$status' WHERE id=$id";
  if($conn->query($sql)) echo "<div class='msg success'>Record updated successfully.</div>";
  else echo "<div class='msg error'>Error: {$conn->error}</div>";
}

// Show updated properties table:
$sql = "SELECT * FROM properties"; $result = $conn->query($sql);
echo '<table><tr><th>ID</th><th>Name</th><th>Location</th><th>Type</th><th>Price</th><th>Status</th></tr>';
if($result && $result->num_rows) while($row = $result->fetch_assoc())
  echo "<tr><td>{$row['id']}</td><td>{$row['name']}</td><td>{$row['location']}</td><td>{$row['type']}</td><td>{$row['price']}</td><td>{$row['status']}</td></tr>";
else echo '<tr><td colspan="6">No records found.</td></tr>';
$conn->close();
?>
</body>
</html>
