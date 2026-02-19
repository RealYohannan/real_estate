<!DOCTYPE html>
<html>
<head>
  <title>Contact & Property Search - Real Estate Hub</title>
  <style>
    nav { margin-bottom:30px; text-align:center;}
    nav a { color: #2c5282; text-decoration: none; padding: 8px 16px;}
    nav a:hover { text-decoration: underline; }
    body { font-family: Arial,sans-serif; max-width: 600px; margin: 20px auto; }
    form { background: #f0f9ff; padding: 20px; border-radius: 10px; margin-bottom: 20px; }
    label { display: block; margin-top: 10px; }
    input[type="text"], input[type="email"] { width: 100%; padding: 8px; border-radius: 6px; border: 1px solid #9ed0ea; }
    button { margin-top: 15px; background: linear-gradient(to right, #4a90e2, #2c5282); color: white; border: none; padding: 10px; border-radius: 8px; cursor: pointer; width: 100%; }
    .result { background: #c9f7d2; padding: 15px; border-radius: 10px; color: #2b683b; font-weight: bold; margin-bottom: 20px; }
  </style>
</head>
<body>
<nav>
  <a href="home.html">Home</a> |
  <a href="prgm09.php">Properties</a> |
  <a href="prgm10.php">Update</a> |
  <a href="prgmsix.php">Calculator</a> |
  <a href="pgm07.php">Contact & Search</a>
</nav>

<form method="get">
  <label for="buyerName">Your Name</label>
  <input type="text" id="buyerName" name="buyerName" placeholder="Enter your name">
  <label for="locationInterest">Preferred Location</label>
  <input type="text" id="locationInterest" name="locationInterest" placeholder="Enter preferred property location">
  <button type="submit">Search Properties</button>
</form>

<?php
if (isset($_GET['buyerName']) || isset($_GET['locationInterest'])) {
    $name = htmlspecialchars($_GET['buyerName'] ?? '');
    $location = htmlspecialchars($_GET['locationInterest'] ?? '');
    if($name || $location) {
        echo "<div class='result'>Thank you, <strong>$name</strong>. Searching properties near: <strong>$location</strong>.</div>";
        echo "<p>Results:</p><ul>";
        // For demo, just echo static sample results matching location keyword
        $properties = [
            ['name' => 'Sunset Villas', 'location' => 'Goa'],
            ['name' => 'Downtown Office Complex', 'location' => 'Bangalore'],
            ['name' => 'Greenwood Apartments', 'location' => 'Chennai'],
            ['name' => 'Skyline Towers', 'location' => 'Mumbai'],
            ['name' => 'Lakeview Homes', 'location' => 'Kerala']
        ];
        $found = false;
        foreach ($properties as $prop) {
            if($location == '' || stripos($prop['location'], $location) !== false) {
                echo "<li>" . htmlspecialchars($prop['name']) . " - " . htmlspecialchars($prop['location']) . "</li>";
                $found = true;
            }
        }
        if (!$found) echo "<li>No properties found matching your location.</li>";
        echo "</ul>";
    }
}
?>

<form method="post">
  <label for="email">Your Email</label>
  <input type="email" id="email" name="email" placeholder="Enter your email" required>
  <label for="phone">Your Phone</label>
  <input type="text" id="phone" name="phone" placeholder="Enter your phone number" required>
  <button type="submit">Send Contact Details</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = htmlspecialchars($_POST['email'] ?? '');
    $phone = htmlspecialchars($_POST['phone'] ?? '');
    if ($email && $phone) {
        echo "<div class='result'>Thank you for sharing your contact details: <br>Email: <strong>$email</strong><br>Phone: <strong>$phone</strong></div>";
    } else {
        echo "<div class='result' style='color: red;'>Please fill both email and phone to submit.</div>";
    }
}
?>

</body>
</html>
