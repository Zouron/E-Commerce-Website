<?php
/*
* This page is used to update the users details. Ih have created this as an extra page as
* the same code is used on two pages: profile and checkout.
*/
    require 'dbconn.php';
$address=addslashes($_POST["address"]);
        $suburb = addslashes($_POST["suburb"]);
        $state = $_POST["state"];
        $postCode = intval($_POST["postcode"]);
        $sql="UPDATE `user`";
        $sql.="SET `address`='$address', `suburb`='$suburb',`state`='$state',`postcode`=$postCode ";
        $sql.="WHERE `id`=$userId";

        $update = $connection->query($sql)
            or die("Failed to update ".$connection->error);?>