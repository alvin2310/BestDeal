<?php
require_once 'DB_Function.php';

$db = new Home();

// json response array
$response = array("error" => FALSE);

if(isset($_POST['rumah_id'])){
  $rumahid = $_POST['rumah_id'];
  $user = $db->view($rumahid);
    if ($user != false) {
    $n = count($user);
    $response["error"] = FALSE;
    foreach ($user as $i => $value){
      if(isset($value['id'])) {
        $response[] = (object) array(
          "rumah_id" => $value['id'],
          "rumah_name" => $value['name'],
          "ukuran" => $value['ukuran'],
          "jenis" => $value['jenis'],
          "harga" => $value['harga'],
          "alamat" => isset($value['alamat']) ? $value['alamat'] : "",
          "lat" => $value['lat'],
          "lng" => $value['lng'],
          "rumah_photo" => isset($value["photo"]) ? $value["photo"] : 'empty',
          "rating" => isset($value['avg']) ? $value['avg'] : '0.00',
          "description" => $value['description']
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