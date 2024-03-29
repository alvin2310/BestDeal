<?php
  session_start();
  include('config.php');
  include_once './Login/auth.php';
  $user = new Auth();

  if (isset($_POST['login'])) {
		extract($_POST);
		$login = $user->AuthLogin($username, $password);
		if ($login) {
				header("Location: ./home.php");
		} else {
				echo "<script>alert('Wrong username or password');</script>";
		}
  }

  if (isset($_SESSION['user_id'])){
    header("Location: ./home.php");
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
                  <li class="menu__item menu__item--current"><a href="index.php" class="menu__link">Home</a></li>
                  <li class="menu__item"><a href="#gallery" class="menu__link scroll">Gallery</a></li>
                  <li class="menu__item"><a href="./about.php" class="menu__link scroll">About Us</a></li>
                  <li class="menu__item"><a href="#" class="menu__link scroll" data-toggle="modal" data-target="#login-modal">Login</a></li>
                  <li class="menu__item"><a href="./Login/register.php" class="menu__link scroll">Register</a></li>
                </ul>
              </nav>
            </div>
          </nav>
          <!-- Login Modal -->
            <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
              <div class="modal-dialog modal-sm">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="Login">User login</h4>
                  </div>
                  <div class="modal-body">
                    <form method="post" name="login">
                      <div class="form-group">
                        <input type="text" class="form-control" id="user_modal" name="username" placeholder="username" maxlength="20">
                      </div>
                      <div class="form-group">
                        <input type="password" class="form-control" id="password_modal" name="password" placeholder="password" maxlength="16">
                      </div>
                      <p class="text-center">
                        <button type="submit" name="login" class="btn btn-primary btn-lg"><i class="fa fa-sign-in"></i> Log in</button>
                      </p>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <!-- <p class="text-center text-muted">Not registered yet?</p>
                    <p class="text-center text-muted"><a href="./Login/register.php"><strong>Register now</strong></a>! It is easy and done in 1&nbsp;minute!</p> -->
                  </div>
                </div>
              </div>
            </div>
          <!-- End Login Modal -->
        </div>
      </div>
      <!-- Banner Start -->
      <?php include('img_slider.php'); ?>
      <!-- Banned End -->
    </div>
		<!--count-->
			<div class="count-agileits">
        <div class="count-grids">
          <?php
            //Mencari Jumlah
            $kns = new DB_con();
            $result = $kns->OpenCon()->query("CALL usp_bd_count_slc()");
            while($data = $result->fetch_array(MYSQLI_ASSOC)){
              $happy=$data['jlh_happy'];
              $place=$data['jlh_place'];
              $client=$data['jlh_user'];
            }
          ?>
          <div class="count-bgcolor-w3ls">
              <div class="col-md-4 agileits_w3layouts_about_counter_left c1 count-grid">
                <i class="fa fa-smile-o" aria-hidden="true"></i>
                <p class="counter"><?php echo $happy; ?></p> 
                <span></span>
                  <h5>Happy Client</h5>
              </div>
              <div class="col-md-4 agileits_w3layouts_about_counter_left c2 count-grid">
                <i class="fa fa-building-o" aria-hidden="true"></i>
                <p class="counter"><?php echo $place; ?></p> 
                <span></span>
                  <h5>Real Estate</h5>
              </div>
              <div class="col-md-4 agileits_w3layouts_about_counter_left c3 count-grid">
                <i class="fa fa-users" aria-hidden="true"></i>
                <p class="counter"><?php echo $client; ?></p>
                <span></span>
                  <h5>Site members</h5>
              </div>
            <div class="clearfix"></div>
          </div>
        </div>
			</div>
		<!--count-->
    <!-- Start Content -->      
		<!-- gallery -->
			<div class="gallery" id="gallery">
				<div class="container">
					<div class="wthree-tittle">
							<h3 class="agile_title one">Properties</h3>
						<p class="w3l-agile-its-title">Find a Good One</p>
					</div>
					<div class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">
							<!-- Tabbed Category -->
							<ul id="myTab" class="nav nav-tabs" role="tablist">
								<li role="presentation" class="active"><a href="#home-main" id="home-tab" role="tab" data-toggle="tab" aria-controls="home-main" aria-expanded="true">All</a></li>
								<li role="presentation"><a href="#1" role="tab" id="learning-tab" data-toggle="tab" aria-controls="1">Jenis 1</a></li>
								<li role="presentation"><a href="#2" role="tab" id="playing-tab" data-toggle="tab" aria-controls="2">Jenis 2</a></li>
								<li role="presentation"><a href="#3" role="tab" id="painting-tab" data-toggle="tab" aria-controls="3">Jenis 3</a></li>
							</ul>
							<!-- Content List Data -->
							<div id="myTabContent" class="tab-content">
								<?php
									//Mencari Rumah
									$kns = new DB_con();
									$rumahmakan = array();
									$result = $kns->OpenCon()->query("SELECT * FROM tbl_rumah A");
									while($data = $result->fetch_array(MYSQLI_ASSOC)){
										$item = array(
											"id" => $data['rumah_id'],
											"name" => $data['rumah_name'],
											"jenis" => $data['jenis'],
											"ukuran" => $data['ukuran'],
											"photo" => $data['rumah_photo'],
											"harga" => $data['harga']
										);
										array_push($rumahmakan,$item);
									}
								?>
								<div role="tabpanel" class="tab-pane fade in active" id="home-main" aria-labelledby="home-tab">
									<div class="w3_tab_img">
										<?php
											$n = count($rumahmakan);
											for($i=0;$i<$n;$i++){
												if(isset($rumahmakan[$i]['photo']) AND $rumahmakan[$i]['photo']<>""){
													$path=$rumahmakan[$i]['photo'];
												}
												else{
													$path="images/no_image.png";
												}
												echo "
												<div class=\"col-sm-3 w3_tab_img_left\">
													<div class=\"demo\">
														<a class=\"cm-overlay\" href=\"$path\">
															<figure class=\"imghvr-shutter-in-out-diag-2\"><img src=\"$path\" alt=\" \" class=\"img-responsive\" height='229' />
															</figure>
														</a>
													</div>
													<div class=\"agile-gallery-info\">
														<h6>".$rumahmakan[$i]['name']." ( <b>".$rumahmakan[$i]['ukuran']."</b> )</h6>
														<h6>Rp.".number_format($rumahmakan[$i]['harga'],2,",",".")."</h6>
													</div>
												</div>";
											}
										?>
										<div class="clearfix"> </div>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane fade" id="1" aria-labelledby="learning-tab">
									<div class="w3_tab_img">
									<?php
											$n = count($rumahmakan);
											for($i=0;$i<$n;$i++){
												if(isset($rumahmakan[$i]['photo']) AND $rumahmakan[$i]['photo']<>""){
													$path=$rumahmakan[$i]['photo'];
												}
												else{
													$path="images/no_image.png";
												}
												if($rumahmakan[$i]['jenis']=="1"){
													echo "
													<div class=\"col-sm-3 w3_tab_img_left\">
														<div class=\"demo\">
															<a class=\"cm-overlay\" href=\"$path\">
																<figure class=\"imghvr-shutter-in-out-diag-2\"><img src=\"$path\" alt=\" \" class=\"img-responsive\" />
																</figure>
															</a>
														</div>
														<div class=\"agile-gallery-info\">
															<h6>".$rumahmakan[$i]['name']." ( <b>".$rumahmakan[$i]['ukuran']."</b> )</h6>
                              <h6>Rp.".number_format($rumahmakan[$i]['harga'],2,",",".")."</h6>
														</div>
													</div>";
												}
											}
										?>
										<div class="clearfix"> </div>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane fade" id="2" aria-labelledby="playing-tab">
									<div class="w3_tab_img">
									<?php
											$n = count($rumahmakan);
											for($i=0;$i<$n;$i++){
												if(isset($rumahmakan[$i]['photo']) AND $rumahmakan[$i]['photo']<>""){
													$path=$rumahmakan[$i]['photo'];
												}
												else{
													$path="images/no_image.png";
												}
												if($rumahmakan[$i]['jenis']=="2"){
													echo "
													<div class=\"col-sm-3 w3_tab_img_left\">
														<div class=\"demo\">
															<a class=\"cm-overlay\" href=\"$path\">
																<figure class=\"imghvr-shutter-in-out-diag-2\"><img src=\"$path\" alt=\" \" class=\"img-responsive\" />
																</figure>
															</a>
														</div>
														<div class=\"agile-gallery-info\">
															<h6>".$rumahmakan[$i]['name']." ( <b>".$rumahmakan[$i]['ukuran']."</b> )</h6>
                              <h6>Rp.".number_format($rumahmakan[$i]['harga'],2,",",".")."</h6>
														</div>
													</div>";
												}
											}
										?>
										<div class="clearfix"> </div>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane fade" id="3" aria-labelledby="painting-tab">
									<div class="w3_tab_img">
									<?php
											$n = count($rumahmakan);
											for($i=0;$i<$n;$i++){
												if(isset($rumahmakan[$i]['photo']) AND $rumahmakan[$i]['photo']<>""){
													$path=$rumahmakan[$i]['photo'];
												}
												else{
													$path="images/no_image.png";
												}
												if($rumahmakan[$i]['jenis']=="3"){
													echo "
													<div class=\"col-sm-3 w3_tab_img_left\">
														<div class=\"demo\">
															<a class=\"cm-overlay\" href=\"$path\">
																<figure class=\"imghvr-shutter-in-out-diag-2\"><img src=\"$path\" alt=\" \" class=\"img-responsive\" />
																</figure>
															</a>
														</div>
														<div class=\"agile-gallery-info\">
															<h6>".$rumahmakan[$i]['name']." ( <b>".$rumahmakan[$i]['ukuran']."</b> )</h6>
                              <h6>Rp.".number_format($rumahmakan[$i]['harga'],2,",",".")."</h6>
														</div>
													</div>";
                        }
											}
										?>
										<div class="clearfix"> </div>
									</div>
								</div>
							</div>
					</div>
				
				</div>
			</div>
		<!-- //gallery -->
    <!-- End Content -->
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
  </body>
</html>