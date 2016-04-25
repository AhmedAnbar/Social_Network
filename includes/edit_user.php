<?php
include $_SERVER['DOCUMENT_ROOT'] . "/Social_Network/functions/functions.php";

if(!isset($_SESSION['user_email'])){
	
	header("location: " . $_SERVER['DOCUMENT_ROOT'] . "/Social_Network/index.php"); 
}
 ?>
    <!DOCTYPE html>
    <html>

    <head>
        <link rel="stylesheet" href="../css/main_style.css" />
        <link rel="stylesheet" href="../css/animate.css" />
        <title>
            <?php echo $_SESSION['user_name']; ?> Home Page</title>
    </head>

    <body>
        <header>
            <a href="../home.php"><img class="animated infinite pulse" src="../images/logo.png" /><span class="headertitle animated flipInY">Web FreeLancer!</span></a>
            <div id="home_links">
                <a href="../logout.php" class="action-button shadow animatebutton blue animated tada">LogOut</a>
                <a href="#" class="action-button shadow animatebutton blue">Edit Profile</a>
                <a href="../includes/my_posts.php" class="action-button shadow animatebutton blue">My Posts(<?php CountPosts(); ?>)</a>
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

                <form action="" method="post" id="edit_user_form" class="animated" enctype="multipart/form-data">
                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>" />
                    <table id="edit_user_table">
                        <tr>
                            <td>
                                <label for="user_name" class="lable">User Name: </label>
                            </td>
                            <td>
                                <input type="text" name="user_name" value="<?php echo $_SESSION['user_name']; ?>" required="required" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="user_pass" class="lable">Password: </label>
                            </td>
                            <td>
                                <input type="password" name="user_pass" placeholder="*******" required="required" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="user_email" class="lable">Email: </label>
                            </td>
                            <td>
                                <input type="email" name="user_email" required="required" value="<?php echo $_SESSION['user_email']; ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="user_country" class="lable">Country: </label>
                            </td>
                            <td>
                                <select name="user_country" disabled="disabled" style="width: 73%;">
                                    <option>
                                        <?php echo $_SESSION['user_country']; ?>
                                    </option>
                                    <option>Egypt</option>
                                    <option>Italy</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="user_gender" class="lable">Gender: </label>
                            </td>
                            <td>
                                <select name="user_gender" disabled="disabled" style="width: 73%;">
                                    <option>
                                        <?php echo $_SESSION['user_gender']; ?>
                                    </option>
                                    <option>Select a Gender</option>
                                    <option>Male</option>
                                    <option>Female</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="user_b_day" class="lable">Birthe Day: </label>
                            </td>
                            <td>
                                <input type="date" name="user_b_day" value="<?php echo $_SESSION['user_b_date']; ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="user_image">User Image: </label>
                            </td>
                            <td>
                                <input type="file" name="u_image" />
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <button name="update_profile" class="btn animated tada" style="margin-top: 20px;">Update Profile</button>
                            </td>
                        </tr>
                    </table>
                </form>
                <?php 
				if (isset($_POST['update_profile'])) {
		
					$u_id = $_POST['user_id'];
					$user_name = $_POST['user_name'];
					$user_pass = $_POST['user_pass'];
					$user_email = $_POST['user_email'];
					$user_country = $_POST['user_country'];
					$user_gender = $_POST['user_gender'];
					$user_b_day = $_POST['user_b_day'];
					$u_image = $_FILES['u_image']['name'];
					$image_tmp = $_FILES['u_image']['tmp_name'];
					
					move_uploaded_file($image_tmp, "../user/user_images/$u_image");
					
					$update_profile = "UPDATE users SET 
						user_name = '$user_name', 
						user_pass = '$user_pass',
						user_email = '$user_email',
						user_country = '$user_country',
						user_gender = '$user_gender',
						user_b_date = '$user_b_day',
						user_image = '$u_image'
						WHERE user_id = '$u_id'
						";
						
						$run_update_profile = mysqli_query($db_connect, $update_profile);
						
						if ($run_update_profile) {
							$_SESSION['user_id'] = $u_id;
							$_SESSION['user_name'] = $user_name;
							$_SESSION['user_pass'] = $user_pass;
							$_SESSION['user_email'] = $user_email;
							$_SESSION['user_country'] = $user_country;
							$_SESSION['user_gender'] = $user_gender;
							$_SESSION['user_b_date'] = $user_b_day;
							$_SESSION['user_image'] = $u_image;
							 header('location: ../home.php');
						}
						else {
							echo mysqli_error($db_connect);
						}
				}
			  ?>
                    <div id="posts">
                    </div>
            </div>

        </div>



    </body>

    </html>