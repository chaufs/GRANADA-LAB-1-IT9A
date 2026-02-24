<?php
include "../db.php";
$result = mysqli_query($conn, "SELECT * FROM services ORDER BY service_id DESC");
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Services</title>
  <link rel="stylesheet" href="../style.css?v=2">
</head>
<body>
<?php include "../nav.php"; ?>
 
<div class="container">
  <div class="page-header">
    <h2>Services</h2>
    </div>

  <div class="table-container">
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Rate</th>
          <th>Active</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = mysqli_fetch_assoc($result)) { ?>
          <tr>
            <td><?php echo $row['service_id']; ?></td>
            <td><?php echo htmlspecialchars($row['service_name']); ?></td>
            <td>₱<?php echo number_format($row['hourly_rate'], 2); ?></td>
            <td><?php echo $row['is_active'] ? "Yes" : "No"; ?></td>
            <td><a href="services_edit.php?id=<?php echo $row['service_id']; ?>" class="action-link">Edit</a></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

</body>
</html>