<?php
    session_start();
    if(isset($_SESSION["id"]))
    {
        $userId = intval($_SESSION["id"]);
        $userType = intval($_SESSION["type"]);
    }
    
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Ogden's Warehouse: Home page</title>
        <link rel="stylesheet" type="text/css" href="styles.css">
        <script type="text/JavaScript" src="actions.js" defer></script>
        <meta name="description" content="Welcome to Ogden's Warehouse. Your one stop shop for all your adventuring needs. Get items from weapon, armour, potions and more.">
        <meta name="keywords" content="ogden's warehouse, ogdens warehouse, armour, weapons,potions,items,stuff, fantasy stuff,warehouse">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
    <header>
    	<?php include('header.php');?>
    </header>
    <section id="main-container" >
        <div class="container main_container">
                <?php include('links.php');?>   
                <div class="page_content" id="page_content">
                    <h1>Welcome to Ogden's Warehouse</h1>
                    <p>Ogden's Warehouse is Tyria's largest retailer of adventuring gear. From weapons and armour, for defending yourself from
                    both expected and unexpected foes, to potions and amulets, we stock anything and everything any intrepid explorer will ever need.
                    </p>
                    <p>We cater to both novice and experienced explorers. We always have in stock a good range of exotic swords, weapons, various types
                    of armour and trinkets. There is definietly something for everyone...</p>
                    <p>This is your one stop shop for all your adventuring needs. Here you will find all the items you will need on your journey
                     and much more, all at very competetive prices. To get started have a look at the <a href="categories.php">categories</a> page
                      or go over to the <a href="products.php">products</a> page to have a look at the items we have in stock.</p>
                </div>
        </div>
    </section>
    <?php include('footer.php');?>
    </body>
</html>