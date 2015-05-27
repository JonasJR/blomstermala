<?php
  session_start();
  include('db.php');

  ini_set('display_errors',1);
  ini_set('display_startup_errors',1);
  error_reporting(-1);
?>

<?php
  echo print_r($_POST);

  if ( isset($_POST['username']) ) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT AnvandarID, Email, Password FROM Anvandare WHERE Email=$username AND Password=$password";

    $result = mysqli_query($link, $sql);

    if ($row = mysql_fetch_array($result)) {
      $_SESSION['id'] = $row['id'];
    } else {
      $error = "Invalid email or password";
    }
  }

  if ( isset($_POST['title']) ) {
    $title = $_POST['title'];
    $body  = $_POST['body'];

    // Code to insert
    //$sql = "INSERT INTO "
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap 101 Template</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <div class="container">
    <?php if(isset($_SESSION['id'])): ?>
      <div class="row">
        <div class="col-md-6 col-md-offset-3">
          <h1>Skriv ny artikel</h1>
          <form method="post" action="" class="form-group">
            <label for="title">Titel</label>
            <input type="text" name="title" class="form-control">
            <label for="body">Text</label>
            <textarea name="body" rows="10" class="form-control"></textarea>
            <button type="submit" class="btn btn-default pull-right">Spara</button>
          </form>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 col-md-offset-3">
        <?php
          $sql = "SELECT * FROM Artikel";
          $result = mysqli_query($link, $sql);


          if (!$result)
          {
          	echo('Fel vid inläsning av artiklar' . mysqli_error($link));
          	exit();
          }
          while ($row = mysqli_fetch_array($result)) {
            echo '<article>';
            echo '<header>' + $row['Rubrik'] + '</header>';
            echo '</article>';
          }
        ?>
        </div>
      </div>
    <?php else: ?>
      <h1>Logga in</h1>
        <?php
          if(isset($error)) {
            echo "<p>$error</p>";
          }
        ?>
      <form method="post" action="" class="form-group">
        <label for="username">Användarnamn</label>
        <input type="text" name="username" class="form-control">
        <label for="password">Lösenord</label>
        <input type="password" name="password" class="form-control">
        <button type="submit" class="btn btn-default">Login</button>
          </form>
        </div>
      </div>
    <?php endif ?>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
