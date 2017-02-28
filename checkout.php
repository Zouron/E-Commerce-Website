<?php
	require 'dbconn.php';
	require 'nocache.php';
	session_start();
	include 'redirecttologin.php';
	$userId = intval($_SESSION["id"]);

	//If there is nothign in the cart, redirect to the products page
	if(!isset($_SESSION['cart'])||count($_SESSION['cart'])<=0)
	{
		header("location: products.php");
	}
	//If the user and checkedout from the cart page
	if(isset($_POST["checkout"]))
	{
		//Check if the users shipping details need to be updated
		if($_POST["update"]==1)
		{
			include 'updatedetails.php';
		}
		//Perform the query to enter the order into the product_order table
		//insert to DB product_order
		$sql="INSERT INTO `product_order` (user,ordered) VALUES ";
		$sql.="($userId,NOW());";
		$connection->query($sql)
			or die($connection->error);

		//get the last auto increment of the order into the product_order table
		$orderID = $connection->insert_id;

		//Use the orderId to enter the products in cart into the product_ordered table
		//insert products into product_ordered
		$insertQuery = "INSERT INTO `product_ordered`(`order`,`product`,`price`,`quantity`) VALUES ";
		foreach ($_SESSION['cart'] as $entry)
		{
			$product = intval($entry['itemid']);
			$prodQuery = $connection->query("SELECT `price` FROM `product` WHERE `id`=$product");
			$result = $prodQuery->fetch_array(MYSQLI_ASSOC);
			//Storing the unit price of the item at the time it was purchased
			$price = floatval($result['price']);
			$qty = intval($entry['qty']);
			$connection->query($insertQuery."($orderID,$product,$price,$qty);")
			or die($connection->error);
		}
		//redirect to thankyou.php with last order.id
		header('location: thankyou.php?orderId='.$orderID);
	}
	//To get information on the user.
	$userQuery = "SELECT * ";
	$userQuery.= "FROM `user` WHERE `id`=$userId";
	$userDetails = $connection->query($userQuery);
	$connection->close();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
	    <title>Checkout</title>
	    <link rel="stylesheet" type="text/css" href="styles.css">
	    <script type="text/JavaScript" src="actions.js" defer></script>
	    <meta name="description" content="The checkout page where the user can update their shipping address and give their payment details for purchasing their order">
	    <meta name="keywords" content="checkout,buy,finalize order,pay,payment,place order, confirm order,make payment">
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
	                    <h1>Checkout</h1>
	                        <h3>Personal Information:</h3>
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
	                        <h4>Grand Total:  <?php echo $_GET['total']; ?></h4>
	                        <section>
	                        <h3>Shipping Address:</h3>
	                            <form action="checkout.php" method="POST" id="checkout" novalidate onsubmit="return verifyCheckout();" name="checkout">
	                                <div class="input-container">
	                                    <label for="address">Address</label>
	                                    <input type="text" name="address" id="address" value="<?php echo $row["address"];?>" required onchange="updateAddress();">
	                                    <div class="error">Enter Address</div>
	                                </div>
	                                <div class="input-container">
	                                    <label for="suburb">Suburb</label>
	                                    <input type="text" name="suburb" id="suburb" value="<?php echo $row["suburb"];?>" required onchange="updateAddress();">
	                                    <div class="error">Enter Suburb</div>
	                                </div>
	                                <div class="input-container">
	                                    <label for="state">State</label>
	                                    <select name="state" id="state" onchange="updateAddress();">
	                                        <option value="<?php echo $row["state"];?>" selected><?php echo $row["state"]?></option>
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
	                                    <input type="text" name="postcode" value="<?php echo $row["postcode"];?>"  required onchange="updateAddress();" id="postcode">
	                                    <div class="error">Enter postcode</div>
	                                </div>
	                                <!--This hidden value checks if there is a change made to the shipping details of the user-->
	                                <input type="hidden" value="" name="update" id="update">

	                                <div class="input-container">
	                                    <label for="method">Payment method</label>
	                                    <select name="method" id="method" required onchange="swapPaymentOption(this);">
	                                        <option value="" disabled selected>Select an option</option>
	                                        <option value="1">Paypal</option>
	                                        <option value="2">Credit Card</option>
	                                    </select>
	                                    <div class="error">Select payment option</div>
	                                </div> 
	                                	<!--A field set created to hold the credit card section of the form. This is disabled and set to not display if paypal is selected-->
	                                    <fieldset disabled id="creditcard" name="creditcard">
	                                    
	                                    	<div class="input-container">
	                                    	    <label for="type">Type</label>
	                                    	    <select class="cc" name="type" id="type" required>
	                                    	        <option value="" disabled selected>Card</option>
	                                    	        <option value="1">Master Card</option>
	                                    	        <option value="2">Visa</option>
	                                    	    </select>
	                                    	    <div class="error">Select card type</div>
	                                    	</div>
	                                    	<div class="input-container">
	                                    	    <label for="name">Card Name</label>
	                                    	    <input class="cc" type="text" name="name" id="name" value="" required>
	                                    	    <div class="error">Enter name</div>
	                                    	</div>
	                                    	<div class="input-container">
	                                    	    <label for="cardnumber">Card Number</label>
	                                    	    <input class="cc" type="text" name="cardnumber" value="" required id="cardnumber">
	                                    	    <div class="error">Enter cardnumber</div>
	                                    	</div>
	                                    	<div class="input-container">
	                                    	    <label for="csv">CSV</label>
	                                    	    <input class="cc" type="text" name="csv" value="" required id="csv">
	                                    	    <div class="error">Enter csv</div>
	                                    	</div>
	                                    	<div class="input-container">
	                                    	    <label for="month">month</label>
	                                    	    <select class="cc" name="month" id="month" required>
	                                    	        <option value="" disabled selected>Month</option>
	                                    	        <?php for ($i=1; $i <= 12; $i++): ?>
	                                    	        <option value=<?php echo $i; ?>><?php echo $i; ?></option>
	                                    	        <?php endfor;?>
	                                    	    </select>
	                                    	    <div class="error">Select month</div>
	                                    	</div>
	                                    	<div class="input-container">
	                                    	    <label for="year">Year</label>
	                                    	    <select class="cc" name="year" id="year" required>
	                                    	        <option value="" disabled selected>Year</option>
	                                    	        <?php for ($i=2016; $i < 2026; $i++): ?>
	                                    	        <option value=<?php echo $i; ?>><?php echo $i; ?></option>
	                                    	        <?php endfor;?>
	                                    	    </select>
	                                    	    <div class="error">Select card type</div>
	                                    	</div>
	                                    
	                                    </fieldset>
	                                    <div id="paypal">
	                                    	<img src="images/paypal_logo.jpg" width="200" alt="paypal logo" height="60">
	                                    </div>
	                                
	                        
	                                <div class="input-container">
	                                    <input type="submit" name="checkout" value="Checkout">
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