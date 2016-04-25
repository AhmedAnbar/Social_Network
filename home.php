<?php
include $_SERVER['DOCUMENT_ROOT'] . "/Social_Network/functions/functions.php";

if(!isset($_SESSION['user_email'])){
	
	header("location: index.php"); 
}
 ?>
    <!DOCTYPE html>
    <html>

    <head>
        <link rel="stylesheet" href="css/main_style.css" />
        <link rel="stylesheet" href="css/animate.css" />
        <title>
            <?php echo $_SESSION['user_name']; ?> Home Page</title>
    </head>

    <body>
        <header>
            <img class="animated infinite pulse" src="images/logo.png" /><span class="headertitle animated flipInY">Web FreeLancer!</span>
            <div id="home_links">
                <a href="logout.php" class="action-button shadow animatebutton blue animated tada">LogOut</a>
                <a href="includes/edit_user.php" class="action-button shadow animatebutton blue animated tada">Edit Profile</a>
                <a href="includes/my_posts.php" class="action-button shadow animatebutton blue animated tada">My Posts(<?php CountPosts(); ?>)</a>

                <form action="includes/results.php" method="get" id="search" style="float: right;">
                    <input type="text" name="user_query" id="user_query" placeholder="Type your search here .." />
                    <button name="search">Search</button>
                </form>

            </div>
        </header>
        <div id="warrper">
            <div id="user_data">
                <div id="user_image" class="animated flipInY"><img style="width: 245px; height: 245px;" src="<?php echo 'user/user_images/' . $_SESSION['user_image']; ?>" /></div>
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

                <form action="" method="post" id="post_form" class="animated ">
                    <input type="text" name="post_title" placeholder="Write a Title" size="70" required="required" />
                    <textarea name="post_content" placeholder="Write a Post ..." required="required"></textarea>
                    <br />
                    <select name="topic" class='btn'>
                        <option>Select Topic</option>
                        <?php 
						getTopicsAsOption ();						
					?>
                    </select>
                    <button name="post" class='btn animated tada'>Post to TimeLine</button>
                </form>
                <?php InsertPost(); ?>
                    <div id="posts">
                        <?php GetPosts(); ?>
                    </div>
            </div>

        </div>



    </body>

    </html>