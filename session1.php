<?php
   include('config.php');
    
   // Start the session
   session_start();
   // Verifying if the login_user session variable is empty
   if(!empty($_SESSION['userName'])){
	   
	   //We assign the session value to the $user_check variable
	   $user_check = $_SESSION['userName'];

	   //Ask if the user is already in our database.
	   $ses_sql = mysqli_query($db,"select * from Users where UName = '$user_check'");
	   $_SESSION['cart']= [];
	   $row = mysqli_fetch_assoc($ses_sql);
	   //We assign the result to the $login_session variable
       if(($row['Type']=="reg_user")||($row['Type']=="admin")) {
           $login_session = "reg_user";
       }
	   
	   //If the $login_session is not set then the user does not exist
	   if(!isset($login_session)){
	      header("location:login.php");
	   }
	// }else{
	// 	//If login_user variable session is empty, we redirect the user to the login page
	// 	header("location:login.php");
	}
?>
