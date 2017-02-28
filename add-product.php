<?php
    //Check if the user has access to this page
    require 'userredirect.php';
	require 'dbconn.php';
    require 'nocache.php';

    //Getting a list of categories to provide to the user to choose from
	$sql= "SELECT * FROM `category`;";
	$categoryList = $connection->query($sql)
		or die("problem with query: ".$connection->error);

    //If the form is submitted
	if (isset($_POST["submit"]))
	{
        //add slashes and convert to approriate datatypw when required
		$name=addslashes($_POST["pname"]);
		$description = addslashes($_POST["description"]);
		$price = round(floatval($_POST["price"]),2);
		$inventory = intval($_POST['inventory']);
		$category = intval($_POST['category']);

        //Entering the product into the database.
		$sql = "INSERT INTO `product`";
		$sql.= "(name,Description,price,inventory,category)";
		$sql.= "VALUES ('$name','$description',$price,$inventory,$category);";
		$result = $connection->query($sql);
		if(!$result)
			echo "insertion failed. ".$connection->error;

	}
    $connection->close();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
	    <title>Add product</title>
	    <link rel="stylesheet" type="text/css" href="styles.css">
	    <script type="text/JavaScript" src="actions.js" defer></script>
	    <meta name="description" content="This page allows the user to add new products to the list of products on the website">
	    <meta name="keywords" content="add product, new product,add item, new item">
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
                        <h1>Add new product</h1>
                        <form action="add-product.php" method="post" novalidate name="newproduct" id="newproduct" onsubmit="return checkAddProduct();">
                            <div class="input-container">
                                <label for="pname">Product Name</label>
                                <input type="text" name="pname" value= "" placeholder="Product Name" required id="pname"><div class="error">Enter a product name</div>
                            </div>
                            <div class="input-container">
                                <label for="description">Product Description:</label>
                                <textarea rows="4" cols="50" name="description" id="description" placeholder="Enter product description here..." required></textarea>
                                <div class="error">Needs a description</div>
                            </div>
                            <div class="input-container">
                                <label for="price">Price</label>
                                <input type="text" name="price" value="" placeholder="Enter price" required id="price"><div class="error">Must enter a price</div>
                            </div>
                            <div class="input-container">
                                <label for="inventory">Stock count</label>
                                <input type="text" name="inventory" id="inventory" value="" placeholder="inventory" required>
                                <div class="error">Enter number in stock</div>
                            </div>
                            <!--A list of the category that the user must select when adding a new a product-->
                            <div class="input-container">
                                <label for="category">Category</label>
                                <select name="category" id="category" required>
                                    <option value="" disabled selected>Category</option>
                                    <?php while($row = $categoryList->fetch_array(MYSQLI_ASSOC)):?>
                                    	<option value=<?php echo $row["id"]; ?>><?php echo $row["name"]; ?></option>
                                    <?php endwhile; ?>
                                </select>
                                <div class="error">Select a category</div>
                            </div>
                            <div>
                                <input type="submit" id="submit" name="submit" value="Submit">
                            </div>
                        </form>
                    </section>
                </div>
        </div>
    </section>
    <?php include('footer.php'); ?>
	</body>
</html>