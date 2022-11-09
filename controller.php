<?php
// Server Settings
$servername = "db5010772275.hosting-data.io";
$username = "dbu1627740";
$password = "Me@Og_oB5f3fb5c";
// Database Name
$database = "dbs9113196";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

?>