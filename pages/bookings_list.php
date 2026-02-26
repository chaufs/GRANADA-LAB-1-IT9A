<?php
include "../db.php";
 
$sql = "
SELECT b.*, c.full_name AS client_name, s.service_name
FROM bookings b
JOIN clients c ON b.client_id = c.client_id
JOIN services s ON b.service_id = s.service_id
ORDER BY b.booking_id DESC
";
$result = mysqli_query($conn, $sql);
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Bookings</title>
  <style>
    :root { --primary: #154C51; --primary-hover: #0f3b3f; --surface: #ffffff; --background: #f4f6f9; --text-main: #333333; --text-muted: #666666; --border-color: #dddddd; }
    body { margin: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: var(--background); color: var(--text-main); }
    .container { padding: 30px; max-width: 1100px; margin: auto; }
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    .page-header h2 { margin: 0; }
    .table-container { background: var(--surface); padding: 20px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th { text-align: left; background-color: #f8f9fa; padding: 15px; border-bottom: 2px solid var(--border-color); color: var(--text-muted); font-size: 14px; }
    td { padding: 15px; border-bottom: 1px solid var(--border-color); font-size: 15px; }
    tr:hover { background-color: #fcfcfc; }
    .btn-add { background-color: var(--primary); color: white; padding: 10px 20px; border: none; border-radius: 6px; text-decoration: none; cursor: pointer; display: inline-block; font-weight: 500; font-size: 14px; }
    .btn-add:hover { background-color: var(--primary-hover); }
    .action-link { color: var(--primary); text-decoration: none; font-weight: 600; }
  </style>
</head>
<body>
<?php include "../nav.php"; ?>
 
<div class="container">
  <div class="page-header">
    <h2>Bookings</h2>
    <a href="bookings_create.php" class="btn-add">+ Create Booking</a>
  </div>
 
  <div class="table-container">
    <table>
      <tr>
        <th>ID</th><th>Client</th><th>Service</th><th>Date</th><th>Hours</th><th>Total</th><th>Status</th><th>Action</th>
      </tr>
      <?php while($b = mysqli_fetch_assoc($result)) { ?>
        <tr>
          <td><?php echo $b['booking_id']; ?></td>
          <td><?php echo $b['client_name']; ?></td>
          <td><?php echo $b['service_name']; ?></td>
          <td><?php echo $b['booking_date']; ?></td>
          <td><?php echo $b['hours']; ?></td>
          <td>₱<?php echo number_format($b['total_cost'],2); ?></td>
          <td><?php echo $b['status']; ?></td>
          <td>
            <a href="payment_process.php?booking_id=<?php echo $b['booking_id']; ?>" class="action-link">Process Payment</a>
          </td>
        </tr>
      <?php } ?>
    </table>
  </div>
</div>
</body>
</html>