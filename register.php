<?php

session_start();

include_once 'connect.php';

if (isset($_POST['register_button'])) {
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  if (!($stmt = $mysqli->prepare("INSERT INTO users (username, email, password)
    VALUES (?,?,?)"))) {
    echo "Prepare failed: (".$mysqli->errno.")".$mysqli->error;
  }

  if (!$stmt->bind_param('sss', $username, $email, $password)) {
    echo "Binding paramaters failed".$stmt->errno.")".$stmt->error;
  }

  if (!$stmt->execute()) {
    ?>
        <script>
          alert('Sorry, that username is already taken. Please try again.');
        </script>
    <?php
  } else {
    ?>
        <script>
          alert('Registration successful.');
        </script>
    <?php
    echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php\">";
  }
}

$mysqli->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Your Personal Cookbook - Registration Page</title>
  <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
  <center>
    <br><br><br><br>
    <h2> Please Register </h2>
    <br><br>
  <div id="login-form">
    <form method="post" action="register.php">
    <table class="login-table" align="center" width="30%" border="0">
      <tr>
        <td>
          Username: <input type="text" name="username" required>
        </td>
      </tr>
      <tr>
        <td>
          Email: <input type="email" name="email" required>
        </td>
      </tr>
      <tr>
        <td>
          Password: <input type="password" name="password" required>
        </td>
      </tr>
      <tr>
        <td>
          <center>
            <input type="submit" value="Register Now" name="register_button">
          </center>
        </td>
      </tr>
    </table>
  </form>
    <center>
      <td>
        <br><br><br>
        <a href="index.php">Sign In</a>
      </td>
    </center>
  </div>
</center>
</body>
</html>
