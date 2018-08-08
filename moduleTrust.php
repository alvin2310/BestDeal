<?php
class Module{
  function home($user_id){
    $kns = new DB_con();

    
    //Pengumpulan Data
      //User Online
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
              "user_id" => $data['user_id'],
              "user_name" => $data['user_name'],
              "user_earn" => $data['user_earn'],
              "user_spent" => $data['user_spent'],
              "selisih" => $data['user_earn']-$data['user_spent'],
              "simpanan" => $data['simpanan']
            );
            array_push($thisUser,$item);
          }
        }
      //End User
        $tblUser = array();
        $query = "SELECT *
                  FROM tbl_users A
                  WHERE A.user_id<>$user_id
                  AND ((user_earn-user_spent)>".$thisUser[0]['selisih']."
                  OR simpanan>".$thisUser[0]['selisih'].")
                  AND A.user_earn<>0 AND A.user_spent<>0
                  LIMIT 4";
        echo $query;
        $hasil = $kns->OpenCon()->query($query);
        if(mysqli_num_rows($hasil)<1){
          echo "Tidak ada Data Hasil";
        }
        else{
          while ($data=mysqli_fetch_assoc($hasil)) {
            $item=array(
              "user_id" => $data['user_id'],
              "user_name" => $data['user_name'],
              "user_earn" => $data['user_earn'],
              "user_spent" => $data['user_spent'],
              "selisih" => $data['user_earn']-$data['user_spent'],
              "simpanan" => $data['simpanan']
            );
            array_push($tblUser,$item);
          }
        }
    //End Data
    
    //Find X
      $X = array();
      for($i=0;$i<count($tblUser);$i++){
        $X[] = $tblUser[$i]['selisih'];
      }
    //End X

    //Find Fx
      $Fx = array();
      for($i=0;$i<count($tblUser);$i++){
        $Fx[] = $tblUser[$i]['simpanan'];
      }
    //End Fx

    //Mencari Harga Cocok
      $F10 = ($Fx[1]-$Fx[0])/($X[1]-$X[0]);
      $F21 = ($Fx[2]-$Fx[1])/($X[2]-$X[1]);
      $F32 = ($Fx[3]-$Fx[2])/($X[3]-$X[2]);
      //echo "$F10\n$F21\n$F32\n";
      $F210 = ((float)$F21-(float)$F10)/($X[2]-$X[0]);
      $F321 = ((float)$F32-(float)$F21)/($X[3]-$X[1]);
      //echo "$F210\n$F321\n";
      $F3210 = ((float)$F321-(float)$F210)/($X[3]-$X[0]);
      //echo "$F3210\n";

      $resultPrice = 
      (
        $Fx[0] + (
          $F10 * ($thisUser[0]['selisih']-$X[0])
        ) + (
          $F210 * (($thisUser[0]['selisih']-$X[0])*($thisUser[0]['selisih']-$X[1]))
        ) + (
          $F3210 * (($thisUser[0]['selisih']-$X[0])*($thisUser[0]['selisih']-$X[1])*($thisUser[0]['selisih']-$X[2]))
        ) 
      );
      
      //echo number_format($resultPrice,0,',','.');
    //End Harga

    //Tampilkan Daftar
      $HasilAkhir = array();
      $query = "SELECT A.*,
                CASE WHEN avgrating IS NULL THEN 0 ELSE avgrating END avgrating,
                CASE WHEN totalrating IS NULL THEN 0 ELSE totalrating END totalrating 
                FROM tbl_rumah A
                LEFT JOIN(SELECT rumah_id,SUM(rating)/COUNT(rating) avgrating,COUNT(rating) totalrating FROM tbl_rating 
                GROUP BY rumah_id) B ON A.rumah_id=B.rumah_id
                WHERE (harga * 20 / 100)<='$resultPrice' ORDER BY avgrating";
      //echo $query;
      $hasil = $kns->OpenCon()->query($query);
      if(mysqli_num_rows($hasil)<1){
        echo "Tidak ada Data Hasil";
      }
      else{
        while ($data=mysqli_fetch_assoc($hasil)) {
          $item=array(
            "rumah_id" => $data['rumah_id'],
            "rumah_name" => $data['rumah_name'],
            "ukuran" => $data['ukuran'],
            "jenis" => isset($value['jenis']) ? $value['jenis'] : 0,
            "harga" => $data['harga'],
            "rumah_photo" => $data['rumah_photo'],
            "avg" => number_format($data['avgrating'],2)
          );
          array_push($HasilAkhir,$item);
        }
      }
    //End

    return $HasilAkhir;
  }
}
?>