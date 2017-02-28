<?php
    //Make sure only staff memebers can access this page
    require 'userredirect.php';
    require 'dbconn.php';
    require 'nocache.php';

    //If a category has been selected to be deleted
    if (isset($_GET['delete']))
    {
        $catid=intval($_GET['catid']);
        //Query to check if there are products in the category
        $sql="SELECT COUNT(*) AS 'num' FROM `product` WHERE `category`=$catid;";

        $result = $connection->query($sql);
        $row = $result->fetch_array();
        //Tell the user if there are products and it cannot be deleted
        if ($row['num']!=0)
        {
            echo "<script type='text/javascript'>alert('There are still products listed under this category.\\nDelete all products to delete this category.');</script>";
        }
        else
        {
            //Otherwise delete the category
            $sql="DELETE FROM `category` WHERE `id`= $catid";
            $connection->query($sql)
                or die($connection->error);
        }
    }
    //Get all the category
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
        <meta name="description" content="This page lists all the category that is available and allows the staff member to delete a category and even add a new category">
        <meta name="keywords" content="category list, all categories, delete category,category listing,add new category">
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
                        <h1>Categories:</h1>
                        <p><a href="add-category.php">Add new category</a></p>
                        <table>
                            <thead>
                                <tr>
                                    <td>Category</td>
                                    <td></td>
                                </tr>
                            </thead>
                            <?php while ($row=$categoryList->fetch_array(MYSQLI_ASSOC)):?>
                                <tr>
                                    <td><?php echo $row['name']?></td><td><form class="catform" name="deletecategory" action="category-list.php" method="GET" onsubmit="return areYouSure('Are you sure you want to delete this category?')">
                                                <input type="hidden" value=<?php echo $row["id"];?> name="catid">
                                                <input type="submit" name="delete" value="Delete">
                                            </form>
                                    </td>
                                </tr>
                            <?php endwhile;?>
                        </table>
                    </section>
                </div>
        </div>
    </section>
    <?php include('footer.php'); ?>
    </body>
</html>