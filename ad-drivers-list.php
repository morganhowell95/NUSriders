<html>

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
            <li class="active"><a href="ad-drivers-list.php">Drivers<span class="sr-only">(current)</span></a></li>
            <li><a href="ad-riders-list.php">Riders</a></li>
            <li><a href="add-user.php">Add user</a></li>
            <li><a href="update-user.php">Update user</a></li>
            <li><a href="ad-admin.php">Admin Dashboard</a></li>
            <li><a href="ad-marketing-dashboard-drivers.php">Marketing Dashboard - Drivers</a></li>
            <li><a href="ad-marketing-dashboard-riders.php">Marketing Dashboard - Riders</a></li>
          </ul>
        </div>
    </div>
</div>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
<h2 class="sub-header">Drivers</h2>
<div class="table-responsive">
<table class="table table-striped">

<tr><td>
<form>
        Name: <input type="text" name="full_name" id="full_name">
        <input type="submit" name="formSubmit" value="Search" >
</form>
<?php

if(!isset($_GET['formSubmit'])) 
{
    $query0 = "SELECT u.id, u.first_name, u.last_name, u.currency_amount,
  COUNT(u.id) AS no_of_riders, SUM(ri.cost) AS total_earned, SUM(ri.cost)/COUNT(u.id) AS average_per_rider 
  FROM users u, route ro, ride ri, proposal p 
  WHERE u.id=ro.driverid AND ri.routeid=ro.routeid AND p.rideid=ri.rideid 
  GROUP BY u.id, u.first_name, u.last_name, u.currency_amount";
  $result0 = pg_query($query0);
echo "<table class='table table-striped'>
  <table border=\"1\" >
    <col width=\"80\">
    <col width=\"120\">
    <col width=\"120\">
    <col width=\"80\">
    <col width=\"80\">
    <col width=\"80\">
    <col width=\"80\">
    <col width=\"80\">
    <col width=\"80\">
    <thead>
  <tr>
    <th>ID</th>
    <th>First name</th>
    <th>Last name</th>
    <th>Currency amount</th>
    <th>Number of riders</th>
    <th>Total earned</th>
    <th>Average per rider</th>  
    <th>Edit</th>
  <th>Delete</th>
    </tr>
  </thead>";

    while ($row = pg_fetch_array($result0)){
      echo "<tbody><tr>";
      echo "<td>{$row['id']}</td>";
      echo "<td>" . $row['first_name'] . "</td>";
      echo "<td>" . $row['last_name'] . "</td>";
      echo "<td>" . $row['currency_amount'] . "</td>";
      if (!empty($row['no_of_riders'])) echo "<td>" . $row['no_of_riders'] . "</td>";
    else echo 0;
    echo "<td>" . $row['total_earned'] . "</td>";
    echo "<td>" . round($row['average_per_rider'],2) . "</td>";
      echo "<td><a href='update-user.php?update={$row['id']}'> Edit </a></td>";
    echo "<td><a href='delete-user.php?delete={$row['id']}'> Delete </a></td>";
      echo "</tr></tbody>";
    }
    echo "</table>";  
    pg_free_result($result0);
}
if(isset($_GET['formSubmit'])) 
{
    $query = "SELECT u.id, u.first_name, u.last_name, u.currency_amount,
  COUNT(u.id) AS no_of_riders, SUM(ri.cost) AS total_earned, SUM(ri.cost)/COUNT(u.id) AS average_per_rider 
  FROM users u, route ro, ride ri, proposal p 
  WHERE p.status=1 AND u.id=ro.driverid AND ri.routeid=ro.routeid AND p.rideid=ri.rideid 
  AND (LOWER(first_name) like LOWER('%".$_GET['full_name']."%') OR LOWER(last_name) like LOWER('%".$_GET['full_name']."%'))
  GROUP BY u.id, u.first_name, u.last_name, u.currency_amount";
    $result = pg_query($query) or die('Query failed: ' . pg_last_error());
    echo "<table class='table table-striped'>
  <table border=\"1\" >
    <col width=\"80\">
    <col width=\"120\">
    <col width=\"120\">
    <col width=\"80\">
    <col width=\"80\">
    <col width=\"80\">
    <col width=\"80\">
    <col width=\"80\">
    <col width=\"80\">
    <thead>
  <tr>
    <th>ID</th>
    <th>First name</th>
    <th>Last name</th>
    <th>Currency amount</th>
    <th>Number of riders</th>
    <th>Total earned</th>
    <th>Average per rider</th>  
    <th>Edit</th>
    <th>Delete</th>
    </tr>
  </thead>";

    while ($row = pg_fetch_array($result)){
      echo "<tbody><tr>";
      echo "<td>{$row['id']}</td>";
      echo "<td>" . $row['first_name'] . "</td>";
      echo "<td>" . $row['last_name'] . "</td>";
      echo "<td>" . $row['currency_amount'] . "</td>";
      echo "<td>" . $row['no_of_riders'] . "</td>";
      echo "<td>" . $row['total_earned'] . "</td>";
      echo "<td>" . round($row['average_per_rider'],2) . "</td>";
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

</table>

</body>
</html>
