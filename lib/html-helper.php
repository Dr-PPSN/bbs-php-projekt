<?php

// Hilfsfunktionen für HTML-Rendering

function buildHtmlTable($tableData, $showButtons, $orderBy, $orderDirection, $link) {
  // Erstelle eine normale HTML-Tabelle, ohne geordnet zu sein
  if ($orderBy == "null") {
    return createHTMLTable($tableData, $showButtons, $link);
  }
  // Erstelle eine HTML-Tabelle, die geordnet ist
  else {
    $tableData = orderTableData($tableData, $orderBy, $orderDirection);
    return createHTMLTable($tableData, $showButtons, $link);
  }
}

function createHTMLTable($tableData, $showButtons, $link){
  if (isset($tableData)) {
    $colNames = array_keys($tableData[0]);
    $thHTML = '<tr>';
    foreach ($colNames as $colName) {
      // wenn die schleife bei der orderBy spalte ist, soll der Pfeil (ASC oder DESC) angezeigt werden
      if ($link) {
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
      else {
        //wenn der cookie orderBy gesetzt ist, soll der Pfeil (ASC oder DESC) angezeigt werden
        if (isset($_COOKIE['orderBy']) && $colName == $_COOKIE['orderBy']) {
          if ($_COOKIE['orderDirection'] == "ASC") {
            $thHTML .= '<th scope="col"><button class="btn neonTableHeader tableHead" id="' . $colName . '">' . $colName . ' ▲</button></th>';
          }
          else if ($_COOKIE['orderDirection'] == "DESC") {
            $thHTML .= '<th scope="col"><button class="btn neonTableHeader tableHead" id="' . $colName . '">' . $colName . ' ▼</button></th>';
          }
        }
        else {
          $thHTML .= '<th scope="col"><button class="btn neonTableHeader tableHead" id="' . $colName . '">' . $colName . '</button></th>';
        }
      }
    }
    $thHTML .= '
      <th colspan="2">
        <div style="text-align: center;">
          <a  class="btn btn-danger align-items-center justify-content-center" data-toggle="modal" data-target="#InsPopup">
            Eintrag einfügen
          </a>
        </div>
      </th>';
    $thHTML .= '</tr>';

    $trHTML = '';
    for ($i = 0; $i < count($tableData); $i++) {
      $row = $tableData[$i];
      $trHTML .= '<tr class= "neonTableHeaderGreen">';
      foreach ($row as $val) {
        $trHTML .= '<td>' . $val . '</td>';
      }
      if ($showButtons) {
        $id = array_values($row)[0];
        $trHTML .= '
          <td>
            <div style="text-align: center;">
              <a class="btn btn-danger align-items-center justify-content-center" data-toggle="modal" data-target="#editPopup' . $id . '">
                Edit
              </a>
            </div>
          </td>';
        $trHTML .= '
          <td>
            <div style="text-align: center;">
              <a class="btn btn-danger align-items-center justify-content-center" data-toggle="modal" data-target="#delPopup' . $id . '">
                Del
              </a>
            </div>
          </td>';
      }
      $trHTML .= '</tr>';
    }
    $tableHTML = '<table class="table table-striped table-dark">' . $thHTML . $trHTML . '</table>';
    return $tableHTML;
  }
}

function orderTableData($tableData, $orderBy, $orderDirection) {
  $n = count($tableData);
  for ($i = 0; $i < $n - 1; $i++) {
    for ($j = 0; $j < $n - $i - 1; $j++) {
      if ($orderDirection === 'ASC') {
        if ($tableData[$j][$orderBy] > $tableData[$j + 1][$orderBy]) {
          swap($tableData[$j], $tableData[$j + 1]);
        }
      } else {
        if ($tableData[$j][$orderBy] < $tableData[$j + 1][$orderBy]) {
          swap($tableData[$j], $tableData[$j + 1]);
        }
      }
    }
  }
  return $tableData;
}

function swap(&$a, &$b) {
  $temp = $a;
  $a = $b;
  $b = $temp;
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

function getEditPopup($tableName, $columns, $rows) {
  $editPopups = array();
  for ($i = 0; $i < count($rows); $i++) {
    $row = $rows[$i];
    if (isset($row[$tableName . "_id"])) {
      $id = $row[$tableName . "_id"];
    } else {
      $id = $i;
    }

    $HTML = '
      <div class="modal fade" id="editPopup' . $id . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalCenterTitle">Eintrag bearbeiten</h5>
              <button type="button" class="btn btn-danger" data-dismiss="modal">X</button>
            </div>
            <form action="" method="post">
              <div class="modal-body">
                <div class="form-group">';

    for ($j = 1; $j < count($row); $j++) {
      $key  = array_keys($row)[$j];
      $val  = array_values($row)[$j];
      $type = getColumnType($columns, $key);
      $HTML .= '<div class="form-group row"><div class="col-sm-4 d-flex justify-content-center align-items-center">' . $key . ':</div>';
      $HTML .= '<div class="col-sm-8 d-flex justify-content-center align-items-center"><input type="' . $type . '" class="form-control mt-2 w-75" id="edit-' . $key . '" name="edit[' . $key . ']" value="' . $val . '"></div></div>';
    }

    $HTML .= '
                </div>
              </div>
              <div class="modal-footer">
                <input type="hidden" name="table" value="' . $tableName . '">';

    if (!isRefTable($tableName)) {
      $HTML .= '<input type="hidden" name="id" value="' . $id . '">';
    } else {
      foreach($row as $key => $val) {
        if (strpos($key, "_id") !== false) {
          $HTML .= '<input type="hidden" name="oldValues[]" value="' . $val . '">';
        }
      }
    }

    $HTML .= '
                <input type="submit" class="btn btn-success" name="btnEdit" id="editSubmit" value="OK">
              </div>
            </form>
          </div>
        </div>
      </div>';

    $editPopups[] = $HTML;
  }

  $HTML = implode("", $editPopups);
  return $HTML;
}


function getInsertPopup($tableName, $columns) {
  $HTML = '
    <div class="modal fade" id="InsPopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Eintrag anlegen</h5>
            <button type="button" class="btn btn-danger" data-dismiss="modal">X</button>
          </div>
          <form action="" method="post">
            <div class="modal-body">
              <div class="form-group">';

  for ($i = 1; $i < count($columns); $i++) {
    $key  = $columns[$i]['COLUMN_NAME'];
    $type = $columns[$i]['DATA_TYPE'];
    $HTML .= '<span>' . $key . '</span>';
    $HTML .= '<input type="' . $type . '" class="form-control mt-2" id="ins-' . $key . '" name="ins[' . $key . ']">';
  }
  
  $HTML .= '
              </div>
            </div>
            <div class="modal-footer">
              <input type="hidden" name="table" value="' . $tableName . '">
              <input type="submit" class="btn btn-success" name="btnIns" id="insSubmit" value="OK">
            </div>
          </form>
        </div>
      </div>
    </div>';

  return $HTML;
}

function getDeletePopup($tableName, $rows) {
  $delPopups = array();
  for ($i = 0; $i < count($rows); $i++) {
    $row = $rows[$i];
    if (isset($row[$tableName . "_id"])) {
      $id = $row[$tableName . "_id"];
    } else {
      $id = $i;
    }

    $HTML = '
      <div class="modal fade" id="delPopup' . $id . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalCenterTitle">Eintrag löschen</h5>
              <button type="button" class="btn btn-danger" data-dismiss="modal">X</button>
            </div>
            <form action="" method="post">
              <div class="modal-body">
                <span>Sind Sie sicher, dass Sie den Eintrag mit der ID ' . $id . ' löschen wollen?</span>
              </div>
              <div class="modal-footer">
                <input type="hidden" name="table" value="' . $tableName . '">
                <input type="hidden" name="id" value="' . $id . '">
                <input type="submit" class="btn btn-success" name="btnDel" id="delSubmit" value="OK">
              </div>
            </form>
          </div>
        </div>
      </div>';
    $delPopups[] = $HTML;
  }
  
  $HTML = implode("", $delPopups);
  return $HTML;
}

function getColumnType($columnTypeList, $columnName) {
  foreach ($columnTypeList as $column) {
    if ($column['COLUMN_NAME'] == $columnName) {
      return getHTMLInputType($column['DATA_TYPE']);
    }
  }
}

function getHTMLInputType($sqlType) {
  switch ($sqlType) {
    case 'int':
      return 'number';
    case 'decimal':
      return 'number';
    case 'varchar':
      return 'text';
    case 'text':
      return 'textarea';
    default:
      return 'text';
  }
}

?>