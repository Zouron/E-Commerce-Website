<?php
    session_start();
    require 'nocache.php';
    //If already logged in rediredct to profile page.
    if (isset($_SESSION['id']))
    {
        header("location: profile.php");
        return;
    }
    require 'dbconn.php';
    //If the form has been submitted
     if(isset($_POST["submit"]))
        {
            //Add slashes to the data to avoid sql injection
            $fname = addslashes($_POST["fname"]);
            $lname = addslashes($_POST["lname"]);
            $email = addslashes($_POST["email"]);
            $pass=(hash('sha256', $_POST["password"]));
            $address = addslashes($_POST["address"]);
            $suburb = addslashes($_POST["suburb"]);
            $state = $_POST["state"];
            $pcode = intval($_POST["postcode"]);

            $sql= "INSERT INTO user";
            $sql.="(email,password,fname,lname,address,suburb,state,postcode,creation,type)";
            $sql.="VALUES ('$email','$pass','$fname','$lname','$address','$suburb','$state',$pcode,NOW(),2);";

            $result = $connection->query($sql);
            if(!$result)
                echo "failed to insert ". $connection->error;
            else
            {
                //Make the user logged in once registration is successful
                $_SESSION['id'] = $connection->insert_id;
                $_SESSION['type'] = 2;
                header("location: profile.php");
            }
        }
        $connection->close();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Registration</title>
        <link rel="stylesheet" type="text/css" href="styles.css">
        <script type="text/JavaScript" src="actions.js" defer></script>
        <meta name="description" content="This page allows the user to register themselves with the website so they can buy products and visit pages only accessable to memebers">
        <meta name="keywords" content="Register,create account,new user,registration,add user,new customer, become a member,new member">
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
                    <form action="register.php" method="post" onsubmit="return checkRegister();" novalidate name="register" id="register">
                        <h1><strong>Create an Account</strong></h1>
                        <div class="input-container">
                            <label for="fname">First Name</label>
                            <input type="text" name="fname" value= "" placeholder="First Name" required id="fname"><div class="error">Enter first name</div>
                        </div>
                        <div class="input-container">
                            <label for="lname">Last Name</label>
                            <input type="text" name="lname" value="" placeholder="Last Name" required id="lname"><div class="error">Enter last name</div>
                        </div>
                        <div class="input-container">
                            <label for="email">Email Address</label>
                            <input type="text" name="email" value="" placeholder="Email Address" required id="email"><div class="error">Enter Address</div>
                        </div>
                        <div class="input-container">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" value="" placeholder="Password" required>
                            <div class="error">Enter Password</div>
                        </div>
                        <div class="input-container">
                            <label for="address">Address</label>
                            <input type="text" name="address" id="address" value="" placeholder="Street Address" required>
                            <div class="error">Enter Address</div>
                        </div>
                        <div class="input-container">
                            <label for="suburb">Suburb</label>
                            <input type="text" name="suburb" value="" id="suburb" placeholder="Suburb" required>
                            <div class="error">Enter Suburb</div>
                        </div>
                        <div class="input-container">
                            <label for="state">State</label>
                            <select name="state" id="state" required>
                                <option value="" disabled selected>Please Select State</option>
                                <option value="NSW">NSW</option>
                                <option value="QLD">QLD</option>
                                <option value="VIC">VIC</option>
                                <option value="TAS">TAS</option>
                                <option value="NT">NT</option>
                                <option value="WA">WA</option>
                                <option value="SA">SA</option>
                            </select>
                            <div class="error">Select state</div>
                        </div>
                        <div class="input-container">
                            <label for="postcode">Post Code</label>
                            <input type="text" name="postcode" value="" placeholder="Post Code" required id="postcode">
                            <div class="error">Enter postcode</div>
                        </div>    
                
                        <div class="input-container">
                            <input type="submit" name="submit" id="submit" value="Submit">
                        </div>
                    </form>
                </div>
        </div>
    </section>
    
        <!-- This is a comment -->
    <?php include('footer.php'); ?>
    </body>
</html>