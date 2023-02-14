<?php
include 'include/conn.php';
required_fields(array("token" , "transaction"));
$user = getUserFromToken($post["token"]);
$user_id = $user["id"];
$transaction = mysqli_real_escape_string($conn , $post["transaction"]);
$sql = "select * from transaction where id=".$transaction;
$result = mysqli_query($conn , $sql);
$user_list =mysqli_fetch_assoc($result)["approval"];
$new_user_list = str_replace($user_id."," , "" , $user_list);
$sql = "update transaction set approval = '".$new_user_list."' where id=".$transaction;
$result = mysqli_query($conn , $sql);
if($result){
    ResponseGenerator(true , $post["token"] , "Item approved Successfully");
}else{
    ResponseGenerator(false , $post["token"] , "Something Went Wrong");
}