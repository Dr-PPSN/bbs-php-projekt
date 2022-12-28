<?php

// Hilfsfunktionen für HTML-Rendering

function buildHtmlTable($tableData, $showButtons, $orderBy, $orderDirection) {
  // Erstelle eine normale HTML-Tabelle, ohne geordnet zu sein
  if ($orderBy == "null") {
    return createHTMLTable($tableData, $showButtons);
  }
  // Erstelle eine HTML-Tabelle, die geordnet ist
  else {
    $tableData = orderTableData($tableData, $orderBy, $orderDirection);
    return createHTMLTable($tableData, $showButtons);
  }
}
function createHTMLTable($tableData, $showButtons){
    if (isset($tableData)) {
    $colNames = array_keys($tableData[0]);
    $thHTML = '<tr>';
    foreach ($colNames as $colName) {
      // wenn die schleife bei der orderBy spalte ist, soll der Pfeil (ASC oder DESC) angezeigt werden
      if (isset($_GET['orderBy']) && $colName == $_GET['orderBy']) {
        if ($_SESSION['orderDirection'] == "ASC") {
          // jede Überschrift ist ein Klick-Link, der die Tabelle neu sortiert durch die neuen GET-Parameter
          $thHTML .= '<th scope="col"><a href="table.php?table=' . $_GET['table'] . '&orderBy=' . $colName . '&orderDirection=' . ascORdesc("ASC") . '" class= "neonTableHeader">' . $colName . ' ' . drawArrow() . '</a></th>';
        }
        else if ($_SESSION['orderDirection'] == "DESC") {
          // jede Überschrift ist ein Klick-Link, der die Tabelle neu sortiert durch die neuen GET-Parameter
          $thHTML .= '<th scope="col"><a href="table.php?table=' . $_GET['table'] . '&orderBy=' . $colName . '&orderDirection=' . ascORdesc("DESC") . '" class= "neonTableHeader">' . $colName . ' ' . drawArrow() . '</a></th>';
        }
      }
      else {
        // jede Überschrift ist ein Klick-Link, der die Tabelle neu sortiert durch die neuen GET-Parameter
        $thHTML .= '<th scope="col"><a href="table.php?table=' . $_GET['table'] . '&orderBy=' . $colName . '&orderDirection=' . ascORdesc("DESC") . '" class= "neonTableHeader">' . $colName . '</a></th>';
      }
    }
    $thHTML .= '</tr>';

    $trHTML = '';
    for ($i = 0; $i < count($tableData); $i++) {
      $row = $tableData[$i];
      $trHTML .= '<tr class= "neonTableHeaderGreen">';
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
function orderTableData($tableData, $orderBy, $orderDirection){
  // Ein Algorithmus, der die Daten nach $orderBy und $orderDirection sortiert und dann die createHTMLTable-Funktion aufruft
    
    if ($orderDirection == "ASC") {
      array_multisort(array_column($tableData, $orderBy), SORT_ASC, $tableData);
    }
    else if ($orderDirection == "DESC") {
      array_multisort(array_column($tableData, $orderBy), SORT_DESC, $tableData);
    }
    return $tableData;
}

function ascORdesc($value) {
  if ($value == "ASC") {
    return "DESC";
  }
  else {
    return "ASC";
  }
}
function drawArrow() {
  if ($_SESSION['orderDirection'] == "ASC") {
    return "▲";
  }
  else {
    return "▼";
  }
}

function buildSelect($tableData, $selectedValue) {
  $selectHTML = '<select name="table" class="form-control" onchange="this.form.submit()">';
  for ($i = 0; $i < count($tableData); $i++) {
    $value = array_values($tableData[$i])[0];
    $selectHTML .= '<option value="' . $value . '"';
    if ($selectedValue == $value) {
      $selectHTML .= ' selected';
    }
    $selectHTML .= '>' . $value . '</option>';
  }
  $selectHTML .= '</select>';
  return $selectHTML;
}

function getEditPopup($columnTypes) {
  // TODO: design popup with bootstrap
}

function getInsertPopup($columnTypes) {
  // TODO: design popup with bootstrap
}

?>