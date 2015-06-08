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
  <title><?php echo $username ?>'s Favorite Recipes - Your Personal Cookbook</title>
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
  <table class="menu">
    <tr>
      <td>
        <div align="right">
          <b>Share Favorite Recipes with Friends!</b><br> <button onclick="window.location.href='share.php?username=<?php echo $username ?>'">Click Here for Link to Share</button>
          <br><br>
          <button onclick="window.location.href='http://www.facebook.com/sharer.php?u=http://web.engr.oregonstate.edu/~hahnl/final_project/share.php?username=<?php echo $username ?>'">Share On Facebook</button>
          <br><br>
          <button onClick="window.print()">Print Favorite Recipes</button>
          <br><br>

      </td>
    </tr>
    </div>
  </table>
  <h2><?php
     echo $username."'s Favorite Recipes";
  ?></h2>
  <table class="main-table">
    <tr>
      <td><h3>Recipe Name</h3></td><td><h3>Meal Type</h3></td><td><h3>Cooking Time</h3></td><td width="50%"><h3>Recipe Instructions</h3></td>
    </tr>
  <?php
    $filtering = "SELECT id, name, category, length, recipe, favorite FROM videodb WHERE favorite = '1' && username = '".$username."'";

    $dbTable = $mysqli->query($filtering);
    if ($dbTable->num_rows > 0) {
      while ($row = $dbTable->fetch_row()) {
        echo "<tr><td>".$row[1]."</td><td>".$row[2]."</td><td>".$row[3]."</td><td>";
        $thing = $row[4];
        $output = str_replace(array("\r\n", "\n", "\\n"), '<br>', $thing);
        echo "<table class=\"recipe\"><tr><td>".$output."</td></tr></table>";
        echo "</td>";
      }
    }
  ?>
</table>
<br><br>
</div>
</body>
</html>
