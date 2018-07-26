<?php
require_once 'DB_Function.php';
$db = new Action();

// json response array
$response = array("error" => FALSE);

if (isset($_POST['user_id']) && isset($_POST['rumah_id'])) {
    $rmid = $_POST['rumah_id'];
    $userid = $_POST['user_id'];
    $rating = $_POST['rating'];

    $user = $db->rateAction($userid,$rmid,$rating);

    if ($user != false) {
        $response["error"] = FALSE;
        foreach ($user as $i => $value){
          if(isset($value['id'])) {
            $response[] = (object) array(
              "id" => $value['id'],
              "avg" => number_format($value['avg'],2),
              "total" => $value['total']
            );
          }
        }
        echo json_encode($response);
    }
    else {
        $response["error"] = TRUE;
        $response["error_msg"] = "Otektikasi gagal. Cek Koneksi";
        echo json_encode($response);
    }
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "User tidak ada / tidak di temukan";
    echo json_encode($response);
}

?>