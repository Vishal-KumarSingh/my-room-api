<?php
session_start();
//$conn  = mysqli_connect("127.0.0.1" , "root" , "" , "myroom");
$conn  = mysqli_connect("localhost" , "id20293696_root" , "qv#=UHv@Ua6g*Tk{" , "id20293696_room");
$post = json_decode(file_get_contents("php://input"),true);
function loadUserFromToken($token){
      $sql = "";
}
function ResponseGenerator($status , $token , $toast , $data = array()) {
    $response = array(
        "token" => $token,
        "status"=> true ,
        "toast"=> $toast
    ); 
    foreach( $data as $key => $value){
        $response[$key] = $value;
    }
    echo json_encode($response);
}
function required_fields($arrays , $token=""){
    global $post;
    if(isset($post["token"])){$token = $post["token"];}
    foreach($arrays as $array){
        //echo $array;
          if(!isset($post[$array])){
                 
                 ResponseGenerator(false , $token , "Missing equired Fields");
                 die();
          }
    }
}
function TokenGenerator(){
    $character = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
   $token = '';
    for($i=0;$i<=6;$i++){
       $token .= $character[rand(0,strlen($character)-1)];
    }
    //echo $token;
    return $token;
}
function getUserFromToken($token) {
    global $conn;
    $sql = "select * from user where token = '". $token."'";
    $result = mysqli_query($conn , $sql);
    $user = mysqli_fetch_assoc($result);
    return $user;
}
function getRoomMemberList($token){
    global $conn;
    $sql = "select * from user where room = ( select room from user where token='".$token."')";
    $result = mysqli_query($conn , $sql);
    $user_list = "";
    while($user = mysqli_fetch_assoc($result))
    {
        $user_list .= $user["id"].",";
    }
    return $user_list; 
}