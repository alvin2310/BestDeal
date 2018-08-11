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
                  <li class="menu__item"><a href="./recommend.php" class="menu__link scroll">List Rekomendasi</a></li>
                  <li class="menu__item menu__item--current"><a href="./search.php" class="menu__link scroll">Cari</a></li>
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
							<h3 class="agile_title one">Cari</h3>
						<p class="w3l-agile-its-title">Mencari Rumah</p>
					</div>
					<!-- Content List Data -->
					<div id="myTabContent" class="tab-content">
            <input class="form-control" name="keyword" id="keyword" placeholder="Keyword" autocomplete="off" />
            <button class="btn btn-primary" name="search" id="search">Search</button>
            <hr>
            <div role="tabpanel" class="tab-pane fade in active" id="home-main" aria-labelledby="home-tab">
              <div class="w3_tab_img" id="listHome">

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
                      $('#rumah_name').html("<h4>"+data.rumah_name+"</h4>");
                      $('#rating_star').attr('data-postID',data.rumah_id);
                      $('#alamat').text(data.alamat);
                      $('#min_dp').text(dp.toLocaleString('it-IT', {style: 'currency', currency: 'IDR'}));
                      $('#lama_kpr').text(lama+" Tahun");
                      $('#deskripsi').text(data.rumah_description);
                      $('#bata').text(data.bata);
                      $('#semen').text(data.semen);
                      $('#kayu').text(data.kayu);
                      $('#pasir').text(data.pasir);
                      $('#beton').text(data.beton);
                      $('#triplek').text(data.triplek);
                      $('#asbes').text(data.asbes);
                      $('#cat').text(data.cat);
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
    <script src="js/jquery-2.2.3.min.js"></script>
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
    <script>
      $("#search").click(function(){
        var keyword = $("#keyword").val();
        $.ajax({
              type: 'POST',
              url: 'search_get.php',
              data: 'keyword='+keyword,
              dataType: 'json',
              success : function(data) {
                if (data.status == 'ok') {
                  $("#listHome").html("");
                  $("#listHome").append(data.daftar);
                }else{
                  $("#listHome").html("");
                  $("#listHome").html("<p>Tidak ada hasil pencarian</p>");
                }
              }
            });
      })
    </script>
  </body>
</html>