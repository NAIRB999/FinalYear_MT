<?php  
session_start();
include('connect.php');

if(isset($_POST['btnSave'])) 
{
	$txtStaffName=$_POST['txtStaffName'];
	$cboRole=$_POST['cboRole'];
	$txtPhone=$_POST['txtPhone'];
	$txtEmail=$_POST['txtEmail'];
	$txtPassword=$_POST['txtPassword'];
	$txtAddress=$_POST['txtAddress'];

	//Image Upload--------------------------------------
	$Image=$_FILES['FileStaffPhoto']['name']; //abc.jpg
	$Folder="StaffPhotos/";

	$filename=$Folder . '_' .  $Image;  //StaffPhotos/_abc.jpg

	$copied=copy($_FILES['FileStaffPhoto']['tmp_name'], $filename);

	if (!$copied) 
	{
		echo "<script>window.alert('Cannot Upload Staff Photo.')</script>";
		echo "<script>window.location='Staff_Entry.php'</script>";
		exit();
	}
	//--------------------------------------------------
	
	//Check Email Already Exist or not-------------------
	$checkEmail="SELECT * FROM staff WHERE Email='$txtEmail' ";
	$ret=mysqli_query($connection,$checkEmail);
	$count=mysqli_num_rows($ret);

	if($count > 0) 
	{
		echo "<script>window.alert('Email address already exist.')</script>";
		echo "<script>window.location='Staff_Entry.php'</script>";
		exit();
	}
	//---------------------------------------------------

	$insert="INSERT INTO staff
			(StaffName,Role,Email,Password,Phone,Address,StaffPhoto) 
			VALUES
			('$txtStaffName','$cboRole','$txtEmail','$txtPassword','$txtPhone','$txtAddress','$filename')
			";
	$ret=mysqli_query($connection,$insert);

	if($ret)  //True
	{
		echo "<script>window.alert('Staff Account Successfully Created!')</script>";
		echo "<script>window.location='Staff_Entry.php'</script>";
	}
	else
	{
		echo "<p>Something went wrong in Staff Entry : " . mysqli_error($connection) . "</p>";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Staff Entry</title>
</head>
<body>
<form action="Staff_Entry.php" method="post" enctype="multipart/form-data">
<fieldset>
<legend>Enter Staff Information :</legend>
<table cellpadding="5px">
<tr>
	<td>
		StaffName:<br/>
		<input type="text" name="txtStaffName" placeholder="Eg.Alan Walker" required />
	</td>
	<td>
		Role:<br/>
		<select name="cboRole">
			<option>---Choose Role---</option>
			<option>Admin Manager</option>
			<option>Sales Manager</option>
		</select>
	</td>
</tr>
<tr>
	<td>
		Phone Number:<br/>
		<input type="text" name="txtPhone" placeholder="+95----------" required/>
	</td>
</tr>
<tr>
	<td>
		Email:<br/>
		<input type="email" name="txtEmail" placeholder="example@domain.com" required/>
	</td>
</tr>
<tr>
	<td>
		Password:<br/>
		<input type="password" name="txtPassword" placeholder="XXXXXXXXXXXX" required/>
	</td>
</tr>
<tr>
	<td colspan="2">
		Staff Photo:<br/>
		<input type="file" name="FileStaffPhoto" />
	</td>
</tr>
<tr>
	<td colspan="2">
		Address:<br/>
		<textarea name="txtAddress" cols="35"></textarea>
	</td>
</tr>
<tr>
	<td >
		<input type="submit" name="btnSave" value="Save"/>
		<input type="reset" value="Clear"/>
	</td>
</tr>
</table>

<hr/>

<?php  
$query="SELECT * FROM Staff";
$ret=mysqli_query($connection,$query);
$count=mysqli_num_rows($ret);

if($count < 1) 
{
	echo "<p>No Staff Information Found...</p>";
}
else
{
?>
	<table border="1" cellpadding="4px">
	<tr>
		<th>Photo</th>
		<th>#</th>
		<th>StaffID</th>
		<th>StaffName</th>
		<th>Email</th>
		<th>PhoneNo</th>
		<th>Address</th>
		<th>RegDate</th>
		<th>Action</th>
	</tr>
	<?php  
		for($i=0;$i<$count;$i++) 
		{ 
			$rows=mysqli_fetch_array($ret);
			//print_r($rows);

			$StaffID=$rows['StaffID'];
			$StaffPhoto=$rows['StaffPhoto'];

			echo "<tr>";
			echo "<td>
					<img src='$StaffPhoto' width='100px' height='100' />
				  </td>";
			echo "<td>" . ($i + 1)  . "</td>";
			echo "<td>$StaffID</td>";
			echo "<td>" . $rows['StaffName'] . "</td>";
			echo "<td>" . $rows['Email'] . "</td>";
			echo "<td>" . $rows['Phone'] . "</td>";
			echo "<td>" . $rows['Address'] . "</td>";
			echo "<td>" . $rows['RegDate'] . "</td>";
			echo "<td>
					<a href='Staff_Update.php?StaffID=$StaffID'>Edit</a> 
					|
					<a href='Staff_Delete.php?StaffID=$StaffID'>Delete</a> 
				  </td>";
			echo "</tr>";
		}
	?>
	</table>

<?php
}
?>

</fieldset>

</form>
</body>
</html>