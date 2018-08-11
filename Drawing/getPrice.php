<?php
session_start();
include_once '../config.php';
$kns = new DB_con();

if(!empty($_POST['semen']) AND !empty($_POST['pasir'])){
    $listHarga = array();
    $semen = $_POST['semen'];
    $pasir = $_POST['pasir'];
    $query="SELECT * FROM tbl_bahan WHERE bahan_id IN (1,24)";
    $result = $kns->OpenCon()->query($query);
    while($data = $result->fetch_array(MYSQLI_ASSOC)){
      $listHarga[]=$data;
    }
    //echo $semen."\n".$pasir;
    $total = ($listHarga[0]['harga'] * $semen) + $listHarga[1]['harga'] * $pasir;
    $item['totalHarga'] = $total;

    //echo $query;
    if($result){
        $item['status'] = 'ok';
    }else{
        $item['status'] = 'err';
    }
    //Return json formatted data
    echo json_encode($item);
}