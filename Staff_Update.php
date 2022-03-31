<?php  
session_start();
include('connect.php');

if(isset($_POST['btnUpdate'])) 
{
	$txtStaffID=$_POST['txtStaffID'];
	$txtStaffName=$_POST['txtStaffName'];
	$cboRole=$_POST['cboRole'];
	$txtPhone=$_POST['txtPhone'];
	$txtEmail=$_POST['txtEmail'];
	$txtPassword=$_POST['txtPassword'];
	$txtAddress=$_POST['txtAddress'];

	$update="UPDATE Staff
			 SET 
			 StaffName='$txtStaffName',
			 Role='$cboRole',
			 Email='$txtEmail',
			 Password='$txtPassword',
			 Phone='$txtPhone',
			 Address='$txtAddress'
			 WHERE
			 StaffID='$txtStaffID'
			 ";
	$ret=mysqli_query($connection,$update);

	if($ret)  //True
	{
		echo "<script>window.alert('Staff Account Successfully Updated!')</script>";
		echo "<script>window.location='Staff_Entry.php'</script>";
	}
	else
	{
		echo "<p>Something went wrong in Staff Update : " . mysqli_error($connection) . "</p>";
	}
}

if(isset($_GET['StaffID']))
{
	$StaffID=$_GET['StaffID'];

	$query="SELECT * FROM Staff WHERE StaffID='$StaffID' ";
	$ret=mysqli_query($connection,$query);
	$count=mysqli_num_rows($ret);
	$rows=mysqli_fetch_array($ret);

	if ($count < 1) 
	{
		echo "<script>window.alert('Invalid Staff Profile.')</script>";
		echo "<script>window.location='Staff_Entry.php'</script>";
	}
}
else
{
	$StaffID="";
	echo "<script>window.location='Staff_Entry.php'</script>";
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Staff Update</title>
</head>
<body>
<form action="Staff_Update.php" method="post" enctype="multipart/form-data">
<fieldset>
<legend>Enter Staff Updated Information :</legend>
<table cellpadding="5px">
<tr>
	<td>
		StaffName:<br/>
		<input type="text" name="txtStaffName" value="<?php echo $rows['StaffName'] ?>" required />
	</td>
	<td>
		Role:<br/>
		<select name="cboRole">
			<option><?php echo $rows['Role'] ?></option>
			<option>---Choose Role---</option>
			<option>Admin Manager</option>
			<option>Sales Manager</option>
		</select>
	</td>
</tr>
<tr>
	<td>
		Phone Number:<br/>
		<input type="text" name="txtPhone" value="<?php echo $rows['Phone'] ?>" required/>
	</td>
</tr>
<tr>
	<td>
		Email:<br/>
		<input type="email" name="txtEmail" value="<?php echo $rows['Email'] ?>" required/>
	</td>
</tr>
<tr>
	<td>
		Password:<br/>
		<input type="password" name="txtPassword" value="<?php echo $rows['Password'] ?>" required/>
	</td>
</tr>
<tr>
	<td colspan="2">
		Address:<br/>
		<textarea name="txtAddress" cols="35"><?php echo $rows['Address'] ?></textarea>
	</td>
</tr>
<tr>
	<td >
		<input type="hidden" name="txtStaffID" value="<?php echo $rows['StaffID'] ?>" />
		<input type="submit" name="btnUpdate" value="Update"/>
		<input type="reset" value="Clear"/>
	</td>
</tr>
</table>

</fieldset>

</form>
</body>
</html>