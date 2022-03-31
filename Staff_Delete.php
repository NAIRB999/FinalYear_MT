<?php  
session_start();
include('connect.php');

$StaffID=$_GET['StaffID'];

$Delete="DELETE FROM Staff WHERE StaffID='$StaffID' ";
$ret=mysqli_query($connection,$Delete);

if($ret)  //True
{
	echo "<script>window.alert('Staff Account Successfully Deleted!')</script>";
	echo "<script>window.location='Staff_Entry.php'</script>";
}
else
{
	echo "<p>Something went wrong in Staff Delete : " . mysqli_error($connection) . "</p>";
}

?>