<!DOCTYPE html>
<html>
<head>
  <title>Contact & Property Search - Real Estate Hub</title>
  <style>
    nav { margin-bottom:30px; text-align:center;}
    nav a { color: #2c5282; text-decoration: none; padding: 8px 16px;}
    nav a:hover { text-decoration: underline; }
    body { background: linear-gradient(to right, #e0f7fa, #f9f9f9); font-family: Segoe UI, Tahoma, Geneva, Verdana, sans-serif; margin: 0; color: #333; line-height: 1.6; padding: 20px; max-width: 600px; margin: 20px auto;}
    form { background: #fff; padding: 25px; border-radius: 12px; margin-bottom: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
    label { display: block; margin-top: 15px; color: #2c5282; font-weight: 500;}
    input[type="text"], input[type="email"] { width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #b6d4fe; box-sizing: border-box; margin-top: 5px;}
    button { margin-top: 20px; background: linear-gradient(to right, #2c5282, #4a90e2); color: white; border: none; padding: 12px; border-radius: 8px; cursor: pointer; width: 100%; font-size: 16px; transition: opacity 0.3s;}
    button:hover { opacity: 0.9; }
    .result { background: #fff; padding: 20px; border-radius: 12px; color: #2b683b; font-weight: bold; margin-bottom: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border-left: 5px solid #48bb78;}
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
