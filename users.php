<?php
    require 'dbconn.php';
    //Redirect if the user is not a staff member
    require 'userredirect.php';
    require 'nocache.php';

    //If the form is submitted
    if(isset($_GET['submit']))
    {
        $newType = ($_GET['type']==1) ? 2 : 1 ;
        $user = intval($_GET['user']);
        $sql = "UPDATE `user` SET `type`=$newType ";
        $sql.= "WHERE `id`= $user;";

        $connection->query($sql)
            or die("something went wrong ".$connection->error);
    }
    //Our sql statement for the Db query
    $sql="SELECT `user`.`id` AS `userid`,CONCAT(`fname`,' ',`lname`) AS `fname`,`user_type`.`name` AS type, `user_type`.`id` AS `usertype` ";
    $sql.="FROM `user` ";
    //Joining the user and user_type tables
    $sql.="INNER JOIN `user_type`";
    $sql.="ON `user`.`type` = `user_type`.`id`";
    $userList = $connection->query($sql)
        or die("problem with query: ".$connection->error);
    $connection->close();    
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Users</title>
        <link rel="stylesheet" type="text/css" href="styles.css">
        <script type="text/JavaScript" src="actions.js" defer></script>
        <meta name="description" content="This page allowd a staff member to change the user_type of other members, making them a staff or demoting them to a regular user">
        <meta name="keywords" content="user list, all users,access list,all users,promote users,demote users">
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
                        <h1>User List:</h1>
                        <table>
                            <thead>
                                <tr>
                                    <td>User Name</td>
                                    <td>Type</td>
                                    <td>Change</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row=$userList->fetch_array(MYSQLI_ASSOC)):?>
                                    <tr>                                
                                        <td><?php echo $row["fname"];?></td>
                                        <td><?php echo $row["type"];?></td>
                                        <td>
                                        <!--The form to swap user type-->
                                            <form action="users.php" method="GET" name="changeuser">
                                                <input type="hidden" value=<?php echo $row['userid'];?> name="user">
                                                <input type="hidden" value=<?php echo $row['usertype'];?> name="type">
                                                <input type="submit" name="submit" value="Change type">
                                            </form>
                                        </td>
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