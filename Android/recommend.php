<?php
require '../config.php';
require_once '../moduleTrust.php';

$db = new Module();

// json response array
$response = array("error" => FALSE);

if(isset($_POST['user_id'])){
  $userid = $_POST['user_id'];
  $user = $db->home($userid);
    if ($user != false) {
    $n = count($user);
    $response["error"] = FALSE;
    foreach ($user as $i => $value){
      if(isset($value['rumah_id'])) {
        $response[] = (object) array(
          "id" => $value['rumah_id'],
          "name" => $value['rumah_name'],
          "jenis" => $value['jenis'],
          "ukuran" => $value['ukuran'],
          "harga" => $value['harga'],
          "photo" => isset($value["rumah_photo"]) ? $value["rumah_photo"] : 'empty',
          "avg" => $value['avg']
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