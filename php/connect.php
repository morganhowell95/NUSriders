<!-- Shared logic in database queries, including connecting to dev/prod database and issuing particular instances -->

<?php
	function executeQuery($sanitizedQuery) {
    	$dbconn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=password")
    or die("Could not connect: ". pg_last_error());


    	pg_close($dbconn)
    }
?>