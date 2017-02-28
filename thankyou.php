<?php 
	session_start();
	require 'nocache.php';
	require('dbconn.php');
	//Redirect if required
	require('redirecttologin.php');
	if(isset($_SESSION['cart'])&&isset($_GET['orderId']))
	{

		//Query to get item details from the DB
		$sql = "SELECT `name`,`price` FROM `product` WHERE `id`=";
		$items = array();
		$total = 0;
		foreach($_SESSION['cart'] as $entry) 
		{
			//Get details from the query for each item in the cart and store it locally
			$id = intval($entry['itemid']);
			$product=$connection->query($sql.$id);
			$item = $product->fetch_array(MYSQLI_ASSOC);
			$items[] = array(
			   'name' => $item['name'],
			   'price' => $item['price'],
			   'qty' => $entry['qty']
			);
			//A tally of the total
			$total += $item['price'] * $entry['qty'];
		}
		/*
		* An alternative to the above method would be to run the query fro mthe Db:
		* SELECT * FROM product_ordered WHERE `order`=$_GET['orderId'];
		* and then using a loop to go through each of the rows
		*/

		//Extracting the user details
		$userId = intval($_SESSION["id"]);
		$userQuery = "SELECT * ";
		$userQuery.= "FROM `user` WHERE `id`=$userId";
		$userDetails = $connection->query($userQuery);
		unset($_SESSION["cart"]);		//Unsettting the cart as the order has alreayd been finalized
		$connection->close();
	}else
	header("location: products.php");
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
	    <title>Thank you</title>
	    <link rel="stylesheet" type="text/css" href="styles.css">
	    <script type="text/JavaScript" src="actions.js" defer></script>
	    <meta name="description" content="This page provides a summary of the order placed along with shipping details of the user. This acts as the invoice.">
	    <meta name="keywords" content="invoice,thank you, shipping address, order summany, reciept, order details">
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
		                    <h1>Invoice No:   <?php echo $_GET['orderId']; ?></h1>
		                        <p>Shippping Details:</p>
		                            <?php $row = $userDetails->fetch_array(MYSQLI_ASSOC);?>
		                            <table>
		                                <tr>
		                                    <td>Name</td>
		                                    <td><?php echo $row["fname"]." ".$row["lname"]; ?></td>
		                                </tr>
		                                <tr>
		                                    <td>Address</td>
		                                    <td><?php echo $row["address"]; ?></td>
		                                </tr>
		                                <tr>
		                                    <td>Suburb</td>
		                                    <td><?php echo $row["suburb"]; ?></td>
		                                </tr>
		                                <tr>
		                                    <td>State</td>
		                                    <td><?php echo $row["state"]; ?></td>
		                                </tr>
		                                <tr>
		                                    <td>Postcode</td>
		                                    <td><?php echo $row["postcode"]; ?></td>
		                                </tr>
		                            </table>
	                        <h1>Order Summary:</h1>
	                        <div>
	                            <table>
	                                <thead>
	                                    <tr>
	                                        <td>Name</td>
	                                        <td>Unit Price</td>
	                                        <td>Qty</td>
	                                        <td>Total</td>
	                                    </tr>
	                                </thead>
	                                <tbody>
	                                	<?php foreach ($items as $value): ?>
	                                		<tr>
	                                			<td><?php echo $value['name'];?></td>
	                                			<td><?php echo $value['price'];?></td>
	                                			<td><?php echo $value['qty'];?></td>
	                                			<td><?php echo $value['qty']*$value['price'];?></td>
	                                		</tr>
	                                <?php endforeach;?>
	                                    
	                                </tbody>
	                            </table>
	                            <h4>Grand Total:	<?php echo($total)?></h4>
	                        </div>
	                    </section>
	                </div>
	        </div>
	    </section>
		<?php include('footer.php'); ?>
	</body>
</html>