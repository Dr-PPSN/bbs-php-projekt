<?php

// Page für SQL-Injection

require '../lib/sql.php';

$inputHTML = '<input type="text" class="form-control" id="sql-injection-text" name="sql-injection-text" placeholder="SQL">';
if (isset($_POST['btnSQLInjection'])) {
  $SQL = $_POST['sql-injection-text'];
  $inputHTML = '<input type="text" class="form-control" id="sql-injection-text" name="sql-injection-text" placeholder="SQL" value="' . $SQL . '">';
  $result = executeSQL($SQL);
}


?>

<!DOCTYPE html>
<html lang=de>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta charset="utf-8">
    <title>BBS PHP Projekt</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../styles/message.css">
    <link rel="stylesheet" type="text/css" href="../styles/style.css">
  </head>
  <body>
    <div class="container-fluid h-100 bg-dark">
      <div class="row bg-dark">
        <div class="col-sm-3 col-md-2 d-flex align-items-center justify-content-center pr-4 mb-2 mt-3">
          <form action="../index.php">
            <button type="submit" class="btn neon-button">Zurück</button>
          </form>
        </div>
        <div class="col-sm-6 col-md-8 py-4 h1 neonTextFlickerGreen" id="ueberschrift">
          <div class="d-flex align-items-center justify-content-center text-center">PHP Projekt Buchladen</div>
        </div>
        <div class="col-sm-3 col-md-2 d-flex align-items-center justify-content-center pr-4 mb-2 mt-3">
          <form action="pages/sqlinjection.php" method="post">
            <button type="submit" name="sqlinjection" class="btn neon-button" id="btnSQLInjection">SQL Injection</button>
          </form>
        </div>
      </div>
      <br><br>
      <!-- Die ausgewaelte Tabelle -->
      <div class="row bg-dark mt-5">
        <div class="col-md-1 align-items-center justify-content-center"></div>
        <div class="col-md-10 align-items-center justify-content-center" id="tableElement">
          <form action="" method="post">
            <?php echo $inputHTML; ?>
            <div class="d-flex align-items-center justify-content-center">
              <button type="submit" class="btn neon-button mt-5" name="btnSQLInjection" id="sql-injection-senden" value="SQL Senden">Senden</button>
            </div>
          </form>
        </div>
        <div class="col-md-1 align-items-center justify-content-center"></div>
      </div>
      <!-- /Die ausgewaelte Tabelle -->
    </div>
    <!-- import scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script src="../js/notification.js"></script>
    <script>
      $("#ueberschrift").click(function(){
        window.location.href = "../index.php";
      });
    </script>
    <?php if (isset($notification)) echo '<script>displayMessage("' . $notification . '");</script>' ?>
  </body>
</html>