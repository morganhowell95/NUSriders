<head>  

    <?php
        include_once 'php/connect.php';
    ?>

<head>
<title>NUSriders</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="assets/css/dashboard/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/dashboard.css" rel="stylesheet">
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
            <li><a href="index.php">Dashboard</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="#">Profile</a></li>
            <li><a href="#">Help</a></li>
          </ul>
        </div>
      </div>
    </nav>

 <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
		 <ul class="nav nav-sidebar">
		 </ul>

          <ul class="nav nav-sidebar">
            <li><a href="ad-drivers-list.php">Drivers</a></li>
            <li><a href="ad-riders-list.php">Riders</a></li>
			      <li><a href="add-user.php">Add user</a></li>
			      <li class="active"><a href="update-user.php">Update user<span class="sr-only">(current)</span></a></li>
    			  <li><a href="ad-admin.php">Admin Dashboard</a></li>
            <li><a href="ad-marketing-dashboard-drivers.php">Marketing Dashboard - Drivers</a></li>
            <li><a href="ad-marketing-dashboard-riders.php">Marketing Dashboard - Riders</a></li>
          </ul>
        </div>
	</div>
</div>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
<h2 class="sub-header">Update user</h2>

<?php  

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
echo "<li><input type='submit' name='formSubmit'></li>"; 
}
}

if (isset($_GET['formSubmit'])) {
$query2 = "UPDATE users SET first_name='$_GET[first_name]', last_name='$_GET[last_name]', password='$_GET[password]', currency_amount='$_GET[currency_amount]', admin='$_GET[admin]',
 WHERE id='$_GET[uid]'";
echo "<b>SQL:   </b>".$query2."<br><br>";
$result2 = pg_query($query2);
header('Location: users-list.php');
}
?>
</div>

</form>  
</ul>
</body>  
</html> 

