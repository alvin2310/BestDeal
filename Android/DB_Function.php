<?php
  class Home{
    private $conn;

    // constructor
    function __construct()
    {
      require_once '../config.php';
      $db = new DB_con();
      $this->conn = $db->OpenCon();
    }

    public function home($userid) {
      $user=array();
      $query="SELECT A.*,
              CASE WHEN avgrating IS NULL THEN 0 ELSE avgrating END avgrating,
              CASE WHEN totalrating IS NULL THEN 0 ELSE totalrating END totalrating 
              FROM tbl_rumah A
              LEFT JOIN(SELECT rumah_id,SUM(rating)/COUNT(rating) avgrating,COUNT(rating) totalrating FROM tbl_rating 
              GROUP BY rumah_id) B ON A.rumah_id=B.rumah_id
              ORDER BY avgrating
              LIMIT 5";
      $stmt=$this->conn->prepare($query);
      if($stmt->execute()) {
        $result = $stmt->get_result();
        while($data=$result->fetch_assoc()) {
          $user[]=array(
              "id" => $data['rumah_id'],
              "name" => $data['rumah_name'],
              "ukuran" => $data['ukuran'],
              "jenis" => $data['jenis'],
              "harga" => number_format($data['harga'],0,",","."),
              "photo" => $data['rumah_photo'],
              "avg" => $data['avgrating']
          );
        }
        $stmt->close();
        return $user;
      } else {
        return NULL;
      }
    }

    public function listhome($userid) {
      $user=array();
      $query="SELECT A.*,
              CASE WHEN avgrating IS NULL THEN 0 ELSE avgrating END avgrating,
              CASE WHEN totalrating IS NULL THEN 0 ELSE totalrating END totalrating 
              FROM tbl_rumah A
              LEFT JOIN(SELECT rumah_id,SUM(rating)/COUNT(rating) avgrating,COUNT(rating) totalrating FROM tbl_rating 
              GROUP BY rumah_id) B ON A.rumah_id=B.rumah_id
              ORDER BY avgrating";
      $stmt=$this->conn->prepare($query);
      if($stmt->execute()) {
        $result = $stmt->get_result();
        while($data=$result->fetch_assoc()) {
          $user[]=array(
              "id" => $data['rumah_id'],
              "name" => $data['rumah_name'],
              "ukuran" => $data['ukuran'],
              "jenis" => $data['jenis'],
              "harga" => number_format($data['harga'],0,",","."),
              "photo" => $data['rumah_photo'],
              "avg" => $data['avgrating']
          );
        }
        $stmt->close();
        return $user;
      } else {
        return NULL;
      }
    }

    public function view($rumahid) {
      $user=array();
      $query="SELECT A.*,
              CASE WHEN avgrating IS NULL THEN 0 ELSE avgrating END avgrating,
              CASE WHEN totalrating IS NULL THEN 0 ELSE totalrating END totalrating 
              FROM tbl_rumah A
              LEFT JOIN(SELECT rumah_id,SUM(rating)/COUNT(rating) avgrating,COUNT(rating) totalrating FROM tbl_rating 
              GROUP BY rumah_id) B ON A.rumah_id=B.rumah_id
              WHERE A.rumah_id=$rumahid
              ORDER BY avgrating
              LIMIT 5";
      $stmt=$this->conn->prepare($query);
      if($stmt->execute()) {
        $result = $stmt->get_result();
        while($data=$result->fetch_assoc()) {
          $user[]=array(
              "id" => $data['rumah_id'],
              "name" => $data['rumah_name'],
              "ukuran" => $data['ukuran'],
              "jenis" => $data['jenis'],
              "harga" => number_format($data['harga'],0,",","."),
              "alamat" => $data['alamat'],
              "photo" => $data['rumah_photo'],
              "avg" => $data['avgrating'],
              "description" => $data['rumah_description']
          );
        }
        $stmt->close();
        return $user;
      } else {
        return NULL;
      }
    }
  }

  class User{
    private $conn;

    // constructor
    function __construct()
    {
      require_once '../config.php';
      $db = new DB_con();
      $this->conn = $db->OpenCon();
    }

    public function loginAuth($email, $password) {
      $query="SELECT * FROM tbl_users WHERE user_name=? AND user_password=?";
      $stmt = $this->conn->prepare($query);
      $stmt->bind_param("ss", $email,$password);
      if ($stmt->execute()) {
          $user = $stmt->get_result()->fetch_assoc();
          $stmt->close();
          return $user;
      } else {
          return NULL;
      }
    }

    public function AuthRegis($username,$password,$firstname,$alamat,$kota,$provinsi,$email,$no_hp) {
      $query = "INSERT INTO tbl_users(user_name,user_password,first_name,alamat,kota,provinsi,email,no_telp,user_earn,user_spent,simpanan) VALUES('$username','$password','$firstname','$alamat','$kota','$provinsi','$email','$no_hp',0,0,0)";
      $stmt = $this->conn->prepare($query);
      if ($stmt->execute()) {
          $stmt->close();
          return true;
      } else {
          return false;
      }
    }
  }

  class Action{
    private $conn;

    // constructor
    function __construct()
    {
      require_once '../config.php';
      $db = new DB_con();
      $this->conn = $db->OpenCon();
    }

    public function rateAction($user_id,$rm_id,$rating) {
      $query="CALL usp_bd_rating_sv($user_id,$rm_id,$rating)";
      $stmt = $this->conn->prepare($query);
      if($stmt->execute()){
        $stmt->close();
      }

      $query2 = "SELECT rumah_id,SUM(rating)/COUNT(rating) avgrating,COUNT(rating) totalrating FROM tbl_rating WHERE rumah_id=$rm_id GROUP BY rumah_id";
      $result = $this->conn->prepare($query2);
      if ($result->execute()) {
        $result2 = $result->get_result();
        while($data=$result2->fetch_assoc()) {
          $user[]=array(
              "id" => $data['rumah_id'],
              "avg" => $data['avgrating'],
              "total" => $data['totalrating']
          );
        }
        $result->close();
        return $user;
      } else {
          return false;
      }
    }
  }
?>