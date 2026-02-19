<!DOCTYPE html>
<html>
<head>
  <title>Calculator & PHP Concepts Demo</title>
  <style>
    nav { margin-bottom:30px; text-align:center;}
    nav a { color: #2c5282; text-decoration: none; padding: 8px 16px;}
    nav a:hover { text-decoration: underline; }
    body { background: linear-gradient(to right, #e0f7fa, #f9f9f9); font-family: Segoe UI, Tahoma, Geneva, Verdana, sans-serif; margin: 0; color: #333; line-height: 1.6; padding: 20px;}
    form { max-width: 400px; margin: 20px auto; background: #fff; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
    label { display: block; margin-top: 15px; color: #2c5282; font-weight: 500;}
    input[type="number"] { width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #b6d4fe; box-sizing: border-box; margin-top: 5px;}
    button { margin-top: 20px; background: linear-gradient(to right, #2c5282, #4a90e2); color: white; border: none; padding: 12px; border-radius: 8px; cursor: pointer; width: 100%; font-size: 16px; transition: opacity 0.3s;}
    button:hover { opacity: 0.9; }
    .result { max-width: 400px; margin: 20px auto; background: #fff; padding: 20px; border-radius: 12px; color: #2b683b; font-weight: bold; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border-left: 5px solid #48bb78;}
    h2 { color: #2c5282; text-align: center; margin-bottom: 20px;}
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
