<?php
error_reporting(E_ALL);
ob_start();
session_start();

include_once 'connect.php';

if(!isset($_SESSION['user'])) {
 header("Location: index.php");
}

$username = $mysqli->real_escape_string($_SESSION['user']);

?>
<!DOCTYPE html>
<html>
<head>
  <title>Welcome to Your Personal Cookbook - Add Recipe</title>
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>

  <table class="menu">
    <tr>
      <td>
        <div align="right">
          <button onclick="window.location.href='logout.php?logout'">Log Out</button>
          <br><br>
          <?php
             echo "Welcome back, <b>".$username."</b>!";
          ?>
      </td>
    </tr>
    </div>
  </table>


<table align="center" width="50%">
  <form class="database-form" method="POST" action="action.php" enctype="multipart/form-data">
  <h3>Add Recipe to Your Cookbook: </h3>
  <label>(Required) Name of Your Recipe:&nbsp;&nbsp; <input type="text" name="name" maxlength="255"></label><br><br>
  <label>Meal Type (Ie. Breakfast, Lunch, Dinner, Healthy Snack, Dessert, Weekend Brunch, etc.):&nbsp;&nbsp; <input type="text" name="category" maxlength="255"></label><br><br>
  <label>Time to Cook (In Minutes):&nbsp;&nbsp; <input type="number" min="1" max="400" name="length"></label><br><br>
  <label>(Required: .TXT FILE ONLY) Upload Recipe Instructions:&nbsp;&nbsp;
    <input type="file" name="uploaded_file"><br><br>
  <input type="submit" value="Add Recipe" name="add">
</form>
<br><br>
</table>

</body>
</html>
