<?php
require 'lib/sql.php';
require 'lib/html-helper.php';
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
    <div class="container-fluid vh-100 bg-dark mb-3">
      <!-- Menue -->
      <div class="row bg-dark">
        <div class="col-sm-3 col-md-2 d-flex align-items-center justify-content-center pr-4 mb-2 mt-3">
          <form action="" method="post">
            <button type="submit" name="btnReset" class="btn neon-button" value="reset">Datenbank zurücksetzen</button>
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
      <!-- /Menue -->
      <!-- Row1 -->
      <div class="row bg-dark py-5">

        <?php
          $allTables = getAllTables();
          foreach ($allTables as $table) {
            $table = $table['Tables_in_buchladen'];
            
            //call the getTable function for every table and save the result in a variable
            $tableData = getTable($table);
            //count how many rows are in the table
            $tableRows = count($tableData);
            //count how many columns are in the table
            $tableColumns = count($tableData[0]);

            echo '<div class="col mt-4 ml-2">
                    <div class="card text-center bg-transparent blueBorder" style="width: 18rem;">
                      <div class="card-body">
                        <h4 class="card-title orangeText">' . $table . '</h4><br>
                        <p class="card-text greenText">Anzahl Attribute: ' . $tableColumns . '</p>
                        <p class="card-text greenText">Anzahl Entitäten: ' . $tableRows . '</p>
                        <a href="/pages/table.php?table=' . $table . '" class="card-link neon-button mt-3">Tabelle Anzeigen</a>
                      </div>
                    </div>
                  </div>';
          }
        ?>
      </div>
      <!-- /Row1 -->
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
    <!-- import scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script src="./js/notification.js"></script>
    <script>
      $("#ueberschrift").click(function(){
        window.location.href = "../index.php";
      });
    </script>
    <?php if (isset($notification)) echo '<script>displayMessage("' . $notification . '");</script>' ?>
  </body>
</html>