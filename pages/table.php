<?php

require './lib/sql.php';

// TODO: Edit / Delete Button for every table row
$tableHTML = '';

if (!empty($_POST['selTable'])) {
  switch ($_POST['selTable']) {
    case 'buecher':
      $tableHTML = buildHtmlTable(getBuecher());
      break;
    case 'autoren':
      $tableHTML = buildHtmlTable(getAutoren());
      break;
    case 'sparten':
      $tableHTML = buildHtmlTable(getSparten());
      break;
    case 'verlage':
      $tableHTML = buildHtmlTable(getVerlage());
      break;
    case 'lieferanten':
      $tableHTML = buildHtmlTable(getLieferanten());
      break;
    case 'orte':
      $tableHTML = buildHtmlTable(getOrte());
      break;
    default:
  }
} else if (!empty($_POST['btnSQLInjection'])) {
  $tableHTML = buildHtmlTable(executeSQL($_POST['sql-injection-text']), false);
} else if (!empty($_POST['btnReset'])) {
  resetDB();
}

function buildHtmlTable($tableData, $showButtons = true) {
  if (isset($tableData)) {
    $colNames = array_keys($tableData[0]);
    $thHTML = '<tr>';
    foreach ($colNames as $colName) {
      $thHTML .= '<th scope="col">' . $colName . '</th>';
    }
    $thHTML .= '</tr>';

    $trHTML = '';
    for ($i = 0; $i < count($tableData); $i++) {
      $row = $tableData[$i];
      $trHTML .= '<tr>';
      foreach ($row as $val) {
        $trHTML .= '<td>' . $val . '</td>';
      }
      if ($showButtons) {
        $trHTML .= '<td><button>Edit</button></td>';
        $trHTML .= '<td><button>Del</button></td>';
      }
      $trHTML .= '</tr>';
    }
    $tableHTML = '<table class="table table-striped table-dark">' . $thHTML . $trHTML . '</table>';
    return $tableHTML;
  }
}

