<?php
  session_start();
  include('config.php');

  if (!isset($_SESSION['user_id'])){
    header("Location: ./index.php");
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
    <link rel="icon" href="./favicon.ico">
    <!-- //for-mobile-apps -->
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
    <link rel="stylesheet" href="css/cm-overlay.css">
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
    <!-- font-awesome icons -->
    <link href="css/font-awesome.css" rel="stylesheet"> 
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
    <!-- Rating System -->
      <link href="css/rating.css" rel="stylesheet" type="text/css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
      <script type="text/javascript" src="js/rating.js"></script>
      <script language="javascript" type="text/javascript">
      function processRating(val, attrVal){
        $.ajax({
            type: 'POST',
            url: 'rating.php',
            data: 'postID='+attrVal+'&ratingPoints='+val,
            dataType: 'json',
            success : function(data) {
                if (data.status == 'ok') {
                    $('#avgrat').text(data.avgrating);
                    $('#totalrat').text(data.totalrating);
                }else{
                    alert('Some problem occured, please try again.');
                }
            }
        });
      }
      </script>
    <!-- End Rating -->
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
                  <li class="menu__item"><a href="index.php" class="menu__link">Awal</a></li>
                  <li class="menu__item menu__item--current"><a href="./recommend.php" class="menu__link scroll">List Rekomendasi</a></li>
                  <li class="menu__item"><a href="./search.php" class="menu__link scroll">Cari</a></li>
                  <li class="menu__item"><a href="./Drawing/index.php" class="menu__link scroll">Rancang</a></li>
                  <li class="dropdown menu__item">
                    <a href="#" class="dropdown-toggle menu__link" data-toggle="dropdown"><?php echo $_SESSION['user_name']; ?><b class="caret"></b></a>
                    <ul class="dropdown-menu agile_short_dropdown">
                      <li><a class="scroll" href="./profile.php">Profil</a></li>
                      <!-- <li><a class="scroll" href="#">Settings</a></li> -->
                      <li><a class="scroll" href="./Login/logout.php">Keluar</a></li>
                    </ul>
                  </li>
                </ul>
              </nav>
            </div>
          </nav>
        </div>
      </div>
    </div>
    <!-- gallery -->
			<div class="gallery" id="gallery">
				<div class="container">
					<div class="wthree-tittle">
							<h3 class="agile_title one">Rekomendasi</h3>
						<p class="w3l-agile-its-title">Daftar rekomendasi</p>
					</div>
					<!-- Content List Data -->
					<div id="myTabContent" class="tab-content">
						<div role="tabpanel" class="tab-pane fade in active" id="home-main" aria-labelledby="home-tab">
							<div class="w3_tab_img">
								<?php
									require_once 'moduleTrust.php';
									$db = new Module();
                  $kns = new DB_con();

                  $userid = $_SESSION['user_id'];

                  $query = "SELECT * FROM tbl_users
                            WHERE user_id=$userid AND (user_earn=0 OR user_spent=0 OR simpanan=0)";
                  $result = $kns->OpenCon()->query($query);
                  if($result->num_rows==1){
                    echo "
                      <p>For a better Recommendation please fill your profile First !</p>
                      <a href='./profile.php' class='btn btn-info btn-lg'>Go to Profile</a>
                    ";
                  } else {
                    $user = $db->home($userid);
                    if ($user != false) {
                      $n = count($user);
                      $response["error"] = FALSE;
                      foreach ($user as $i => $value){
                        if(isset($value['rumah_id'])) {
                          if(isset($value['rumah_photo']) AND $value['rumah_photo']<>""){
                            $path=$value['rumah_photo'];
                          }
                          else{
                            $path="images/no_image.png";
                          }
  
                          echo "
                          <div class=\"col-sm-3 w3_tab_img_left\">
                            <div class=\"demo\">
                              <a class=\"cm-overlay\" href=\"$path\">
                                <figure class=\"imghvr-shutter-in-out-diag-2\"><img src=\"$path\" alt=\" \" class=\"img-responsive\"  height='229' />
                                </figure>
                              </a>
                            </div>
                            <div class=\"agile-gallery-info\" style='cursor:pointer;' id=\"open-View\" data-toggle=\"modal\" data-id=\"".$value['rumah_id']."\">
                              <h6>".$value['rumah_name']." ( <b>".$value['ukuran']."</b> )</h6>
                              <h6>Rp.".number_format($value['harga'],2,",",".")."</h6>
                            </div>
                          </div>";
                        }
                      }
                    }
                  }
								?>
								<div class="clearfix"> </div>
              </div>
						</div>
            <script>
              $(document).on("click", "#open-View", function () {
                var userid = <?php echo $_SESSION['user_id']; ?>;
                //remove Old Widget
                $('.rating_widget').remove();
                $('.clear-fix').remove();
                //Add New Widget
                $("#rating_star").rating_widget({
                    starLength: '5',
                    initialValue: '',
                    callbackFunctionName: 'processRating',
                    imageDirectory: 'images/',
                    inputAttr: 'data-postID'
                });
                var viewId = $(this).data('id');
                $.ajax({
                  type: 'POST',
                  url: 'rating.php',
                  data: 'postID='+viewId+'&userID='+userid,
                  dataType: 'json',
                  success : function(data) {
                    if (data.status == 'ok') {
                      var dp = data.harga * 20 / 100;
                      var pct = "12%"; // or from an <input> field or whatever
                      pct = parseFloat(pct) / 100;
                      pct = (data.harga - dp) * pct;
                      var lama = Math.ceil(( ((data.harga - dp) + pct) / data.selisih) / 12);
                      if(lama > 5 && lama < 10) {
                        lama = 10;
                      } else if(lama > 10 && lama < 15) {
                        lama = 15;
                      }
                      var bata = data.bata;
                      var semen = data.bata;
                      var kayu = data.bata;
                      var pasir = data.bata;
                      var beton = data.bata;
                      var triplek = data.bata;
                      var asbes = data.bata;
                      var cat = data.bata;
                      $('#rumah_name').html("<h4>"+data.rumah_name+"</h4>");
                      $('#rating_star').attr('data-postID',data.rumah_id);
                      $('#alamat').text(data.alamat);
                      $('#min_dp').text(dp.toLocaleString('it-IT', {style: 'currency', currency: 'IDR'}));
                      $('#lama_kpr').text(lama+" Tahun");
                      $('#deskripsi').text(data.rumah_description);
                      $('#bata').text(data.bata + " buah");
                      $('#semen').text(data.semen + " sak");
                      $('#kayu').text(data.kayu + " buah");
                      $('#pasir').text(data.pasir + " m3");
                      $('#beton').text(data.beton + " buah");
                      $('#triplek').text(data.triplek + " buah");
                      $('#asbes').text(data.asbes + " buah");
                      $('#cat').text(data.cat + " kaleng");
                      $('#avgrat').text(data.avgrating);
                      $('#totalrat').text(data.totalrating);
                    }else{
                      alert('Some problem occured, please try again.');
                    }
                  }
                });
                /* $(".modal-footer #rating_start").postID(viewId); */
                $('#view-modal').modal('show');
              });
            </script>
          </div>
				</div>
			</div>
    <!-- //gallery -->
    
    <!-- View Modal -->
      <div class="modal fade" id="view-modal">
        <div class="modal-dialog">
          <div class="modal-content">
          
            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Rumah</h4>
              <p id="rumah_name"></p>
            </div>
            
            <!-- Modal body -->
            <div class="modal-body">
              <div class="form-group">
                <label>Alamat</label>
                <p id="alamat"></p>
              </div>
              <div class="form-group">
                <label>Min. DP</label>
                <p id="min_dp"></p>
              </div>
              <div class="form-group">
                <label>Lama KPR</label>
                <p id="lama_kpr"></p>
              </div>
              <div class="form-group">
                <label>Rating</label>
                <div style="font-size: 14px;margin-top: 5px;color: #8e8d8d;">(Average Rating <span id="avgrat"></span> Based on <span id="totalrat"></span> rating)</span></div>
              </div>
              <div class="form-group">
                <label>Deskripsi</label>
                <p id="deskripsi"></p>
              </div>
              <div class="form-group">
                <label>Daftar Bahan Bangunan : </label>
                <hr>
                <label>Bata</label>
                <p id="bata"></p>
                <label>Semen</label>
                <p id="semen"></p>
                <label>Kayu</label>
                <p id="kayu"></p>
                <label>Pasir</label>
                <p id="pasir"></p>
                <label>Beton</label>
                <p id="beton"></p>
                <label>Triplek</label>
                <p id="triplek"></p>
                <label>Asbes</label>
                <p id="asbes"></p>
                <label>Cat</label>
                <p id="cat"></p>
              </div>
              <!-- <div class="form-group">
                <label>Post Comment</label>
                <input type="text" class="form-control" nama="comments" id="comments" value="" />
                <a href="javascript:void(0)" class="btn btn-success" name="send" id="send">Send</a>
                <i><label id="message"></label><i>
              </div> -->
              <div class="form-group">
              </div>
            </div>
          
            <!-- Modal footer -->
            <div class="modal-footer">
              <input name="rating" value="0" id="rating_star" type="hidden" data-postID="0" />
            </div>
          
          </div>

          <script language="javascript" type="text/javascript">
            /* $("#send").click(function() {
              var val = $("#comments").val();
              var attrVal = $('#open-View').attr("data-id");
              $.ajax({
                  type: 'POST',
                  url: 'comment.php',
                  data: 'postID='+attrVal+'&comment='+val,
                  dataType: 'json',
                  success : function(data) {
                      if (data.status == 'ok') {
                        $("#comments").val("");
                        $("#message").empty();
                        $("#message").append("Comment post successfully");
                      }else{
                          alert('Some problem occured, please try again.');
                      }
                  }
              });
            }); */
          </script>
        </div>
      </div>
    <!-- End View Modal -->
    <!-- <script src="js/jquery-2.2.3.min.js"></script> -->
    <!-- Stats-Number-Scroller-Animation-JavaScript -->
      <script src="js/waypoints.min.js"></script> 
      <script src="js/counterup.min.js"></script> 
      <script>
        jQuery(document).ready(function( $ ) {
          $('.counter').counterUp({
            delay: 100,
            time: 1000
          });
        });
      </script>
    <!-- //Stats-Number-Scroller-Animation-JavaScript -->
    <script src="js/responsiveslides.min.js"></script>
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
    <script src="js/bootstrap.js"></script>
    <script src="js/jquery.tools.min.js"></script>
    <script src="js/jquery.mobile.custom.min.js"></script>
    <script src="js/jquery.cm-overlay.js"></script>
    <script>
      $(document).ready(function(){
        $('.cm-overlay').cmOverlay();
      });
    </script>
    <script src="js/jarallax.js"></script>
    <script type="text/javascript">
      /* init Jarallax */
      $('.jarallax').jarallax({
        speed: 0.5,
        imgWidth: 1366,
        imgHeight: 768
      })
    </script>
    <script type="text/javascript" src="js/jquery.flexisel.js"></script>
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