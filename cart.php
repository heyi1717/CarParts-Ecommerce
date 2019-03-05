<?php
require_once("./common.php");
require_once("./session1.php");

if(isset($_POST['cancel'])){
	//$_SESSION['ary'] == NULL;
	echo "Canceled order<br>";
	echo "Cart emptied successfully";
	// remove all session variables
	session_unset();

	// destroy the session
	//session_destroy();
}

if(isset($_POST['complete'])){
	echo "Creating order";
	$user=$_SESSION['userName'];
	//$user="User1";
	$total= $_SESSION['total'];
	$shipping=$_SESSION['ship'];
	$subtotal=$_SESSION['sub'];
	$tax=$_SESSION['tax'];
	$ary = $_SESSION['ary'];
	$size=sizeof($_SESSION['ary']);
	$query = "INSERT INTO `Orders`(`UName`, `OrdDate`,`ModDate`,`NumItems`,`OrdTotal`, `Tax`,`Shipping`, `FinalTotal`) VALUES ('$user',NOW(),NOW(), $size, $subtotal, $tax, $shipping, $total)";
	echo "<br>$query<br>";
	$t_results = send_query($query);

	$query ="SELECT LAST_INSERT_ID()";
	$t_results = send_query($query);

	$query ="SELECT MAX(`OrderID`) FROM `Orders`";
	$t_results = send_query($query);
	$result = mysqli_fetch_row($t_results);
	foreach ($result as $key) {
		foreach ($ary as $value) {
			$query = "INSERT INTO OrderItems(`OrderID`,`UName`,`PartID`,`Price`) VALUES ($key,'$user',$value,(SELECT `Price` FROM Allparts WHERE `PartID` = $value))";
			echo $query;
			$t_results = send_query($query);
		}
	}
	//$ary=[];
	//$_SESSION['ary'] = $ary;
	//header("location:user.php");
    //echo "Cart emptied successfully";

}
if(isset($_POST['complete'])){
	$ary=[];
	$_SESSION['ary'] = $ary;
	header("location:home.php");
    //header("checkout.php?PartID=".$key["PartID"]);
    echo "Cart emptied successfully";
}

if (!isset($_SESSION)){ header("Location: home.php"); }
echo <<< _END
<!DOCTYPE html>
  <html>
    <head>
    <link rel="stylesheet" href="./css/styles.css">
    <style>
    	table,td{
  			border: 1px solid black;
  			color:black;
		}
		th{
			background-color: #0000ff;
			color:white;
			border: 1px solid black;
		}

</style>
      <title>Cart Page</title>

    </head>

_END;

$temp= [];
$results=[];
if(!$_SESSION['ary']){
  echo "Cart is empty";
} else {
	$query = "SELECT `State`,`Zip` FROM `CustInfo` WHERE `UName` = '".$_SESSION['userName']."'";
	$t_results = send_query($query);
	$result = mysqli_fetch_row($t_results);

	$state = $result[0];
	$zip = $result[1];
	$tax = (rtrim($state) === 'TX')? 0.0825 : 0.00;
	$total=0.0;
	$results = [];
	foreach ($_SESSION['ary'] as $key) {

		$key = rtrim($key);
		array_push($temp,$key);
	}
	foreach ($temp as $key) {
		$query = "SELECT `PartID`,`PartName`, `Suppliers`, `Price` FROM `Allparts` WHERE `PartID`=" . $key;
		$t_results = send_query($query);
		$result = mysqli_fetch_row($t_results);
		array_push($results, $result);
	}
	echo "<table class=\"tablesformat\"><caption><h3>Cart Contents</h3></caption>";
            echo "<tr>
              <th class=\"tablesheader\">PartID</th>
              <th>Part Name</th>
              <th>Suppliers</th>
              <th>Price</th></tr>";
	foreach ($results as $key) {
		echo "<tr>";
		foreach ($key as $value) {
			echo "<td>".$value . "</td>";
		}
		$total+= (float)$key[3];
		echo "</tr>";
	}
	$subtotal = $total;
	$tax = ($tax)? ($total * $tax) : 0;
    $shipping = 9.99;
	$total = ($tax)? $total +($tax)+($shipping): $total;
	$_SESSION['sub']=$subtotal;
	$_SESSION['tax']=$tax;
	$_SESSION['total']=$total;
	$_SESSION['ship']=$shipping;
	echo"
			<tr>
			<td colspan =\"3\">
			Subtotal
			</td>
			<td>";
			echo number_format($subtotal,2);
			echo "</td>
			<tr>
			<td colspan =\"3\">
			Tax
			</td>
			<td>";
			echo number_format($tax,2);
			echo "
			</td>
			<tr>
			<td colspan =\"3\">
			Shipping
			</td>
			<td>";
			echo number_format($shipping,2);
			echo "
			</td>
			</tr>
			<tr>
			<td colspan =\"3\">
			Total
			</td>
			<td>";
			echo number_format($total,2);
			echo "
			</td>
			</tr>
			<p><form action\"cart.php\" method=\"post\">
				<input type =\"submit\" name=\"cancel\" value=\"Cancel Order\">
				<input type=\"submit\" name=\"complete\" value=\"Complete Order\">
			</p>
			";

}
echo <<< _END

	</form>
    <body>
    </body>
  </html>
_END;

?>
