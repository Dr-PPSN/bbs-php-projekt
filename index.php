<?php
    
    // Landing Page


    if (isset($_POST['btnAllTables'])) {
        header('Location: /pages/alltables.php');
        exit();
    } else if (isset($_POST['btnSQLInjection'])) {
        // TODO: check if sql is select -> redirect to table.php with sql
        // else display notification if successful or not
        // $tableHTML = buildHtmlTable(executeSQL($_POST['sql-injection-text']));
    } else if (isset($_POST['btnReset'])) {
        require './lib/DB.php';
        resetDB();
    }

?>

<!DOCTYPE html>
<html lang=de>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
        <meta charset="utf-8">
        <title>BBS PHP Projekt</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="./styles/message.css">
        <link rel="stylesheet" type="text/css" href="./styles/style.css">
    </head>
    <body>
        <div class="container-fluid h-100 bg-dark">
            <!-- Menue -->
            <div class="row bg-dark">
                <div class="col-md-7 col-sm-6 col-xs-4 py-4 h1 d-flex align-items-center justify-content-center neonTextFlickerGreen">
                    PHP Projekt Buchladen
                </div>
                <div class="col-md-5 col-sm-6 col-xs-8 d-flex align-items-center justify-content-center">
                    <div class="col-md-6 col-sm-6 col-xs-6 d-flex align-items-center justify-content-center">
                        <a class="btn btn-danger align-items-center justify-content-center" data-toggle="modal" data-target="#sql_injection_modal">
                            SQL-Injection
                        </a>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6 d-flex align-items-center justify-content-center">
                        <form action="" method="post">
                            <button type="submit" name="btnReset" class="btn btn-danger" value="reset">Datenbank zurücksetzen</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /Menue -->
            <!-- Row1 -->
            <div class="row bg-dark py-3">
                <div class="col-md-6 col-sm-6 col-xs-6 h3 d-flex align-items-center justify-content-center neonTextRed">
                    Datenbank auswählen:
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6 d-flex align-items-center justify-content-center">
                    <!-- TODO: Button für Tabellenauswahl hinzufügen -->
                    <form action="pages/table.php" method="get">
                        <button type="submit" name="table" class="button" id="btnTable" value="buecher">Bücher</button>
                        <button type="submit" name="table" class="button" id="btnTable" value="autoren">Autoren</button>
                        <button type="submit" name="table" class="button" id="btnTable" value="sparten">Sparten</button>
                        <button type="submit" name="table" class="button" id="btnTable" value="verlage">Verlage</button>
                        <button type="submit" name="table" class="button" id="btnTable" value="lieferanten">Lieferanten</button>
                        <button type="submit" name="table" class="button" id="btnTable" value="orte">Orte</button>
                    </form>
                    <form action="" method="post">
                        <button type="submit" name="btnAllTables" class="button" id="btnAllTables" value="">Alle Tabellen anzeigen</button>
                        <button type="submit" name="btnSQLInjection" class="button" id="btnSQLInjection" value="">SQL Injection</button>
                        <button type="submit" name="btnReset" class="button" id="btnReset" value="">Datenbank zurücksetzen</button>
                    </form>
                </div>
            </div>
            <!-- /Row1 -->
        </div>
        <!-- Modal SQL-Injection -->
        <div class="modal fade" id="sql_injection_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Auszuführendes SQL hier eingeben</h5>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">X</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control" id="sql-injection-text" name="sql-injection-text" placeholder="SQL">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-success" name="btnSQLInjection" id="sql-injection-senden" value="SQL Senden">
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal SQL-Injection -->
        <!-- import scripts -->
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
        <script src="./js/notification.js"></script>
    </body>
</html>