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
                      <p>Untuk mendapatkan hasil rekomendasi yang baik, Perbaiki profile anda !</p>
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
                    } else {
                      echo "
                        <p>Pendapatan atau Pengeluaran tidak sesuai, Perbaiki profile anda !</p>
                        <a href='./profile.php' class='btn btn-info btn-lg'>Go to Profile</a>
                      ";
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
                      var harga = data.harga * 1;
                      var dp = data.harga * 20 / 100;
                      var pct = "12"; // or from an <input> field or whatever
                      $('#bunga').text(pct + " %");
                      pct = parseFloat(pct) / 100;
                      pct = (data.harga - dp) * pct;
                      var sisaBayar = data.harga - data.simpanan;
                      var lama = 0;
                      if(sisaBayar<0){
                        lama = 0;
                      } else {
                        lama = Math.ceil(( ((sisaBayar) + pct) / data.selisih) / 12);
                      }

                      if(lama > 5 && lama < 10) {
                        lama = 10;
                      } else if(lama > 10 && lama < 15) {
                        lama = 15;
                      } else if(lama > 15 && lama < 20) {
                        lama = 20;
                      }
                      var cicilan = ((data.harga - dp) + pct) / (lama*12);
                      var bata = data.bata;
                      var semen = data.semen;
                      /* var kayu = data.kayu;
                      var pasir = data.pasir;
                      var beton = data.beton;
                      var triplek = data.triplek;
                      var asbes = data.asbes;
                      var cat = data.cat; */
                      $('#rumah_name').html("<h4>"+data.rumah_name+"</h4>");
                      $('#rating_star').attr('data-postID',data.rumah_id);
                      $('#alamat').text(data.alamat);
                      $('#earn').text((data.selisih * 1).toLocaleString('it-IT', {style: 'currency', currency: 'IDR'}));
                      $('#kesanggupan').text((data.simpanan * 1).toLocaleString('it-IT', {style: 'currency', currency: 'IDR'}));
                      $('#harga').text(harga.toLocaleString('it-IT', {style: 'currency', currency: 'IDR'}));
                      $('#min_dp').text(dp.toLocaleString('it-IT', {style: 'currency', currency: 'IDR'}));
                      if(lama > 20) {
                        lama = "Lama KPR Melebihi 20 Tahun Perbesar Kesanggupan";
                        $('#lama_kpr').text(lama);
                      } else {
                        $('#lama_kpr').text(lama+" Tahun");
                      }
                      $('#cicilan').text(cicilan.toLocaleString('it-IT', {style: 'currency', currency: 'IDR'})+" / Bulan");
                      $('#deskripsi').text(data.rumah_description);
                      $('#bata').text(data.bata + " buah");
                      $('#semen').text(data.semen + " sak");
                      $('#pasir').text(data.pasir + " m3");
                      /* $('#kayu').text(data.kayu + " buah");
                      $('#beton').text(data.beton + " buah");
                      $('#triplek').text(data.triplek + " buah");
                      $('#asbes').text(data.asbes + " buah");
                      $('#cat').text(data.cat + " kaleng"); */
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
                <label>Pendapatan Bersih</label>
                <p id="earn"></p>
                <input type="text" class="form-control" id="inp_earn" onkeypress="return fun_AllowOnlyAmountAndDot(this.id);" value="0" />
              </div>
              <div class="form-group">
                <label>Kesanggupan</label>
                <p id="kesanggupan"></p>     
                <input type="text" class="form-control" id="inp_dp" onkeypress="return fun_AllowOnlyAmountAndDot(this.id);" value="0" />           
              </div>
              <div class="form-group">
                <label>Harga Rumah</label>
                <p id="harga"></p>
              </div>
              <div class="form-group">
                <label>Min. DP Rumah</label>
                <p id="min_dp"></p>
              </div>
              <div class="form-group">
                <label>Bunga</label>
                <div class="form-group row">
                  <div class="col-xs-2">
                    <p id="bunga"></p>
                  </div>
                  <div class="col-xs-2">
                    <input type="text" class="form-control input-sm" id="inp_bunga" onkeypress="return fun_AllowOnlyAmountAndDot(this.id);" value="12" />
                  </div>
                  <div class="col-xs-2">
                    <label class="control-label">%</label>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label>Cicilan / Bulan</label>
                <p id="cicilan"></p>
                <input type="text" class="form-control" id="inp_cicilan" value="0" readonly />
              </div>
              <div class="form-group">
                <label>Lama KPR</label>
                <p id="lama_kpr"></p>
                <input type="text" class="form-control" id="inp_lama" value="0" readonly/>
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
                <label>Pasir</label>
                <p id="pasir"></p>
                <!-- <label>Kayu</label>
                <p id="kayu"></p>
                <label>Beton</label>
                <p id="beton"></p>
                <label>Triplek</label>
                <p id="triplek"></p>
                <label>Asbes</label>
                <p id="asbes"></p>
                <label>Cat</label>
                <p id="cat"></p> -->
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
          <script>
            function fun_AllowOnlyAmountAndDot(txt)
            {
              if(event.keyCode > 47 && event.keyCode < 58 || event.keyCode == 46)
              {
                var txtbx=document.getElementById(txt);
                var amount = document.getElementById(txt).value;
                var present=0;
                var count=0;

                if(amount.indexOf(".",present)||amount.indexOf(".",present+1));
                {
                  // alert('0');
                }
                do
                {
                present=amount.indexOf(".",present);
                if(present!=-1)
                  {
                  count++;
                  present++;
                  }
                }
                while(present!=-1);
                if(present==-1 && amount.length==0 && event.keyCode == 46)
                {
                  event.keyCode=0;
                  //alert("Wrong position of decimal point not  allowed !!");
                  return false;
                }

                if(count>=1 && event.keyCode == 46)
                {
                  event.keyCode=0;
                  //alert("Only one decimal point is allowed !!");
                  return false;
                }
                if(count==1)
                {
                  var lastdigits=amount.substring(amount.indexOf(".")+1,amount.length);
                  if(lastdigits.length>=2)
                  {
                    //alert("Two decimal places only allowed");
                    event.keyCode=0;
                    return false;
                  }
                }
                return true;
              }
              else
              {
                event.keyCode=0;
                //alert("Only Numbers with dot allowed !!");
                return false;
              }
            }
            $(document).on("change", "#inp_dp", function () {
              var dp = $(this).val();
              var harga = $("#harga").text();
              harga = harga.split(".").join("");
              harga = parseInt(harga);
              var selisih = $("#earn").text();
              selisih = selisih.split(".").join("");
              selisih = parseInt(selisih);
              var pct = $("#inp_bunga").val(); // or from an <input> field or whatever
              pct = parseFloat(pct) / 100;
              pct = (harga * 1 - dp) * pct;

              var sisaBayar = harga - dp;
              var lama = 0;
              if(sisaBayar<0){
                lama = 0;
              } else {
                lama = Math.ceil(( ((sisaBayar) + pct) / data.selisih) / 12);
              }

              //var lama = Math.ceil(( ((harga * 1 - dp) + pct) / selisih) / 12);
              if(lama > 5 && lama < 10) {
                lama = 10;
              } else if(lama > 10 && lama < 15) {
                lama = 15;
              } else if(lama > 15 && lama < 20) {
                lama = 20;
              }
              alert("Harga "+harga+" dengan DP "+dp);
              var cicilan = ((harga - dp) + pct) / (lama*12);
              if(lama > 20) {
                lama = "Lama KPR Melebihi 20 Tahun Perbesar Kesanggupan";
                $('#inp_lama').val(lama);
              } else {
                $('#inp_lama').val(lama+" Tahun");
              }
              $('#inp_cicilan').val(cicilan.toLocaleString('it-IT', {style: 'currency', currency: 'IDR'})+" / Bulan");
            });
            $(document).on("change", "#inp_bunga", function () {
              var dp = 0;
              if($("#inp_dp").val() == 0){
                dp = $("#min_dp").text();
                dp = dp.split(".").join("");
                dp = parseInt(dp);
              } else {
                dp = $("#inp_dp").val();
              }
              var harga = $("#harga").text();
              harga = harga.split(".").join("");
              harga = parseInt(harga);
              var selisih = $("#earn").text();
              selisih = selisih.split(".").join("");
              selisih = parseInt(selisih);
              var pct = $(this).val(); // or from an <input> field or whatever
              pct = parseFloat(pct) / 100;
              pct = (harga * 1 - dp) * pct;

              var sisaBayar = harga - dp;
              var lama = 0;
              if(sisaBayar<0){
                lama = 0;
              } else {
                lama = Math.ceil(( ((sisaBayar) + pct) / data.selisih) / 12);
              }

              //var lama = Math.ceil(( ((harga * 1 - dp) + pct) / selisih) / 12);
              if(lama > 5 && lama < 10) {
                lama = 10;
              } else if(lama > 10 && lama < 15) {
                lama = 15;
              } else if(lama > 15 && lama < 20) {
                lama = 20;
              }
              alert("Harga "+harga+" dengan DP "+dp);
              var cicilan = ((harga - dp) + pct) / (lama*12);
              if(lama > 20) {
                lama = "Lama KPR Melebihi 20 Tahun Perbesar Kesanggupan";
                $('#inp_lama').val(lama);
              } else {
                $('#inp_lama').val(lama+" Tahun");
              }
              $('#inp_cicilan').val(cicilan.toLocaleString('it-IT', {style: 'currency', currency: 'IDR'})+" / Bulan");
            });
            $(document).on("change", "#inp_earn", function () {
              var dp = 0;
              if($("#inp_dp").val() == 0){
                dp = $("#min_dp").text();
                dp = dp.split(".").join("");
                dp = parseInt(dp);
              } else {
                dp = $("#inp_dp").val();
              }
              var harga = $("#harga").text();
              harga = harga.split(".").join("");
              harga = parseInt(harga);
              var selisih = $(this).val();
              selisih = selisih.split(".").join("");
              selisih = parseInt(selisih);
              var pct = $("#inp_bunga").val(); // or from an <input> field or whatever
              pct = parseFloat(pct) / 100;
              pct = (harga * 1 - dp) * pct;

              var sisaBayar = harga - dp;
              var lama = 0;
              if(sisaBayar<0){
                lama = 0;
              } else {
                lama = Math.ceil(( ((sisaBayar) + pct) / data.selisih) / 12);
              }

              //var lama = Math.ceil(( ((harga * 1 - dp) + pct) / selisih) / 12);
              if(lama > 5 && lama < 10) {
                lama = 10;
              } else if(lama > 10 && lama < 15) {
                lama = 15;
              } else if(lama > 15 && lama < 20) {
                lama = 20;
              }
              alert("Harga "+harga+" dengan DP "+dp);
              var cicilan = ((harga - dp) + pct) / (lama*12);
              if(lama > 20) {
                lama = "Lama KPR Melebihi 20 Tahun Perbesar Kesanggupan";
                $('#inp_lama').val(lama);
              } else {
                $('#inp_lama').val(lama+" Tahun");
              }
              $('#inp_cicilan').val(cicilan.toLocaleString('it-IT', {style: 'currency', currency: 'IDR'})+" / Bulan");
            });
          </script>
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