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

class User {
    protected $db;
    public function __construct(){
        $this->db = new DB_con();
        $this->db = $this->db->OpenCon();
    }

    public function saveProfile($userid,$password,$firstname,$lastname,$alamat,$kota,$provinsi,$email,$no_hp,$earn,$spent,$simpanan){
        $pass = hash('sha256', $password);
        if($password==""){
            $query = "UPDATE tbl_users SET 
                        first_name='$firstname',
                        last_name='$lastname',
                        alamat='$alamat',
                        kota='$kota',
                        provinsi='$provinsi',
                        email='$email',
                        no_telp='$no_hp',
                        user_earn='$earn',
                        user_spent='$spent',
                        simpanan='$simpanan' WHERE user_id=$userid ";
        } else {
            $query = "UPDATE tbl_users SET 
                        user_password='$pass',
                        first_name='$firstname',
                        last_name='$lastname',
                        alamat='$alamat',
                        kota='$kota',
                        provinsi='$provinsi',
                        email='$email',
                        no_telp='$no_hp',
                        user_earn='$earn',
                        user_spent='$spent',
                        simpanan='$simpanan' WHERE user_id=$userid ";
        }

        if($this->db->query($query)){
            return true;
        }
        else{
            return false;
        }
        //header('Location: ../index.php');
    }

}
?>