<?php  
session_start();
include('connect.php');


if(isset($_SESSION['StaffID'])) 
{
	echo "<script>window.location='Staff_Home.php'</script>";
}

if(isset($_POST['btnLogin'])) 
{
	$txtEmail=$_POST['txtEmail'];
	$txtPassword=$_POST['txtPassword'];

	$query="SELECT * FROM Staff
			WHERE Email='$txtEmail'
			AND Password='$txtPassword' ";
	$ret=mysqli_query($connection,$query);
	$count=mysqli_num_rows($ret);
	$rows=mysqli_fetch_array($ret);

	if ($count < 1) 
	{
		echo "<script>window.alert('Invalid Login.Try Again')</script>";
		echo "<script>window.location='Staff_Login.php'</script>";
	}
	else
	{
		$_SESSION['StaffID']=$rows['StaffID'];
		$_SESSION['StaffName']=$rows['StaffName'];
		$_SESSION['Role']=$rows['Role'];
		$_SESSION['StaffPhoto']=$rows['StaffPhoto'];

		echo "<script>window.alert('Success: You are login as Staff')</script>";
		echo "<script>window.location='Staff_Home.php'</script>";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Staff Login</title>
</head>
<body>
<form action="Staff_Login.php" method="post">
<fieldset>
<legend>Enter Staff Login Information:</legend>
<table align="center" cellpadding="5px">
<tr>
	<td>Email</td>
	<td>
		<input type="email" name="txtEmail" placeholder="example@domain.com" required />
	</td>
</tr>
<tr>
	<td>Password</td>
	<td>
		<input type="password" name="txtPassword" placeholder="XXXXXXXXXXXXXXX" required />
	</td>
</tr>
<tr>
	<td></td>
	<td>
		<input type="submit" name="btnLogin" value="Login" />
		<input type="reset"  value="Cancel" />
	</td>
</tr>
</table>
</fieldset>
</form>
</body>
</html>