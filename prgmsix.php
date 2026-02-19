<!DOCTYPE html>
<html>
<head>
  <title>Calculator & PHP Concepts Demo</title>
  <style>
    nav { margin-bottom:30px; text-align:center;}
    nav a { color: #2c5282; text-decoration: none; padding: 8px 16px;}
    nav a:hover { text-decoration: underline; }
    form { max-width: 400px; margin: 20px auto; background: #f0f9ff; padding: 20px; border-radius: 10px; }
    label { display: block; margin-top: 10px; }
    input[type="number"] { width: 100%; padding: 8px; border-radius: 6px; border: 1px solid #9ed0ea; }
    button { margin-top: 15px; background: linear-gradient(to right, #4a90e2, #2c5282); color: white; border: none; padding: 10px; border-radius: 8px; cursor: pointer; width: 100%; }
    .result { max-width: 400px; margin: 20px auto; background: #c9f7d2; padding: 15px; border-radius: 10px; color: #2b683b; font-weight: bold; }
    h2 { color: #2c5282; text-align: center; }
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
<h2>Financial Calculator</h2>

<?php
function calcGST($amt, $gst = 5) { return $amt * $gst / 100; }
function calcDiscount($amt, $percent) { return $amt * $percent / 100; }
function calculateEMI($principal, $years, $rate) {
  $n = $years * 12;
  $r = $rate / (12 * 100);
  $emi = ($principal * $r * pow(1+$r, $n)) / (pow(1+$r, $n)-1);
  return round($emi, 2);
}

$resultHTML = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $price = floatval($_POST['price']);
  $gstPerc = floatval($_POST['gst']);
  $discountPerc = floatval($_POST['discount']);
  $loanYears = intval($_POST['years']);
  $interestRate = floatval($_POST['rate']);

  $gstAmt = calcGST($price, $gstPerc);
  $discountAmt = calcDiscount($price, $discountPerc);
  $finalPrice = $price + $gstAmt - $discountAmt;
  $emi = calculateEMI($finalPrice, $loanYears, $interestRate);

  $resultHTML = "<div class='result'>";
  $resultHTML .= "Base Price: ₹" . number_format($price, 2) . "<br>";
  $resultHTML .= "GST @ $gstPerc%: ₹" . number_format($gstAmt, 2) . "<br>";
  $resultHTML .= "Discount @ $discountPerc%: -₹" . number_format($discountAmt, 2) . "<br>";
  $resultHTML .= "Final Price: ₹" . number_format($finalPrice, 2) . "<br>";
  $resultHTML .= "Monthly EMI ($loanYears years @ $interestRate%): ₹" . number_format($emi, 2);
  $resultHTML .= "</div>";
}
?>

<form method="post">
  <label for="price">Base Price (₹):</label>
  <input type="number" id="price" name="price" value="250000" required step="0.01" min="0">

  <label for="gst">GST (%):</label>
  <input type="number" id="gst" name="gst" value="5" required step="0.01" min="0">

  <label for="discount">Discount (%):</label>
  <input type="number" id="discount" name="discount" value="10" required step="0.01" min="0">

  <label for="years">Loan Period (Years):</label>
  <input type="number" id="years" name="years" value="15" required min="1" max="30">

  <label for="rate">Interest Rate (% per Year):</label>
  <input type="number" id="rate" name="rate" value="7.5" required step="0.01" min="0">

  <button type="submit">Calculate</button>
</form>

<?php echo $resultHTML; ?>

</body>
</html>
