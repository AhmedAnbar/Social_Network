<?php

include $_SERVER['DOCUMENT_ROOT'] . "/social_network/functions/functions.php";

if(!isset($_SESSION['user_email'])){
	
	header("location: index.php"); 
}



if (isset($_GET['post_id'])) {
		
	global $db_connect;	
	
	$get_id = $_GET['post_id'];		
	
	
	$delete_comment = "DELETE FROM comments WHERE post_id = '$get_id'";
	$run_delete_comment = mysqli_query($db_connect, $delete_comment);
	
	if ($run_delete_comment) {
			
		$delete_post = "DELETE FROM posts WHERE post_id = '$get_id' ";
	
		$run_delete = mysqli_query($db_connect, $delete_post);
		
		if ($run_delete) {
			header('Location: ../home.php');
		}
		else {
			echo mysqli_error($db_connect);
		}
	}
	
	
	
	
	
		
}
?>