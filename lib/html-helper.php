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

function getEditPopup($columns, $rows) {
  foreach ($rows as $row) {
    $HTML = '
    <div class="modal fade" id="editPopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Eintrag bearbeiten</h5>
            <button type="button" class="btn btn-danger" data-dismiss="modal">X</button>
          </div>
          <div class="modal-body">
            <div class="form-group">';

    foreach ($row as $val) {
      // TODO: Columns einfügen
      $HTML .= '<input type="text" class="form-control" id="sql-injection-text" name="sql-injection-text" placeholder="SQL">';
    }

    $HTML .= '
            </div>
          </div>
          <div class="modal-footer">
            <input type="submit" class="btn btn-success" name="btnSQLInjection" id="sql-injection-senden" value="SQL Senden">
          </div>
        </div>
      </div>
    </div>';
  }
  return $HTML;
}


function getInsertPopup($columns) {
  // TODO: design popup with bootstrap
  return "Edit Popup";
}

?>