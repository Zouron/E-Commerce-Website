<?php
    require 'dbconn.php';
    require 'nocache.php';
    session_start();
    
    $sql="SELECT `id`,`name`,`Description`,`price` FROM `product` ";
    //If a category is selected
    if(isset($_GET["cat"]))
    {
        //choose only that particular category
        $category = intval($_GET["cat"]);
        $sql.="WHERE `category`=$category ";
    }
    $sql.="ORDER BY `name`;";
    $productList = $connection->query($sql)
        or die("problem with query: ".$connection->error);
    $connection->close();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Products</title>
        <link rel="stylesheet" type="text/css" href="styles.css">
        <script type="text/JavaScript" src="actions.js" defer></script>
        <meta name="description" content="List of products available for purchase from Ogden's Warehouse">
        <meta name="keywords" content="product list, items,purchase,buy,cool stuff,stock list">
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
                <h1>Products:</h1>
                <!--If there are products to list-->
                    <?php if($productList->num_rows>0):?>
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
                                    <td class="qtycolumn">
                                        <form action="cart.php" method="GET" name="addtocart" onsubmit="return quantityCheck(this);" novalidate>
                                        	<input type="hidden" name="itemid" value=<?php echo $row['id']; ?>>
                                        	<div class="input-container">
                                            <input class="qty" type="number" value="1" name="qty" min="1"></div>
                                            <div class="input-container">
                                            <input type="submit" name="add" value="Add to cart"></div>
                                        </form>
                                    </td>
                                </tr>                            
                            <?php endwhile;?>
                        </tbody>
                    </table>
                <!--Tell the user there are no products and provide some links-->
                <?php else:?>
                    <p>There are no items in this category!!</p>
                    <p>View <a href="products.php">all products</a> or go back to the <a href="categories.php">category</a> page.</p>
                <?php endif;?>
                </div>
        </div>
    </section>    
    <?php include('footer.php'); ?>
    </body>
</html>