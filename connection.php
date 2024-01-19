<?php 
    $con = mysqli_connect("localhost","root","","crudproduct");
    if(mysqli_connect_error()){
        die("Cannot connect to Database".mysqli_connect_errno());
    }

    define("UPLOAD_SRC",$_SERVER['DOCUMENT_ROOT']."/CRUD PRODUCT PHP/UPLOADS/");

    define('FETCH_SRC',"http://localhost/crud%20product%20php/uploads/");

?>