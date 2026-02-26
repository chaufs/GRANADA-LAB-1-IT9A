<?php
include "../db.php";
 
$message = "";
 
if (isset($_POST['assign'])) {
  // SECURITY FIX: Cast POST variables to integers
  $booking_id = intval($_POST['booking_id']);
  $tool_id = intval($_POST['tool_id']);
  $qty = intval($_POST['qty_used']);
 
  if ($qty <= 0) {
      $message = "<span style='color:#d32f2f; background: #ffebee; padding: 10px; border-radius: 6px; display:inline-block; margin-bottom: 15px;'>Quantity must be at least 1!</span>";
  } else {
      $toolRow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT quantity_available FROM tools WHERE tool_id=$tool_id"));
     
      if ($qty > $toolRow['quantity_available']) {
        $message = "<span style='color:#d32f2f; background: #ffebee; padding: 10px; border-radius: 6px; display:inline-block; margin-bottom: 15px;'>Not enough available tools!</span>";
      } else {
        mysqli_query($conn, "INSERT INTO booking_tools (booking_id, tool_id, qty_used) VALUES ($booking_id, $tool_id, $qty)");
        mysqli_query($conn, "UPDATE tools SET quantity_available = quantity_available - $qty WHERE tool_id=$tool_id");
        $message = "<span style='color:#2e7d32; background: #e8f5e9; padding: 10px; border-radius: 6px; display:inline-block; margin-bottom: 15px;'>Tool assigned successfully!</span>";
      }
  }
}
 
$tools = mysqli_query($conn, "SELECT * FROM tools ORDER BY tool_name ASC");
$bookings = mysqli_query($conn, "SELECT booking_id FROM bookings ORDER BY booking_id DESC");
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Tools</title>
  <style>
    :root { --primary: #154C51; --primary-hover: #0f3b3f; --surface: #ffffff; --background: #f4f6f9; --text-main: #333333; --text-muted: #666666; --border-color: #dddddd; }
    body { margin: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: var(--background); color: var(--text-main); }
    .container { padding: 30px; max-width: 1100px; margin: auto; }
    .table-container { background: var(--surface); padding: 20px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow-x: auto; margin-bottom: 40px; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th { text-align: left; background-color: #f8f9fa; padding: 15px; border-bottom: 2px solid var(--border-color); color: var(--text-muted); font-size: 14px; }
    td { padding: 15px; border-bottom: 1px solid var(--border-color); font-size: 15px; }
    tr:hover { background-color: #fcfcfc; }
    .form-container { background: var(--surface); padding: 32px; border-radius: 10px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); max-width: 500px; }
    .form-group { margin-bottom: 20px; }
    label { display: block; font-weight: 500; margin-bottom: 8px; font-size: 14px; }
    input, select { width: 100%; padding: 12px; border: 1px solid var(--border-color); border-radius: 6px; box-sizing: border-box; }
    button[type="submit"] { background-color: var(--primary); color: white; padding: 12px 24px; border: none; border-radius: 6px; cursor: pointer; width: 100%; font-size: 15px; font-weight: 500; margin-top: 10px;}
    button[type="submit"]:hover { background-color: var(--primary-hover); }
    h2, h3 { color: #333; }
  </style>
</head>
<body>
<?php include "../nav.php"; ?>
 
<div class="container">
  <h2>Tools & Inventory</h2>
  <?php if($message != "") echo $message; ?>
 
  <h3>Available Tools</h3>
  <div class="table-container">
    <table>
      <tr><th>Name</th><th>Total</th><th>Available</th></tr>
      <?php while($t = mysqli_fetch_assoc($tools)) { ?>
        <tr>
          <td><?php echo $t['tool_name']; ?></td>
          <td><?php echo $t['quantity_total']; ?></td>
          <td><strong><?php echo $t['quantity_available']; ?></strong></td>
        </tr>
      <?php } ?>
    </table>
  </div>
 
  <h3>Assign Tool to Booking</h3>
  <div class="form-container">
    <form method="post">
      <div class="form-group">
        <label>Booking ID</label>
        <select name="booking_id">
          <?php while($b = mysqli_fetch_assoc($bookings)) { ?>
            <option value="<?php echo $b['booking_id']; ?>">#<?php echo $b['booking_id']; ?></option>
          <?php } ?>
        </select>
      </div>
    
      <div class="form-group">
        <label>Tool</label>
        <select name="tool_id">
          <?php
            // Re-fetch tools for the dropdown
            $tools2 = mysqli_query($conn, "SELECT * FROM tools ORDER BY tool_name ASC");
            while($t2 = mysqli_fetch_assoc($tools2)) {
          ?>
            <option value="<?php echo $t2['tool_id']; ?>">
              <?php echo $t2['tool_name']; ?> (Avail: <?php echo $t2['quantity_available']; ?>)
            </option>
          <?php } ?>
        </select>
      </div>
    
      <div class="form-group">
        <label>Qty Used</label>
        <input type="number" name="qty_used" min="1" value="1" required>
      </div>
    
      <button type="submit" name="assign">Assign Tool</button>
    </form>
  </div>
</div>
 
</body>
</html>