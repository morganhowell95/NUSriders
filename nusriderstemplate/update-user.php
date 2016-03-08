<head>  
<title>Update user</title> 
<title>NUSriders</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <link href="../css/dashboard.css" rel="stylesheet"> 
<style>  
li {listt-style: none;}  
</style>  
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
			<li><a href="../NUSriders/riders-list.php">Riders</a></li>
			<li><a href="../NUSriders/users-list.php">All users</a></li>
			<li><a href="../NUSriders/add-user.php">Add user</a></li>
			<li class="active"><a href="../NUSriders/update-user.php">Update user<span class="sr-only">(current)</span></a></li>
          </ul>
        </div>
	</div>
</div>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
<h2 class="sub-header">Update user</h2>

<?php  
$dbconn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=password")
    or die('Could not connect: ' . pg_last_error());

$update = intval($_GET['update']);
$query = "SELECT * FROM users WHERE id='$update' ";
$result = pg_query($query);

if (isset($_GET['update'])) {
while ($row0 = pg_fetch_array($result)) {
echo "<ul>";
echo "<form name='update-user' action='update-user.php' method='GET' >";
echo "<input class='input' type='hidden' name='uid' value='{$row0['id']}' />";
echo "<li>First name:</li><li><input type='text' name='first_name' id='first_name' value='{$row0['first_name']}'/></li>"; 
echo "<li>Last name:</li><li><input type='text' name='last_name' id='last_name' value='{$row0['last_name']}'/></li>";
echo "<li>Password:</li><li><input type='text' name='password' id='password' value='{$row0['password']}'/></li>";
echo "<li>Currency amount:</li><li><input type='money' name='currency_amount' id='currency_amount' value='{$row0['currency_amount']}'/></li>"; 
echo "<li>Admin:</li><li><input type='boolean' name='admin' id='admin' value='{$row0['admin']}'/></li>"; 
echo "<li>Driver:</li><li><input type='boolean' name='driver' id='driver' value='{$row0['driver']}'/></li>";  
echo "<li>Rider:</li><li><input type='boolean' name='rider' id='rider' value='{$row0['rider']}'/></li>";
echo "<li><input type='submit' name='formSubmit'></li>"; 
}
}

if (isset($_GET['formSubmit'])) {
$query2 = "UPDATE users SET first_name='$_GET[first_name]', last_name='$_GET[last_name]', password='$_GET[password]', currency_amount='$_GET[currency_amount]', admin='$_GET[admin]', 
driver='$_GET[driver]', rider='$_GET[rider]' WHERE id='$_GET[uid]'";
echo "<b>SQL:   </b>".$query2."<br><br>";
$result2 = pg_query($query2);
header('Location: users-list.php');
}
?>
</div>

<?php
pg_close($dbconn);
?>

</form>  
</ul>
</body>  
</html> 

