<?php

// Hilfsfunktionen für HTML-Rendering

function buildHtmlTable($tableData, $showButtons, $orderBy, $orderDirection) {
  // Erstelle eine normale HTML-Tabelle, ohne geordnet zu sein
  if ($orderBy == "" && $orderDirection == "") {
    return createHTMLTable($tableData, $showButtons);
  }
  // Erstelle eine HTML-Tabelle, die geordnet ist
  else {
    
  }
}
function createHTMLTable($tableData, $showButtons){
    if (isset($tableData)) {
    $colNames = array_keys($tableData[0]);
    $thHTML = '<tr>';
    foreach ($colNames as $colName) {
      $thHTML .= '<th scope="col" class= "neonTableHeader">' . $colName . '</th>';
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

?>