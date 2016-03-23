<?php
include $_SERVER['DOCUMENT_ROOT'] . "/social_network/functions/functions.php";

if(!isset($_SESSION['user_email'])){
	
	header("location: index.php"); 
}
 ?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="../css/main_style.css" />
		<link rel="stylesheet" href="../css/animate.css" />
		<title>Coment on <?php echo $_SESSION['user_name']; ?> post</title>
	</head>
<body>
	<header>
    	<a href="../home.php"><img class="animated infinite pulse" src="../images/logo.png"  /><span class="headertitle animated flipInY">Web FreeLancer!</span></a>
	<div id="home_links">
		<a href="../logout.php" class="action-button shadow animatebutton blue animated tada">LogOut</a>
		<a href="edit_user.php" class="action-button shadow animatebutton blue">Edit Profile</a>
		<a href="my_posts.php" class="action-button shadow animatebutton blue">My Posts(<?php CountPosts(); ?>)</a>
	</div>
        </header>
	<div id="warrper">
		<div id="user_data">
			<div id="user_image" class="animated flipInY"><img style="width: 245px; height: 245px;" src="<?php echo '../user/user_images/' . $_SESSION['user_image']; ?>" /></div>
			<div id="user_info" class="animated flipInY">
				<?php  
					echo "<p>User Name: " . $_SESSION['user_name'] . "</p>";
					echo "<p>Email: " . $_SESSION['user_email'] . "</p>";
					echo "<p>User Country: " . $_SESSION['user_country'] . "</p>";
					echo "<p>Register Date: " . $_SESSION['register_date'] . "</p>";
					echo "<p>Last Login: " . $_SESSION['last_login'] . "</p>";

				?>
			</div>
		</div>
		<div id="user_posts">
			<div id="posts">
				<?php
					$post_id = $_GET['post_id'];
		
					// get post to dispaly on form
					
					$get_post = "SELECT * FROM posts WHERE post_id = '$post_id'";
					
					$run_get_post = mysqli_query($db_connect, $get_post);
					
					$row_post = mysqli_fetch_array($run_get_post);
					
					$post_title = $row_post['post_title'];
					$post_content = $row_post['post_content'];
					
					// display form
					
					echo "
						
						<div>
							<form action='' method='post' id='post_form'>
								<input type='hidden' name='post_id' value='$post_id' />
								<input type='text' name='post_title' class='btn' value='$post_title' />
								<textarea name='post_content'>$post_content</textarea>
								<select name='topic'>";
								getTopicsAsOption();
								
					echo "
								</select>
								<button name='edit_post'>Edit Post</button>					
							</form>
						</div>
						
					";
					
					EditMyPost();
				?>
			</div>
		</div>

	</div>
	
	
	
</body>	
</html>