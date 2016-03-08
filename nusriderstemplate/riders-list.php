<html>
<head>
<title>NUSriders</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <link href="../css/dashboard.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">NUSriders</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="#">Profile</a></li>
            <li><a href="#">Help</a></li>
          </ul>
          <form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Search...">
          </form>
        </div>
      </div>
    </nav>

 <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
		 <ul class="nav nav-sidebar">
		 </ul>
          <ul class="nav nav-sidebar">
            <li><a href="#">Rides</a></li>
            <li><a href="#">Requests</a></li>
          </ul>
          <ul class="nav nav-sidebar">
			<li><a href="../NUSriders/drivers-list.php">Drivers</a></li>
			<li class="active"><a href="../NUSriders/riders-list.php">Riders<span class="sr-only">(current)</span></a></li>
			<li><a href="../NUSriders/users-list.php">All users</a></li>
			<li><a href="../NUSriders/add-user.php">Add user</a></li>
			<li><a href="../NUSriders/update-user.php">Update user</a></li>
          </ul>
        </div>
	</div>
</div>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
<h2 class="sub-header">Riders</h2>
<div class="table-responsive">
<table class="table table-striped">

<?php
$dbconn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=password")
    or die('Could not connect: ' . pg_last_error());
?>

<tr><td>
<form>
        Name: <input type="text" name="full_name" id="full_name">
        <input type="submit" name="formSubmit" value="Search" >
</form>
<?php

if(!isset($_GET['formSubmit'])) 
{
$query0 = "SELECT * FROM users WHERE rider='true'";
$result0 = pg_query($query0);
echo "<table border=\"1\" >
    <col width=\"80\">
    <col width=\"120\">
    <col width=\"120\">
    <col width=\"200\">
    <col width=\"120\">
    <col width=\"80\">
    <col width=\"80\">
    <thead>
	<tr>
    <th>User ID</th>
    <th>First name</th>
    <th>Last name</th>
    <th>Email</th>
    <th>Currency amount</th>
    <th>Edit</th>
	<th>Delete</th>
    </tr>
	</thead>";

    while ($row = pg_fetch_array($result0)){
      echo "<tbody><tr>";
      echo "<td>{$row['id']}</td>";
      echo "<td>" . $row['first_name'] . "</td>";
      echo "<td>" . $row['last_name'] . "</td>";
      echo "<td>" . $row['email'] . "</td>";
      echo "<td>" . $row['currency_amount'] . "</td>";
      echo "<td><a href='update-user.php?update={$row['id']}'> Edit </a></td>";
	  echo "<td><a href='delete-user.php?delete={$row['id']}'> Delete </a></td>";
      echo "</tr></tbody>";
    }
    echo "</table>";
    
    pg_free_result($result0);
}

if(isset($_GET['formSubmit'])) 
{
    $query = "SELECT id, first_name, last_name, email, currency_amount FROM users WHERE (LOWER(first_name) like LOWER('%".$_GET['full_name']."%')
OR LOWER(last_name) like LOWER('%".$_GET['full_name']."%')) ";
    $result = pg_query($query) or die('Query failed: ' . pg_last_error());
    echo "<table border=\"1\" >
    <col width=\"80\">
    <col width=\"120\">
    <col width=\"120\">
    <col width=\"200\">
    <col width=\"120\">
    <col width=\"80\">
    <col width=\"80\">
    <thead>
	<tr>
    <th>User ID</th>
    <th>First name</th>
    <th>Last name</th>
    <th>Email</th>
    <th>Currency amount</th>
    <th>Edit</th>
	<th>Delete</th>
    </tr>
	</thead>";

    while ($row = pg_fetch_array($result)){
      echo "<tbody><tr>";
      echo "<td>{$row['id']}</td>";
      echo "<td>" . $row['first_name'] . "</td>";
      echo "<td>" . $row['last_name'] . "</td>";
      echo "<td>" . $row['email'] . "</td>";
      echo "<td>" . $row['currency_amount'] . "</td>";
      echo "<td><a href='update-user.php?update={$row['id']}'> Edit </a></td>";
	  echo "<td><a href='delete-user.php?delete={$row['id']}'> Delete </a></td>";
      echo "</tr></tbody>";
    }
    echo "</table>";
    
    pg_free_result($result);
}
?>

</td> </tr>
</div>
</div>
<?php
pg_close($dbconn);
?>
</table>

</body>
</html>
