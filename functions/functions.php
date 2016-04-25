<?php
session_start();

include $_SERVER['DOCUMENT_ROOT'] . '/Social_Network/includes/connection.php';

// get topic as option for select element
function getTopicsAsOption() {
	global $db_connect;
	
	$get_topics = "SELECT * FROM topics";
	
	$run_topics = mysqli_query($db_connect, $get_topics);
	
	
	while ($row = mysqli_fetch_array($run_topics)) {
		
		$topic_id = $row['topic_id'];
		$topic_title = $row['topic_title'];
		
		echo "<option value='$topic_id'>$topic_title</option>";
		
	}		
}

// function to add user to databbase
function SignUp(){
	global $db_connect;
	
    
	if (isset($_POST['sign_up'])) {
	$name = htmlspecialchars($_POST['u_name']);
	$password = htmlspecialchars($_POST['u_pass']);
	$email = htmlspecialchars($_POST['u_mail']);
	$country = htmlspecialchars($_POST['u_country']);
	$gender = htmlspecialchars($_POST['u_gender']);
	$b_day = htmlspecialchars($_POST['u_birhtday']);
	$date = date("d-m-y");
	$status = "unverified";
	$posts = "No";
	
	$get_email = "SELECT * FROM users WHERE user_email='$email'";
	
	$run_email = mysqli_query($db_connect, $get_email);
	
	$check = mysqli_num_rows($run_email);
	
	if ($check == 1) {
		echo "<br />";
		echo "<h2>Email is alrady registered, plz try another!</h2>";
		exit();			
	}
		
	if (strlen($password) < 8) {
		echo "<h2>Password Error!</h2>";
		exit();			
	}
	
	$insert_user = "INSERT INTO users (
			`user_name` ,`user_pass` ,`user_email` ,
			`user_country` ,`user_gender` ,`user_b_date` ,`user_image` ,
			`register_date` ,`last_login` ,`status` ,`posts`
		)
		VALUES (
			'$name', '$password', '$email', 
			'$country', '$gender', '$b_day', 'default.jpg',
			 NOW(), NOW(), '$status', '$posts'
		);";
				
	$run_insert = mysqli_query($db_connect, $insert_user);
	
	if ($run_insert) {
		$_SESSION['user_email'] = $email;
		$_SESSION['user_name'] = $name;
		header('Location: home.php');
	}
    if (!$run_insert) {
        echo "<h1>Not inserted.</h1>";
    }
}
}

// function to login user and start session virables
function LoginUser(){
	global $db_connect;
	
if (isset($_POST['login'])) {
	
	$email = htmlspecialchars($_POST['email']);
	$password = htmlspecialchars($_POST['pass']);
	
	
	$get_email = "SELECT * FROM users WHERE user_email = '$email' AND user_pass = '$password'";
	$run_email = mysqli_query($db_connect, $get_email);
	$row = mysqli_fetch_array($run_email);
	$check = mysqli_num_rows($run_email);
	
	if ($check == 1) {
		
		$_SESSION['user_id'] = $row['user_id'];
		$_SESSION['user_name'] = $row['user_name'];
		$_SESSION['user_pass'] = $password;
		$_SESSION['user_email'] = $email;
		$_SESSION['user_country'] = $row['user_country'];
		$_SESSION['user_gender'] = $row['user_gender'];
		$_SESSION['user_b_date'] = $row['user_b_date'];
		$_SESSION['user_image'] = $row['user_image'];
		$_SESSION['register_date'] = $row['register_date'];
		$_SESSION['last_login'] = $row['last_login'];
		$_SESSION['status'] = $row['status'];
		$_SESSION['posts'] = $row['posts'];
		
		header('Location: home.php');
	}
	else {
		echo "<h2>Password or email is not correct!</h2>";
	}
		
		
	}
}

// function to insert post from home.php and redirect to home.php to prevent resubmited the form
function InsertPost(){
	global $db_connect;
	
	if (isset($_POST['post'])) {
		
		$post_title = htmlspecialchars($_POST['post_title']);
		$content = htmlspecialchars($_POST['post_content']);
		$topic_id = $_POST['topic'];
		$user_id = $_SESSION['user_id'];
		
		if ($post_title == '') {
			echo "<h2 class='error'>Please enter a title</h2>";
			exit();
		}
		elseif ($content == '') {
			echo "<h2 class='error'>Please enter topic description</h2>";
			exit();
		}
		else {
			$insrt_topic = "INSERT INTO posts (user_id, topic_id, post_content, post_title, post_date)				
								VALUE ('$user_id', '$topic_id', '$content','$post_title', NOW())";
				
			$run_insert_topic = mysqli_query($db_connect, $insrt_topic);
			
			header('location: home.php');
		}
	}
}

// paginatin function to navigate the postes in mutipages
function PaginationPosts(){
		global $db_connect;
		$per_page=5;
	
	$query = "select * from posts";
	$result = mysqli_query($db_connect, $query);
	// Count the total records
	$total_posts = mysqli_num_rows($result);
	//Using ceil function to divide the total records on per page
	$total_pages = ceil($total_posts / $per_page);
	//Going to first page
	echo "
	<center>
	<div id='pagination'>
	<a href='home.php?page=1'>First Page</a>
	";
	
	for ($i=1; $i<=$total_pages; $i++) {
	echo "<a href='home.php?page=$i'>$i</a>";
	}
	// Going to last page
	echo "<a href='home.php?page=$total_pages'>Last Page</a></center></div>";
	
}

// Function to display latest posts
function GetPosts(){
	global $db_connect;
	
	$per_page=5;
	
	if (isset($_GET['page'])) {
	$page = $_GET['page'];
	}
	else {
	$page=1;
	}
	$start_from = ($page-1) * $per_page;
	
	$get_posts = "select * from posts ORDER by 1 DESC LIMIT $start_from, $per_page";
	
	$run_posts = mysqli_query($db_connect, $get_posts);
	
	while ($row_posts = mysqli_fetch_array($run_posts)) {
		
		$post_id = $row_posts['post_id'];
		$user_id = $row_posts['user_id'];
		$post_title = $row_posts['post_title'];
		$post_content = $row_posts['post_content'];
		$post_date = $row_posts['post_date'];
		
		
		// getting the user who hase post the thread
		$get_user = "SELECT * FROM users WHERE user_id = '$user_id'";
		
		$run_get_user = mysqli_query($db_connect, $get_user);
		
		$row_users = mysqli_fetch_array($run_get_user);
		
		$user_name = $row_users['user_name'];
		$user_image = $row_users['user_image'];
		
		// now displaying all at once.
		
		echo "
			<div id='post' class='animated bounceInUp'>
				<img src='user/user_images/$user_image' width='50' height='50'>
				<h5><a href='user_profile.php?u_id=$user_id'>$user_name</a></h5>
				<h3>$post_title</h3>
				<h6>$post_date</h6>
				<p>$post_content</p>
				<a href='single.php?post_id=$post_id' class='btn animated tada'>Reply</a>
			</div>
			<br />
		";
	}
	
	PaginationPosts();
}

// function to display single post in single.php
function GetSinglePost() {
	global $db_connect;
	
	if (isset($_GET['post_id'])) {
		
		$get_id = $_GET['post_id'];
		
		$get_posts = "select * from posts WHERE post_id = $get_id";
	
		$run_posts = mysqli_query($db_connect, $get_posts);
		
		$row_posts = mysqli_fetch_array($run_posts);
			
			$post_id = $row_posts['post_id'];
			$user_id = $row_posts['user_id'];
			$post_title = $row_posts['post_title'];
			$post_content = $row_posts['post_content'];
			$post_date = $row_posts['post_date'];
			
			
			// getting the user who hase post the thread
			$get_user = "SELECT * FROM users WHERE user_id = '$user_id'";
			
			$run_get_user = mysqli_query($db_connect, $get_user);
			
			$row_users = mysqli_fetch_array($run_get_user);
			
			$user_name = $row_users['user_name'];
			$user_image = $row_users['user_image'];
			
			// now displaying all at once.
			
			echo "
				<div id='post' class='animated bounceInUp'>
					<img src='user/user_images/$user_image' width='50' height='50'>
					<h5><a href='user_profile.php?u_id=$user_id'>$user_name</a></h5>
					<h3>$post_title</h3>
					<h6>$post_date</h6>
					<p>$post_content</p>";
					
			if ($_SESSION['user_id']  == $user_id ) {
				echo "<a href='includes/delete_post.php?post_id=$post_id' class='btn animated tada'>Delete</a>";
				echo "<a href='includes/edit_post.php?post_id=$post_id' class='btn animated tada'>Edit</a>";
			}
			echo "
				</div>
				<br />
			";
			// Code to diplay comments starts

			$get_comment = "SELECT * FROM comments WHERE post_id = '$post_id' ORDER BY 1 DESC";
			
			$run_get_comment = mysqli_query($db_connect, $get_comment);
			
			while ($row_com = mysqli_fetch_array($run_get_comment)) {
				$com_id = $row_com['comment_id'];
				$com_user = $row_com['comment_author'];
				$com_user_id = $row_com['user_id'];
				$com_content = $row_com['comment_content'];
				$com_date = $row_com['date'];
				
				// HTML display starts
				echo "
					<div id='comment'>
					<h3>$com_user</h3><span><i>Said</i> on $com_date</span>
					<p>$com_content</p>";
				
				if ($com_user_id == $_SESSION['user_id']) {
					echo "
					<form action='' method='post'>
						<input type='hidden' name='com_post_id' value='$com_id' />
						<button name='delete_comment' class='btn' style='float:right; margin-top: -10px; width: 70px;'>Delete</button>
					</form>
				";
				}
					
				echo "
					</div>				
				";				
				// HTML display ends	
			}
			// Code to delete comments starts	
				if (isset($_POST['delete_comment'])) {
						
					$com_post_id = $_POST['com_post_id'];
					
					$delete_com = 'DELETE FROM comments WHERE comment_id = ' . $com_post_id;
					
					$run_delete_com = mysqli_query($db_connect, $delete_com);
					
					if (!$run_delete_com) {
						echo mysqli_error($db_connect);
					}
					header('location: single.php?post_id=' . $post_id);
				}
			// Code to delete comment ends	
			// Cod to insert a comment starts
			echo "
			<!--
				form to insert comment starts
			-->
				<form action='' method='post' id='insert_comment'>
					<textarea type='text' name='comment_content' required='required' style='padding: 10px;' class='btn' placeholder='Type your comment'></textarea><br />
					<button class='btn animated tada' style='margin-top: 5px;' name='insert_comment'>Post a comment</button>
				</form>				
			<!--
				form to insert comment starts
			-->
			
			";
			
			if (isset($_POST['insert_comment'])) {
				$comment = htmlspecialchars($_POST['comment_content']);
				$user_in_com = $_SESSION['user_id'];
				$user_in_name = $_SESSION['user_name'];
				
				$insert_com = "INSERT INTO comments (post_id, user_id, comment_content, comment_author, date) 
										VALUE ('$post_id', '$user_in_com', '$comment', '$user_in_name', NOW())";
										
				$run_insert_com = mysqli_query($db_connect,$insert_com);
				
				if ($run_insert_com) {
					header('location: single.php?post_id=' . $post_id);
				}
			}
				
	}
			
			// Cod to insert a comment ends			
	}

// function to get search results
function GetResult(){
	global $db_connect;
	
	
	if (isset($_GET['user_query'])) {
		$search_trem = $_GET['user_query'];
	}
		
		$get_posts = "select * from posts WHERE post_title LIKE '%$search_trem%' ORDER BY 1 DESC";
	
		$run_posts = mysqli_query($db_connect, $get_posts);
		
		$count_result = mysqli_num_rows($run_posts);
		
		if ($count_result == 0) {
			echo "<h3 class='error'>Sorry, we do not have results for this keyword!</h3>"; 
			exit();
		}
		
		while ($row_posts = mysqli_fetch_array($run_posts)) {
			
			
			$post_id = $row_posts['post_id'];
			$user_id = $row_posts['user_id'];
			$post_title = $row_posts['post_title'];
			$post_content = $row_posts['post_content'];
			$post_date = $row_posts['post_date'];
			
			
			// getting the user who hase post the thread
			$get_user = "SELECT * FROM users WHERE user_id = '$user_id'";
			
			$run_get_user = mysqli_query($db_connect, $get_user);
			
			$row_users = mysqli_fetch_array($run_get_user);
			
			$user_name = $row_users['user_name'];
			$user_image = $row_users['user_image'];
			
			// now displaying all at once.
			
			echo "
				<div id='post' class='animated bounceInUp'>
					<img src='../user/user_images/$user_image' width='50' height='50'>
					<h5><a href='../user_profile.php?u_id=$user_id'>$user_name</a></h5>
					<h3>$post_title</h3>
					<h6>$post_date</h6>
					<p>$post_content</p>";
					
			if ($_SESSION['user_id']  == $user_id ) {
				echo "<a href='delete_post.php?post_id=$post_id' class='btn animated tada'>Delete</a>";
				echo "<a href='edit_post.php?post_id=$post_id' class='btn animated tada'>Edit</a>";
			}
			echo "
				</div>
				<br />
			";
		
		
		}
	}

// function to count login user posts
function CountPosts(){
	global $db_connect;
	
	$us_id = $_SESSION['user_id'];
	
	$get_posts = "SELECT * FROM posts WHERE user_id = '$us_id'";
	
	$run_posts = mysqli_query($db_connect, $get_posts);
	
	$count_posts = mysqli_num_rows($run_posts);
	
	echo $count_posts;	
}

// function to get user date for user_profile.php page
function UserProfile(){
	global $db_connect;
	
	if (isset($_GET['u_id'])) {
		
		$user_id = $_GET['u_id'];
		
		$get_profile = "SELECT * FROM users WHERE user_id = '$user_id'";
		
		$run_get_profile = mysqli_query($db_connect, $get_profile);
		
		$row_user_profile = mysqli_fetch_array($run_get_profile);
		
		$user_name = $row_user_profile['user_name'];
		$user_email = $row_user_profile['user_email'];
		$user_country = $row_user_profile['user_country'];
		$user_b_date = $row_user_profile['user_b_date'];
		$user_image = $row_user_profile['user_image'];
		$register_date = $row_user_profile['register_date'];
		$last_login = $row_user_profile['last_login'];
		
		
		echo "
			<div id='user_profile_img'><img src='user/user_images/$user_image' /></div>
			<div id='user_profile_page'>
			<table>
			<tr>
				<td class='profile_lable'><p>User Name:</p></td>
				<td class='profile_value'><p>$user_name</p></td>
			</tr>
			<tr>
				<td class='profile_lable'><p>User Email:</p></td>
				<td class='profile_value'><p>$user_email</p></td>
			</tr>
			<tr>
				<td class='profile_lable'><p>User Country</p></td>
				<td class='profile_value'><p>$user_country</p></td>
			</tr>
			<tr>
				<td class='profile_lable'><p>User Birhtday:</p></td>
				<td class='profile_value'><p>$user_b_date</p></td>
			</tr>
			<tr>
				<td class='profile_lable'><p>Register Date:</p></td>
				<td class='profile_value'><p>$register_date</p></td>
			</tr>
			<tr>
				<td class='profile_lable'><p>Last Login:</p></td>
				<td class='profile_value'><p>$last_login</p></td>
			</tr>
			</table>
			<div>
		
		";
		
		
	}
}

// function to get login user post
function GetMyPost() {
	global $db_connect;
	
	$u_id = $_SESSION['user_id'];
	
	$get_my_posts = "SELECT * FROM posts WHERE posts.user_id = '$u_id'";
	
	$run_get_my_posts = mysqli_query($db_connect, $get_my_posts);
	
	$num_my_posts = mysqli_num_rows($run_get_my_posts);
	
	if ($num_my_posts < 1) {
		echo "<p class='error'>You don't post any posts!!</p>";
		exit;
	}
	
	while ($row_my_post = mysqli_fetch_array($run_get_my_posts)) {
			
		$my_post_id = $row_my_post['post_id'];
		$my_topic_id = $row_my_post['topic_id'];
		$my_post_title = $row_my_post['post_title'];
		$my_post_content = $row_my_post['post_content'];
		$my_post_date = $row_my_post['post_date'];
		$user_name = $_SESSION['user_name'];
		$user_image = $_SESSION['user_image'];
		
		
		echo "
				<div id='post' class='animated bounceInUp'>
					<img src='../user/user_images/$user_image' width='50' height='50'>
					<h5><a href='../user_profile.php?u_id=$u_id'>$user_name</a></h5>
					<h3>$my_post_title</h3>
					<h6>$my_post_date</h6>
					<p>$my_post_content</p>
					<a href='delete_post.php?post_id=$my_post_id' class='btn animated tada'>Delete</a>
					<a href='edit_post.php?post_id=$my_post_id' class='btn animated tada'>Edit</a>
				</div>
				<br />
			";
		
	}
	
	
}

// function to edit posts
function EditMyPost() {
	global $db_connect;
	
	if (isset($_POST['edit_post'])) {
		
		$post_id = $_POST['post_id'];
		$post_title = htmlspecialchars($_POST['post_title']);
		$post_contnet = htmlspecialchars($_POST['post_content']);
		$topic_id = $_POST['topic'];
		
		$update_post = "UPDATE posts SET
			post_title = '$post_title',
			post_content = '$post_contnet',
			topic_id = '$topic_id'
			WHERE post_id = '$post_id'
		";
		
		$run_update_post = mysqli_query($db_connect, $update_post);
		
		if ($run_update_post) {
			header('Location: ../single.php?post_id=' . $post_id);
		}
		
		
		
	}
}


// paginatin function to navigate members in mutipages
function PaginationMembers(){
		global $db_connect;
		$per_page=5;
	
	$query = "select * from users";
	$result = mysqli_query($db_connect, $query);
	// Count the total records
	$total_members = mysqli_num_rows($result);
	//Using ceil function to divide the total records on per page
	$total_pages = ceil($total_members / $per_page);
	//Going to first page
	echo "
	<center>
	<div id='pagination'>
	<a href='members.php?page=1'>First Page</a>
	";
	
	for ($i=1; $i<=$total_pages; $i++) {
	echo "<a href='members.php?page=$i'>$i</a>";
	}
	// Going to last page
	echo "<a href='members.php?page=$total_pages'>Last Page</a></center></div>";
	
}
// function to get all members and display theme

function Members() {
	global $db_connect;
	
	$per_page=5;
	
	if (isset($_GET['page'])) {
	$page = $_GET['page'];
	}
	else {
	$page=1;
	}
	$start_from = ($page-1) * $per_page;
	
	$get_members = "SELECT * FROM users ORDER by 1 DESC LIMIT $start_from, $per_page";
	
	$run_get_members = mysqli_query($db_connect, $get_members) or die(mysqli_error($db_connect));
	
	while ($row_member = mysqli_fetch_array($run_get_members)) {
		$user_id = $row_member['user_id'];
		$user_name = $row_member['user_name'];
		$user_email = $row_member['user_email'];
		$user_country = $row_member['user_country'];
		$user_gender = $row_member['user_gender'];
		$register_date = $row_member['register_date'];
		$user_image = $row_member['user_image'];
		
		echo "
			<div id='members' class='animated bounceInUp'>
				<table>
					<tr>
					<td><a href='../user_profile.php?u_id=$user_id'><img src='../user/user_images/$user_image' alt='$user_name' /></a></td>
					<td>
						<p>User Name: $user_name</p>
						<p>User Email: $user_email</p>
						<p>User Country: $user_country</p>
						<p>User Gender: $user_gender</p>
						<p>Register Date: $register_date</p>					
					</td>
					</tr>
				</table>
			</div>			
		";
	}
	PaginationMembers();
}



?>