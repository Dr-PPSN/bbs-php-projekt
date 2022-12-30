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

// ---------------------------- get tables -------------------------------------

function getBuecher($id = null) {
  $SQL = '
    SELECT
      b.buecher_id        ID,
      b.titel             Titel,
      b.verkaufspreis     Verkaufspreis,
      b.einkaufspreis     Einkaufspreis,
      b.erscheinungsjahr  Erscheinungsjahr,
      v.name              Verlag,
      ba.Autoren          Autoren,
      bl.Lieferanten      Lieferanten
    FROM
      buecher b
    LEFT JOIN verlage v ON b.verlage_verlage_id = v.verlage_id
    LEFT JOIN
      (SELECT
        ahb.buecher_buecher_id,
        GROUP_CONCAT(
          DISTINCT CONCAT(a.vorname, " ", a.nachname)
          ORDER BY CONCAT(a.vorname, " ", a.nachname)
          SEPARATOR "<br>") Autoren
      FROM
        autoren_has_buecher ahb
      LEFT JOIN autoren a ON ahb.autoren_autoren_id = a.autoren_id
      GROUP BY buecher_buecher_id
      ) ba
      ON b.buecher_id = ba.buecher_buecher_id
    LEFT JOIN
      (SELECT
        bhl.buecher_buecher_id,
        GROUP_CONCAT(
          DISTINCT l.name
          ORDER BY l.name
          SEPARATOR "<br>") Lieferanten
      FROM
        buecher_has_lieferanten bhl
      LEFT JOIN lieferanten l ON bhl.lieferanten_lieferanten_id = l.lieferanten_id
      GROUP BY buecher_buecher_id) bl
      ON b.buecher_id = bl.buecher_buecher_id
    WHERE
      (b.buecher_id = ? OR ? is NULL)
    ORDER BY buecher_id
  ';
  return executeSQL($SQL, [$id, $id]);
}

function getVerlage($id = null) {
  $SQL = '
  SELECT 
    v.verlage_id    ID,
    v.name          Verlag,
    o.postleitzahl  PLZ,
    o.name          Sitz
  FROM
    verlage v
  LEFT JOIN orte o ON v.orte_orte_id = o.orte_id
  WHERE
    (v.verlage_id = ? OR ? is NULL)
  ';
  return executeSQL($SQL, [$id, $id]);
}

function getLieferanten($id = null) {
  $SQL = '
  SELECT 
    l.lieferanten_id  ID,
    l.name            Lieferant,
    o.postleitzahl    PLZ,
    o.name            Sitz
  FROM 
    lieferanten l
  LEFT JOIN orte o ON l.orte_orte_id = o.orte_id
  WHERE
    (l.lieferanten_id = ? OR ? is NULL)
  ';
  return executeSQL($SQL, [$id, $id]);
}

function getAutoren($id = null) {
  $SQL = '
  SELECT 
    a.autoren_id    ID,
    a.vorname       Vorname,
    a.nachname      Nachname,
    a.geburtsdatum  Geburtsdatum
  FROM
    autoren a
  WHERE
    (a.autoren_id = ? OR ? is NULL)
  ';
  return executeSQL($SQL, [$id, $id]);
}

function getSparten($id = null) {
  $SQL = '
  SELECT
    s.sparten_id  ID,
    s.bezeichnung Sparte
  FROM
    sparten s
  WHERE
    (s.sparten_id = ? OR ? is NULL)
  ';
  return executeSQL($SQL, [$id, $id]);
}

function getOrte($id = null) {
  $SQL = '
  SELECT
    o.orte_id       ID,
    o.postleitzahl  PLZ,
    o.name          Sitz
  FROM
    orte o
  WHERE
    (o.orte_id = ? OR ? is null)
  ';
  return executeSQL($SQL, [$id, $id]);
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


// ---------------------------- update tables -------------------------------------

function updateTable(string $tableName, $id, array $values) {
  $SQL = 'UPDATE ' . $tableName . ' SET';
  foreach ($values as $key => $value) {
    $SQL .= ' ' . $key . ' = "' . $value . '",';
  }
  $SQL = substr($SQL, 0, -1);
  $SQL .= ' WHERE ' . $tableName . '_id = ?';
  return executeSQL($SQL, [$id]);
}

function updateRefTable() {
  // TODO: Update RefTable
}


// ---------------------------- delete tables -------------------------------------

function deleteRow($tableName, $id) {
  $SQL = '
  DELETE FROM
    '. $tableName .'
  WHERE
    '. $tableName .'_id = ?
  ';
  return executeSQL($SQL, [$id]);
}

?>