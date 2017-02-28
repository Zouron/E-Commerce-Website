<?php

$connection = new mysqli("localhost", "root", "", "assignment047");
//$connection = new mysqli("localhost", "twa047", "twa04740", "assignment047");

if ($connection->connect_error){
     echo "Could not connect: ". $connection->connect_error;
}

?>