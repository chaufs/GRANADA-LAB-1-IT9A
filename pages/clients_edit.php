<?php
include "../db.php";
 
// SECURITY FIX: Ensure the ID is strictly an integer
$booking_id = isset($_GET['booking_id']) ? intval($_GET['booking_id']) : 0;
 
$get_booking = mysqli_query($conn, "SELECT * FROM bookings WHERE booking_id=$booking_id");
if(mysqli_num_rows($get_booking) == 0) {
    die("Booking not found.");
}
$booking = mysqli_fetch_assoc($get_booking);
 
$paidRow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(SUM(amount_paid),0) AS paid FROM payments WHERE booking_id=$booking_id"));
$total_paid = $paidRow['paid'];
 
$balance = $booking['total_cost'] - $total_paid;
$message = "";
 
if (isset($_POST['pay'])) {
  // SECURITY FIX: Sanitize inputs before database insertion
  $amount = floatval($_POST['amount_paid']);
  $method = mysqli_real_escape_string($conn, $_POST['method']);
 
  if ($amount <= 0) {
    $message = "Invalid amount!";
  } else if ($amount > $balance) {
    $message = "Amount exceeds balance!";
  } else {
    // 1) Insert payment
    mysqli_query($conn, "INSERT INTO payments (booking_id, amount_paid, method) VALUES ($booking_id, $amount, '$method')");
    
    // 2) Recompute total paid 
    $paidRow2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(SUM(amount_paid),0) AS paid FROM payments WHERE booking_id=$booking_id"));
    $total_paid2 = $paidRow2['paid'];
    
    // 3) Recompute new balance
    $new_balance = $booking['total_cost'] - $total_paid2;
 
    // 4) Update status if fully paid (using a small float threshold for accuracy)
    if ($new_balance <= 0.009) {
      mysqli_query($conn, "UPDATE bookings SET status='PAID' WHERE booking_id=$booking_id");
    }
    
    header("Location: bookings_list.php");
    exit;
  }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Process Payment</title>
  <style>
    :root { --primary: #154C51; --primary-hover: #0f3b3f; --surface: #ffffff; --background: #f4f6f9; --text-main: #333333; --text-muted: #666666; --border-color: #dddddd; }
    body { margin: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: var(--background); color: var(--text-main); }
    .container { padding: 30px; max-width: 1100px; margin: auto; }
    .form-container { background: var(--surface); padding: 32px; border-radius: 10px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); max-width: 500px; margin-top: 24px; }
    .form-group { margin-bottom: 20px; }
    label { display: block; font-weight: 500; margin-bottom: 8px; font-size: 14px; }
    input, select { width: 100%; padding: 12px; border: 1px solid var(--border-color); border-radius: 6px; box-sizing: border-box; }
    button[type="submit"] { background-color: var(--primary); color: white; padding: 12px 24px; border: none; border-radius: 6px; cursor: pointer; width: 100%; font-size: 15px; font-weight: 500; margin-top: 10px;}
    button[type="submit"]:hover { background-color: var(--primary-hover); }
    .back-link { display: inline-block; margin-bottom: 15px; color: var(--text-muted); text-decoration: none; }
    .summary-box { background: #e8ecef; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
    .summary-box p { margin: 5px 0; }
  </style>
</head>
<body>
<?php include "../nav.php"; ?>
 
<div class="container">
  <a href="bookings_list.php" class="back-link">&larr; Back to Bookings</a>
  <h2>Process Payment (Booking #<?php echo $booking_id; ?>)</h2>
 
  <div class="form-container">
    <div class="summary-box">
      <p>Total Cost: ₱<?php echo number_format($booking['total_cost'],2); ?></p>
      <p>Total Paid: ₱<?php echo number_format($total_paid,2); ?></p>
      <p style="font-size: 18px; color: #154C51;"><b>Balance: ₱<?php echo number_format($balance,2); ?></b></p>
    </div>

    <?php if($message != "") { ?>
      <p style="color:#d32f2f; background: #ffebee; padding: 10px; border-radius: 6px;"><?php echo $message; ?></p>
    <?php } ?>

    <?php if($balance > 0) { ?>
    <form method="post">
      <div class="form-group">
        <label>Amount Paid</label>
        <input type="number" name="amount_paid" step="0.01" max="<?php echo $balance; ?>" required>
      </div>
    
      <div class="form-group">
        <label>Method</label>
        <select name="method">
          <option value="CASH">CASH</option>
          <option value="GCASH">GCASH</option>
          <option value="CARD">CARD</option>
        </select>
      </div>
    
      <button type="submit" name="pay">Save Payment</button>
    </form>
    <?php } else { ?>
      <p style="color: #2e7d32; font-weight: bold; text-align: center;">This booking is fully paid.</p>
    <?php } ?>
  </div>
</div>
</body>
</html>