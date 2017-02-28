<div class="menu_options" id="menu_options">
    <div class="panel">
        <div class="link-holder">
            <p><a href="index.php">HomePage</a></p>
        </div>
    </div>
    <div class="panel">
        <div class="link-holder">
            <p><a href="products.php">Products</a></p>
        </div>
    </div>
    <div class="panel">
        <div class="link-holder">
            <p><a href="categories.php">Categories</a></p>
        </div>
    </div>
    <div class="panel">
        <div class="link-holder">
            <p><a href="search.php">Search</a></p>
        </div>
    </div>
    <div class="panel">
        <div class="link-holder">
            <p><a href="cart.php">Cart(<?php echo $cartItems; ?>)</a></p>
        </div>
    </div>
    <?php if(!isset($_SESSION["id"])):?>
        <div class="panel">
            <div class="link-holder">
                <p><a href="login.php">Login</a></p>
            </div>
        </div>
        <div class="panel">
            <div class="link-holder">
                <p><a href="register.php">Register</a></p>
            </div>
        </div>
    <?php endif; ?>
    <?php if(isset($_SESSION["id"])):?>
        <div class="panel">
            <div class="link-holder">
                <p><a href="profile.php">Profile</a></p>
            </div>
        </div>
        <div class="panel">
            <div class="link-holder">
                <p><a href="history.php">Previous Orders</a></p>
            </div>
        </div>
        <?php if($_SESSION["type"]==1):?>
            <div class="panel">
                <div class="link-holder">
                    <p><a href="users.php">Users</a></p>
                </div>
            </div>
            <div class="panel">
                <div class="link-holder">
                    <p><a href="order-list.php">Order list</a></p>
                </div>
            </div>
            <div class="panel">
                <div class="link-holder">
                    <p><a href="product-list.php">Product list</a></p>
                </div>
            </div>
            <div class="panel">
                <div class="link-holder">
                    <p><a href="category-list.php">Category List</a></p>
                </div>
            </div>
        <?php endif;?>
        <div class="panel">
            <div class="link-holder">
                <p><a href="logoff.php">Logoff</a></p>
            </div>
        </div>
    <?php endif;?>
</div>