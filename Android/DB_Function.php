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
      $query="SELECT A.*,avgrating,totalrating FROM tbl_rumah A
              LEFT JOIN(
              SELECT rumah_id,SUM(rating)/COUNT(rating) avgrating,COUNT(rating) totalrating FROM tbl_rating 
              GROUP BY rumah_id) B ON A.rumah_id=B.rumah_id
              LIMIT 10";
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
      $query="SELECT * FROM tbl_user WHERE user_name=? AND user_password=?";
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
  }
?>