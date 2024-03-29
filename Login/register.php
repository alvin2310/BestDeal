<?php
  session_start();
  include('../config.php');
  include_once './auth.php';
  $user = new Auth();

  if (isset($_POST['login'])) {
		extract($_POST);
		$login = $user->AuthLogin($username, $password);
		if ($login) {
				header("Location: ../home.php");
		} else {
				echo "<script>alert('Wrong username or password');</script>";
		}
  }

  if (isset($_SESSION['user_id'])){
    header("Location: ../home.php");
  }

  if (isset($_POST['register'])) {
    extract($_POST);
    $register = $user->AuthRegis($username,$password,$firstname,$alamat,$kota,$provinsi,$email,$no_hp); //,$earn,$spent,$simpanan);
		if ($register) {
        echo "<script type='text/javascript'>
          alert('Registration Successfully please Login');
          window.location = '../index.php';
        </script>";
				//header("Location: ../index.php");
		} else {
				echo "<script>alert('Something Wrong / ID / Username already exists');</script>";
		}
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

    <script src="../js/jquery-2.2.3.min.js"></script>
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
              <h1><a class="navbar-brand" href="../index.php">Best <span>Deal</span><p class="logo_w3l_agile_caption">Find a Good One</p></a></h1>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-right" id="bs-example-navbar-collapse-1">
              <nav class="menu menu--iris">
                <ul class="nav navbar-nav menu__list">
                  <li class="menu__item"><a href="../index.php" class="menu__link">Home</a></li>
                  <li class="menu__item"><a href="../index.php#gallery" class="menu__link scroll">Gallery</a></li>
                  <li class="menu__item"><a href="./about.php" class="menu__link scroll">About Us</a></li>
                  <li class="menu__item"><a href="#" class="menu__link scroll" data-toggle="modal" data-target="#login-modal">Login</a></li>
                  <li class="menu__item menu__item--current"><a href="./register.php" class="menu__link scroll">Register</a></li>
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
    </div>
    <!-- gallery -->
			<div class="gallery" id="gallery">
				<div class="container">
					<div class="wthree-tittle">
							<h3 class="agile_title one">Register</h3>
						<p class="w3l-agile-its-title">Register User.</p>
					</div>
					<!-- Content List Data -->
					<div id="myTabContent" class="tab-content">
						<div role="tabpanel" class="tab-pane fade in active" id="home-main" aria-labelledby="home-tab">
							<div class="w3_tab_img">
                <form method="post" name="register">
                  <div class="form-group">
                    <label class="control-label">Username</label>
                    <input type="text" class="form-control" id="user_modal" name="username" placeholder="username" autocomplete="off" maxlength="20" required>
                  </div>
                  <div class="form-group">
                    <label class="control-label">First Name</label>
                    <input type="text" class="form-control" id="first_modal" name="firstname" placeholder="First Name" autocomplete="off" maxlength="20" required>
                  </div>
                  <div class="form-group">
                    <label class="control-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="password" minlength="3" maxlength="16" required>
                  </div>
                  <div class="form-group">
                    <label class="control-label">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="confirm password" minlength="3" maxlength="16" required>
                    <span id='message'></span>
                  </div>
                  <div class="form-group">
                    <label class="control-label">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="5" required></textarea>
                  </div>
                  <div class="form-group">
                    <label class="control-label">Kota</label>
                    <input type="text" class="form-control" id="kota" name="kota" placeholder="Kota" autocomplete="off" maxlength="20" required>
                  </div>
                  <div class="form-group">
                    <label class="control-label">Provinsi</label>
                    <input type="text" class="form-control" id="provinsi" name="provinsi" placeholder="Provinsi" autocomplete="off" maxlength="20" required>
                  </div>
                  <div class="form-group">
                    <label class="control-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" autocomplete="off" required>
                  </div>
                  <div class="form-group">
                    <label class="control-label">No Hp</label>
                    <input type="text" class="form-control" id="no_hp" name="no_hp" placeholder="No Hp" minlength="10" maxlength="12" onkeypress="return fun_AllowOnlyAmountAndDot(this.id);" required>
                  </div>
                  <!-- <div class="form-group">
                    <input type="number" class="form-control" id="earn" name="earn" placeholder="User Earn" autocomplete="off" maxlength="20" required>
                  </div>
                  <div class="form-group">
                    <input type="number" class="form-control" id="spent" name="spent" placeholder="User Spent" autocomplete="off" maxlength="20" required>
                  </div>
                  <div class="form-group">
                    <input type="number" class="form-control" id="simpanan" name="simpanan" placeholder="Simpanan" autocomplete="off" maxlength="20" required>
                  </div> -->
                  <p class="text-center">
                    <button type="submit" id="register" name="register" class="btn btn-info btn-lg" onclick="return(submitlogin());"><i class="fa fa-sign-in"></i> Register</button>
                  </p>
                </form>
							</div>
              <script type="text/javascript">
                function submitlogin() {
                  var form = document.register;
                  if (form.password.value != form.confirm_password.value) {
                    alert("Password did not match");
                    return false;
                  }
                }
                $('#password, #confirm_password').on('keyup', function () {
                  if ($('#password').val() == ""){
                    $('#message').html('Password can\'t be Empty').css('color', 'red');
                  } else if ($('#password').val() == $('#confirm_password').val()) {
                    $('#message').html('Matching').css('color', 'green');
                  }
                  else {
                    $('#message').html('Not Matching').css('color', 'red');
                  }
                });
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
              </script>
						</div>
					</div>
				</div>
			</div>
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