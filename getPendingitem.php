<?php
include 'include/conn.php';
required_fields(array("token"));
$user = getUserFromToken($post["token"]);
$user_id = $user["id"];
$token = $post["token"];
$all_transaction = mysqli_query($conn , "select * from transaction where deleted=0 and approval is not null and done_by in (select id from user where room = ( select room from user where token= '".$token."'))");

$all_transaction =mysqli_fetch_all($all_transaction, true);
$data = array("transactions"=>$all_transaction);
ResponseGenerator(true , $post["token"] , "" ,$data );