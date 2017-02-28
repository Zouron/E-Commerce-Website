<?php
    $cartItems=0;
    if (isset($_SESSION['cart'])) {
        $cartItems = count($_SESSION['cart']);
    }
?>
<nav>
    		<!--burger icon-->
    		<div class="top_banner">
                <a href="index.php"><img class="logo" src="images/mob_banner_460x44.png" alt="ogden's warehouse logo"></a>
                <a href="search.php"><img class="search" src="images/search_icon_2.png" alt="magnifying glass icon"></a>
            </div>
    		<!--for banner image-->
    		<div class="icon-bar">
                <div class="nav-bar-icons">
                    <img src="images/menu_icon.png" alt="menu icon" onclick="toggleMenu();">
                </div>
                <div class="nav-bar-icons">
                    <a href="categories.php"><img src="images/pages_icon_1.png" alt="pages icon"></a>
                </div>
                <div class="nav-bar-icons">
                    <?php if(isset($_SESSION["id"])): ?>
                        <a href="profile.php"><img src="images/user_icon.png" alt="person icon"></a>
                    <?php else:?>
                        <a href="login.php"><img src="images/user_icon.png" alt="person icon"></a>
                    <?php endif; ?>
                </div>
                <div class="nav-bar-icons">
                    <a href="cart.php"><img src="images/cart_icon.png" alt="shopping cart icon"><?php echo $cartItems;?></a>
                </div>                          
            </div>
    		<!--cart image-->
</nav>