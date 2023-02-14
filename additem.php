<?php
include 'include/conn.php';
required_fields(array("token" , "desc" , "amount"));

$user = getUserFromToken($post["token"]);
$user_id = $user["id"];
$desc = mysqli_real_escape_string($conn , $post["desc"]);
$amount = mysqli_real_escape_string($conn , $post["amount"]);
$user_list = getRoomMemberList($post["token"]);
$sql = "insert into transaction (description,done_by,amount,approval) values ('".$desc."' ,".$user_id."  , ".$amount." , '".$user_list."')";
$result = mysqli_query($conn , $sql);
if($result){
    ResponseGenerator(true , $post["token"] , "Item Added Successfully");
}else{
    ResponseGenerator(false , $post["token"] , "Something Went Wrong");

}