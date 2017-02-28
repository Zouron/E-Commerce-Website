<?php
    require 'dbconn.php';
    session_start();

    //If a query is made
    if(isset($_GET['submit']))
    {
        //Add slashes
        $query=addslashes($_GET['query']);
        $sql = "SELECT * FROM `product` ";
        //check for any item that begins with, ends with or has the query in its name
        $sql.= "WHERE `name` LIKE '$query' OR (`name` LIKE '$query%') OR (`name` LIKE '%$query%') ";
        $sql.="ORDER BY `name`;";
        $productList = $connection->query($sql)
            or die("problem with query: ".$connection->error);
    }    
    $connection->close();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Search</title>
        <link rel="stylesheet" type="text/css" href="styles.css">
        <script type="text/JavaScript" src="actions.js" defer></script>
        <meta name="description" content="Perform a search for an all items in the product list available on Ogden's Warehouse.">
        <meta name="keywords" content="search,query,find,look for">
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
                <!--The container for the search form and button-->
                    <section>
                    <h1>Search</h1>
                        <form action="search.php" method="GET" novalidate>
                            <div class="input-container">
                                <input type="text" required id="query" name="query" placeholder="Search for item by name.">
                            </div>
                            <div class="input-container">
                                <input type="submit" name="submit" id="submit" value="Search">
                            </div>
                        </form>
                    </section>
                    <section>
                    <!--If a query is made-->
                    <?php if(isset($_GET['submit'])):?>
                        <!--If there are items matching that query-->
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
                                            <td>
                                                <form action="cart.php" method="GET" name="addtocart" id="addtocart" onsubmit="return quantityCheck(this);" novalidate>
                                                    <input type="hidden" name="itemid" id="itemid" value=<?php echo $row['id']; ?>>
                                                    <input class="qty" type="number" value="1" id="qty" name="qty" min="1" width="4"><br>
                                                    <input type="submit" id="add" name="add" value="Add to cart">
                                                </form>
                                            </td>
                                        </tr>                            
                                    <?php endwhile;?>
                                </tbody>
                            </table>
                            <!--Otherwise display this-->
                        <?php else:?>
                            <p>No items found. Try something else.</p>
                        <?php endif; ?>
                    <?php endif;?>
                    </section>
                </div>
        </div>
    </section>
    <?php include('footer.php'); ?>
    </body>
</html>