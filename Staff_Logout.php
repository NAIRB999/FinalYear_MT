<?php  
session_start();
session_destroy();

echo "<script>window.alert('Successfully Logout.')</script>";
echo "<script>window.location='Staff_Login.php'</script>";
?>