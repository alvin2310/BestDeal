<?php
class Module{
  function home($user_id,$agama){
    $kns = new DB_con();

    //Pengumpulan Data
      $tblUser = array();
      $query = "SELECT * FROM tbl_users WHERE user_id<>$user_id";
      //echo $query;
      $hasil = $kns->OpenCon()->query($query);
      if(mysqli_num_rows($hasil)<1){
        echo "Tidak ada Data Hasil";
      }
      else{
        while ($data=mysqli_fetch_assoc($hasil)) {
          $item=array(

          );
          array_push($tblUser,$item);
        }
      }
      $thisUser = array();
      $query = "SELECT * FROM tbl_users WHERE user_id=$user_id";
      //echo $query;
      $hasil = $kns->OpenCon()->query($query);
      if(mysqli_num_rows($hasil)<1){
        echo "Tidak ada Data Hasil";
      }
      else{
        while ($data=mysqli_fetch_assoc($hasil)) {
          $item=array(

          );
          array_push($thisUser,$item);
        }
      }
    //End Data

    //Find a Node
      //$tblUser = array();
      for($i=0;$i<count($tblUser);$i++){
        $query = "";
        //echo $query;
        $hasil = $kns->OpenCon()->query($query);
        if(mysqli_num_rows($hasil)<1){
          echo "Tidak ada Data Hasil";
        }
        else{
          while ($data=mysqli_fetch_assoc($hasil)) {
            foreach ($tblUser as $key => $val) {
              echo $val['user_id']."\n";
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