<?php
	require 'nocache.php';
	require 'dbconn.php';
	session_start();
	//If the quantity of an item in the cart has been updated
	if (isset($_GET['update']))
	{
		foreach($_SESSION['cart'] as $key => &$product)
		{
			if($product['itemid']==$_GET['id'])
			{
				$product['qty'] = $_GET['quantity'];
				//If the quantity if set to zero, remove it from the cart
				if($product['qty']==0)
					unset($_SESSION['cart'][$key]);
			}
		}
	}

	//If an item had been added to the cart
	if(isset($_GET['add']))
	{
		$itemId = intval($_GET['itemid']);
		$qty = intval($_GET['qty']);
		$inArray = false;
		//Check if a cart has been created
		if(!isset($_SESSION['cart'])) {
			$_SESSION['cart'] = array();
		}
		//Check if the item already exists in the cart, so we don't double up on an item
		foreach($_SESSION['cart'] as $product)
		{
			if($product['itemid']==$itemId)
			{
				$inArray = true;
			}
		}
		//If it is not in the cart, add the item to the cart
		if(!$inArray)
		{
			$_SESSION['cart'][] = array('itemid' => $itemId, 'qty' => $qty);
		}
				
	}
	//If the cart is already set
	if(isset($_SESSION['cart']))
	{
		//Query to get the item name and price from the id stored in the cart
		$sql = "SELECT `name`,`price` FROM `product` WHERE `id`=";
		$items = array();
		$grandTotal = 0;
		//Perform the query for each item in the cart
		foreach($_SESSION['cart'] as $entry) 
		{
			$id = intval($entry['itemid']);
			//getting the details of the item
			$products=$connection->query($sql.$id);
			$item = $products->fetch_array(MYSQLI_ASSOC);
			//pushcing the details into an array that will be used to display the cart on the page
			$items[] = array(
			   'name' => $item['name'],
			   'price' => $item['price'],
			   'qty' => $entry['qty'],
			   'id' => $id
			);
			//tracking the grandtotal
			$grandTotal += $item['price'] * $entry['qty'];
		}
	}
	$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Shopping Cart</title>
		<link rel="stylesheet" type="text/css" href="styles.css">
		<script type="text/JavaScript" src="actions.js" defer></script>
		<meta name="description" content="This page diaplays the items that are in the shopping cart of the user">
		<meta name="keywords" content="shopping cart, shopping trolley, cart, items, items to buy">
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
	            <h1>Shopping Cart</h1>
	            <!--If the cart is set and there are items to display-->
	            <?php if(!empty($_SESSION['cart'])): ?>
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
		                    			<td class="qtycolumn">
		                    			<!--A form to let the user modify the quantity of item-->
			                    			<form action="cart.php" method="get" name="updatecart" id="updatecart">
			                    				<div class="input-container">
				                    			<input class="qty" type="number" name="quantity" id="quantity" min="0" value="<?php echo $value['qty'];?>"></div>
				                    			<input type="hidden" name="id" id="id" value=<?php echo $value['id']; ?> >
				                    			<div class="input-container">
				                    			<input type="submit" name="update" id="update" value="Update"></div>
			                    			</form>
		                    			</td>
		                    			<td><?php echo $value['price']*$value['qty']; ?></td>
		                    		</tr>
		                    <?php endforeach;?>
		                    </tbody>
		                </table>
		                <p><strong>Grand Total:  <?php echo $grandTotal; ?></strong></p>
		                <?php if (isset($_SESSION['id'])):?>
			                <form action="checkout.php" method="GET">
			                	<input type="hidden" id="total" name="total" value=<?php echo $grandTotal; ?>>
			                	<input type="submit" id="submit" name="submit" value="Checkout">
			                </form>
			            <?php else: ?>
			            	<!--Telling the user they need to login in if they want to buy item in their cart-->
			            	<p>Please <a href="login.php">login</a> to proceed to checkout.</p>
		            	<?php endif;?>
		        <?php else: ?>
		        	<!--Prodving options if there are no items in the cart-->
		        	<p>No items in the cart. <a href="products.php"> Continue shopping</a></p>
		        <?php endif; ?>
	            </div>
	    </div>
	</section>
	<?php include('footer.php'); ?>
	</body>
</html>