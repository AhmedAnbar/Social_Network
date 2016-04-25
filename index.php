<?php 

include $_SERVER['DOCUMENT_ROOT'] . "/Social_Network/functions/functions.php";
if(isset($_SESSION['user_email'])){
	
	header("location: home.php"); 
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Project Home Page</title>
	<link rel="stylesheet" href="css/style.css" />
	<link rel="stylesheet" href="css/animate.css" />
</head>
<body>
	<header>
    <img class="animated infinite pulse" src="images/logo.png" /><span class="headertitle animated lightSpeedIn">Web FreeLancer!</span>
	<!--<div id="socialico"><img src="images/facebook1.png" /><img src="images/google.png" /><img src="images/bloger.png" /><img src="images/Twitter.png" /></div>-->
	<div id="loginbar">
		<form method="post" action="">
			<input type="email" name="email" placeholder="Email" required="required"/>
			<input type="password" name="pass" placeholder="******" required="required" />
			<button name="login" class="btn animated tada">Login</button>
		</form>
	</div>

	</header>
	
	<div id="warrper">
	<section id="present">
            	<h2 class="animated infinite bounce">Ahmed Sayed</h2>
            	<p class="animated flipInX">Hand Coded HTML, CSS, JavaScript and PHP</p>
        </section>
	<form id="regform" method="post" action="">
	<h2 class="animated infinite pulse" style="text-align: center;padding:5px;">Sign Up Here</h2>
	<table>
		<tr>
			<td><lable for="name" />Name: </td>
			<td><input type="text" name="u_name" placeholder="Enter Your Name" required="required"/></td>
		</tr>
		<tr>
			<td><lable for="password" />Password: </td>
			<td><input type="password" name="u_pass" placeholder="******" required="required"/></td>
		</tr>
		<tr>
			<td><lable for="email" />Email: </td>
			<td><input type="email" name="u_mail" placeholder="Enter Your Email" required="required"/></td>
		</tr>
		<tr>
			<td><lable for="country" />Country:</td>
			<td>
				<select name="u_country" class="btn" required="required">
					<option></option>
					<option>Egypt</option>
					<option>Italy</option>
				</select>
			</td>
		</tr>
		<tr>
			<td><lable for="gender" />Gender:</td>
			<td>
				<select name="u_gender" class="btn" required="required">
					<option>Select a Gender</option>
					<option>Male</option>
					<option>Female</option>
				</select>
			</td>
		</tr>
		<tr>
			<td><lable for="birthday" />Birthday:</td>
			<td><input type="date" name="u_birhtday" placeholder="D-MM-YYYY" required="required" /></td>
		</tr>
		<tr>
			<td></td>
			<td><button name="sign_up" class="btn animated tada" style="margin-top: 10px; width: 100%;">Sign Up</button></td>
		</tr>
	</table>
	</form>
	</div>
	<div id="message">
		<!--
			Dynamic Message starts
		-->
		<?php 
		
		SignUp();
		LoginUser();
		
		 ?>
		 <!--
			Dynamic Message ends
		-->
</div>

        <footer>CopyRights Reserved Web FreeLancer&copy; - Ahmed Sayed</footer>
</body>
</html>	

