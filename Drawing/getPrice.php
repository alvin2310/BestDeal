<?php
session_start();
include_once '../config.php';
$kns = new DB_con();

if(!empty($_POST['semen']) AND !empty($_POST['pasir']) AND !empty($_POST['bata'])){
    $listHarga = array();
    $jenis1 = $_POST['jenis_1'];
    $jenis2 = $_POST['jenis_2'];
    $jenis3 = $_POST['jenis_3'];

    $semen = $_POST['semen'];
    $pasir = $_POST['pasir'];
    $bata = $_POST['bata'];

    $query="SELECT * FROM tbl_bahan WHERE bahan_id IN ($jenis1,$jenis2,$jenis3)";
    //echo $query;
    $result = $kns->OpenCon()->query($query);
    while($data = $result->fetch_array(MYSQLI_ASSOC)){
      $listHarga[]=$data;
    }
    //echo "(".$listHarga[0]['harga']." * $semen) + (".$listHarga[1]['harga']." * $pasir) + (".$listHarga[2]['harga']." * $bata)";
    $total = ($listHarga[0]['harga'] * $semen) + ($listHarga[2]['harga'] * $pasir) + ($listHarga[1]['harga'] * $bata);
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