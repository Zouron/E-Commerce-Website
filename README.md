#Build an E-Commerce website

##Description and Tasks
Your assignment is to build a simple eCommerce site. The products available for this site is up to you. There is no
facility for product images, so your products will have a name and a description only.

###Navigation
There are two (2) different types of users on the site, 􀀀user, and staff􀀀. Both users will use the same login feature, however depending on the type of user logged in will determine what the user can navigate to. This means there will be dynamic private links dependent on the type of user logged in. However, there will be public links available to all users and guests (those not logged in).

  * Public links : all users
    * Home Page
    * Products
    * Categories
    * Search
    * Shopping Cart
    * Login
    * User Registration
  * Private Links: user and staff users only
    * Checkout
    * Profile
    * Previous Orders
  * Private Links : staff users only
    * Users
    * Orders
    * Products
    * Categories

###Validation
Where there are forms, validation should be carried out with javascript to ensure the data is valid before submission. For all other validation, such as callbacks or postbacks, this validation is to be done server side through PHP.

###Site Report
You are to do a simple report, no more than two pages. One page for your system srchitecture, and another with:

  * A basic assessment of security
  * Suggested improvements to the site
  * Notes about deviations with your work to the instruction. Eg: Extra functionality


###Site Files
The site will be made up of various files creating HTML5 and files which do logic and redirect. This means some will be a mix of PHP and HTML5, and others will just be PHP.

As a bare minimum the following files should exist within your site:

  * index.php
  * products.php
  * categories.php
  * search.php
  * cart.php
  * login.php
  * logout.php
  * register.php
  * checkout.php
  * thankyou.php
  * profile.php􀀀
  * changepassword.php
  * history.php
  * users.php
  * order-list.php
  * product-list.php
  * category-list.php
  * add-product.php
  * add-category.php
  * styles.css
  * actions.js

#### index.php
This is your home page to the site. You can incorporate static images, and you can stylise it the way you want. You do however have to ensure the user can navigate all sections of the site from this page. This includes the public and private links.

The shopping cart links should show the amount of products within it on all pages.

Remember you are building for a wide range of devices and therefore your design should be responsive - use media queries (refer to style.css file)􀀀

####products.php
The products page lists all the products available within your site. They will be listed in alphabetical order. The way you present your products is up to you. It must be clear though. It also must have a link to add product to the cart and quantity of such product.
The products page can also handle product categories, restrict listing only to category, when a user selects a category from the category.php page. To achieve something like this:

####categories.php
This page provides a simple list of all the categories available. When a category is selected the user is taken to the products page where only the products available chosen category exists.

####search.php
Is almost a replicate of the products page, however the user is able to search for products by a query. This means there has to be a search box available to the user. The query will be passed via a GET request. With this query you can use WHERE clauses to find product by name. The an example SQL statement:􀀀

####cart.php
This page presents the contents of the shopping cart to the user. The name of the product, price, total, has to be displayed to the user.

When a user clicks Add to Cart, this page also handles the GET request with the product being added, and the quantity.

####logout.php
This page does not present anything to the user. Instead, the user is taken to this page when they click logoff,􀀀 which is a dynamic link that appears throughout the site once logged in. Once a user has been taken to this page their session is destroyed which results in them loosing access to logged in only sections of the site, such as dynamic links and pages. Upon this, they are redirected to the home page index.php

####register.php
This page presents a form for registration. You should provide a link on your site to register if they want to become a new member. The link to this page should also be present on the shopping cart page, if they are not logged in, as they can't checkout unless they are registered.

Remember the password is to be encrypted!

####checkout.php
Check is available to only user's who are logged in. It is the page which a user progresses to after they have put something into their cart. They cannot progress to checkout if there is nothing in their cart. This page will present two forms. One for shipping details, this will be pre-populated by the user's details in their profile, and the􀀀 payment method. You will have two choices for payment. One an Electronic Wallet, such as Paypal, and the second being Credit card. The choice will be decided by the user, and upon choice a section underneath the selection should appear accommodating their choice. For the electronic wallet, you present a bade.

####thankyou.php
Once a successful checkout has taken place, this page will be presented. On this page will be a summary of the shipping details, the order number, and what was bought and the totalling price. You can think of it as the invoice.

####profile.php
For the currently logged in user, they will be able to update their details for their profile. Upon submission their􀀀 details will be updated

####changepassword.php
This page is only accessible through the profile.php page. The user will have to enter in their old password, and also have the new password confirmed. A password cannot be updated, unless the old password is valid.􀀀

####history.php
This is a simple page listing the currently logged in user's previous orders. You only have to list the order ID, the total price of the order, and the date it was placed.

####users.php
This page is only accessible by users who are of staff type. On this page, all users (Staff and User user type) are􀀀􀀀 to be listed via a table. You are also to provide a link within the list to make the user a Staff user_type or to revoke􀀀 it.

####order-list.php
This page provides a list of all orders placed within a table. The orders are to be sorted based on date.

####product-list.php
This page provides a list via a table, for all products on the site. You are also to provide a link within the table to delete a product. This can be carried out via a callback. Make sure there is validation before a product is deleted.

####category-list.php
This page provides a list of available categories within the site. You are also to provide a link within the table to delete a category. This be carried out by callback. Make sure there is validation before a product is deleted. To get maximum marks for this section you are to confirm twice if there are products existing for the category. You􀀀 don't want to delete a category and also delete 1,000s of products, when you only wanted a certain few.

####add-product.php & add-category.php
These two pages will be accessible via their relevant sister pages, product-list.php and category-list.php . They are to present forms to add new products or categories.

####styles.css
This file is your Cascading Style Sheet. Within it will hold all your style rules for your site. To get maximum marks􀀀 there shouldn't be any embeded or inline styles unless it is unique ot that page or HTML5 element. As the site needs to respond to the different sizes of screens, you are to use the follow media queries:􀀀

####action.js
This file is your javascript file. You should place all your javascript within this file and link to it within your HTML5.􀀀􀀀􀀀