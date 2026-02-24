<?php
include "../db.php";
$id = $_GET['id'];
 
$get = mysqli_query($conn, "SELECT * FROM services WHERE service_id = $id");
$service = mysqli_fetch_assoc($get);
 
if (isset($_POST['update'])) {
  $name = $_POST['service_name'];
  $desc = $_POST['description'];
  $rate = $_POST['hourly_rate'];
  $active = $_POST['is_active'];
 
  mysqli_query($conn, "UPDATE services
    SET service_name='$name', description='$desc', hourly_rate='$rate', is_active='$active'
    WHERE service_id=$id");
 
  header("Location: services_list.php");
  exit;
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Edit Service</title>
  <link rel="stylesheet" href="../style.css?v=3">
</head>
<body>
<?php include "../nav.php"; ?>
 
<div class="container">
  <a href="services_list.php" class="back-link">&larr; Back to Services</a>

  <div class="page-header">
    <h2>Edit Service</h2>
  </div>
 
  <div class="form-container">
    <form method="post">
      <div class="form-group">
        <label for="service_name">Service Name</label>
        <input type="text" id="service_name" name="service_name" value="<?php echo htmlspecialchars($service['service_name']); ?>" required>
      </div>
    
      <div class="form-group">
        <label for="description">Description</label>
        <textarea id="description" name="description" rows="4"><?php echo htmlspecialchars($service['description']); ?></textarea>
      </div>
    
      <div class="form-group">
        <label for="hourly_rate">Hourly Rate</label>
        <input type="text" id="hourly_rate" name="hourly_rate" value="<?php echo htmlspecialchars($service['hourly_rate']); ?>" required>
      </div>
    
      <div class="form-group">
        <label for="is_active">Active</label>
        <select id="is_active" name="is_active">
          <option value="1" <?php if($service['is_active']==1) echo "selected"; ?>>Yes</option>
          <option value="0" <?php if($service['is_active']==0) echo "selected"; ?>>No</option>
        </select>
      </div>
    
      <button type="submit" name="update">Update</button>
    </form>
  </div>
</div>

</body>
</html>