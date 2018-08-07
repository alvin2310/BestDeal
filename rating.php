<?php
session_start();
include_once 'config.php';
$kns = new DB_con();

if(!empty($_POST['postID'])){
    $rmID = $_POST['postID'];
    $uid = $_POST['userID'];

    //Fetch rating deatails from database
    $query2 = "SELECT (user_earn-user_spent) selisih FROM tbl_users WHERE user_id=$uid";
    $result = $kns->OpenCon()->query($query2);
    $user = $result->fetch_assoc();

    $query="SELECT A.rumah_id,A.rumah_name,
            CASE WHEN A.alamat IS NULL THEN 'Kosong' ELSE A.alamat END alamat,
            A.rumah_description,A.harga,".$user['selisih']." selisih,rumah_description,
            CASE WHEN bata_qty IS NULL THEN 0 ELSE bata_qty END bata,
            CASE WHEN semen_qty IS NULL THEN 0 ELSE semen_qty END semen,
            CASE WHEN kayu_qty IS NULL THEN 0 ELSE kayu_qty END kayu,
            CASE WHEN pasir_qty IS NULL THEN 0 ELSE pasir_qty END pasir,
            CASE WHEN beton_qty IS NULL THEN 0 ELSE beton_qty END beton,
            CASE WHEN triplek_qty IS NULL THEN 0 ELSE triplek_qty END triplek,
            CASE WHEN asbes_qty IS NULL THEN 0 ELSE asbes_qty END asbes,
            CASE WHEN cat_qty IS NULL THEN 0 ELSE cat_qty END cat,
            CASE WHEN A.rumah_photo IS NULL THEN 'img/no_image.png' ELSE A.rumah_photo END rumah_photo,
            CASE WHEN C.avgrating IS NULL THEN 0 ELSE ROUND(C.avgrating,2) END avgrating,
            CASE WHEN C.totalrating IS NULL THEN 0 ELSE C.totalrating END totalrating FROM tbl_rumah A
            LEFT JOIN tbl_bangunan B ON A.rumah_id=B.rumah_id
            LEFT JOIN(SELECT rumah_id,SUM(rating)/COUNT(rating) avgrating,COUNT(rating) totalrating FROM tbl_rating
            GROUP BY rumah_id) C ON A.rumah_id=C.rumah_id
            WHERE A.rumah_id=$rmID
            ORDER BY C.avgrating DESC";
    $result = $kns->OpenCon()->query($query);
    $item = $result->fetch_assoc();

    if($item){
        $item['status'] = 'ok';
    }else{
        $item['status'] = 'err';
    }
    //Return json formatted data
    echo json_encode($item);
    /* while($data = $result->fetch_array(MYSQLI_ASSOC)){
        $item = array(
            "id" => $data['rm_id'],
            "name" => $data['rm_name'],
            "alamat" => $data['rm_alamat'],
            "hp" => $data['rm_hp'],
            "description" => $data['rm_description'],
            "photo" => $data['rm_photo'],
            "category" => $data['category_name'],
            "rating" => $data['rating']
        );
    } */
}

if(!empty($_POST['ratingPoints'])){
    $rmID = $_POST['postID'];
    $user_id = $_SESSION['user_id'];
    $ratingPoints = $_POST['ratingPoints'];

    //Update rating data into the database
    $query = "CALL usp_bd_rating_sv($user_id,$rmID,$ratingPoints)";
    $update = $kns->OpenCon()->query($query);

    //Fetch rating deatails from database
    $query2 = "SELECT rumah_id,SUM(rating)/COUNT(rating) avgrating,COUNT(rating) totalrating FROM tbl_rating WHERE rumah_id=$rmID GROUP BY rumah_id";
    $result = $kns->OpenCon()->query($query2);
    $ratingRow = $result->fetch_assoc();
    
    if($ratingRow){
        $ratingRow['status'] = 'ok';
    }else{
        $ratingRow['status'] = 'err';
    }
    
    //Return json formatted rating data
    echo json_encode($ratingRow);
}

?>
<?php
/* include_once 'dbConfig.php';
//Fetch rating deatails from database
$query = "SELECT rating_number, FORMAT((total_points / rating_number),1) as average_rating FROM post_rating WHERE post_id = 1 AND status = 1";
$result = $db->query($query);
$ratingRow = $result->fetch_assoc(); */
?>