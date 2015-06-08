<?php
error_reporting(E_ALL);
ob_start();
session_start();

include_once 'connect.php';

$username = $_POST['username'];
$password = $_POST['password'];

if(isset($_SESSION['user'])) {
 header("Location: main.php");
}

if (isset($_POST['login_button'])) {
  if (!($stmt = $mysqli->prepare("SELECT username, password FROM users WHERE username = ?"))) {
    echo "Prepared statement fail: (".$mysqli->errno.")".$mysqli->error;
  }

  if (!$stmt->bind_param('s', $username)) {
    echo "Binding paramaters fail:(".$stmt->errno.")".$stmt->error;
  }

  if (!$stmt->execute()) {
    echo "Execute fail: (".$stmt->errno.")".$stmt->error;
  }

  $userdata = $stmt->get_result();
  $row = $userdata->fetch_array(MYSQLI_ASSOC);
  $stmt->bind_result($username, $password);
  $stmt->store_result();

  if ($password == $row['password']) {
    $_SESSION['user'] = $_POST['username'];
    header('Location: main.php');
    exit();
  }
  else {
    ?>
      <script>
        alert("Sorry, we do not recognize that username and password combination. Please try again.");
      </script>

    <?php
  }

  $stmt->close();
}

$mysqli->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Your Personal Cookbook - Login Page</title>
  <link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>
<center>
  <br><br><br><br>
  <h1> Your Personal Cookbook </h1>
  <br><br>
  <div id="login-form">
    <form method="post" action="index.php">
    <table class="login-table" align="center" width="30%" border="0">
      <tr>
        <td>
          <b>Username:</b> <input type="text" name="username" required>
        </td>
      </tr>
      <tr>
        <td>
          <b>Password:  </b><input type="password" name="password" required>
        </td>
      </tr>
      <tr>
        <td>
          <center>
            <input type="submit" value="Log In" name="login_button">
          </center>
          </td>
        </tr>
      </table>
      </form>
      <center>
        <td>
          <br><br><br>
          <a href="register.php">Register Here</a>
        </td>
      </center>
    </div>
</center>
</body>
</html>
