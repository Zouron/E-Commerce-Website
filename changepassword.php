 <?php  
    require_once("nocache.php");
    session_start();
    //redirection if required
    require 'redirecttologin.php';
    require 'dbconn.php';
    $errorMessage="";
    $userId = intval($_SESSION["id"]);

    //IF the request had been made to update the password after client validation
    if(isset($_POST["update"]))
    {   
        //Hashing the old and new passwords entered by the user
        $oldPassword=hash('sha256',$_POST["currentpassword"]);
        $newPassword=hash('sha256',$_POST["newpassword"]);
        
        //Getting the password sotred for the user
        $sql="SELECT `password` FROM `user` WHERE `id`=$userId;";
        $result = $connection->query($sql)
            or die("Failed to update ".$connection->error);

        $row=$result->fetch_array(MYSQLI_ASSOC);
        $storedPassword = $row["password"];

        //If the currentpassword entered by the user matches the stored password
        if($storedPassword==$currentpassword)
        {
            //Set the newPassword as the password in the DB
            $sql = "UPDATE `user` SET `password`='$newPassword' WHERE `id`=$userId;";
            $connection->query($sql);
        }
        else
            //otherwise this is the error message
            $errorMessage = "The current password provided doesn't match the stored password!!";
        
    }

    $userQuery = "SELECT * ";
    $userQuery.= "FROM `user` WHERE `id`=$userId";
    $userDetails = $connection->query($userQuery);
    $connection->close();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Profile</title>
        <link rel="stylesheet" type="text/css" href="styles.css">
        <script type="text/JavaScript" src="actions.js" defer></script>
        <meta name="description" content="This page allows the user to change their currently stored password.">
        <meta name="keywords" content="New password,changepassword,reset password.">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    
    <body>
    <header>
    	<?php include('header.php');?>
    </header>
    <section id="main-container" >
        <div class="container main_container">
            <?php include('links.php'); ?>
	        <div class="page_content" id="page_content">
            <section>
                <h1>Change Password:</h1>
                <p><?php echo $errorMessage?></p>
                    <form action="changepassword.php" method="POST" id="changepasswords" name="changepasswords" onsubmit="return checkChangePassword();" novalidate>
                        <div class="input-container">
                            <label for="currentpassword">Current password</label>
                            <input type="password" name="currentpassword" id="currentpassword" value="" required>
                            <div class="error">Enter current password</div>
                        </div>
                        <div class="input-container">
                            <label for="newpassword">New password</label>
                            <input type="password" id="newpassword" name="newpassword" value="" required>
                            <div class="error">Enter New password</div>
                        </div>
                        <div class="input-container">
                            <label for="confirmnewpassword">Confirm new password</label>
                            <input type="password" id="confirmnewpassword" name="confirmnewpassword" value="" required>
                            <div class="error">Reenter new password</div>
                        </div>                        
                
                        <div class="input-container">
                            <input type="submit" name="update" id="update" value="Change password">
                        </div>
                    </form>
            </section>
		    </div>
	    </div>
    </section>
    <?php include('footer.php'); ?>
    </body>
</html>