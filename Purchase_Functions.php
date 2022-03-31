<?php  
function AddProduct($cboProductID,$txtPurchasePrice,$txtPurchaseQuantity)
{
	include('connect.php');

	$query="SELECT * FROM Product WHERE ProductID='$cboProductID' ";
	$ret=mysqli_query($connection,$query);
	$count=mysqli_num_rows($ret);
	$rows=mysqli_fetch_array($ret);

	if ($count < 1) 
	{
		echo "<p>No Product Found.</p>";
		exit();
	}
	if ($txtPurchaseQuantity < 1) 
	{
		echo "<script>window.alert('Purchase Quantity cannot be Zero (0) .')</script>";
		exit();
	}

	//Already exist for Product
	if(isset($_SESSION['Purchase_Functions'])) 
	{
		$Index=IndexOf($cboProductID);

		if ($Index== -1) 
		{
			$size=count($_SESSION['Purchase_Functions']);

			$_SESSION['Purchase_Functions'][$size]['ProductID']=$cboProductID;
			$_SESSION['Purchase_Functions'][$size]['PurchasePrice']=$txtPurchasePrice;
			$_SESSION['Purchase_Functions'][$size]['PurchaseQuantity']=$txtPurchaseQuantity;
			$_SESSION['Purchase_Functions'][$size]['ProductName']=$rows['ProductName'];
			$_SESSION['Purchase_Functions'][$size]['ProductImage1']=$rows['ProductImage1'];	
		}
		else
		{
			$_SESSION['Purchase_Functions'][$Index]['PurchaseQuantity']+=$txtPurchaseQuantity;
		}
	}
	//No Product in Session
	else
	{
		$_SESSION['Purchase_Functions']=array();

		$_SESSION['Purchase_Functions'][0]['ProductID']=$cboProductID;
		$_SESSION['Purchase_Functions'][0]['PurchasePrice']=$txtPurchasePrice;
		$_SESSION['Purchase_Functions'][0]['PurchaseQuantity']=$txtPurchaseQuantity;
		$_SESSION['Purchase_Functions'][0]['ProductName']=$rows['ProductName'];
		$_SESSION['Purchase_Functions'][0]['ProductImage1']=$rows['ProductImage1'];	
	}
	echo "<script>window.location='Purchase_Order.php'</script>";
}

function ClearAll()
{
	unset($_SESSION['Purchase_Functions']);
	echo "<script>window.location='Purchase_Order.php'</script>";
}

function RemoveProduct($ProductID)
{
	$Index=IndexOf($ProductID);

	unset($_SESSION['Purchase_Functions'][$Index]);

	$_SESSION['Purchase_Functions']=array_values($_SESSION['Purchase_Functions']);

	echo "<script>window.location='Purchase_Order.php'</script>";
}

function CalculateTotalAmount()
{
	if (!isset($_SESSION['Purchase_Functions'])) 
	{
		return 0;
	}

	$TotalAmount=0;

	$size=count($_SESSION['Purchase_Functions']);

	for ($i=0; $i < $size; $i++) 
	{ 
		$PurchasePrice=$_SESSION['Purchase_Functions'][$i]['PurchasePrice'];
		$PurchaseQuantity=$_SESSION['Purchase_Functions'][$i]['PurchaseQuantity'];

		$TotalAmount += ($PurchasePrice * $PurchaseQuantity);
	}
	return $TotalAmount;
}

function IndexOf($cboProductID)
{
	if(!isset($_SESSION['Purchase_Functions'])) 
	{
		return -1;
	}

	$size=count($_SESSION['Purchase_Functions']);

	if ($size < 1) 
	{
		return -1;
	}

	for($i=0;$i<$size;$i++) 
	{ 
		if($cboProductID == $_SESSION['Purchase_Functions'][$i]['ProductID'])
		{
			return $i;
		}
		else
		{
			return -1;
		}
	}
	return -1;

}
?>