<!-- Shared logic in database queries, including connecting to dev/prod database and issuing particular instances -->

<?php

if(!defined('INCLUDE_CHECK')) die('You are not allowed to execute this file directly');

pg_connect("host=localhost port=5432 dbname=postgres user=INSERTUSERNAME password=INSERT PASSWORD")
		or die('Could not connect: ' . pg_last_error());
?>