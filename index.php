 
<?php
session_start();
 
// If not logged in, redirect to login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}?>


<?php 
include "db.php";

$clients = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM clients"))['c'];
$services = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS s FROM services"))['s'];
$bookings = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS b FROM bookings"))['b'];

$revRow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(SUM(amount_paid),0) AS s FROM payments"));
$revenue = $revRow['s'];
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Dashboard</title>
  <style>
    :root { --primary: #154C51; --primary-hover: #0f3b3f; --surface: #ffffff; --background: #f4f6f9; --text-main: #333333; --text-muted: #666666; }
    body { margin: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: var(--background); color: var(--text-main); }
    .container { padding: 30px; max-width: 1100px; margin: auto; }
    h2 { margin-bottom: 25px; color: #333; }
    .cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 30px; }
    .card { background: var(--surface); padding: 25px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
    .card h3 { margin: 0 0 10px; font-size: 15px; color: var(--text-muted); font-weight: 500; }
    .card .value { font-size: 28px; font-weight: bold; color: var(--primary); }
    .links { margin-top: 20px; }
    .btn { display: inline-block; padding: 10px 18px; border-radius: 8px; text-decoration: none; font-weight: 500; margin-right: 10px; transition: 0.2s; font-size: 15px; }
    .btn-primary { background: var(--primary); color: white; }
    .btn-primary:hover { background: var(--primary-hover); }
    .btn-secondary { background: #e4e6eb; color: #333; }
    .btn-secondary:hover { background: #d0d3d8; }
  </style>
</head>
<body>

<?php include "nav.php"; ?>
<h2 style = "margin-bottom: 25px; text-align: center;">Welcome, <?php echo $_SESSION['username']; ?>!</h2>
<div class="container">
  <h2>Dashboard Overview</h2>

  <div class="cards">
    <div class="card">
      <h3>Total Clients</h3>
      <div class="value"><?php echo $clients; ?></div>
    </div>

    <div class="card">
      <h3>Total Services</h3>
      <div class="value"><?php echo $services; ?></div>
    </div>

    <div class="card">
      <h3>Total Bookings</h3>
      <div class="value"><?php echo $bookings; ?></div>
    </div>

    <div class="card">
      <h3>Total Revenue</h3>
      <div class="value">₱<?php echo number_format($revenue,2); ?></div>
    </div>
  </div>

  <div class="links">
    <a href="/assessment/pages/clients_add.php" class="btn btn-primary">+ Add Client</a>
    <a href="/assessment/pages/services_list.php" class="btn btn-secondary">Services</a>
    <a href="/assessment/pages/bookings_create.php" class="btn btn-secondary">+ Create Booking</a>
  </div>
</div>

</body>
</html>