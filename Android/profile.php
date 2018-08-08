<?php
require_once './DB_Function.php';
$db = new Profile();

// json response array
$response = array("error" => FALSE);


if (isset($_POST['user_id']) && $_POST['action']=="get") {
  $user_id = $_POST['user_id'];

  // get the user by email and password
  // get user berdasarkan email dan password
  $user = $db->loadProfile($user_id);
  if ($user != false) {
    // user ditemukan
    $response["error"] = FALSE;
    $response["user"]["user_id"] = $user["user_id"];
    $response["user"]["user_name"] = $user["user_name"];
    $response["user"]["first_name"] = $user["first_name"];
    $response["user"]["last_name"] = $user["last_name"];
    $response["user"]["alamat"] = $user["alamat"];
    $response["user"]["kota"] = $user["kota"];
    $response["user"]["provinsi"] = $user["provinsi"];
    $response["user"]["email"] = $user["email"];
    $response["user"]["no_hp"] = $user["no_telp"];
    $response["user"]["earn"] = number_format($user["user_earn"],0,",",".");
    $response["user"]["spent"] = number_format($user["user_spent"],0,",",".");
    $response["user"]["simpanan"] = number_format($user["simpanan"],0,",",".");
    //$response["user"]["photo_pict"] = isset($user["photo_pict"]) ? $user["photo_pict"] : "empty";
    echo json_encode($response);
  } else {
    // user tidak ditemukan password/email salah
    $response["error"] = TRUE;
    $response["error_msg"] = "Login gagal. Cek Koneksi";
    echo json_encode($response);
  }
} 
elseif (isset($_POST['user_id']) && $_POST['action']=="post") {
  $uid = $_POST['user_id'];
  $firstname = $_POST['first_name'];
  $lastname = $_POST['last_name'];
  $alamat = $_POST['alamat'];
  $kota = $_POST['kota'];
  $provinsi = $_POST['provinsi'];
  $email = $_POST['email'];
  $no_hp = $_POST['nohp'];
  $earn = $_POST['earn'];
  $spent = str_replace(".","",$_POST['spent']);
  $simpanan = str_replace(".","",$_POST['simpanan']);
  $password = str_replace(".","",$_POST['password']);

  // get the user by email and password
  // get user berdasarkan email dan password
  $user = $db->saveProfile($uid,$password,$firstname,$lastname,$alamat,$kota,$provinsi,$email,$no_hp,$earn,$spent,$simpanan);
  if ($user != false) {
    // user ditemukan
    $response["error"] = FALSE;
    echo json_encode($response);
  } else {
    // user tidak ditemukan password/email salah
    $response["error"] = TRUE;
    $response["error_msg"] = "Login gagal. Password/Email salah";
    echo json_encode($response);
  }
}
else {
  $response["error"] = TRUE;
  $response["error_msg"] = "Parameter (email atau password) ada yang kurang";
  echo json_encode($response);
}
?>
