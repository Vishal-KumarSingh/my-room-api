<?php
include 'include/conn.php';
required_fields(array("token"));
$user = getUserFromToken($post["token"]);
$user_id = $user["id"];
$token = $post["token"];
$sql = "select * from user where room = ( select room from user where token='".$token."')";
$result = mysqli_query($conn , $sql);

$total_expense = mysqli_fetch_assoc(mysqli_query($conn , "select sum(amount) as data from transaction where deleted = 0 and approval='' and done_by in (select id from user where room = ( select room from user where token= '".$token."'))"))["data"];
$user_expense = mysqli_fetch_assoc(mysqli_query($conn , "select sum(amount) as data from transaction where deleted=0 and approval='' and done_by = (select id from user where token= '".$token."')"))["data"];
$total_member = mysqli_fetch_assoc(mysqli_query($conn , "select count(id) as data from user where room = ( select room from user where token='".$token."')"))["data"];
$per_head_share = floor($total_expense / $total_member);
$profitloss = floor($user_expense - $per_head_share);

$dashboard = array(
    "total"=>$total_expense,
    "user"=>$user_expense,
    "share"=>$per_head_share,
    "profit"=>$profitloss
);
ResponseGenerator(true , $post["token"] , "Item approved Successfully" , $dashboard);