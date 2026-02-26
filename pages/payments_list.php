<?php
include "../db.php";
 
$sql = "
SELECT p.*, b.booking_date, c.full_name
FROM payments p
JOIN bookings b ON p.booking_id = b.booking_id
JOIN clients c ON b.client_id = c.client_id
ORDER BY p.payment_id DESC
";
$result = mysqli_query($conn, $sql);
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Payments</title>
  <style>
    :root { --primary: #154C51; --surface: #ffffff; --background: #f4f6f9; --text-main: #333333; --text-muted: #666666; --border-color: #dddddd; }
    body { margin: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: var(--background); color: var(--text-main); }
    .container { padding: 30px; max-width: 1100px; margin: auto; }
    .page-header { margin-bottom: 20px; }
    .page-header h2 { margin: 0; }
    .table-container { background: var(--surface); padding: 20px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th { text-align: left; background-color: #f8f9fa; padding: 15px; border-bottom: 2px solid var(--border-color); color: var(--text-muted); font-size: 14px; }
    td { padding: 15px; border-bottom: 1px solid var(--border-color); font-size: 15px; }
    tr:hover { background-color: #fcfcfc; }
  </style>
</head>
<body>
<?php include "../nav.php"; ?>
 
<div class="container">
  <div class="page-header">
    <h2>Payments</h2>
  </div>

  <div class="table-container">
    <table>
      <tr>
        <th>ID</th><th>Client</th><th>Booking ID</th><th>Amount</th><th>Method</th><th>Date</th>
      </tr>
      <?php while($p = mysqli_fetch_assoc($result)) { ?>
        <tr>
          <td><?php echo $p['payment_id']; ?></td>
          <td><?php echo $p['full_name']; ?></td>
          <td><?php echo $p['booking_id']; ?></td>
          <td>₱<?php echo number_format($p['amount_paid'],2); ?></td>
          <td><?php echo $p['method']; ?></td>
          <td><?php echo $p['payment_date']; ?></td>
        </tr>
      <?php } ?>
    </table>
  </div>
</div>
</body>
</html>