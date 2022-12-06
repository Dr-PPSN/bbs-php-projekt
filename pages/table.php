<?php

// Page um Tabellen anzuzeigen

require '../lib/sql.php';
require '../lib/html-helper.php';

$orderBy = "null"; // Spalte nach der sortiert werden soll
$orderDirection = "ASC"; // Sortierrichtung (ASC oder DESC)
$tableHTML = ''; // HTML-Code für die Tabelle


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
$_SESSION['orderDirection'] = $orderDirection; // Speichere die Sortierrichtung in der Session, damit sie in der nächsten Seite wieder verwendet werden kann

if (isset($_GET['table'])) {
  switch ($_GET['table']) {
    case 'buecher':
      $tableHTML = buildHtmlTable(getBuecher(), true, $orderBy, $orderDirection);
      break;
    case 'autoren':
      $tableHTML = buildHtmlTable(getAutoren(), true, $orderBy, $orderDirection);
      break;
    case 'sparten':
      $tableHTML = buildHtmlTable(getSparten(), true, $orderBy, $orderDirection);
      break;
    case 'verlage':
      $tableHTML = buildHtmlTable(getVerlage(), true, $orderBy, $orderDirection);
      break;
    case 'lieferanten':
      $tableHTML = buildHtmlTable(getLieferanten(), true, $orderBy, $orderDirection);
      break;
    case 'orte':
      $tableHTML = buildHtmlTable(getOrte(), true, $orderBy, $orderDirection);
      break;
    default:
      header('Location: index.php');
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
    <link rel="stylesheet" type="text/css" href="../styles/message.css">
    <link rel="stylesheet" type="text/css" href="../styles/style.css">
  </head>
  <body>
    <div class="container-fluid h-100 bg-dark">
      <div class="col-md-7 col-sm-6 col-xs-4 py-4 h1 d-flex align-items-center justify-content-center neonTextFlickerGreen">
        PHP Projekt Buchladen
      </div>
      <!-- Die ausgewaelte Tabelle -->
      <div class="row bg-dark">
        <div class="col-md-12 d-flex align-items-center justify-content-center" id="tableElement">
          <?php echo $tableHTML?>
        </div>
      </div>
      <!-- /Die ausgewaelte Tabelle -->
    </div>
    <!-- import scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script src="../js/notification.js"></script>
    <?php
      if (isset($notification)){
        echo '<script>displayMessage("' . $notification . '");</script>';
      }
    ?>
  </body>
</html>