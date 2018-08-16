<?php

class Auth{
  protected $db;
  public function __construct(){
      $this->db = new DB_con();
      $this->db = $this->db->OpenCon();
  }

  public function saveRumah($rmID,$rumah_name,$alamat,$ukuran,$harga,$jenis_semen,$qtysemen,$jenis_pasir,$qtypasir,$jenis_bata,$qtybata,$uid){
      $query = "CALL usp_bd_rumah_sv($rmID,'$rumah_name','$alamat','$ukuran',$harga,$jenis_semen,$qtysemen,$jenis_pasir,$qtypasir,$jenis_bata,$qtybata,$uid)";
      echo $query;
      $result = $this->db->prepare($query);
      if($result->execute()){
          return true;
      }
      else{
          return false;
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