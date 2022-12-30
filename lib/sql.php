<?php

// Funktionen für alle SQL-Operationen

require 'DB.php';

function executeSQL($SQL, $params = null) {
  global $conn;
  global $notification;
  try {
    $statement = $conn->prepare($SQL);
    if ($statement->execute($params) === true) {
      $result = $statement->get_result(); 
      if ($result === true) {
        return true;
      } else if ($result === false) {
        if ($conn->error != '') {
          $notification = 'SQL Fehler: ' . $conn->error;
        }
        return false;
      } else {
        $tableData = [];
        while ($row = $result->fetch_assoc()) {
          $tableData[] = $row;
        }
        return $tableData;
      }
    } else {
      if ($conn->error != '') {
        $notification = 'SQL Fehler: ' . $conn->error;
      }
      return false;
    }
  } catch (Exception $e) {
    if ($conn->error != '') {
      $notification = 'SQL Fehler: ' . $conn->error;
    }
    return false;
  }
}


// ---------------------------- all tables -------------------------------------


function getAllTables() {
  $SQL = '
  SHOW TABLES
  ';
  return executeSQL($SQL);
}

function getTable($tableName) {
  $SQL = '
  SELECT
    *
  FROM
  '. $tableName;
  return executeSQL($SQL);
}

function getColumnTypes($tableName) {
  $SQL = '
  SELECT
    COLUMN_NAME,
    DATA_TYPE
  FROM
    INFORMATION_SCHEMA.COLUMNS
  WHERE
    TABLE_NAME = ?
  ';
  return executeSQL($SQL, [$tableName]);
}


// ---------------------------- update rows -------------------------------------

function updateTable(string $tableName, $id, array $values) {
  $SQL = 'UPDATE ' . $tableName . ' SET';
  foreach ($values as $key => $value) {
    $SQL .= ' ' . $key . ' = "' . $value . '",';
  }
  $SQL = substr($SQL, 0, -1);
  $SQL .= ' WHERE ' . $tableName . '_id = ?';
  return executeSQL($SQL, [$id]);
}

function updateRefTable(string $tablename, array $oldValues, array $newValues) {
  // TODO: Update RefTable
}


// ---------------------------- delete rows -------------------------------------

function deleteRow($tableName, $id) {
  $SQL = '
  DELETE FROM
    '. $tableName .'
  WHERE
    '. $tableName .'_id = ?
  ';
  return executeSQL($SQL, [$id]);
}

function deleteRowRefTable(string $tablename, array $values) {
  // TODO: delete RefTable
}

// ---------------------------- insert rows -------------------------------------

function addRow(string $tableName, array $values) {
  $SQL = '
  INSERT INTO
    '. $tableName .'
  SET
  ';
  foreach ($values as $key => $value) {
    $SQL .= ' ' . $key . ' = "' . $value . '",';
  }
  $SQL = substr($SQL, 0, -1);
  return executeSQL($SQL);
}

function addRowRefTable(string $tablename, array $values) {
  // TODO: add RefTable
}

// ---------------------------- table helper function -------------------------------------

function isRefTable(string $tableName) {
  $columns = getColumnTypes($tableName);
  foreach ($columns as $column) {
    if ($column['COLUMN_NAME'] == $tableName . '_id') {
      return false;
    }
  }
  return true;
}

?>