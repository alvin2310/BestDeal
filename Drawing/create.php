<?php
  session_start();
  include('../config.php');
  include_once './auth.php';
  $user = new Auth();

  if (isset($_POST['save'])) {
    extract($_POST);
    $rmID = isset($_GET['rumah_id']) ? $_GET['rumah_id'] : 0;
    $uid = $_SESSION['user_id'];
    $create = $user->saveRumah($rmID,$rumah_name,$alamat,$ukuran,$harga,$qtysemen,$qtypasir,$qtybata,$uid);
		if ($create) {
        echo "<script type='text/javascript'>
          alert('Data telah terupdate !');
          window.location = './index.php';
        </script>";
				//header("Location: ../index.php");
		} else {
				echo "<script>alert('Something Wrong / ID / Username already exists');</script>";
		}
  }
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Design the House</title>
  
  <!-- Favicon  -->
  <link rel="icon" href="../favicon.ico">
  <!-- //for-mobile-apps -->
  <link href="../css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
  <link rel="stylesheet" href="../css/cm-overlay.css">
  <link href="../css/style.css" rel="stylesheet" type="text/css" media="all" />
  <!-- font-awesome icons -->
  <link href="../css/font-awesome.css" rel="stylesheet"> 
  <!-- //font-awesome icons -->

  <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <style>
		table td {
			width: 1024px;
			height: 720px;
		}
		#draggable { 
			width: 50px; 
			height: 50px;
			margin: 10px;
		}
		.dropzone {
      background-image: url("gfx/toggle-grid.png");
      background-repeat: repeat;
			width: 100%;
			height: 100%;
		}
		.tools{
			width: 30%;
    }
    .ui-widget-room {
      border: 2px solid black;
    }
    .ui-widget-wc {
      background-color: #e1f3fe;
      border: 2px solid black;
    }
		p {
			text-align: center;
		}
  </style>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

  <script type="text/javascript">
    $(document).on("mouseover","div.tool-master", function(event){
      $( ".tool-master" ).draggable({ 
        revert: "valid",
        //helper: "clone",
        cursor: "move",
      });
      
      $( ".dropzone" ).droppable({
        accept: ".tool-master",
        drop: function( event, ui ) {
          var $item = ui.draggable.clone();
          var itemType = $item.find("p").text();

          var jenis1 = $("#jenis_semen").val();
          var jenis2 = $("#jenis_pasir").val();
          var jenis3 = $("#jenis_bata").val();
          
          if(itemType=="Tanah"){
            $item.css("width",300);
            $item.css("height",480);
            $item.removeClass("tool-master");
            $item.attr("id",itemType);
            $item.css("z-index",2);
            var tWid = parseInt($item.width());
            var tHei = parseInt($item.height());
            var t = "P:"+((tHei/40).toFixed(1)).replace('.0','')+"m <br />L:"+((tWid/60).toFixed(1)).replace('.0','')+"m";
            $item
              .find("p")
              .html(t);
            var hargaTanah = ((tHei/40)*(tWid/60)) * 1000000; //$("#hargatanah").val();
            tWid = tWid/60;
            tHei = tHei/40;
            $("#hargatanah").val(hargaTanah);
            $("#ukuran").val((parseInt(tWid))+" x "+(parseInt(tHei)));
            var pl = (tWid)*(tHei);
            var pt = (tHei)*2.8;
            var lt = (tWid)*2.8;
            var luas = 2*(pl+pt+lt);
            var semen = Math.round((luas*9.68));
            var pasir = Math.round((luas*0.045));
            var jlhBata = luas;

            if(jenis1=="1" || jenis1=="4"){
              semen = Math.round(semen/50);
            } else {
              semen = Math.round(semen/40);
            }
            if(jenis3=="4" || jenis3=="5"){
              jlhBata = Math.round(jlhBata*0.045);
            } else {
              jlhBata = Math.round(jlhBata*36);
            }
            $("#semen1").val(semen);
            $("#pasir1").val(pasir);
            $("#bata1").val(jlhBata);
          } else if(itemType=="Room"){
            $item.css("width",160);
            $item.css("height",160);
            $item.removeClass("tool-master");
            $item.attr("id",itemType);
            $item.css("z-index",3);
            var tWid = parseInt($item.width());
            var tHei = parseInt($item.height());
            var t = "P:"+((tHei/40).toFixed(1)).replace('.0','')+"m <br />L:"+((tWid/40).toFixed(1)).replace('.0','')+"m";
            $item
              .find("p")
              .html(t);
            tWid = tWid/40;
            tHei = tHei/40;

            var pl = (tWid)*(tHei);
            var pt = (tHei)*2.8;
            var lt = (tWid)*2.8;
            var luas = 2*(pl+pt+lt);
            var semen = Math.round((luas*9.68));
            var pasir = Math.round((luas*0.045));
            var jlhBata = luas;

            if(jenis1=="1" || jenis1=="4"){
              semen = Math.round(semen/50);
            } else {
              semen = Math.round(semen/40);
            }
            if(jenis3=="4" || jenis3=="5"){
              jlhBata = Math.round(jlhBata*0.045);
            } else {
              jlhBata = Math.round(jlhBata*36);
            }
            $("#semen2").val(semen);
            $("#pasir2").val(pasir);
            $("#bata2").val(jlhBata);
          } else if(itemType=="WC"){
            $item.css("width",80);
            $item.css("height",80);
            $item.removeClass("tool-master");
            $item.attr("id",itemType);
            $item.css("z-index",3);
            var tWid = parseInt($item.width());
            var tHei = parseInt($item.height());
            var t = "P:"+((tHei/40).toFixed(1)).replace('.0','')+"m <br />L:"+((tWid/40).toFixed(1)).replace('.0','')+"m";
            $item
              .find("p")
              .html(t);
            tWid = tWid/40;
            tHei = tHei/40;

            var pl = (tWid)*(tHei);
            var pt = (tHei)*2.8;
            var lt = (tWid)*2.8;
            var luas = 2*(pl+pt+lt);
            var semen = Math.round((luas*9.68));
            var pasir = Math.round((luas*0.045));
            var jlhBata = luas;

            if(jenis1=="1" || jenis1=="4"){
              semen = Math.round(semen/50);
            } else {
              semen = Math.round(semen/40);
            }
            if(jenis3=="4" || jenis3=="5"){
              jlhBata = Math.round(jlhBata*0.045);
            } else {
              jlhBata = Math.round(jlhBata*36);
            }
            $("#semen3").val(semen);
            $("#pasir3").val(pasir);
            $("#bata3").val(jlhBata);
          } else {
            $item.removeClass("ui-widget-content tool-master");
            $item.attr("id",itemType);
            $item.css("z-index",4);
            var tWid = parseInt($item.width());
            var tHei = parseInt($item.height());
            tWid = tWid/40;
            tHei = tHei/40;
          }
          $item.addClass("item-child");

          $(this).append($item);
          $item.css("position","absolute");
          if(parseInt($item.css('top'))<0){
            var cur = parseInt($item.css('top'))*-1;
            var selisih = 66 - cur;
            //alert("The Top is "+(cur+selisih) );
            $item.css("top",(cur+selisih) );
          } else if(parseInt($item.css('top'))>0 && parseInt($item.css('top'))<66){
            var selisih = 66 - parseInt($item.css('top'));
            //alert("The Top is "+(parseInt($item.css('top'))+selisih));
            $item.css("top",(parseInt($item.css('top'))+selisih) );
          }
          var totalharga = $("#harga").val();
          var hargaTanah = $("#hargatanah").val();

          var totalSemen = parseInt($("#semen1").val()) + parseInt($("#semen2").val()) + parseInt($("#semen3").val());
          var totalPasir = parseInt($("#pasir1").val()) + parseInt($("#pasir2").val()) + parseInt($("#pasir3").val());
          var totalBata = parseInt($("#bata1").val()) + parseInt($("#bata2").val()) + parseInt($("#bata3").val());

          $("#qtysemen").val(totalSemen);
          $("#qtypasir").val(totalPasir);
          $("#qtybata").val(totalBata);

          $.ajax({
            type: 'POST',
            url: 'getPrice.php',
            data: 'jenis_1='+jenis1+'&semen='+totalSemen+'&jenis_2='+jenis2+'&pasir='+totalPasir+'&jenis_3='+jenis3+'&bata='+totalBata,
            dataType: 'json',
            success : function(data) {
              if (data.status == 'ok') {
                $("#harga").val(parseInt(data.totalHarga));
                  var grandTotal = parseInt($("#harga").val()) + parseInt(hargaTanah);
                  $("#totalHarga").val(grandTotal);
              }else{
                alert('Some problem occured, please try again.');
              }
            }
          });
        }
      });
    });
	</script>
</head>
<body>
  <div class="col-lg-12">
    <table border="1">
      </tr>
        <th>Tools</th>
        <th>Canvas</th>
      </tr>
      <tr>
        <td class="tools">
          <div id="draggable" class="ui-widget-content tool-master" name="tanah">
            <p>Tanah</p>
          </div>
          <div id="draggable" class="ui-widget-content tool-master" name="door-pull">
            <img src="gfx/items-door-01.png" alt="Door Tarik" width="50" height="50" />
          </div>
          <div id="draggable" class="ui-widget-content tool-master" name="door-push">
            <img src="gfx/items-door-02.png" alt="Door Dorong" width="50" height="50" />
          </div>
          <!-- <div id="draggable" class="ui-widget-content tool-master" name="jendela-v">
            <img src="gfx/Window_V.png" alt="Jendela Vertical" width="50" height="50" />
          </div>
          <div id="draggable" class="ui-widget-content tool-master" name="jendela-h">
            <img src="gfx/Window_H.png" alt="Jendela Horizontal" width="50" height="50" />
          </div> -->
          <div id="draggable" class="ui-widget-room tool-master" name="room">
            <p>Room</p>
          </div>
          <div id="draggable" class="ui-widget-wc tool-master" name="wc">
            <p>WC</p>
          </div>
        </td>
        <td id="canvas" class="canvas">
          <div id="d1" class="dropzone">
          </div>
        </td>
      </tr>
    </table>
    <script type="text/javascript">
      $(document).on("mouseover","div.item-child", function(event){
        var itemType = $(this).attr("name");

        var jenis1 = $("#jenis_semen").val();
        var jenis2 = $("#jenis_pasir").val();
        var jenis3 = $("#jenis_bata").val();

        $(this).draggable({
          cursor: "move",
          containment: ".dropzone"
        });
        $(this).resizable({
          grid: 1,
          containment: ".dropzone"
        });
        $(this).resize(function() {
          var tWid = parseInt($(this).css("width"));
          var tHei = parseInt($(this).css("height"));
          var hargaTanah = $("#hargatanah").val();
          var t = "P:"+((tHei/40).toFixed(1)).replace('.0','')+"m <br />L:"+((tWid/60).toFixed(1)).replace('.0','')+"m";
          $(this)
            .find("p")
            .html(t);
          if(itemType=="tanah"){
            var hargaTanah = ((tHei/40)*(tWid/60)) * 1000000;
            $("#hargatanah").val(hargaTanah);

            var pl = (tWid/60)*(tHei/40);
            var pt = (tHei/40)*2.8;
            var lt = (tWid/60)*2.8;
            var luas = 2*(pl+pt+lt);

            var semen = Math.round((luas*9.68));
            var pasir = Math.round((luas*0.045));
            var jlhBata = luas;

            if(jenis1=="1" || jenis1=="4"){
              semen = Math.round(semen/50);
            } else {
              semen = Math.round(semen/40);
            }
            if(jenis3=="4" || jenis3=="5"){
              jlhBata = Math.round(jlhBata*0.045);
            } else {
              jlhBata = Math.round(jlhBata*36);
            }
            $("#semen1").val(semen);
            $("#pasir1").val(pasir);
            $("#bata1").val(jlhBata);
            var ukuran = ((tWid/60).toFixed(1)).replace('.0','') + " x " + ((tHei/40).toFixed(1)).replace('.0','');
            $("#ukuran").val(ukuran);
          } else if (itemType=="room") {
            var pl = (tWid/40)*(tHei/40);
            var pt = (tHei/40)*2.8;
            var lt = (tWid/40)*2.8;
            var luas = 2*(pl+pt+lt);

            var semen = Math.round((luas*9.68));
            var pasir = Math.round((luas*0.045));
            var jlhBata = luas;

            if(jenis1=="1" || jenis1=="4"){
              semen = Math.round(semen/50);
            } else {
              semen = Math.round(semen/40);
            }
            if(jenis3=="4" || jenis3=="5"){
              jlhBata = Math.round(jlhBata*0.045);
            } else {
              jlhBata = Math.round(jlhBata*36);
            }
            $("#semen2").val(semen);
            $("#pasir2").val(pasir);
            $("#bata2").val(jlhBata);
          } else if (itemType=="wc") {
            var pl = (tWid/40)*(tHei/40);
            var pt = (tHei/40)*2.8;
            var lt = (tWid/40)*2.8;
            var luas = 2*(pl+pt+lt);

            var semen = Math.round((luas*9.68));
            var pasir = Math.round((luas*0.045));
            var jlhBata = luas;

            if(jenis1=="1" || jenis1=="4"){
              semen = Math.round(semen/50);
            } else {
              semen = Math.round(semen/40);
            }
            if(jenis3=="4" || jenis3=="5"){
              jlhBata = Math.round(jlhBata*0.045);
            } else {
              jlhBata = Math.round(jlhBata*36);
            }
            $("#semen3").val(semen);
            $("#pasir3").val(pasir);
            $("#bata3").val(jlhBata);
          }
          /* else {
            var totalharga = $("#harga").val();
            var pl = (tWid/40)*(tHei/40);
            var pt = (tHei/40)*2.8;
            var lt = (tWid/40)*2.8;
            var luas = 2*(pl+pt+lt);

            var semen = luas*9.68;
            var pasir = Math.round((luas*0.045));
            var jlhBata = Math.round(luas * 36);

            if(jenis1=="1" || jenis1=="4"){
              semen = Math.round(semen/50);
            } else {
              semen = Math.round(semen/40);
            }
            if(jenis3=="4" || jenis3=="5"){
              jlhBata = Math.round(luas*0.045);
            }

            var old_1 = $("#qtysemen").val();
            var old_2 = $("#qtypasir").val();
            var old_3 = $("#qtybata").val();

            $("#qtysemen").val(parseInt(old_1)-parseInt(semen));
            $("#qtypasir").val(parseInt(old_2)-parseInt(pasir));
            $("#qtybata").val(parseInt(old_3)-parseInt(jlhBata));
            
            var old_harga = $("#totalHarga").val();
            $.ajax({
              type: 'POST',
              url: 'getPrice.php',
              data: 'jenis_1='+jenis1+'&semen='+semen+'&jenis_2='+jenis2+'&pasir='+pasir+'&jenis_3='+jenis3+'&bata='+jlhBata,
              dataType: 'json',
              success : function(data) {
                if (data.status == 'ok') {
                  $("#harga").val(parseInt(old_harga)-parseInt(totalharga)+parseInt(data.totalHarga));
                  var grandTotal = parseInt($("#harga").val()) + parseInt(hargaTanah);
                  $("#totalHarga").val(grandTotal);
                }else{
                  alert('Some problem occured, please try again.');
                }
              }
            });
          } */

          var totalharga = $("#harga").val();
          var hargaTanah = $("#hargatanah").val();

          var totalSemen = parseInt($("#semen1").val()) + parseInt($("#semen2").val()) + parseInt($("#semen3").val());
          var totalPasir = parseInt($("#pasir1").val()) + parseInt($("#pasir2").val()) + parseInt($("#pasir3").val());
          var totalBata = parseInt($("#bata1").val()) + parseInt($("#bata2").val()) + parseInt($("#bata3").val());

          $("#qtysemen").val(totalSemen);
          $("#qtypasir").val(totalPasir);
          $("#qtybata").val(totalBata);

          $.ajax({
            type: 'POST',
            url: 'getPrice.php',
            data: 'jenis_1='+jenis1+'&semen='+totalSemen+'&jenis_2='+jenis2+'&pasir='+totalPasir+'&jenis_3='+jenis3+'&bata='+totalBata,
            dataType: 'json',
            success : function(data) {
              if (data.status == 'ok') {
                $("#harga").val(parseInt(data.totalHarga));
                  var grandTotal = parseInt($("#harga").val()) + parseInt(hargaTanah);
                  $("#totalHarga").val(grandTotal);
              }else{
                alert('Some problem occured, please try again.');
              }
            }
          });

        });
      });
    </script>
  </div>
  <div class="col-lg-12">
    <br />
    <label class="control-label">NB:</label>
    <ul>
      <li>Ukuran denah 6:4 secara Default Tanah dalam meter : 5 x 12</li>
      <li>Jenis Pintu ada 2 Dorong dan tarik</li>
      <li>Ukuran Ruangan dan kamar Mandi 4:4 secara Default Ruangan dalam meter : 4 x 4</li>
    </ul>
    <hr />
    <script type="text/javascript" src="./js/html2canvas.js"></script>
    <button id="btn-success" class="btn btn-success">Set</button>
    <button id="btn-clear" class="btn btn-danger">Clear</button>
    <button id="btn-exit" class="btn btn-info">Keluar</button>
    <hr />
  </div>
  <?php
    if(isset($_GET['rumah_id'])){
      $rumahID = $_GET['rumah_id'];
      $userID = $_SESSION['user_id'];
  
      $kns = new DB_con();
      $query="SELECT rumah_name,jenis,ukuran,harga,
      CASE WHEN alamat IS NULL THEN '' ELSE alamat END alamat,
      CASE WHEN rumah_photo IS NULL THEN '../images/no_image.png' ELSE rumah_photo END rumah_photo,
      CASE WHEN rumah_description IS NULL THEN '' ELSE rumah_description END rumah_description FROM tbl_rumah WHERE rumah_id=$rumahID AND user_id=$userID";
      //echo $query;
      $result = $kns->OpenCon()->query($query);
      $item = $result->fetch_assoc();
    }
  ?>
  <form method="post" name="form">
    <div class="form-row">
      <div class="form-group col-md-3">
        <label class="control-label">Rumah Type</label>
        <input type="text" class="form-control" id="rumah_name" name="rumah_name" <?php if(isset($_GET['rumah_id'])){ echo "readonly value=\"".$item['rumah_name']."\""; } ?> />
      </div>
      <div class="form-group col-md-6">
        <label class="control-label">Alamat</label>
        <input type="text" class="form-control" id="alamat" name="alamat" required value="<?php if(isset($_GET['rumah_id'])){ echo $item['alamat']; } ?>" />
      </div>
      <div class="form-group col-md-3">
        <label class="control-label">Ukuran</label>
        <input type="text" class="form-control" id="ukuran" name="ukuran" readonly value="<?php if(isset($_GET['rumah_id'])){ echo $item['ukuran']; } ?>" />
      </div>
      <div class="form-group col-md-3">
        <label class="control-label">Harga Tanah</label>
        <input type="text" class="form-control" id="hargatanah" name="hargatanah" value=0 readonly />
      </div>
      <div class="form-group col-md-3">
        <label class="control-label">Harga Bahan</label>
        <input type="text" class="form-control" id="harga" name="harga" value=0 readonly />
      </div>
      <div class="form-group col-md-3">
        <label class="control-label">Total Jual</label>
        <input type="text" class="form-control" id="totalHarga" name="totalHarga" required value="<?php if(isset($_GET['rumah_id'])){ echo number_format($item['harga'],0,",","."); } ?>" />
      </div>
      <div class="form-group col-md-6">
        <button type="submit" name="save" id="save" class="btn btn-primary">Save</button>
      </div>
    </div>
    <div class="col-lg-12">
      <label class="control-label">Detail Bahan</label>
    </div>
    <div class="col-md-3">
      <label class="control-label">Jenis Semen</label>
      <select class="form-control" id="jenis_semen" name="jenis_semen">
        <option value="1" selected>Semen Tiga Roda 50kg</option>
        <option value="2">Semen Gresik 40kg</option>
        <option value="3">Semen Holcim 40kg</option>
        <option value="4">Semen Holcim 50kg</option>
        <option value="5">Semen Padang 40kg</option>
      </select>
      <label class="control-label">Semen</label>
      <input type="hidden" class="form-control" id="semen1" name="semen1" value=0 readonly />
      <input type="hidden" class="form-control" id="semen2" name="semen2" value=0 readonly />
      <input type="hidden" class="form-control" id="semen3" name="semen3" value=0 readonly />
      <input type="text" class="form-control" id="qtysemen" name="qtysemen" placeholder="Jlh Semen" value=0 readonly />
    </div>
    <div class="col-md-3">
      <label class="control-label">Jenis Pasir</label>
      <select class="form-control" id="jenis_pasir" name="jenis_pasir">
        <option value="23">Pasir Beton / M3</option>
        <option value="24" selected>Pasir Biasa / M3</option>
        <option value="25">Pasir Mundu / M3</option>
      </select>
      <label class="control-label">Pasir</label>
      <input type="hidden" class="form-control" id="pasir1" name="pasir1" value=0 readonly />
      <input type="hidden" class="form-control" id="pasir2" name="pasir2" value=0 readonly />
      <input type="hidden" class="form-control" id="pasir3" name="pasir3" value=0 readonly />
      <input type="text" class="form-control" id="qtypasir" name="qtypasir" placeholder="Jlh Pasir" value=0 readonly />
    </div>
    <div class="col-md-3">
      <label class="control-label">Jenis Bata</label>
      <select class="form-control" id="jenis_bata" name="jenis_bata">
        <option value="6" selected>Batu Bata / Biji</option>
        <option value="7">Batu Bata Jumbo / Biji</option>
        <option value="8">Batako / Biji</option>
        <option value="9">Batu Kali / M3</option>
        <option value="10">Batu Koral / M3</option>
      </select>
      <label class="control-label">Batu Bata</label>
      <input type="hidden" class="form-control" id="bata1" name="bata1" value=0 readonly />
      <input type="hidden" class="form-control" id="bata2" name="bata2" value=0 readonly />
      <input type="hidden" class="form-control" id="bata3" name="bata3" value=0 readonly />
      <input type="text" class="form-control" id="qtybata" name="qtybata" placeholder="Jlh Bata" value=0 readonly />
    </div>
  </form>
  <script>
    $('#btn-success').click(function(){
      var filename = $("#rumah_name").val();
      if(filename==null || filename==""){
        alert("Isi tipe rumah terlebih dahulu !"+filename);
      } else {
        html2canvas(document.querySelector('#canvas')).then(function(canvas) {
        console.log(canvas);
        saveAs(canvas.toDataURL(), filename+'.png');
        });
      }
    });
    function saveAs(uri, filename) {
      var link = document.createElement('a');
      if (typeof link.download === 'string') {
          link.href = uri;
          link.download = filename;
          //Firefox requires the link to be in the body
          document.body.appendChild(link);
          //simulate click
          link.click();
          //remove the link when done
          document.body.removeChild(link);
      } else {
          window.open(uri);
      }
    }
  </script>
  <script>
    $("#jenis_semen").change(function(){
      var jenis1 = $("#jenis_semen").val();
      var jenis2 = $("#jenis_pasir").val();
      var jenis3 = $("#jenis_bata").val();

      var semen = $("#qtysemen").val();
      var pasir = $("#qtypasir").val();
      var jlhBata = $("#qtybata").val();
      var hargaTanah = $("#hargatanah").val();
      $.ajax({
        type: 'POST',
        url: 'getPrice.php',
        data: 'jenis_1='+jenis1+'&semen='+semen+'&jenis_2='+jenis2+'&pasir='+pasir+'&jenis_3='+jenis3+'&bata='+jlhBata,
        dataType: 'json',
        success : function(data) {
          if (data.status == 'ok') {
            $("#harga").val(parseInt(data.totalHarga));
            var grandTotal = parseInt($("#harga").val()) + parseInt(hargaTanah);
            $("#totalHarga").val(grandTotal);
          }else{
            alert('Some problem occured, please try again.');
          }
        }
      });
    });
    $("#jenis_pasir").change(function(){
      var jenis1 = $("#jenis_semen").val();
      var jenis2 = $("#jenis_pasir").val();
      var jenis3 = $("#jenis_bata").val();

      var semen = $("#qtysemen").val();
      var pasir = $("#qtypasir").val();
      var jlhBata = $("#qtybata").val();
      var hargaTanah = $("#hargatanah").val();
      $.ajax({
        type: 'POST',
        url: 'getPrice.php',
        data: 'jenis_1='+jenis1+'&semen='+semen+'&jenis_2='+jenis2+'&pasir='+pasir+'&jenis_3='+jenis3+'&bata='+jlhBata,
        dataType: 'json',
        success : function(data) {
          if (data.status == 'ok') {
            $("#harga").val(parseInt(data.totalHarga));
            var grandTotal = parseInt($("#harga").val()) + parseInt(hargaTanah);
            $("#totalHarga").val(grandTotal);
          }else{
            alert('Some problem occured, please try again.');
          }
        }
      });
    });
    $("#jenis_bata").change(function(){
      var jenis1 = $("#jenis_semen").val();
      var jenis2 = $("#jenis_pasir").val();
      var jenis3 = $("#jenis_bata").val();

      var semen = $("#qtysemen").val();
      var pasir = $("#qtypasir").val();
      var jlhBata = $("#qtybata").val();
      var hargaTanah = $("#hargatanah").val();
      $.ajax({
        type: 'POST',
        url: 'getPrice.php',
        data: 'jenis_1='+jenis1+'&semen='+semen+'&jenis_2='+jenis2+'&pasir='+pasir+'&jenis_3='+jenis3+'&bata='+jlhBata,
        dataType: 'json',
        success : function(data) {
          if (data.status == 'ok') {
            $("#harga").val(parseInt(data.totalHarga));
            var grandTotal = parseInt($("#harga").val()) + parseInt(hargaTanah);
            $("#totalHarga").val(grandTotal);
          }else{
            alert('Some problem occured, please try again.');
          }
        }
      });
    });
    $("#btn-clear").click(function() {
      $( ".dropzone" ).html("");
      $("#hargatanah").val(0);
      $("#harga").val(0);
      $("#totalHarga").val(0);

      $("#qtysemen").val(0);
      $("#qtypasir").val(0);
      $("#qtybata").val(0);
    });
    $("#btn-exit").click(function() {
      window.location = "./index.php";
    });
    /* $("#addTingkat").click(function(event){
      var tingkat = [];
      $("#tingkat option").each(function()
      {
        tingkat.push($(this).val());
      });
      var addNew = tingkat.length + 1;
      $("#tingkat").append("<option value='"+addNew+"'>"+addNew+"</option>");
      $("#tingkat").val(addNew);
      $(".canvas").append('<div id="d'+addNew+'" class="dropzone"></div>');
    });
    $("#removeTingkat").click(function(event){
      var tingkat = [];
      $("#tingkat option").each(function()
      {
        tingkat.push($(this).val());
      });
      var selected = $("#tingkat").val();
      var end = tingkat.length;
      if(selected==end){
        $("#tingkat").children('option:selected').remove();
        tingkat.pop();
        $("#tingkat").val(tingkat.length);
        $("#d"+selected).remove();
      } else {
        alert("Buang dari tingkat paling tinggi !");
      }
    }); */
  </script>
  <!-- <div class="col-md-2">
    <label class="control-label">Jumlah Tingkat</label>
  </div>
  <div class="col-md-1">
    <select class="form-control" tabindex="-1" id="tingkat" name="tingkat">
      <option value="1">1</option>
    </select>
  </div>
  <div class="col-md-2">
    <button id="addTingkat" class="btn btn-block btn-info">Tambah Tingkat</button>
  </div>
  <div class="col-xs-2">
    <button id="removeTingkat" class="btn btn-block btn-danger">Remove <i class="fa fa-minus"></i></button>
  </div> -->
</body>
</html>