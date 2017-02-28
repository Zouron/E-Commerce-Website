<?php  
    require_once("nocache.php");
    //Redirect if required    
    session_start();
    include 'redirecttologin.php';
    require 'dbconn.php';
   
    $userId = intval($_SESSION["id"]);

    //Update the details if the user has submitted any changes
    if(isset($_POST["update"]))
    {
        include 'updatedetails.php';

    }

    //Query to displayu the user details
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
        <meta name="description" content="This page dispalys the profile of the user, along with their details. Theycan also view their previous orders and change their password from this page.">
        <meta name="keywords" content="profile, user details, address details,view profile,details">
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
                <a href="changepassword.php">Change Password</a>|
                <a href="history.php">History</a>
                <section>
                        <h1>User Details:</h1>
                        <?php $row = $userDetails->fetch_array(MYSQLI_ASSOC);?>
                        <table>
                            <tr>
                                <td>First Name</td>
                                <td><?php echo $row["fname"]; ?></td>
                            </tr>
                            <tr>
                                <td>Last Name</td>
                                <td><?php echo $row["lname"]; ?></td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td><?php echo $row["email"]; ?></td>
                            </tr>
                        </table>
                </section>
                <section>
                <!--A form displaying the user's address details. If they make change to the the fields they can submit the form and have their address updated in the DB-->
                    <h1>Address:</h1>
                        <form action="profile.php" method="POST" novalidate id="updateAddress" name="updateAddress" onsubmit="return checkProfile();">
                            <div class="input-container">
                                <label for="address">Address</label>
                                <input type="text" name="address" id="address" value="<?php echo $row["address"];?>" required onchange="activateButton();">
                                <div class="error">Enter Address</div>
                            </div>
                            <div class="input-container">
                                <label for="suburb">Suburb</label>
                                <input type="text" name="suburb" id="suburb" value="<?php echo $row["suburb"];?>" placeholder="Suburb" required onchange="activateButton();">
                                <div class="error">Enter Suburb</div>
                            </div>
                            <div class="input-container">
                                <label for="state">State</label>
                                <select name="state" id="state" onchange="activateButton();">
                                    <option value="<?php echo $row["state"]?>" selected><?php echo $row["state"]?></option>
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
                                <input type="text" name="postcode" value="<?php echo $row["postcode"];?>" required onchange="activateButton();" id="postcode">
                                <div class="error">Enter postcode</div>
                            </div>    
                    
                            <div class="input-container">
                                <input type="submit" name="update" id="update" value="Update Address" disabled>
                            </div>
                        </form>
                </section>
            </section>
		    </div>
	    </div>
    </section>
    <?php include('footer.php'); ?>
    </body>
</html>