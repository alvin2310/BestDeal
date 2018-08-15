<?php
session_start();
include_once '../config.php';
$kns = new DB_con();

if(!empty($_POST['postID'])){
    $rumahID = $_POST['postID'];
    $userID = $_SESSION['user_id'];
    
    $query="SELECT rumah_name,jenis,ukuran,harga,
    CASE WHEN alamat IS NULL THEN '' ELSE alamat END alamat,
    CASE WHEN rumah_photo IS NULL THEN '../images/no_image.png' ELSE rumah_photo END rumah_photo,
    CASE WHEN rumah_description IS NULL THEN '' ELSE rumah_description END rumah_description FROM tbl_rumah WHERE rumah_id=$rumahID AND user_id=$userID";
    //echo $query;
    $result = $kns->OpenCon()->query($query);
    $item = $result->fetch_assoc();

    if($item){
        $item['status'] = 'ok';
    }else{
        $item['status'] = 'err';
    }
    //Return json formatted data
    echo json_encode($item);
}

?>