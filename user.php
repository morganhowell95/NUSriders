<?php
require 'php/pgHeader.php';

require 'php/connect.php';
// connect to database

/** id of user's page */
$idArg =  $_GET['user'];
/** id of session user */
$idSs = current_user()->getUserId();

$row = pg_fetch_assoc(pg_query("
  SELECT email, first_name, last_name, currency_amount
  FROM users
  WHERE id = '{$idArg}'
"));
// query if id is valid

if($row) {
  $pg_username = $row['first_name']. " " . $row['last_name'];
  $pg_currency = $row['currency_amount'];
  $pg_ownself = $idArg == $idSs;
  include 'views/userView.php';
}else {
  echo "<html>
  <body>
  invalid
  </body>
  </html>";
  //TODO 404
}
/*
$test = current_user()->isAdmin();
echo "<html>
<body>
<script>alert(".$test.");</script>
invalid
</body>
</html>";*/
//THERES no transaction detection.... ride complete detection... money transfer business....
?>
