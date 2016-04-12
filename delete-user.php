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

<?php  

$delete = intval($_GET['delete']);
$query = "DELETE FROM users WHERE id='$delete'";
$rs = pg_query($query);
echo "<b>SQL:   </b>".$query."<br><br>";
if($rs){
  header('Location: users-list.php');
}
	
?>
</body>  
</html> 

