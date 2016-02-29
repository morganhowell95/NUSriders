<head>  
<title>Add user</title>  
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
<style>  
li {listt-style: none;}  
</style>  
</head>  
<body>  

<?php  
$dbconn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=password")
    or die('Could not connect: ' . pg_last_error());

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

