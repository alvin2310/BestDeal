<?php

class Auth{
    protected $db;
    public function __construct(){
        $this->db = new DB_con();
        $this->db = $this->db->OpenCon();
    }

    public function AuthLogin($user,$pass){
        $pass = hash('sha256', $_POST['password']);
        
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

    public function AuthRegis($username,$password,$firstname,$alamat,$kota,$provinsi,$email,$no_hp,$earn,$spent,$simpanan){
        $pass = hash('sha256', $pass);

        $query = "INSERT INTO tbl_users(user_name,user_password,first_name,alamat,kota,provinsi,no_hp,user_earn,user_spent,simpanan) VALUES('$name','$pass','$name','$alamat','$kota','$provinsi','$no_hp','$earn','$spent','$simpanan')";
        if($this->db->query($query)){
            return true;
        }
        else{
            return false;
        }
    }
}

?>