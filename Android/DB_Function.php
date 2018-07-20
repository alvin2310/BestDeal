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
      $query="SELECT A.rm_id,A.rm_name,A.rm_alamat,A.rm_hp,A.rm_description,A.rm_photo,B.category_name,C.rating FROM tbl_rumahmakan A 
              LEFT JOIN tbl_category B ON A.rm_category=B.category_id
              LEFT JOIN(SELECT rm_id,SUM(rating)/COUNT(rating) rating FROM tbl_rating
              GROUP BY rm_id) C ON A.rm_id=C.rm_id
              ORDER BY C.rating DESC
              LIMIT 10";
      $stmt=$this->conn->prepare($query);
      if($stmt->execute()) {
        $result = $stmt->get_result();
        while($data=$result->fetch_assoc()) {
          $user[]=array(
              "id" => $data['rm_id'],
              "name" => $data['rm_name'],
              "alamat" => $data['rm_alamat'],
              "hp" => $data['rm_hp'],
              "description" => $data['rm_description'],
              "photo" => $data['rm_photo'],
              "category" => $data['category_name'],
              "rating" => number_format($data['rating'],2)
          );
        }
        $stmt->close();
        return $user;
      } else {
        return NULL;
      }
    }

    public function search($keyword,$halal,$nonhalal,$vegetarian) {
      $user=array();
      $category = "";
      if($halal==1) {
        $category = $category=="" ? "A.rm_category=1" : $category.=" OR A.rm_category=1";
      } 
      if($nonhalal==1) {
        $category = $category=="" ? "A.rm_category=2" : $category.=" OR A.rm_category=2";
        //$category.=" OR A.rm_category=2";
      } 
      if($vegetarian==1) {
        $category = $category=="" ? "A.rm_category=3" : $category.=" OR A.rm_category=3";
        //$category.=" OR A.rm_category=3";
      }

      if($halal==0 AND $nonhalal==0 AND $vegetarian==0){
        $category = "A.rm_category IN (1,2,3)";
      }

      //echo $halal." AND ".$nonhalal." AND ".$vegetarian."\nResult:".$category."\n";
      $query="SELECT A.rm_id,A.rm_name,A.rm_alamat,A.rm_hp,A.rm_description,A.rm_photo,B.category_name,C.rating FROM tbl_rumahmakan A 
              LEFT JOIN tbl_category B ON A.rm_category=B.category_id
              LEFT JOIN(SELECT rm_id,SUM(rating)/COUNT(rating) rating FROM tbl_rating
              GROUP BY rm_id) C ON A.rm_id=C.rm_id
              WHERE A.rm_name LIKE '%$keyword%' AND ($category)
              ORDER BY C.rating DESC
              LIMIT 10";
      $stmt=$this->conn->prepare($query);
      if($stmt->execute()) {
        $result = $stmt->get_result();
        while($data=$result->fetch_assoc()) {
          $user[]=array(
              "id" => $data['rm_id'],
              "name" => $data['rm_name'],
              "alamat" => $data['rm_alamat'],
              "hp" => $data['rm_hp'],
              "description" => $data['rm_description'],
              "photo" => $data['rm_photo'],
              "category" => $data['category_name'],
              "rating" => number_format($data['rating'],2)
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