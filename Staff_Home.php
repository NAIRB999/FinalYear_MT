<?php  
session_start();
include('connect.php');

if(!isset($_SESSION['StaffID'])) 
{
	echo "<script>window.alert('Please Login first to continue.')</script>";
	echo "<script>window.location='Staff_Login.php'</script>";
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Staff Home</title>
</head>
<body>
<form>
<h4>
Welcome : <?php echo $_SESSION['StaffName'] ?> 
<img src="<?php echo $_SESSION['StaffPhoto'] ?>" width="10px" height="10px" />
|  <?php echo $_SESSION['Role'] ?>
|  <a href="Staff_Logout.php"> Logout</a>


?>
	
</h4>
</form>
</body>
</html>