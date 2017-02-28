<?php
    require 'dbconn.php';
    require 'nocache.php';
    require 'userredirect.php';  
    
    $userId = $_SESSION["id"];
    /*
    * This query is similar to the one used in the history.php page, except it gets the
    * previous orders for all the users. This uses a nested selected statement, to display the total
    * of the each order from the unit price stored in the produc_ordered table with the orderId from
    * the product_order table, for all users that have placed an order.
    */
    $sql="SELECT `product_order`.`id`, (SELECT SUM(`quantity`*`price`) FROM `product_ordered` ";
    $sql.="WHERE `product_order`.`id` = `product_ordered`.`order`) AS 'total', ";
    $sql.="CONCAT(`user`.`fname`,' ',`user`.`lname`) AS 'name', `product_order`.`ordered` FROM `product_order` ";
    $sql.="INNER JOIN `user` ON `product_order`.`user`=`user`.`id` ORDER BY `product_order`.`ordered`;";

    $orderList = $connection->query($sql)
        or die("problem with query: ".$connection->error);
    $connection->close();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Order list</title>
        <link rel="stylesheet" type="text/css" href="styles.css">
        <script type="text/JavaScript" src="actions.js" defer></script>
        <meta name="description" content="This page provides a list of all orders made by all users. This page is only accessible to staff members.">
        <meta name="keywords" content="previous order, all orders, view all, order history">
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
                <h1>All orders:</h1>
                    <table>
                        <thead>
                            <tr>
                                <td>Order No</td>
                                <td>Customer Name</td>
                                <td>Total</td>
                                <td>Date Ordered</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row=$orderList->fetch_array(MYSQLI_ASSOC)):?>
                                <tr>                                
                                    <td><?php echo $row["id"];?></td>
                                    <td><?php echo $row["name"];?></td>
                                    <td><?php echo round($row["total"],2);?></td>
                                    <td><?php echo $row["ordered"];?></td>
                                </tr>                            
                            <?php endwhile;?>
                        </tbody>
                    </table>
                </section>
                </div>
        </div>
    </section>
    <?php include('footer.php'); ?>
    </body>
</html>