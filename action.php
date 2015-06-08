<?php
  error_reporting(E_ALL);
  ob_start();
  session_start();

  ini_set('display_errors','On');

  $mysqli = new mysqli("oniddb.cws.oregonstate.edu", "hahnl-db", "3C15z4js2nneWpks", "hahnl-db");

  if (!$mysqli || $mysqli->connect_errno) {
    echo "Error connecting to MySQLi Session:(".$mysqli->connect_errno."): ".$mysqli->connect_error;
  }

  if (isset($_POST["add"])) {
    addToDatabase();
  }
  if (isset($_POST["favorite"])) {
    favoriteRecipe();
  }
  if (isset($_POST["unfav"])) {
    unfavoriteRecipe();
  }
  if (isset($_POST["remove"])) {
    removeRecipe();
  }

  function addToDatabase() {
    $mysqli = new mysqli("oniddb.cws.oregonstate.edu", "hahnl-db", "3C15z4js2nneWpks", "hahnl-db");

    if (!$mysqli || $mysqli->connect_errno) {
      echo "Error connecting to MySQLi Session:(".$mysqli->connect_errno."): ".$mysqli->connect_error;
    }

    $name = $_POST["name"];
    $category = $_POST["category"];
    $length = $_POST["length"];
    $username = $mysqli->real_escape_string($_SESSION['user']);

    if (isset($_FILES['uploaded_file'])) {
      if ($_FILES['uploaded_file']['error'] == 0) {
        $recipe = $mysqli->real_escape_string(file_get_contents($_FILES ['uploaded_file']['tmp_name']));
      }
    }

    if ($name == NULL) {
      echo "The name field is a required field and must be unique.";
      echo "<meta http-equiv=\"refresh\" content=\"2;URL=addRecipe.php\">";
      exit(1);
    }

    if(!($adding = $mysqli->prepare("INSERT INTO videodb (name, category, length, recipe, username) VALUES (?,?,?,?,?)"))) {
      echo "Prepare failed.";
    }

    if (!$adding->bind_param("ssiss", $name, $category, $length, $recipe, $username)) {
      echo "Binding parameters failed.";
    }

    if (!$adding->execute()) {
?>
      <script>
        alert("Failed to meet requirements. Try again.");
      </script>

<?php
      echo "<meta http-equiv=\"refresh\" content=\"0;URL=addRecipe.php\">";
      exit(1);
    }

    echo "<meta http-equiv=\"refresh\" content=\"0;URL=main.php\">";
  }

  function favoriteRecipe() {
    $mysqli = new mysqli("oniddb.cws.oregonstate.edu", "hahnl-db", "3C15z4js2nneWpks", "hahnl-db");

    if (!$mysqli || $mysqli->connect_errno) {
      echo "Error connecting to MySQLi Session:(".$mysqli->connect_errno."): ".$mysqli->connect_error;
    }

    $id = $_POST["id"];
    $fav = $mysqli->prepare("UPDATE videodb SET favorite = 1 WHERE id = ?");
    $fav->bind_param("i", $id);
    $fav->execute();
    $fav->close();
    echo "<meta http-equiv=\"refresh\" content=\"0;URL=main.php\">";
  }

  function unfavoriteRecipe() {
    $mysqli = new mysqli("oniddb.cws.oregonstate.edu", "hahnl-db", "3C15z4js2nneWpks", "hahnl-db");

    if (!$mysqli || $mysqli->connect_errno) {
      echo "Error connecting to MySQLi Session:(".$mysqli->connect_errno."): ".$mysqli->connect_error;
    }

    $id = $_POST["id"];
    $unfav = $mysqli->prepare("UPDATE videodb SET favorite = 0 WHERE id = ?");
    $unfav->bind_param("i", $id);
    $unfav->execute();
    $unfav->close();
    echo "<meta http-equiv=\"refresh\" content=\"0;URL=main.php\">";
  }

  function removeRecipe() {
    $mysqli = new mysqli("oniddb.cws.oregonstate.edu", "hahnl-db", "3C15z4js2nneWpks", "hahnl-db");

    if (!$mysqli || $mysqli->connect_errno) {
      echo "Error connecting to MySQLi Session:(".$mysqli->connect_errno."): ".$mysqli->connect_error;
    }

    $id = $_POST["id"];
    $remove = $mysqli->prepare("DELETE FROM videodb WHERE id = ?");
    $remove->bind_param("i", $id);
    $remove->execute();
    $remove->close();
    echo "<meta http-equiv=\"refresh\" content=\"0;URL=main.php\">";
  }
?>
