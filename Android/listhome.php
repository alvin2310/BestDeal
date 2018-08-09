<?php
require_once 'DB_Function.php';

$db = new Home();

// json response array
$response = array("error" => FALSE);

if(isset($_POST['user_id'])){
  $userid = $_POST['user_id'];
  $user = $db->listhome($userid);
    if ($user != false) {
    $n = count($user);
    $response["error"] = FALSE;
    foreach ($user as $i => $value){
      if(isset($value['id'])) {
        $response[] = (object) array(
          "id" => $value['id'],
          "name" => $value['name'],
          "ukuran" => $value['ukuran'],
          "jenis" => $value['jenis'],
          "harga" => $value['harga'],
          "photo" => isset($value["photo"]) ? $value["photo"] : 'empty',
          "point" => $value['point'],
          "avg" => isset($value['avg']) ? $value['avg'] : '0.00'
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