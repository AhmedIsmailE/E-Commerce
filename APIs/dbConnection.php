<?php

function get_db_connection(){
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $databaseName = "projectdb";

    $connection = new mysqli($hostname,$username,$password,$databaseName);

    if($connection->connect_error){
        die("Connection Failed: ".$connection->connect_error);
    }
    try {
    $connection->set_charset("UTF8");
    return $connection;
    }
    catch (Exception $e){
        die($e->getMessage());
    }
}
?>