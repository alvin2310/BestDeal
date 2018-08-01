<?php
require_once './DB_Function.php';
$db = new User();

// json response array
$response = array("error" => FALSE);

if (isset($_POST['username']) && isset($_POST['password']) && $_POST['password']!="") {
  // menerima parameter POST ( email dan password )
  $username = $_POST['username'];
  $password = hash('sha256', $_POST['password']);
  $firstname = $_POST['firstname'];
  $alamat = $_POST['alamat'];
  $kota = $_POST['kota'];
  $provinsi = $_POST['provinsi'];
  $email = $_POST['email'];
  $no_hp = $_POST['nohp'];

  // get the user by email and password
  // get user berdasarkan email dan password
  $user = $db->AuthRegis($username,$password,$firstname,$alamat,$kota,$provinsi,$email,$no_hp);
  if ($user != false) {
    // user ditemukan
    $response["error"] = FALSE;
    echo json_encode($response);
  } else {
    // user tidak ditemukan password/email salah
    $response["error"] = TRUE;
    $response["error_msg"] = "Registrasi gagal. Password/Email salah";
    echo json_encode($response);
  }
} 
else {
  $response["error"] = TRUE;
  $response["error_msg"] = "Parameter (email atau password) ada yang kurang";
  echo json_encode($response);
}
?>
