<?php
    //Redirect if user doesn't have access
    require 'userredirect.php';
    require 'nocache.php';
    require 'dbconn.php';

    //If a product is to be deleted (This only happens after confirmation from the user in JS)
    if (isset($_GET["delete"]))
    {
        $prodId = intval($_GET["deleteProd"]);
        //Checking if an order exists for the product
        $sql="SELECT COUNT(*) AS 'num' FROM `product_ordered` WHERE `product`=$prodId;";

        $result = $connection->query($sql);
        $row = $result->fetch_array();
        //Cannot delete product if an order exists for it
        if ($row['num']!=0)
        {
            echo "<script type='text/javascript'>alert('Orders have been placed for this product. It cannot be deleted.');</script>";
        }
        else
        //otherwise delete it
        {
        	$sql="DELETE FROM `product` WHERE `id`= $prodId";
        	$connection->query($sql)
        		or die($connection->error);
        }
    }
    //Displaying all the products available
    $sql="SELECT `id`,`name`,`Description`,`price` FROM `product` ";
    $sql.="ORDER BY `name`;";
    $productList = $connection->query($sql)
        or die("problem with query: ".$connection->error);
    $connection->close();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Product-List</title>
        <link rel="stylesheet" type="text/css" href="styles.css">
        <script type="text/JavaScript" src="actions.js" defer></script>
        <meta name="description" content="A page available only to staff to list all the products and delete an item if required and add a new product">
        <meta name="keywords" content="all products, staff only, limited access,delete product,view products,product list">
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
                    <h1>Products:</h1>
                    	<p><a href="add-product.php">Add new Product</a></p>
                        <table>
                            <thead>
                                <tr>
                                    <td>Name</td>
                                    <td>Description</td>
                                    <td>Price</td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row=$productList->fetch_array(MYSQLI_ASSOC)):?>
                                    <tr>                                
                                        <td><?php echo $row["name"];?></td>
                                        <td><?php echo $row["Description"];?></td>
                                        <td><?php echo $row["price"];?></td>
                                        <td>
                                        <!--A short form to provide access to delete a product, the staff is asked for conrimation if they really want the product deleted-->
                                            <form action="product-list.php" method="GET" onsubmit="return areYouSure('Are you sure you want to delete this product?');" name="deleteproduct">
                                                <input type="hidden" value=<?php echo $row["id"]; ?> name="deleteProd">
                                                <input type="submit" name="delete" value="Delete">
                                            </form>
                                        </td>
                                    </tr>                            
                                <?php endwhile;?>
                            </tbody>
                        </table>
                    </section>
                </div>
        </div>
    </section>
    <?php include('footer.php'); ?>
</html>