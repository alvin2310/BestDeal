<?php
class Module{
  function home($user_id,$agama){
    $kns = new DB_con();

    //Pengumpulan Data
      $tblUser = array();
      $query = "SELECT A.user_id,B.category FROM tbl_user A
                LEFT JOIN tbl_friend B ON A.user_id=B.user_friend AND B.user_id=$user_id
                WHERE A.user_id<>$user_id AND B.category IS NOT NULL
                ORDER BY A.user_id";
      //echo $query;
      $hasil = $kns->OpenCon()->query($query);
      if(mysqli_num_rows($hasil)<1){
        echo "Tidak ada Data Hasil";
      }
      else{
        while ($data=mysqli_fetch_assoc($hasil)) {
          $tblUser[]=$data;
        }
      }
      //print_r($tblUser);
    //End Data

    //Find a Node
      //$tblUser = array();
      for($i=0;$i<count($tblUser);$i++){
        $query = "SELECT A.user_id,B.category FROM tbl_user A
                  LEFT JOIN tbl_friend B ON A.user_id=B.user_friend AND B.user_id=".$tblUser[$i]["user_id"]."
                  WHERE A.user_id<>".$tblUser[$i]["user_id"]." AND B.category IS NOT NULL
                  ORDER BY A.user_id";
        //echo $query;
        $hasil = $kns->OpenCon()->query($query);
        if(mysqli_num_rows($hasil)<1){
          echo "Tidak ada Data Hasil";
        }
        else{
          while ($data=mysqli_fetch_assoc($hasil)) {
            foreach ($tblUser as $key => $val) {
              echo $val['user_id']."<br>";
              /* if ($val['user_id'] === $data['user_id']) {
                echo "<br>".$data['user_id']." and ".$val['category'];
              } */
            }
          }
        }
      }
    //End Binning

    //return $HasilAkhir;
  }
}
?>