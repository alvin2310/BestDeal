<?php
session_start();
include_once './config.php';
$kns = new DB_con();

$list = "";
if(!empty($_POST['keyword'])){
  $keyword = $_POST['keyword'];
  $query = "SELECT A.*,
            CASE WHEN avgrating IS NULL THEN 0 ELSE avgrating END avgrating,
            CASE WHEN totalrating IS NULL THEN 0 ELSE totalrating END totalrating 
            FROM tbl_rumah A
            LEFT JOIN(SELECT rumah_id,SUM(rating)/COUNT(rating) avgrating,COUNT(rating) totalrating FROM tbl_rating WHERE rating<>0
            GROUP BY rumah_id) B ON A.rumah_id=B.rumah_id
            WHERE rumah_name LIKE '%$keyword%'
            ORDER BY avgrating";
  //echo $query;
  $result = $kns->OpenCon()->query($query);
  while($data = $result->fetch_array(MYSQLI_ASSOC)){
    if(isset($data['rumah_photo']) AND $data['rumah_photo']<>""){
      $path=$data['rumah_photo'];
    }
    else{
      $path="images/no_image.png";
    }
    $list.="
      <div class=\"col-sm-3 w3_tab_img_left\">
        <div class=\"demo\">
          <a class=\"cm-overlay\" href=\"$path\">
            <figure class=\"imghvr-shutter-in-out-diag-2\"><img src=\"$path\" alt=\" \" class=\"img-responsive\" height='229' />
            </figure>
          </a>
        </div>
        <div class=\"agile-gallery-info\" style='cursor:pointer;' id=\"open-View\" data-toggle=\"modal\" data-id=\"".$data['rumah_id']."\">
          <h6>".$data['rumah_name']." ( <b>".$data['ukuran']."</b> )</h6>
          <h6>Rp.".number_format($data['harga'],2,",",".")."</h6>
        </div>
      </div>
    ";
  }
  $list.="<div class=\"clearfix\"> </div>";
  $item['daftar'] = $list;

  //echo $query;
  if($result->num_rows>0){
      $item['status'] = 'ok';
  }else{
      $item['status'] = 'err';
  }
  //Return json formatted data
  echo json_encode($item);
}
?>