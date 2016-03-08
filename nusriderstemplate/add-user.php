<head>  
<title>Add user</title>  
    <meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
			<li class="active"><a href="../NUSriders/add-user.php">Add user<span class="sr-only">(current)</span></a></li>
			<li><a href="../NUSriders/update-user.php">Update user</a></li>
          </ul>
        </div>
	</div>
</div>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
<h2 class="sub-header">Add user</h2>
<ul>  
<form name="add-user" action="add-user.php" method="POST" >  
<li>Email:</li><li><input type="text" name="email" id="email" /></li>  
<li>First name:</li><li><input type="text" name="first_name" id="first_name" /></li>  
<li>Last name:</li><li><input type="text" name="last_name" id="last_name" /></li>  
<li>Password:</li><li><input type="text" name="password" id="password" /></li>  
<li>Currency amount:</li><li><input type="money" name="currency_amount" id="currency_amount" /></li>  
<li>Admin:</li><li><input type="boolean" name="admin" id="admin" /></li>
<li>Driver:</li><li><input type="boolean" name="driver" id="driver" /></li>  
<li>Rider:</li><li><input type="boolean" name="rider" id="rider" /></li>  
<li><input type="submit" name="formSubmit" /></li> 
<?php  
$dbconn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=password")
    or die('Could not connect: ' . pg_last_error());

$query = "INSERT INTO users (email,first_name,last_name,password,currency_amount,admin,driver,rider) 
VALUES ('$_POST[email]','$_POST[first_name]', '$_POST[last_name]', '$_POST[password]', '$_POST[currency_amount]', '$_POST[admin]', 
'$_POST[driver]', '$_POST[rider]') ";
echo "<b>SQL:   </b>".$query."<br><br>"; 
$result = pg_query($query);
?>
</div>
</form>  
</ul>
</body>  
</html> 

