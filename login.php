<?php 
    require 'dbconn.php';
    require 'nocache.php';
    //If a session exists at the login page, redirect to the profile
    session_start();
    //If the user is loggedin redirect to profile page
    if (isset($_SESSION['id']))
    {
        header("location: profile.php");
        return;
    }
    $errorMsg="";
    $isFormValid =true;
    //If the form is submitted we check that all fields are filled in
    if(isset($_POST["submit"]))
    {
        foreach ($_POST as $key=>$value) {
        	if(empty($value))
        	{
        		$isFormValid =false;
                $errorMsg = "All fields are required.";
        	}
        }
    }
    //If the form is valid we process it
    if(isset($_POST["submit"]) && $isFormValid)
    {
        $username = addslashes($_POST["username"]);
        $password = hash('sha256', $_POST["password"]);
        $sql= "SELECT * ";
        $sql.="from `user`";
        //Get a match of the username and password
        $sql.="where `email` = '$username' AND `password`='$password';";
            
        $result = $connection->query($sql);
        if(!$result)
            echo "failed query". $connection->error;
        //If there are matches create a session id an type and redirect the user to the home page
        if($result->num_rows>0)
        {
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $_SESSION["id"] = $row["id"];
            $_SESSION["type"] = $row["type"];
            header("location: index.php");
        }
        //If no matched found the wrong credentials have been entered
        else
        {
             $errorMsg = "Bad username or password. Check your credentials and try again.";
        }
    }
    $connection->close();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <link rel="stylesheet" type="text/css" href="styles.css">
        <script type="text/JavaScript" src="actions.js" defer></script>
        <meta name="description" content="This page allows the user to login to their accouunt to buy items and access the website">
        <meta name="keywords" content="login,sign-in,get access,check in">
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
            <h1>Login</h1>
		        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" novalidate name="login" id="login" method="post" onsubmit="return checkLogin();">
		            <p><?php echo $errorMsg;?></p>
		            <div class="input-container">
		                <label for="username">Log In</label>
		                <input type="text" name="username" required value="" placeholder="Username" id="username"><div class="error">Enter username</div>
		            </div>
		            <div class="input-container">
		                <label for="password">Password</label>
		                <input type="password" name="password" required value="" placeholder="Password" id="password">
		                <div class="error">Enter Password</div>
		            </div>
		            <div class="input-container">
		                <input type="submit" name="submit" id="submit" value="Submit">
		            </div>
		        </form>
                <p>Don't have an account? <a href="register.php">Register here.</a></p>
            </section>
		    </div>
	    </div>
    </section>
    <?php include('footer.php'); ?>
    </body>
</html>