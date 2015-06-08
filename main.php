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
  <title>Welcome to Your Personal Cookbook</title>
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
  <table class="menu">
    <tr>
      <td>
        <div align="left">
          <button onclick="window.location.href='addRecipe.php'">Add Recipe to Cookbook</button><br><br>
          <button onclick="window.open('favorites.php');">Your Favorite Recipes</button>
        </div>
      </td>
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
  <h2> Your Personal Cookbook: </h2>
  <table class="header-table">
  <tr>
  <td>
  <?php
    if (!isset($_POST["categories"])) {
      $filter = 'All Recipes';
    }
    else {
      $filter = $_POST["categories"];
    }
  ?>
  <form class="database-form" method="POST" action="main.php">
    <label><div align="right">Filter by Meal Type: <select name="categories">
      <option value="All Recipes">All Recipes</option>
      <?php
        $mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

        if (!$mysqli || $mysqli->connect_errno) {
          echo "Error connection to MySQLi Session(".$mysqli->connect_errno."): ".$mysqli->connect_error;
        }

        $display_categories = "SELECT DISTINCT category FROM videodb WHERE username = '".$username."'";

        if ($all = $mysqli->query($display_categories)) {
          while ($row = $all->fetch_row()) {
            echo '<option name="categories" value="'.$row[0].'">'.$row[0].'</option>';
          }
        }

        $all->close();
      ?>
    </select></label>
    <input type="submit" value="Filter Recipes"></div>
  </form></td>
 </table>
  <table class="main-table">
    <tr>
      <td><h3>Recipe Name</h3></td><td><h3>Meal Type</h3></td><td><h3>Cooking Time</h3></td><td><h3>Recipe Instructions</h3></td><td><h3>Favorite Recipe</h3></td><td><h3>Remove?</h3></td>
    </tr>
  <?php
    $mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if (!$mysqli || $mysqli->connect_errno) {
      echo "Error connection to MySQLi Session(".$mysqli->connect_errno."): ".$mysqli->connect_error;
    }

    if ($filter != 'All Recipes') {
      $filtering = "SELECT id, name, category, length, recipe, favorite FROM videodb WHERE category = '".$filter."' && username = '".$username."'";
    }
    else{
      $filtering = "SELECT id, name, category, length, recipe, favorite FROM videodb WHERE username = '".$username."'";
    }

    $dbTable = $mysqli->query($filtering);
    if ($dbTable->num_rows > 0) {
      while ($row = $dbTable->fetch_row()) {
        if ($row[5] === '1') {
          $status = 'Favorite';
        }
        elseif ($row[5] === '0') {
          $status = ' ';
        }
        $idNum = $row[0];
        echo "<tr><td>".$row[1]."</td><td>".$row[2]."</td><td>".$row[3]."</td><td>";
        $thing = $row[4];
        $output = str_replace(array("\r\n", "\n", "\\n"), '<br>', $thing);
        echo "<table class=\"recipe\"><tr><td>".$output."</td></tr></table>";
        echo "</td>";
        if ($row[5] === '0') {
          echo "<td>".$status."<form action='action.php' method='POST'><input type='hidden' name='id' value='$idNum'><input type='submit' name='favorite' value='Make Favorite'></form></td>";
        }
        elseif ($row[5] === '1'){
          echo "<td>".$status."<form action='action.php' method='POST'><input type='hidden' name='id' value='$idNum'><input type='submit' name='unfav' value='Unfavorite'></form></td>";
        }
        echo "<form action='action.php' method='POST'><input type='hidden' name='id' value='$idNum'><td><input type='submit' name='remove' value='Remove'></form></td>";
      }
    }
  ?>
  </table>
  <br><br>
</div>
</body>
</html>
