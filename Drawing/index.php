<?php
  session_start();
  include('../config.php');

  if (!isset($_SESSION['user_id'])){
    header("Location: ../index.php");
  }
?>
<html lang="zxx">
  <head>
    <title>Best Deal - Save you Future Pocket</title>
    <!-- for-mobile-apps -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="Factual Real Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
    Smartphone Compatible web template, free web designs for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
        function hideURLbar(){ window.scrollTo(0,1); } </script>
    
    <!-- Favicon  -->
    <link rel="icon" href="../favicon.ico">
    <!-- //for-mobile-apps -->
    <link href="../css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
    <link rel="stylesheet" href="../css/cm-overlay.css">
    <link href="../css/style.css" rel="stylesheet" type="text/css" media="all" />
    <!-- font-awesome icons -->
    <link href="../css/font-awesome.css" rel="stylesheet"> 
    <!-- //font-awesome icons -->
    <link href="//fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
    <script>
      var documentTitle = document.title + " - ";
      (function titleMarquee() {
        document.title = documentTitle = documentTitle.substring(1) + documentTitle.substring(0,1);
        setTimeout(titleMarquee, 100);
      })();
    </script>
  </head>
  <body>
    <div class="banner-top">
      <div class="w3_navigation">
        <div class="container">
          <nav class="navbar navbar-default">
            <div class="navbar-header navbar-left">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <h1><a class="navbar-brand" href="index.php">Best <span>Deal</span><p class="logo_w3l_agile_caption">Find a Good One</p></a></h1>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-right" id="bs-example-navbar-collapse-1">
              <nav class="menu menu--iris">
                <ul class="nav navbar-nav menu__list">
                  <li class="menu__item"><a href="../index.php" class="menu__link">Awal</a></li>
                  <li class="menu__item"><a href="../recommend.php" class="menu__link scroll">List Rekomendasi</a></li>
                  <li class="menu__item"><a href="../search.php" class="menu__link scroll">Cari</a></li>
                  <li class="menu__item menu__item--current"><a href="./index.php" class="menu__link scroll">Rancang</a></li>
                  <li class="dropdown menu__item">
                    <a href="#" class="dropdown-toggle menu__link" data-toggle="dropdown"><?php echo $_SESSION['user_name']; ?><b class="caret"></b></a>
                    <ul class="dropdown-menu agile_short_dropdown">
                      <li><a class="scroll" href="../profile.php">Profil</a></li>
                      <!-- <li><a class="scroll" href="#">Settings</a></li> -->
                      <li><a class="scroll" href="../Login/logout.php">Keluar</a></li>
                    </ul>
                  </li>
                </ul>
              </nav>
            </div>
          </nav>
        </div>
      </div>
    </div>
    <div class="gallery" id="design">
      <div class="container">
        <div class="wthree-tittle">
            <h3 class="agile_title one">Daftar Rumah</h3>
          <p class="w3l-agile-its-title">Rancang rumah anda</p>
        </div>
        <?php
          $kns = new DB_con();
          $query = "SELECT * FROM tbl_rumah
                    WHERE user_id=".$_SESSION['user_id']."";
          //echo $query;
          $result = $kns->OpenCon()->query($query);
          if($result->num_rows==0){
            echo "
              <p>Kamu belum ada rancangan rumah buat baru ?</p>
              <a href='./create.php' class='btn btn-info btn-lg'><i class='fa fa-plus-circle></i> Tambah Baru'</a>
            ";
          } else {
            echo "<a href='./create.php' class='btn btn-info btn-lg'><i class='fa fa-plus-circle'></i> Tambah Baru</a>";
            while($data = $result->fetch_array(MYSQLI_ASSOC)){
              echo "
              <table class='table table-hover'>
                <thead>
                  <tr>
                    <th>Tipe Rumah</th>
                    <th>Tingkat</th>
                    <th>Ukuran</th>
                    <th>Harga</th>
                    <th>Alamat</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>".$data['rumah_name']."</td>
                    <td>".$data['jenis']."</td>
                    <td>".$data['ukuran']."</td>
                    <td>".$data['harga']."</td>
                    <td>".$data['alamat']."</td>
                    <td>
                      <a href=\"javascript:void(0)\" data-id=\"".$data['rumah_id']."\" name=\"accept\" onclick=\"accept(".$data['rumah_id'].")\" class=\"btn btn-success\" title=\"Accept\">
                          <i class=\"fa fa-edit\"></i>
                      </a>
                      <a href=\"./create.php?rumah_id=".$data['rumah_id']."\" class=\"btn btn-info\" title=\"Design\"><i class=\"fa fa-paint-brush\"></i></a>
                      <a href=\"javascript:void(0)\" data-id=\"".$data['rumah_id']."\" name=\"delete\" onclick=\"remove(".$data['rumah_id'].")\" class=\"btn btn-danger\" title=\"Remove\">
                          <i class=\"fa fa-trash-o\"></i>
                      </a>
                    </td>
                  </tr>
                </tbody>
              </table>";
            }
          }
        ?>
      </div>
    </div>
    <!-- View Modal -->
      <div class="modal fade" id="view-modal">
        <div class="modal-dialog">
          <div class="modal-content">
          
            <!-- Modal Header -->
            <div class="modal-header">
              <input type="hidden" id="viewId" name="viewId" value="" />
              <h4 class="modal-title">Rumah </h4>
              <p id="rumah_name"></p>
            </div>
            
            <!-- Modal body -->
            <div class="modal-body">
              <div class="form-group">
                <center>
                  <img class="img-fluid" name="profil" id="profil" src="<?php echo $path; ?>" alt="User Pict" height="500" width="300">
                </center>
                <label class="form-label">Upload Foto:</label>
                <input type="file" name="photo_pict" class="filestyle" data-icon="false" accept="image/*">
              </div>
              <div class="form-group">
                <label>Ukuran</label>
                <input type="text" class="form-control" id="ukuran" value="" readonly />
              </div>
              <div class="form-group">
                <label>Alamat</label>
                <input type="text" class="form-control" id="alamat" />
              </div>
              <div class="form-group">
                <label>Harga Jual</label>
                <input type="text" class="form-control" id="harga" />
              </div>
              <div class="form-group">
                <label>Deskripsi</label>
                <textarea class="form-control" id="deskripsi"></textarea>
              </div>
            </div>
          
            <!-- Modal footer -->
            <div class="modal-footer">
              <button type="submit" id="save" name="save" class="btn btn-info">Save</button>
            </div>
            <?php
              if(isset($_POST['save'])){
                extract($_POST);
                // definisi folder upload
                define("UPLOAD_DIR", "img/user/");
                if ( ! is_dir(UPLOAD_DIR)) {
                  mkdir(UPLOAD_DIR);
                }
                if (!empty($_FILES["photo_pict"])) {
                  $photo_pict = $_FILES["photo_pict"];
                  $ext    = pathinfo($_FILES["photo_pict"]["name"], PATHINFO_EXTENSION);
                  $size   = $_FILES["photo_pict"]["size"];

                  if ($photo_pict["error"] !== UPLOAD_ERR_OK) {
                    echo '<div class="alert alert-warning">Gagal upload file.</div>';
                    exit;
                  }
                  if ($size>3000000) {
                    echo '<div class="alert alert-warning">File terlalu besar,Gagal upload file.</div>';
                    exit;
                  }
                  // filename yang aman
                  $temp = explode(".", $_FILES["photo_pict"]["name"]);
                  $newfilename = $user . '.' . end($temp);

                  $name = preg_replace("/[^A-Z0-9._-]/i", "_", $newfilename);

                  // // mencegah overwrite filename
                  // $i = 0;
                  // $parts = pathinfo($name);
                  // while (file_exists(UPLOAD_DIR . $name)) {
                  // $i++;
                  // $name = $parts["filename"] . "-" . $i . "." . $parts["extension"];
                  // }

                  // upload file
                  $success = move_uploaded_file($photo_pict["tmp_name"],UPLOAD_DIR . $name);
                  if (!$success) {
                    echo '<div class="alert alert-warning">Gagal upload file.</div>';
                    exit;
                  }
                  else{
                    $kns = new DB_con();
                    $query = "INSERT INTO tbl_rumah (rumah_name,jenis,ukuran,harga,alamat,rumah_photo,rumah_description,rumah_sketch) VALUES('$rumah_name',1,'$ukuran',$totalHarga,'$alamat',NULL,'','images/Home/$name')";
                    $hasil = $kns->OpenCon()->query($query) or die($kns->OpenCon()->error);
                    if($hasil){
                      //echo '<div class="alert alert-success">File berhasil di upload.</div>';
                      echo "<script type='text/javascript'>
                            alert(Rumah baru sudah di tambahkan');
                            window.location='index.php';
                            </script>";
                    }else{
                      echo '<div class="alert alert-warning">Gagal upload file.</div>';
                      exit;
                    }
                  }
                  // set permisi file
                  chmod(UPLOAD_DIR . $name, 0644);
                }
              }
            ?>
          
          </div>

        </div>
      </div>
    <!-- End View Modal -->
    <script>
      function accept(id){
        $.ajax({
          type: 'POST',
          url: 'getHome.php',
          data: 'postID='+id,
          dataType: 'json',
          success : function(data) {
            if (data.status == 'ok') {
              $('#rumah_name').html("<h4>"+data.rumah_name+"</h4>");
              $('#alamat').val(data.alamat);
              $('#ukuran').val(data.ukuran);
              $('#harga').val(data.harga);
              $('#deskripsi').text(data.rumah_description);
            }else{
              alert('Some problem occured, please try again.');
            }
          }
        });
        /* $(".modal-footer #rating_start").postID(viewId); */
        $('#view-modal').modal('show');
      }
      function remove(id){
        alert("You remove "+id);
      }
    </script>
    <script src="../js/jquery-2.2.3.min.js"></script>
    <!-- Stats-Number-Scroller-Animation-JavaScript -->
      <script src="../js/waypoints.min.js"></script> 
      <script src="../js/counterup.min.js"></script> 
      <script>
        jQuery(document).ready(function( $ ) {
          $('.counter').counterUp({
            delay: 100,
            time: 1000
          });
        });
      </script>
    <!-- //Stats-Number-Scroller-Animation-JavaScript -->
    <script src="../js/responsiveslides.min.js"></script>
    <script>
      // You can also use "$(window).load(function() {"
      $(function () {
        // Slideshow 4
        $("#slider4").responsiveSlides({
        auto: true,
        pager:true,
        nav:false,
        speed: 500,
        namespace: "callbacks",
        before: function () {
          $('.events').append("<li>before event fired.</li>");
        },
        after: function () {
          $('.events').append("<li>after event fired.</li>");
        }
        });
      });
    </script>
    <script src="../js/bootstrap.js"></script>
    <script src="../js/jquery.tools.min.js"></script>
    <script src="../js/jquery.mobile.custom.min.js"></script>
    <script src="../js/jquery.cm-overlay.js"></script>
    <script>
      $(document).ready(function(){
        $('.cm-overlay').cmOverlay();
      });
    </script>
    <script src="../js/jarallax.js"></script>
    <script type="text/javascript">
      /* init Jarallax */
      $('.jarallax').jarallax({
        speed: 0.5,
        imgWidth: 1366,
        imgHeight: 768
      })
    </script>
    <script type="text/javascript" src="../js/jquery.flexisel.js"></script>
    <!-- here stars scrolling icon -->
      <script type="text/javascript">
        $(document).ready(function() {
          /*
            var defaults = {
            containerID: 'toTop', // fading element id
            containerHoverID: 'toTopHover', // fading element hover id
            scrollSpeed: 1200,
            easingType: 'linear' 
            };
          */    
          $().UItoTop({ easingType: 'easeOutQuart' });     
        });
      </script>
    <!-- //here ends scrolling icon -->
    <!-- copy-right -->
      <div class="w3lagile_copy_right">
          <p>© 2017 Factual Villa. All Rights Reserved | Design by <a href="https://w3layouts.com/" target="_blank">W3layouts</a></p>
      </div>
    <!-- //copy-right -->
    <a href="#" id="toTop" style="display: block;"> <span id="toTopHover" style="opacity: 1;"> </span></a>
  </body>
</html>