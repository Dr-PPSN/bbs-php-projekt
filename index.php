<?php

// Landing Page

checkPHPVersion();

if (isset($_POST['btnReset'])) {
  require './lib/DB.php';
  resetDB();
}

function checkPHPVersion() {
  if (version_compare(phpversion(), '8.1.0', '<')) {
    echo 'PHP Version is too old. Please update to 8.1.0 or higher.';
    exit();
  }
}

?>

<!DOCTYPE html>
<html lang=de>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta charset="utf-8">
    <title>BBS PHP Projekt</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="./styles/message.css">
    <link rel="stylesheet" type="text/css" href="./styles/style.css">
    <link rel="stylesheet" type="text/css" href="./styles/neonBTN.css">
  </head>
  <body>
    <div class="container-fluid vh-100 bg-dark">
      <!-- Menue -->
      <div class="row bg-dark">
        <div class="col-md-7 col-sm-6 col-xs-4 py-4 h1 d-flex align-items-center justify-content-center neonTextFlickerGreen">
          PHP Projekt Buchladen
        </div>
        <div class="col-md-5 col-sm-6 col-xs-8 d-flex align-items-center justify-content-center">
          <div class="col-md-6 col-sm-6 col-xs-6 d-flex align-items-center justify-content-center">
            <form action="pages/sqlinjection.php" method="post">
              <button type="submit" name="sqlinjection" class="btn neon-button" id="btnSQLInjection">SQL Injection</button>
            </form>
          </div>
          <div class="col-md-6 col-sm-6 col-xs-6 d-flex align-items-center justify-content-center">
            <form action="" method="post">
              <button type="submit" name="btnReset" class="btn neon-button" value="reset">Datenbank zurücksetzen</button>
            </form>
          </div>
        </div>
      </div>
      <!-- /Menue -->
      <!-- Row1 -->
      <div class="row bg-dark py-5">
        <div class="col-md-8 col-sm-8 col-xs-8 d-flex align-items-center justify-content-center">
          <div class="btn-group-vertical">
            <a href="/pages/table.php?table=buecher" class="neon-button-2"><span></span><span></span><span></span><span></span>Bücher</a>
            <a href="/pages/table.php?table=autoren" class="neon-button-2"><span></span><span></span><span></span><span></span>Autoren</a>
            <a href="/pages/table.php?table=sparten" class="neon-button-2"><span></span><span></span><span></span><span></span>Sparten</a>
            <a href="/pages/table.php?table=verlage" class="neon-button-2"><span></span><span></span><span></span><span></span>Verlage</a>
            <a href="/pages/table.php?table=lieferanten" class="neon-button-2"><span></span><span></span><span></span><span></span>Lieferanten</a>
            <a href="/pages/table.php?table=orte" class="neon-button-2"><span></span><span></span><span></span><span></span>Orte</a>
          </div>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-4 d-flex align-items-center justify-content-center mt-4">
          <form action="pages/alltables.php" method="get">
            <button type="submit" name="alltables" class="btn neon-button" id="btnAllTables">Alle Tabellen anzeigen</button>
          </form>
        </div>
      </div>
      <!-- /Row1 -->
      <!-- footer -->
      <div class="row bg-dark fixed-bottom">
        <hr>
        <div class="col-md-4 col-sm-4 col-xs-4 d-flex align-items-center justify-content-center">
          <p class="text-white">© 2023 - BBS PHP Projekt</p>
        </div>
        <div class="col-md-8 col-sm-8 col-xs-8 d-flex align-items-center justify-content-center">
          <p class="text-white">Robert, Kai und Dennis</p>
        </div>
      </div>
    </div>
    <!-- Modal SQL-Injection -->
    <div class="modal fade" id="sql_injection_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Auszuführendes SQL hier eingeben</h5>
            <button type="button" class="btn btn-danger" data-dismiss="modal">X</button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <input type="text" class="form-control" id="sql-injection-text" name="sql-injection-text" placeholder="SQL">
            </div>
          </div>
          <div class="modal-footer">
            <input type="submit" class="btn btn-success" name="btnSQLInjection" id="sql-injection-senden" value="SQL Senden">
          </div>
        </div>
      </div>
    </div>
    <!-- Modal SQL-Injection -->
    <!-- import scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script src="./js/notification.js"></script>
    <?php if (isset($notification)) echo '<script>displayMessage("' . $notification . '");</script>' ?>
  </body>
</html>