<div id="warrper">
	<section id="present">
            	<h2 class="animated infinite bounce">Ahmed Sayed</h2>
            	<p class="animated flipInX">Hand Coded HTML, CSS, JavaScript and PHP</p>
        </section>
	<form id="regform" method="post" action="">
	<h1 class="animated infinite pulse" style="text-align: center;padding:5px;">Sign Up Here</h1>
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
				<select name="u_country" required="required">
					<option>Select a Country</option>
					<option>Egypt</option>
					<option>Italy</option>
				</select>
			</td>
		</tr>
		<tr>
			<td><lable for="gender" />Gender:</td>
			<td>
				<select name="u_gender" required="required">
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
			<td><button name="sign_up">Sign Up</button></td>
		</tr>
	</table>
	</form>
	</div>
	<div id="message">
		<!--
			Dynamic Message starts
		-->
		<?php 
		
		include $_SERVER['DOCUMENT_ROOT'] . "/social_network/user_insert.php";
		LoginUser();
		
		 ?>
		 <!--
			Dynamic Message ends
		-->
</div>