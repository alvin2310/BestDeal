<?php
require_once 'moduleTrust.php';
include('config.php');

$db = new Module();

// json response array
$response = array("error" => FALSE);

if(isset($_POST['user_id'])){
  $userid = $_POST['user_id'];
  $agama = $_POST['agama'];
  $user = $db->home($userid,$agama);
  echo json_encode($user);
    /* if ($user != false) {
      $n = count($user);
      $response["error"] = FALSE;
      foreach ($user as $i => $value){
        if(isset($value['user_id'])) {
          $response[] = (object) array(
            'user_id' => $value["user_id"],
            'user_name' => $value["user_name"],
            'age' => $value["Age"],
            'location' => $value["location"],
            'like_count' => $value["like_count"],
            'view_count' => $value["view_count"],
            'photo_pict' => isset($value["photo_pict"]) ? $value["photo_pict"] : '@drawable/ic_account',
            'last_seen' => $value['last_seen']
          );
        }
      }
      echo json_encode($response);
    } 
    else {
        // user tidak ditemukan password/email salah
        $response["error"] = TRUE;
        $response["error_msg"] = "Data yang anda cari tidak ada";
        echo json_encode($response);
    } */
} else {
  $response["error"] = TRUE;
  $response["error_msg"] = "Silahkan login terlebih dahulu";
  echo json_encode($response);
}
?>