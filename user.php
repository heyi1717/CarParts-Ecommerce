<!DOCTYPE html>
<html>
<head>
<title>User</title>
<style>
body {margin:0;}

ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #333;
    position: fixed;
    top: 0;
    width: 100%;
}

li {
    float: left;
}

li a {
    display: block;
    color: white;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}

li a:hover:not(.active) {
    background-color: #111;
}

.active {
    background-color: #cd50ff;
}
</style>
</head>
<body>

<ul>
  <li><a class="active" href="user.php">USER</a></li>
  <li><a href="home.php">Shopping</a></li>
  <li><a href="resetPW.php">Password</a></li>
  <li><a href="addAD.php">Enter Address</a></li>
  <li><a href="resetAD.php">Update Address</a></li>
<?php
    
    /*if($_SESSION['userType'] == "admin") {
        echo "<li><a href='admin.php'>ADMIN</a></li>";
    } else {
        echo "";
    }*/
    ?>
  <li><a href="user.php">|</a></li>
  <li><a href="logout.php">LOG OUT</a></li>
</ul>

<div style="padding:20px;margin-top:30px;background-color:#FFFFFF;height:1500px;">
<h2>Account Information</h2>
<?php
    include('session1.php');
        
    $user_check = $_SESSION['userName'];
    $query="SELECT * From CustInfo JOIN Users WHERE CustInfo.UName = Users.UName AND Users.UName = '$user_check'";
    $result=mysqli_query($db, $query);
    if(!$result) {
        die('Could not query: '. mysqli_error());
    }
    $sql0 = "SELECT * FROM Users WHERE UName = '$user_check'";
    $Uinfo = mysqli_query($db, $sql0);
    if(!$Uinfo) {
        die('Could not query: '. mysqli_error());
    }
    
    echo "<b>Signed in As: </b>" .$user_check."<br>"."<br>";
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = mysqli_fetch_array($result)) {
            echo "<b>Username:</b> " . $row["UName"]."  |  <b>Address:</b> " . $row["Street1"].", ".$row["State"].", ".$row["Zip"]."  |  <b>First Name:</b> " . $row["Fname"]. "  |  <b>Last Name:</b> " . $row["LNAME"].  "  |  <b>User Type:</b> " . $row["Type"]."<br>".  "<b>Email:</b> " . $row["Email"]."  |  <b>Password:</b> ".$row["Password"]."  |  <b>Time of Account Creation:</b> " . $row["CreateTime"]. "  |  <b>Time of last login:</b> " . $row["LastLogin"]. "<br>"."<br>";
        }
    } else {
        while($row = mysqli_fetch_array($Uinfo)) {
            echo "<b>Username:</b> " . $row["UName"]."  |  <b>First Name:</b> " . $row["Fname"]. "  |  <b>Last Name:</b> " . $row["LNAME"].  "  |  <b>User Type:</b> " . $row["Type"]."<br>".  "<b>Email:</b> " . $row["Email"]."  |  <b>Password:</b> ".$row["Password"]."  |  <b>Time of Account Creation:</b> " . $row["CreateTime"]. "  |  <b>Time of last login:</b> " . $row["LastLogin"]. "<br>"."<br>";
        }
    }
?>
<h2>Order Information</h2>
<?php
    //$sql = "SELECT * FROM Orders JOIN OrderItems WHERE Orders.OrderID = OrderItems.OrderID AND Orders.UName = '$user_check'";
    $sql = "SELECT * FROM Orders WHERE UName = '$user_check'";
    $order=mysqli_query($db, $sql);
    if(!$order) {
        die('Could not query: '. mysqli_error());
    }
    if (mysqli_num_rows($order) > 0) {
        // output data of each row
        while($row = mysqli_fetch_array($order)) {
            echo "<b>Order ID:</b> " . $row["OrderID"]."  |  <b>Order Date:</b> " . $row["OrdDate"]. "  |  <b>Modift Date:</b> " . $row["ModDate"].  "  |  <b># of Item(s):</b> " . $row["NumItems"]."<br><br>".  "<b>Sub-Total:</b> " . $row["OrdTotal"]."<br>"."<b>Tax:</b> ".$row["Tax"]."<br>"."<b>Shipping:</b> " . $row["Shipping"]. "<br>".  "<b>Total:</b> " . $row["FinalTotal"]. "<br>"."<br>";
        }
    } else {
        echo "0 Order";
    }
    
    ?>
<h2>Order Items</h2>
<?php
    //$sql = "SELECT * FROM Orders JOIN OrderItems WHERE Orders.OrderID = OrderItems.OrderID AND Orders.UName = '$user_check'";
    $sql1 = "SELECT * FROM OrderItems where UName = '$user_check' ";
    $item=mysqli_query($db, $sql1);
    if(!$item) {
        die('Could not query: '. mysqli_error());
    }
    if (mysqli_num_rows($item) > 0) {
        // output data of each row
        while($row = mysqli_fetch_array($item)) {
            echo "<b>Order ID:</b> " . $row["OrderID"]."  |  <b>Part ID:</b> " . $row["PartID"]."  |  <b>Price:</b> " . $row["Price"]. "<br>"."<br>";
        }
    } else {
        echo "0 Items";
    }
    
    ?>
<p></p>
</div>

</body>
</html>
