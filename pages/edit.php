<?php

// edit page gets called with GET request (table & id)
// edit page IS NOT AVAILABLE for results from sql injection
// TODO: design edit page dependent on given table
// by submitting, the original data 

$table = $_REQUEST['table'];
$id    = $_REQUEST['id'];


?>