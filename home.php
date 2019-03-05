<?php 
//echo phpinfo();
require_once("common.php"); 
require_once("session1.php"); 

if(isset($_POST['update']) && !empty($_SESSION['userName'])){

  if(!isset($_SESSION['ary'])) $ary = [];
  else $ary = $_SESSION['ary'];
  if(isset($_POST['checked'])){
    foreach($_POST['checked'] as $value){
      array_push($ary,$value);
      }
    }
    $_SESSION['ary'] = $ary;
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta name="author" name="Jonathan Cobos SWB Team 11">
    <title>Car Parts | Home</title>
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
  </head>

  <body>

    <header>
      <div class="container">
        <div id="branding">
          <h1>UTEP | Auto Store</h1>
      </div>
      <nav>
        <ul>
          <?php
          if(!empty($_SESSION['userName'])){
              $username = $_SESSION['userName'];
            $items=sizeof($_SESSION['ary']);
            echo "
            <li><a href=\"home.php\">Home</a></li>
            <li><a href=\"user.php\">$username</a></li>
            <li><a href=\"cart.php\">Cart $items</a></li>
            <li>|</li>
            <li><a href=\"logout.php\">Sign out</a></li>";
          } else echo "
            <li><a href=\"home.php\">Home</a></li>
            <li><a href=\"login.php\">Sign in</a></li>
            <li>|</li>
            <li><a href=\"register.php\">Register</a></li>";
          ?>
            
          </ul>
      </nav>
    </header>

    <section id="showcase">
      <div class="container">
        <h1>Affordable car parts</h1>
        <?php
        if(!isset($login_session)){
        echo "
        <p>Welcome to the auto parts page! <br> You can sign in, view auto parts in stock, and their pricing.</p>
        <p>Not a customer? Sign up today!</p>

        ";} else {
          echo "<p><h2>Browse our amazing selection below!</h2></p>";
        }
        ?>
      </div>
      
    </section>
    <div class="item">
      <p> Select part by category: 

          <?php

          $parts_category_drop ="SELECT DISTINCT `Category` FROM `Allparts`";
          function select_parts_category($var){
              return "SELECT * FROM `Allparts` WHERE `Category`='".$var."'";
          }
          
          
          echo "
          <form action\"home.php\" method=\"post\">
          <select name=\"dropdown\">";
          $query = $parts_category_drop;
          $results = send_query($query);
          foreach ($results as $key) {
            foreach ($key as $value) {
              echo "<option value=\"$value\">$value</option>";
                }
            }
            echo "
            </select> 
            <p>
            <input type =\"submit\" name=\"submit\"> 
            </p>
            <input type=\"submit\" name=\"update\" value=\"Add to Cart\">";
            if(isset($_POST['dropdown'])){
            $category = sanitzeString($_POST['dropdown']);
            $test = select_parts_category($category);
            $results = send_query($test);
            echo "<table class=\"tablesformat\"><caption><h3>$category</h3></caption>";
            echo "<tr>
              <th class=\"tablesheader\">PartID</th>
              <th>Part Name</th>
              <th>Part Number</th>
              <th>Suppliers</th>
              <th>Category</th>
              <th>Description 1</th>
              <th>Description 2</th>
              <th>Description 3</th>
              <th>Description 4</th>
              <th>Price</th>
              <th>Est. Ship. Cost</th>
              <th>Image 1</th>
              <th>Image 2</th>
              <th>Image 3</th>
              <th>Image 4</th>
              <th>Notes</th>
              <th>Ship. Weight</th>
              <th>Add To Cart</th>
              <th>Buy Now</th>
              </tr>";

            foreach ($results as $key) {
              echo "<tr>";
              foreach ($key as $value) {
                if (strpos($value, 'jpg') !== false) {
                  echo "<td><img src=\"./imgs/partimages/$value\"></td>";
                }
                else echo "<td>$value</td>";
              }
              echo"<td><input type=\"checkbox\" name=\"checked[]\" value=\"". $key["PartID"] . " \"/></td><td><a href=\"checkout.php?PartID=".$key["PartID"]."\">Buy Now</a/td>";
              echo "</tr>";
            }
            echo "</table>";
          }
          echo "</form></div>";
                ?>
      </p>
      </div>
<section>
    </section>
    <footer>
      <p>SWB Team 11, Copyright &copy; 2017</p>
    </footer>

  </body>
</html>
