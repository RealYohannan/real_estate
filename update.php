<?php
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Update Property - Real Estate Hub</title>
  <style>
    nav { margin-bottom:30px; text-align:center;}
    nav a { color: #2c5282; text-decoration: none; padding: 8px 16px;}
    nav a:hover { text-decoration: underline; }
    body { background: linear-gradient(to right, #e0f7fa, #f9f9f9); font-family: Segoe UI, Tahoma, Geneva, Verdana, sans-serif; margin: 0; color: #333; line-height: 1.6; padding: 20px;}
    label {display:inline-block; width:90px; font-weight: 600; color: #2c5282;}
    table { border-collapse:collapse; width: 70%; margin: 20px auto; background: #fff; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border-radius: 8px; overflow: hidden;}
    th, td { border:1px solid #e2e8f0; padding:12px; text-align: left;}
    th {background: linear-gradient(to right, #2c5282, #4a90e2); color:#fff; font-weight: 600;}
    tr:nth-child(even) {background-color: #f7fafc;}
    tr:hover {background-color: #edf2f7;}
    .msg {margin:15px 0;padding:10px; border-radius: 4px; text-align: center;}
    .success { background:#c9f7d2; color:#2b683b; border: 1px solid #a4deac;}
    .error { background:#f9d6d5; color:#8a150f; border: 1px solid #f5c6cb;}
    .logout-btn { float: right; background: #e53e3e; color: white; padding: 5px 10px; text-decoration: none; border-radius: 4px; font-size: 14px; transition: background 0.3s;}
    .logout-btn:hover { background: #c53030; }
    h2 { text-align: center; color: #2c5282; margin-bottom: 20px;}
    form { max-width: 600px; margin: 20px auto; background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);}
    input, select { padding: 8px; border: 1px solid #cbd5e0; border-radius: 4px; margin-right: 10px;}
    input[type="submit"] { background: linear-gradient(to right, #2c5282, #4a90e2); color: white; border: none; cursor: pointer; padding: 8px 16px;}
  </style>
</head>
<body>
<nav>
  <a href="home.html">Home</a> |
  <a href="properties.php">Properties</a> |
  <a href="update.php">Update</a> |
  <a href="calculator.php">Calculator</a> |
  <a href="contact.php">Contact & Search</a> 
  <a href="logout.php" class="logout-btn">Logout</a>
</nav>
<h2>Update Property Status/Price</h2>

<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "realestatehub";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
// Create connection
try {
    $conn = new mysqli($servername, $username, $password);
} catch (mysqli_sql_exception $e) {
    die("Connection failed: " . $e->getMessage() . "<br><strong>Hint:</strong> Check your database username and password in the file. Current user: '$username', Password: " . ($password ? "SET" : "EMPTY"));
}

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Select database
if (!$conn->select_db($dbname)) {
    die("Database '$dbname' not found. Please run 'Properties' page first to initialize the database.");
}

// Check if table exists
$tableCheck = $conn->query("SHOW TABLES LIKE 'properties'");
if ($tableCheck->num_rows == 0) {
    die("Table 'properties' not found. Please run 'Properties' page first to initialize the table.");
}

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
