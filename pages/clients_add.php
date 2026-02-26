<?php
include "../db.php";
 
$message = "";
 
if (isset($_POST['save'])) {
  $full_name = $_POST['full_name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $address = $_POST['address'];
 
  if ($full_name == "" || $email == "") {
    $message = "Name and Email are required!";
  } else {
    $sql = "INSERT INTO clients (full_name, email, phone, address)
            VALUES ('$full_name', '$email', '$phone', '$address')";
    mysqli_query($conn, $sql);
    header("Location: clients_list.php");
    exit;
  }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Add Client</title>
  <style>
    :root { --primary: #154C51; --primary-hover: #0f3b3f; --surface: #ffffff; --background: #f4f6f9; --text-main: #333333; --text-muted: #666666; --border-color: #dddddd; }
    body { margin: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: var(--background); color: var(--text-main); }
    .container { padding: 30px; max-width: 1100px; margin: auto; }
    .form-container { background: var(--surface); padding: 32px; border-radius: 10px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); max-width: 500px; margin-top: 24px; }
    .form-group { margin-bottom: 20px; }
    label { display: block; font-weight: 500; margin-bottom: 8px; font-size: 14px; }
    input, select, textarea { width: 100%; padding: 12px; border: 1px solid var(--border-color); border-radius: 6px; box-sizing: border-box; }
    button[type="submit"] { background-color: var(--primary); color: white; padding: 12px 24px; border: none; border-radius: 6px; cursor: pointer; display: inline-block; font-weight: 500; font-size: 14px; width: 100%; margin-top: 10px;}
    button[type="submit"]:hover { background-color: var(--primary-hover); }
    .back-link { display: inline-block; margin-bottom: 15px; color: var(--text-muted); text-decoration: none; }
    .alert-error { color: #d32f2f; background: #ffebee; padding: 10px; border-radius: 6px; display: inline-block; margin-bottom: 15px; }
  </style>
</head>
<body>
<?php include "../nav.php"; ?>

<div class="container">
  <a href="clients_list.php" class="back-link">&larr; Back to Clients</a>
  <h2>Add Client</h2>
  
  <?php if($message != "") { ?>
    <div class="alert-error"><?php echo $message; ?></div>
  <?php } ?>
 
  <div class="form-container">
    <form method="post">
      <div class="form-group">
        <label>Full Name*</label>
        <input type="text" name="full_name" placeholder="e.g. Geoff Granada">
      </div>
    
      <div class="form-group">
        <label>Email*</label>
        <input type="email" name="email" placeholder="email@example.com">
      </div>
    
      <div class="form-group">
        <label>Phone</label>
        <input type="text" name="phone" placeholder="Phone number">
      </div>
    
      <div class="form-group">
        <label>Address</label>
        <input type="text" name="address" placeholder="Full address">
      </div>
    
      <button type="submit" name="save">Save Client</button>
    </form>
  </div>
</div>

</body>
</html>