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
      			<li class="active"><a href="add-user.php">Add user<span class="sr-only">(current)</span></a></li>
      			<li><a href="update-user.php">Update user</a></li>
            <li><a href="ad-admin.php">Admin Dashboard</a></li>
            <li><a href="ad-marketing-dashboard-drivers.php">Marketing Dashboard - Drivers</a></li>
            <li><a href="ad-marketing-dashboard-riders.php">Marketing Dashboard - Riders</a></li>
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
<li><input type="submit" name="formSubmit" /></li> 

<?php  
$query = "INSERT INTO users (email,first_name,last_name,password,currency_amount,admin) 
VALUES ('$_POST[email]','$_POST[first_name]', '$_POST[last_name]', '$_POST[password]', '$_POST[currency_amount]', '$_POST[admin]') ";
$result = pg_query($query);
?>

</div>
</form>  
</ul>
</body>  
</html> 

