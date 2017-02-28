<?php
    require 'dbconn.php';
    session_start();
    $sql="SELECT * FROM `category`;";
    $categoryList = $connection->query($sql)
        or die("problem with query: ".$connection->error);
    $connection->close();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Category</title>
        <link rel="stylesheet" type="text/css" href="styles.css">
        <script type="text/JavaScript" src="actions.js" defer></script>
        <meta name="description" content="Provide a list of categories available to choose products available on Ogdens Warehouse.">
        <meta name="keywords" content="categories,category,swords,daggers,shields,pauldron,helms,list,gauntlets,greaves,armour,potions">
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
                <h1>Categories:</h1>
                    <?php while ($row=$categoryList->fetch_array(MYSQLI_ASSOC)):?>
                        <div class="panel desktop-panel">
                            <div class="link-holder">
                                <p><a href="products.php?cat=<?php echo $row['id']?>"><?php echo $row['name']?></a></p>
                            </div>
                        </div>
                    <?php endwhile;?>
                </div>
        </div>
    </section>
    <?php include('footer.php'); ?>
    </body>
</html>