<?php
require_once './DB_Function.php';
$db = new User();

// json response array
$response = array("error" => FALSE);

if (isset($_POST['username']) && isset($_POST['password'])) {
  // menerima parameter POST ( email dan password )
  $email = $_POST['username'];
  $password = hash('sha256', $_POST['password']);

  // get the user by email and password
  // get user berdasarkan email dan password
  $user = $db->loginAuth($email, $password);
  if ($user != false) {
    // user ditemukan
    $response["error"] = FALSE;
    $response["user"]["user_id"] = $user["user_id"];
    $response["user"]["user_name"] = $user["user_name"];
    $response["user"]["email"] = $user["email"];
    /* $response["user"]["photo_pict"] = $user["photo_pict"]; */
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
