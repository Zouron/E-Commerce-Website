<?php
	require 'userredirect.php';
	require 'nocache.php';
	require 'dbconn.php';

	if (isset($_POST["submit"]))
	{
		$name=addslashes($_POST["category"]);
		//Adding the new category to the database
		$sql = "INSERT INTO `category`";
		$sql.= "(name)";
		$sql.= "VALUES ('$name');";
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
	    <title>Add category</title>
	    <link rel="stylesheet" type="text/css" href="styles.css">
	    <script type="text/JavaScript" src="actions.js" defer></script>
	    <meta name="description" content="This page allws the user to add a new category to the categories page.">
	    <meta name="keywords" content="new category,add category">
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
	                    <form action="add-category.php" method="post" novalidate name="newcategory" id="newcategory" onsubmit="return checkAddCategory();">
	                        <h1>Add new category</h1>
	                        <div class="input-container">
	                            <label for="category">Category Name</label>
	                            <input type="text" name="category" value="" placeholder="Category Name" required id="category"><div class="error">Enter a name for category</div>
	                        </div>	                        
	                        <div class="input-container">
	                            <input type="submit" name="submit" id="submit" value="Submit">
	                        </div>
	                    </form>
	                </section>
                </div>
        </div>
    </section>
    <?php include('footer.php'); ?>
	</body>
</html>