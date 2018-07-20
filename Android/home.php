<?php
require_once 'DB_Function.php';

$db = new Home();

// json response array
$response = array("error" => FALSE);

if(isset($_POST['user_id'])){
  $userid = $_POST['user_id'];
  $user = $db->home($userid);
    if ($user != false) {
    $n = count($user);
    $response["error"] = FALSE;
    foreach ($user as $i => $value){
      if(isset($value['id'])) {
        $response[] = (object) array(
          "id" => $value['id'],
          "name" => $value['name'],
          "alamat" => $value['alamat'],
          "hp" => $value['hp'],
          "description" => $value['description'],
          "photo_pict" => isset($value["photo_pict"]) ? $value["photo_pict"] : 'empty',
          "category" => $value['category'],
          "rating" => $value['rating']
        );
      }
    }
    echo json_encode($response);
    } else {
        // user tidak ditemukan password/email salah
        $response["error"] = TRUE;
        $response["error_msg"] = "value yang anda cari tidak ada";
        echo json_encode($response);
    }
} else {
  $response["error"] = TRUE;
  $response["error_msg"] = "Silahkan login terlebih dahulu";
  echo json_encode($response);
}
?>