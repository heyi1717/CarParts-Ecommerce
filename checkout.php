<?php   //checkout.php
require_once 'config.php';
//require_once 'login.php';

if (isset($_POST['zip'])) {
    // Calculate Shipping
    $zip = $_POST['zip'];
    if (is_numeric($zip)){
        $zip3 = substr($zip, 0, 3);
        $zipQuery = "SELECT * FROM `ZiptoZone` WHERE $zip3 BETWEEN LowZip AND HighZip";
        //$conn = new mysqli($db_hostname, $db_username, $db_password, $db_database);
        $conn = $db;
        if ($conn->connect_error){
            die($conn->connect);
        }
        else {
            $result = $conn->query($zipQuery);
            if (!$result){
                echo "No Zone Found.";
                die($conn->error);
            }
            else {
                // Get shipping cost
                $rows = $result->num_rows;
                for ($u = 0; $u < $rows; ++$u) {
                    $result->data_seek($u);
                    $row = $result->fetch_array(MYSQLI_ASSOC);
                    $zone = $row['ZoneGround'];
                }
                $weight = trim($_POST['weight']);
                $zoneQuery = "Zone" . $zone;
                $shipCostQuery = "SELECT * FROM `UPSzone` WHERE Weight = $weight";
                $shipresult = $conn->query($shipCostQuery);
                if (!$shipresult){
                    echo "No Shipping Zone Found.";
                    die($conn->error);
                }
                else {
                    $shiprows = $shipresult->num_rows;
                    for ($i = 0; $i < $shiprows; ++$i) {
                        $shipresult->data_seek($i);
                        $shiprow = $shipresult->fetch_array(MYSQLI_ASSOC);
                        $shippingcost = $shiprow[$zoneQuery];
                    }
                }
                $quantity = $_POST['quantity'];
                $price = $_POST['price'];
                $itemname = $_POST['itemname'];
                $tax_rate = 0;
                $tax = 0;
                if (isset($_POST['state'])){
                    if ($_POST['state'] == "TX"){
                        $tax_rate = .0825;
                        $tax = round((($quantity * $price) * $tax_rate), 2);
                    }
                    else {
                        $tax_rate = 0;
                        $tax = 0;
                    }
                }
                else{
                    $tax_rate = 0;
                    $tax = 0;
                }
                $total = round((($quantity * $price) + $shippingcost + $tax),2);
                echo <<<_END
                <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" target="_top">
                
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="LNG2LVVDWJRY6">
<input type="hidden" name="lc" value="US">
<input type="hidden" name="item_name" value="$itemname">
<input type="hidden" name="button_subtype" value="services">
<input type="hidden" name="amount" value="$price">
<input type="hidden" name="quantity" value="$quantity">
<input type="hidden" name="tax" value="$tax">
<input type="hidden" name="no_note" value="0">
<input type="hidden" name="cn" value="Add special instructions to the seller:">
<input type="hidden" name="shipping" value="$shippingcost">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynowCC_LG.gif:NonHosted">
<br>
                        <table>
                        <tr><th>Order Summary</th></tr>
                        <tr><td>Item: $itemname</td></tr>
                        <tr><td>Merchandise Total: $$price</td></tr>
                        <tr><td>Quantity: $quantity</td></tr>
                        <tr><td>Shipping: $$shippingcost</td></tr>
                        <tr><td>Tax: $$tax</td></tr>
                        <tr><td>Total: $$total</td></tr>
                        </table>
                        <br>
<input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>

_END;
            }
        }
    }
    else {
        echo "Not a valid zip code.";
    }
}
else {
    echo <<<_END
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <meta name="author" name="Brian McMahon SWB Team 11">
        <title>Car Parts | Checkout</title>
        <link rel="stylesheet" href="./css/style1.css">
        <style>
            table {
                font-family: arial, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }

            td, th {
                border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;
            }

            tr:nth-child(even) {
                background-color: #dddddd;
            }
        </style>
    </head>
    <body>
    <header>
      <div class="container">
        <div id="branding">
          <h1>UTEP | Auto Store</h1>
      </div>
      <nav>
        <ul>
          
            <li><a href="home.php">Home</a></li>
            <li><a href="logout.php">Sign out</a></li>
            <li><a href="cart.php">Cart 0</a></li>
            <li>|</li>
            <li><a href="register.php">Register</a></li>            
          </ul>
      </nav>
    </header>
    <form method="post" action="checkout.php">
_END;
    // Get PartID
    $PartID;
    if (isset($_GET['PartID'])){
        $PartID = $_GET['PartID'];
        if (is_numeric($PartID)){
            //echo $PartID;
            // Return Part from DB
            //$conn = new mysqli($db_hostname, $db_username, $db_password, $db_database);
            $conn = $db;
            if ($conn->connect_error){
                die($conn->connect);
            }
            else {
                // Get Part Record
                $query = "SELECT * FROM Allparts WHERE PartID = '$PartID'";
                $result = $conn->query($query);
                if (!$result){
                    echo "No Parts Found.";
                    die($conn->error);
                }
                else {
                    $rows = $result->num_rows;
                    for ($u = 0; $u < $rows; ++$u) {
                        $result->data_seek($u);
                        $row = $result->fetch_array(MYSQLI_ASSOC);
                        $PartName = $row['PartName'];
                        $PartNumber = $row['PartNumber'];
                        $Suppliers = $row['Suppliers'];
                        $Category = $row['Category'];
                        $Description01 = $row['Description01'];
                        $Description02 = $row['Description02'];
                        $Description03 = $row['Description03'];
                        $Description04 = $row['Description04'];
                        $Price = trim($row['Price']);
                        $EstShipCost = $row['EstShippingCost'];
                        $imagefilename1 = "imgs/partimages/" . trim($row['imagefilename1']);
                        $Notes = $row['Notes'];
                        $ShippingWeight = $row['ShippingWeight'];
                    }
                }
                
                // Build form
                echo <<<_END
                    <br>
                    <div class="container">
                        <h1>Check Out</h1>
                        <br>
                        <div>
                            <input type="hidden" name="itemname" value="$PartName">
                            <input type="hidden" name="price" value="$Price">
                            <input type="hidden" name="weight" value="$ShippingWeight">
                        </div>
                        <div class='row'>
                            <div class='col-xs-9 col-sm-9 col-lg-9 col-xl-9'>
                                <div class="container">
                                    <div class='row'>
                                        <div class='col-xs-12 col-sm-12 col-lg-12 col-xl-12'>
                                            <table>
                                                <tr>
                                                    <th>Item</th>
                                                    <th>Quantity</th>
                                                    <th>Price</th>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table>
                                                            <tr>
                                                                <td><img src="$imagefilename1" height="auto" width="100%"></td>
                                                                <td rowspan="3">$PartName</td>
                                                                <td>
                                                                    <div># $PartNumber</div>
                                                                    <div>$Suppliers</div>
                                                                    <div>$Category</div>
                                                                </td>
                                                            <tr>
                                                        </table>
                                                    </td>
                                                    <td>Change: <input type="text" name="quantity" value="1" style="width:20px" required></td>
                                                    <td>$$Price</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <br>
                                        <div class='col-xs-12 col-sm-12 col-lg-12 col-xl-12'>
                                            <div class="login">
                                                <table>
                                                    <tr>
                                                        <th colspan="3">Shipping Address: </th>
                                                    </tr>
                                                    <tr>
                                                        <td>City: <input type="text" name="city" required></td>
                                                        <td>State: 
                                                            <select name="state" required>
                                                                <option value="AL">Alabama</option>
                                                                <option value="AK">Alaska</option>
                                                                <option value="AZ">Arizona</option>
                                                                <option value="AR">Arkansas</option>
                                                                <option value="CA">California</option>
                                                                <option value="CO">Colorado</option>
                                                                <option value="CT">Connecticut</option>
                                                                <option value="DE">Delaware</option>
                                                                <option value="DC">District Of Columbia</option>
                                                                <option value="FL">Florida</option>
                                                                <option value="GA">Georgia</option>
                                                                <option value="HI">Hawaii</option>
                                                                <option value="ID">Idaho</option>
                                                                <option value="IL">Illinois</option>
                                                                <option value="IN">Indiana</option>
                                                                <option value="IA">Iowa</option>
                                                                <option value="KS">Kansas</option>
                                                                <option value="KY">Kentucky</option>
                                                                <option value="LA">Louisiana</option>
                                                                <option value="ME">Maine</option>
                                                                <option value="MD">Maryland</option>
                                                                <option value="MA">Massachusetts</option>
                                                                <option value="MI">Michigan</option>
                                                                <option value="MN">Minnesota</option>
                                                                <option value="MS">Mississippi</option>
                                                                <option value="MO">Missouri</option>
                                                                <option value="MT">Montana</option>
                                                                <option value="NE">Nebraska</option>
                                                                <option value="NV">Nevada</option>
                                                                <option value="NH">New Hampshire</option>
                                                                <option value="NJ">New Jersey</option>
                                                                <option value="NM">New Mexico</option>
                                                                <option value="NY">New York</option>
                                                                <option value="NC">North Carolina</option>
                                                                <option value="ND">North Dakota</option>
                                                                <option value="OH">Ohio</option>
                                                                <option value="OK">Oklahoma</option>
                                                                <option value="OR">Oregon</option>
                                                                <option value="PA">Pennsylvania</option>
                                                                <option value="RI">Rhode Island</option>
                                                                <option value="SC">South Carolina</option>
                                                                <option value="SD">South Dakota</option>
                                                                <option value="TN">Tennessee</option>
                                                                <option value="TX">Texas</option>
                                                                <option value="UT">Utah</option>
                                                                <option value="VT">Vermont</option>
                                                                <option value="VA">Virginia</option>
                                                                <option value="WA">Washington</option>
                                                                <option value="WV">West Virginia</option>
                                                                <option value="WI">Wisconsin</option>
                                                                <option value="WY">Wyoming</option>
                                                            </select>
                                                        </td>
                                                        <td>Zip Code: <input type="text" name="zip" required></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" style="text-align:center">
                                                            <input type="submit" style="background: yellow; font-weight:700;" value="Proceed To Checkout">
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <br>
                                        <br>
                                        <div class='col-xs-12 col-sm-12 col-lg-12 col-xl-12'>
                                            <table>
                                                <tr>
                                                    <th>Part Details:</th>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <ol>
                                                            <li>$Description01</li>
                                                            <li>$Description02</li>
                                                            <li>$Description03</li>
                                                            <li>$Description04</li>
                                                        </ol>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <br>
                                    </div>
                                  </div>
                            </div>
                        </div>
                    </div>
_END;
            }
        }
        else {
            echo "Invalid Part.";
        }
    }
    else {
        echo "No Parts Found.";
    }
        
echo <<<_END
    </form>
    </body>
</html>
_END;
}
?>