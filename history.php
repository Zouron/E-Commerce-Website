<?php
    require 'dbconn.php';
    require 'nocache.php';
    session_start();
    include 'redirecttologin.php';

    $userId = $_SESSION["id"];
    /*
    * This query gets the order id, the total sum for each product for that order
    * (nested select statements are used for this query),
    * the date the order was place for the specific user that is logged in. The
    * result we get from the DB is then ordered by the date as requested in the specification.
    */
    $sql="SELECT `product_order`.`id`, (SELECT SUM(`quantity`*`price`) FROM ";
    $sql.="`product_ordered` WHERE `product_order`.`id` = `product_ordered`.`order`) AS 'total', ";
    $sql.="`product_order`.`ordered` FROM `product_order` WHERE `product_order`.`user`=$userId ";
    $sql.="ORDER BY `product_order`.`ordered`;";

    $orderList = $connection->query($sql)
        or die("problem with query: ".$connection->error);
    $connection->close();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>History</title>
        <link rel="stylesheet" type="text/css" href="styles.css">
        <script type="text/JavaScript" src="actions.js" defer></script>
        <meta name="description" content="This page allows the user to view all the previous orders that they have placed from the website">
        <meta name="keywords" content="history, previous orders,archived orders,all orders, old orders,order history">
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
                <h1>Previous orders:</h1>
                    <table>
                        <thead>
                            <tr>
                                <td>Order No</td>
                                <td>Total</td>
                                <td>Date Ordered</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row=$orderList->fetch_array(MYSQLI_ASSOC)):?>
                                <tr>                                
                                    <td><?php echo $row["id"];?></td>
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