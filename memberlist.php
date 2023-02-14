<?php
include 'include/conn.php';
required_fields(array("token"));
$user = getUserFromToken($post["token"]);
$user_id = $user["id"];
$token = $post["token"];
$all_transaction = mysqli_query($conn , "select user.email,sum(transaction.amount)as amount from transaction left join user on user.id=transaction.done_by where room = ( select room from user where token= '".$token."') group by user.id");

$all_transaction =mysqli_fetch_all($all_transaction, true);
$data = array("members"=>$all_transaction);
ResponseGenerator(true , $post["token"] , "" ,$data );