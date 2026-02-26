<?php
include "../db.php";
 
$clients = mysqli_query($conn, "SELECT * FROM clients ORDER BY full_name ASC");
$services = mysqli_query($conn, "SELECT * FROM services WHERE is_active=1 ORDER BY service_name ASC");
 
if (isset($_POST['create'])) {
  $client_id = $_POST['client_id'];
  $service_id = $_POST['service_id'];
  $booking_date = $_POST['booking_date'];
  $hours = $_POST['hours'];
 
  $s = mysqli_fetch_assoc(mysqli_query($conn, "SELECT hourly_rate FROM services WHERE service_id=$service_id"));
  $rate = $s['hourly_rate'];
 
  $total = $rate * $hours;
 
  mysqli_query($conn, "INSERT INTO bookings (client_id, service_id, booking_date, hours, hourly_rate_snapshot, total_cost, status)
    VALUES ($client_id, $service_id, '$booking_date', $hours, $rate, $total, 'PENDING')");
 
  header("Location: bookings_list.php");
  exit;
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Create Booking</title>
  <style>
    :root { --primary: #154C51; --primary-hover: #0f3b3f; --surface: #ffffff; --background: #f4f6f9; --text-main: #333333; --text-muted: #666666; --border-color: #dddddd; }
    body { margin: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: var(--background); color: var(--text-main); }
    .container { padding: 30px; max-width: 1100px; margin: auto; }
    .form-container { background: var(--surface); padding: 32px; border-radius: 10px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); max-width: 500px; margin-top: 24px; }
    .form-group { margin-bottom: 20px; }
    label { display: block; font-weight: 500; margin-bottom: 8px; font-size: 14px; }
    input, select { width: 100%; padding: 12px; border: 1px solid var(--border-color); border-radius: 6px; box-sizing: border-box; }
    button[type="submit"] { background-color: var(--primary); color: white; padding: 12px 24px; border: none; border-radius: 6px; cursor: pointer; display: inline-block; font-weight: 500; font-size: 14px; width: 100%; margin-top: 10px;}
    button[type="submit"]:hover { background-color: var(--primary-hover); }
    .back-link { display: inline-block; margin-bottom: 15px; color: var(--text-muted); text-decoration: none; }
  </style>
</head>
<body>
<?php include "../nav.php"; ?>
 
<div class="container">
  <a href="bookings_list.php" class="back-link">&larr; Back to Bookings</a>
  <h2>Create Booking</h2>
 
  <div class="form-container">
    <form method="post">
      <div class="form-group">
        <label>Client</label>
        <select name="client_id">
          <?php while($c = mysqli_fetch_assoc($clients)) { ?>
            <option value="<?php echo $c['client_id']; ?>"><?php echo $c['full_name']; ?></option>
          <?php } ?>
        </select>
      </div>
    
      <div class="form-group">
        <label>Service</label>
        <select name="service_id">
          <?php while($s = mysqli_fetch_assoc($services)) { ?>
            <option value="<?php echo $s['service_id']; ?>">
              <?php echo $s['service_name']; ?> (₱<?php echo number_format($s['hourly_rate'],2); ?>/hr)
            </option>
          <?php } ?>
        </select>
      </div>
    
      <div class="form-group">
        <label>Date</label>
        <input type="date" name="booking_date">
      </div>
    
      <div class="form-group">
        <label>Hours</label>
        <input type="number" name="hours" min="1" value="1">
      </div>
    
      <button type="submit" name="create">Create Booking</button>
    </form>
  </div>
</div>
</body>