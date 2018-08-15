<?php

class Auth{
  protected $db;
  public function __construct(){
      $this->db = new DB_con();
      $this->db = $this->db->OpenCon();
  }

  public function saveRumah($rmID,$rumah_name,$alamat,$ukuran,$harga,$qtysemen,$qtypasir,$qtybata,$uid){
      if($rmID==0){
        $query = "INSERT INTO tbl_rumah (rumah_name,jenis,ukuran,harga,alamat,user_id) 
                  VALUES('$rumah_name',1,'$ukuran',$harga,'$alamat',$uid)";
      } else {
        $query = "UPDATE tbl_rumah SET alamat='$alamat',harga=$harga WHERE rumah_id=$rmID";
      }
      
      $query = $this->db->query("SELECT * FROM tbl_users WHERE user_name='$user' AND user_password='$pass'") or die($this->db->error);
      if($query->num_rows==1){
          $row = $query->fetch_array(MYSQLI_ASSOC);
          $_SESSION['user_name'] = $user;
          $_SESSION['user_id'] = $row['user_id'];
          return true;
      }
      else{
          return 0;
      }
      //header('Location: ../index.php');
  }

  public function AuthRegis($username,$password,$firstname,$alamat,$kota,$provinsi,$email,$no_hp) {
      //,$earn,$spent,$simpanan){
      $pass = hash('sha256', $password);

      $query = "INSERT INTO tbl_users(user_name,user_password,first_name,alamat,kota,provinsi,email,no_telp,user_earn,user_spent,simpanan) VALUES('$username','$pass','$firstname','$alamat','$kota','$provinsi','$email','$no_hp',0,0,0)";
      //echo $query;
      if($this->db->query($query)){
          return true;
      }
      else{
          return false;
      }
  }
}

?>