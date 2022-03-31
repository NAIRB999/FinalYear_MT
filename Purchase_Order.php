<?php  
session_start();
include('connect.php');
include('AutoID_Functions.php');
include('Purchase_Functions.php');

if(isset($_POST['btnAdd'])) 
{
	$cboProductID=$_POST['cboProductID'];
	$txtPurchasePrice=$_POST['txtPurchasePrice'];
	$txtPurchaseQuantity=$_POST['txtPurchaseQuantity'];

	AddProduct($cboProductID,$txtPurchasePrice,$txtPurchaseQuantity);
}

if (isset($_GET['action'])) 
{
	$action=$_GET['action'];

	if($action== "remove")
	{
		$ProductID=$_GET['ProductID'];
		RemoveProduct($ProductID);
	}
	
	if ($action == "clearall") 
	{
		ClearAll();
	}

}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Purchase Order</title>
</head>
<body>
<form action="Purchase_Order.php" method="post">
<fieldset>
<legend>Purchase Order Form :</legend>
<table cellpadding="5px">
<tr>
	<td>PO ID</td>
	<td>
		<input type="text" name="txtPOID" value="<?php echo AutoID('purchaseorder','PurchaseOrderID','PU-',6) ?>" readonly>
	</td>
	<td>Total Quantity</td>
	<td>
		<input type="text" name="txtTotalQuantity" value="0" readonly /> pcs
	</td>
</tr>
<tr>
	<td>PO Date</td>
	<td>
		<input type="text" name="txtPODate" value="<?php echo date('Y-m-d') ?>" readonly>
	</td>
	<td>Total Amount</td>
	<td>
		<input type="text" name="txtTotalAmount" value="<?php echo CalculateTotalAmount() ?>" readonly /> MMK
	</td>
</tr>
<tr>
	<td>Staff Info</td>
	<td>
		<input type="text" name="txtStaffInfo" value="<?php echo $_SESSION['StaffName'] ?>" readonly>
	</td>
	<td>VAT (5%)</td>
	<td>
		<input type="text" name="txtVAT" value="0" readonly /> MMK
	</td>
</tr>
<tr>
	<td>Product ID</td>
	<td>
		<select name="cboProductID">
		<option>--Choose ProductID--</option>
		<?php  
		$query="SELECT * FROM Product";
		$ret=mysqli_query($connection,$query);
		$count=mysqli_num_rows($ret);

		for($i=0;$i<$count;$i++) 
		{ 
			$row=mysqli_fetch_array($ret);
			$ProductID=$row['ProductID'];
			$ProductName=$row['ProductName'];

			echo "<option value='$ProductID' >" . $ProductID . ' - ' . $ProductName . "</option>";
		}
		?>
		</select>
	</td>
	<td>Grand Total</td>
	<td>
		<input type="text" name="txtGrandTotal" value="0" readonly /> MMK
	</td>
</tr>
<tr>
	<td>Purchase Price</td>
	<td>
		<input type="number" name="txtPurchasePrice" value="0"  /> MMK
	</td>
</tr>
<tr>
	<td>Purchase Quantity</td>
	<td>
		<input type="number" name="txtPurchaseQuantity" value="0"  /> pcs
	</td>
</tr>
<tr>
	<td></td>
	<td>
		<input type="submit" name="btnAdd" value="Add"  />
		<input type="reset"  value="Cancel"  />
	</td>
</tr>
</table>
<hr/>

<?php 
if(isset($_SESSION['Purchase_Functions'])) 
{
?>
<table border="1" cellpadding="5px">
<tr>
	<th>ProductImage</th>
	<th>ProductID</th>
	<th>ProductName</th>
	<th>PurchasePrice</th>
	<th>PurchaseQuantity</th>
	<th>Sub-Total</th>
	<th>Action</th>
</tr>
	<?php
	$size=count($_SESSION['Purchase_Functions']);

	for ($i=0;$i<$size;$i++) 
	{ 
		$ProductImage1=$_SESSION['Purchase_Functions'][$i]['ProductImage1'];
		$ProductID=$_SESSION['Purchase_Functions'][$i]['ProductID'];
		$ProductName=$_SESSION['Purchase_Functions'][$i]['ProductName'];
		$PurchasePrice=$_SESSION['Purchase_Functions'][$i]['PurchasePrice'];
		$PurchaseQuantity=$_SESSION['Purchase_Functions'][$i]['PurchaseQuantity'];
		$SubTotal=$PurchasePrice * $PurchaseQuantity;

	  	echo "<tr>";
	  	echo "<td>
	  	 		<img src='$ProductImage1' width='100px' height='100px'/>
	  		  </td>";
		echo "<td>$ProductID</td>";
		echo "<td>$ProductName</td>";
		echo "<td>$PurchasePrice</td>";
		echo "<td>$PurchaseQuantity</td>";
		echo "<td>$SubTotal</td>";
		echo "<td>
				<a href='Purchase_Order.php?action=remove&ProductID=$ProductID'>Remove</a>
			  </td>";
	  	echo "</tr>";
	}  
	?>
</table>
<?php
}
?>
<a href="Purchase_Order.php?action=clearall">Clear All</a>
</fieldset>
</form>
</body>
</html>