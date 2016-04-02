<?php
require 'php/pgHeader.php';

require 'php/connect.php';
// connect to database
//detect if POST called or default load
$dt = $_POST['dt'];
$rows = pg_fetch_all(pg_query("
SELECT * FROM route
"));

include 'views/searchView.php';
// RENDER VIEW ----------------------------------------------------------------
?>
