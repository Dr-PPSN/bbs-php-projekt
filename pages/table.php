<?php

// Page um Tabellen anzuzeigen

require '../lib/sql.php';
require '../lib/html-helper.php';

if (isset($_POST['btnEdit'])) {
  // TODO: Tabellen unterscheiden
  $table  = $_POST['table'];
  $id     = $_POST['id'];
  $values = $_POST['edit'];
  updateTable($table, $id, $values);
}

if (isset($_POST['btnDel'])) {
  $table = $_POST['table'];
  $id    = $_POST['id'];
  deleteRow($table, $id);
}

$orderBy = "null"; // Spalte nach der sortiert werden soll
$orderDirection = "ASC"; // Sortierrichtung (ASC oder DESC)
$tableHTML = '';

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
$_SESSION['orderDirection'] = $orderDirection;
// Speichere die Sortierrichtung in der Session, damit sie in der nächsten Seite wieder verwendet werden kann

$allTables = getAllTables();
// TODO: fehlermeldung falls keine Tabellen vorhanden sind
if (isset($_GET['table']) && !empty($_GET['table'])) {
  $selectedTable = $_GET['table'];
} else {
  $selectedTable = array_values($allTables[0])[0];
}
$rows         = getTable($selectedTable);
$columnTypes  = getColumnTypes($selectedTable);
$selHTML   = buildSelect($allTables, $selectedTable);
$tableHTML = buildHtmlTable($rows, true, $orderBy, $orderDirection);
$editPopupsHTML    = getEditPopup($selectedTable, $columnTypes, $rows);
$insertPopupsHTML  = getInsertPopup($selectedTable, $columnTypes);
$deletePopupHTML   = getDeletePopup($selectedTable, $rows);


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
      <form action="table.php" method="get" class="row bg-dark">
        <div class="col-md-12 d-flex align-items-center justify-content-center">
          <?php echo $selHTML ?>
        </div>
      </form>
      <!-- Die ausgewaelte Tabelle -->
      <div class="row bg-dark">
        <div class="col-12 d-flex align-items-center justify-content-center" id="tableElement">
          <?php echo $tableHTML?>
        </div>
      </div>
      <!-- /Die ausgewaelte Tabelle -->
    </div>
    <?php echo $editPopupsHTML ?>
    <?php echo $insertPopupsHTML ?>
    <?php echo $deletePopupHTML ?>
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
    <?php
      if (isset($notification)){
        echo '<script>displayMessage("' . $notification . '");</script>';
      }
    ?>
  </body>
</html>