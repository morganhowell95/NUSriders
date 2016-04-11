<?php
require 'php/pgHeader.php';

require 'php/connect.php';
// connect to database
pg_query("INSERT INTO proposal VALUES('{$_GET["pID"]}', '{$_GET["rID"]}')");
header("Location: userprofile.php?user=".current_user()->getUserId()."&pg_view=2");
?>
