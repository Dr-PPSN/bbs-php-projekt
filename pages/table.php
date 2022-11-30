<?php

require './lib/DB.php';

// TODO: Edit / Delete Button for every table row


$selTable = getSelTable();

$table = buildHtmlTable(getTableData('AUTOREN'));
if (!empty($_POST['btnGetTable'])) {
  $table = buildHtmlTable(getTableData($_POST['selTable']));
}
if (!empty($_POST['btnSQLInjection'])) {
  $table = buildHtmlTable(executeSQL($_POST['sql-injection-text']));
}

if (!empty($_POST['btnReset'])) {
  resetDB();
}

function getSelTable() {
  $tableData = executeSQL("select TABLE_NAME from information_schema.tables where table_type = 'BASE TABLE' and TABLE_SCHEMA = 'buchladen';");
  if (isset($tableData)) {
    $htmlString = '<select name="selTable" id="selTable">';
    for ($i = 1; $i < count($tableData); $i++) {
      $row = $tableData[$i];
      foreach ($row as $value) {
        if (isset($_POST['selTable']) && $value == $_POST['selTable']) {
          $htmlString .= '<option value="' . $value . '" selected>' . strtoupper($value) . '</option>';
        } else {
          $htmlString .= '<option value="' . $value . '">' . strtoupper($value) . '</option>';
        }
      }
    }
    $htmlString .= '</select>';  
    return $htmlString;
  }
}

function getTableData($table) {
  return executeSQL("SELECT * FROM buchladen." . $table . ";");
}

function executeSQL($SQL) {
  global $conn;
  global $notification;
  $result = $conn->query($SQL);
  if ($result === true) {
    return true;
  } else if ($result === false) {
    $notification = 'Ups ein Fehler ist aufgetreten';
    return false;
  } else {
    $tableData[] = $result->fetch_fields();
    while ($row = $result->fetch_assoc()) {
      $tableData[] = $row;
    }
    return $tableData;
  }
}

function buildHtmlTable($tabledata) {
  if (isset($tabledata)) {
    $tableHeader = $tabledata[0];
    $thHTML = '<tr>';
    foreach ($tableHeader as $value) {
      $thHTML .= '<th scope="col">' . $value->name . '</th>';
    }
    $thHTML .= '</tr>';

    $trHTML = '';
    for ($i = 1; $i < count($tabledata); $i++) {
      $row = $tabledata[$i];
      $trHTML .= '<tr>';
      foreach ($row as $value) {
        $trHTML .= '<td>' . $value . '</td>';
      }
      $trHTML .= '</tr>';
    }
    $tableHTML = '<table class="table table-striped table-dark">' . $thHTML . $trHTML . '</table>';
  }
  return $tableHTML;
}

