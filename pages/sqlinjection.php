<?php

// Page für SQL-Injection

require '../lib/sql.php';
require '../lib/html-helper.php';

$orderBy = "null"; // Spalte nach der sortiert werden soll
$orderDirection = "ASC"; // Sortierrichtung (ASC oder DESC)
$tableHTML = '';
$inputHTML = '<textarea class="form-control" rows="10" id="sql-injection-text" name="sql-injection-text" placeholder="SQL"></textarea>';
if (isset($_POST['btnSQLInjection']) || true) {
  $sql = $_POST['sql-injection-text'];
  $inputHTML = '<textarea class="form-control" rows="10" id="sql-injection-text" name="sql-injection-text" placeholder="SQL">' . $sql . '</textarea>';
  $result = executeSQL($sql);
}
if (isset($_GET['orderBy'])) {
  $orderBy = $_GET['orderBy'];
  if (isset($_GET['orderDirection'])) {
    //$orderDirection = $_GET['orderDirection'];
    // wenn die Sortierrichtung nicht gesetzt ist, dann ist sie ASC
    if (!($_GET['orderDirection'] == "ASC" || $_GET['orderDirection'] == "DESC")) {
      $orderDirection = "ASC";
    }
    else if ($_GET['orderDirection'] == "ASC") {
      $orderDirection = "ASC";
    }
    else if ($_GET['orderDirection'] == "DESC") {
      $orderDirection = "DESC";
    }
  }
}
// Speichere die Sortierrichtung in der Session, damit sie in der nächsten Seite wieder verwendet werden kann
$_SESSION['orderDirection'] = $orderDirection;
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
          <form action="" method="post">
            <button type="submit" name="btnReset" class="btn neon-button" value="reset">Datenbank zurücksetzen</button>
          </form>
        </div>
      </div>
      <br><br>
      <!-- SQL Input und senden BTN -->
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
      <!-- /SQL Input und senden BTN -->
      <!-- SQL Result, wenn Select abfrage erfolgreich war -->
      <?php
        echo 'hier';
        
      ?>
      <!-- /SQL Result, wenn Select abfrage erfolgreich war -->
      <!-- footer -->
      <div class="row bg-dark fixed-bottom">
        <hr>
        <div class="col-md-4 col-sm-4 col-xs-4 d-flex align-items-center justify-content-center">
          <p class="redText">© 2023 - BBS PHP Projekt</p>
        </div>
        <div class="col-md-8 col-sm-8 col-xs-8 d-flex align-items-center justify-content-center">
          <p class="redText">Robert, Kai und Dennis</p>
        </div>
      </div>
    </div>
    <!-- /footer -->
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