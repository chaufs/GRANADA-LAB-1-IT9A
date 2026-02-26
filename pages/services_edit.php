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
  <style>
    :root { --primary: #154C51; --primary-hover: #0f3b3f; --surface: #ffffff; --background: #f4f6f9; --text-main: #333333; --text-muted: #666666; --border-color: #dddddd; }
    body { margin: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: var(--background); color: var(--text-main); }
    .container { padding: 30px; max-width: 1100px; margin: auto; }
    .form-container { background: var(--surface); padding: 32px; border-radius: 10px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); max-width: 500px; margin-top: 24px; }
    .form-group { margin-bottom: 20px; }
    label { display: block; font-weight: 500; margin-bottom: 8px; font-size: 14px; }
    input, select, textarea { width: 100%; padding: 12px; border: 1px solid var(--border-color); border-radius: 6px; box-sizing: border-box; }
    textarea { resize: vertical; }
    button[type="submit"] { background-color: var(--primary); color: white; padding: 12px 24px; border: none; border-radius: 6px; cursor: pointer; display: inline-block; font-weight: 500; font-size: 14px; width: 100%; margin-top: 10px;}
    button[type="submit"]:hover { background-color: var(--primary-hover); }
    .back-link { display: inline-block; margin-bottom: 15px; color: var(--text-muted); text-decoration: none; }
  </style>
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