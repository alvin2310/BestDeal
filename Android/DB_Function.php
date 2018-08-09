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
              CASE WHEN AA.rating IS NULL THEN 0 ELSE AA.rating END ratingPoint,
              CASE WHEN avgrating IS NULL THEN 0 ELSE avgrating END avgrating,
              CASE WHEN totalrating IS NULL THEN 0 ELSE totalrating END totalrating 
              FROM tbl_rumah A
              LEFT JOIN tbl_rating AA ON A.rumah_id=AA.rumah_id AND AA.user_id=$userid
              LEFT JOIN(SELECT rumah_id,SUM(rating)/COUNT(rating) avgrating,COUNT(rating) totalrating FROM tbl_rating 
              GROUP BY rumah_id) B ON A.rumah_id=B.rumah_id
              ORDER BY avgrating DESC";
      //echo $query;
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
              "point" => $data['ratingPoint'],
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
              CASE WHEN AA.rating IS NULL THEN 0 ELSE AA.rating END ratingPoint,
              CASE WHEN avgrating IS NULL THEN 0 ELSE avgrating END avgrating,
              CASE WHEN totalrating IS NULL THEN 0 ELSE totalrating END totalrating 
              FROM tbl_rumah A
              LEFT JOIN tbl_rating AA ON A.rumah_id=AA.rumah_id AND AA.user_id=$userid
              LEFT JOIN(SELECT rumah_id,SUM(rating)/COUNT(rating) avgrating,COUNT(rating) totalrating FROM tbl_rating 
              GROUP BY rumah_id) B ON A.rumah_id=B.rumah_id
              ORDER BY avgrating DESC";
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
              "point" => $data['ratingPoint'],
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
              WHERE A.rumah_id=$rumahid";
      $stmt=$this->conn->prepare($query);
      if($stmt->execute()) {
        $result = $stmt->get_result();
        while($data=$result->fetch_assoc()) {
          if(isset($data['alamat'])){
            $address = str_replace(" ","+",$data['alamat']);
            $geo = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&sensor=false');
  
            // We convert the JSON to an array
            $geo = json_decode($geo, true);
  
            // If everything is cool
            $latitude = $geo['results'][0]['geometry']['location']['lat'];
            $longitude = $geo['results'][0]['geometry']['location']['lng'];
          } else {
            $latitude = "3.597031";
            $longitude = "98.678513";
          }

          $user[]=array(
              "id" => $data['rumah_id'],
              "name" => $data['rumah_name'],
              "ukuran" => $data['ukuran'],
              "jenis" => $data['jenis'],
              "harga" => number_format($data['harga'],0,",","."),
              "alamat" => $data['alamat'],
              "lat" => $latitude,
              "lng" => $longitude,
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

  class Profile{
    private $conn;
      
    // constructor
    function __construct() {
      require_once '../config.php';
      // koneksi ke database
      $db = new Db_con();
      $this->conn = $db->OpenCon();
    }

    public function loadProfile($user_id){
      $query="SELECT * FROM tbl_users
              WHERE user_id=$user_id";
      //echo $query;
      $stmt = $this->conn->prepare($query);
      if ($stmt->execute()) {
          $user = $stmt->get_result()->fetch_assoc();
          $stmt->close();
          return $user;
      } else {
          return NULL;
      }
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
      //echo $query;
      $stmt = $this->conn->prepare($query);
      if ($stmt->execute()) {
          $stmt->close();
          return true;
      } else {
          return false;
      }
    }
  }
?>