<?php
include 'include/conn.php';
required_fields(array("token" , "transaction"));
$transaction = mysqli_real_escape_string($conn , $post["transaction"]);
$sql = "update transaction set deleted = 1 where id=".$transaction;
$result = mysqli_query($conn , $sql);
if($result){
    ResponseGenerator(true , $post["token"] , "Item deleted Successfully");
}else{
    ResponseGenerator(false , $post["token"] , "Something Went Wrong");
}