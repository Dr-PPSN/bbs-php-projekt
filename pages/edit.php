<?php

// edit page gets called with GET request (table & id)
// edit page IS NOT AVAILABLE for results from sql injection
// TODO: design edit page dependent on given table
// by submitting, the original data 

$table = $_REQUEST['table'];
$id    = $_REQUEST['id'];

$tableHTML = '';
switch ($table) {
  case 'buecher':
    $tableHTML = buildHtmlTable(getBuecher($id));
    break;
  case 'autoren':
    $tableHTML = buildHtmlTable(getAutoren($id));
    break;
  case 'sparten':
    $tableHTML = buildHtmlTable(getSparten($id));
    break;
  case 'verlage':
    $tableHTML = buildHtmlTable(getVerlage($id));
    break;
  case 'lieferanten':
    $tableHTML = buildHtmlTable(getLieferanten($id));
    break;
  case 'orte':
    $tableHTML = buildHtmlTable(getOrte($id));
    break;
  default:
}

function buildEditForm($id) {
  
}


?>