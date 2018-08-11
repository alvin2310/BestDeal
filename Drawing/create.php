<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Design the House</title>
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <!-- <link rel="stylesheet" href="/resources/demos/style.css"> -->
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
          //alert("Jenis Barang " + itemType);
          if(itemType=="Tanah"){
            $item.css("width",300);
            $item.css("height",480);
            $item.removeClass("tool-master");
            $item.attr("id",itemType);
            $item.css("z-index",2);
            var tWid = $item.width();
            var tHei = $item.height();
            var t = "P:"+tHei+" <br />L:"+tWid;
            $item
              .find("p")
              .html(t);
          } else if(itemType=="Room" || itemType=="WC"){
            $item.css("width",160);
            $item.css("height",160);
            $item.removeClass("tool-master");
            $item.attr("id",itemType);
            $item.css("z-index",3);
          } else {
            $item.removeClass("ui-widget-content tool-master");
            $item.attr("id",itemType);
            $item.css("z-index",4);
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
          
          var hargaJual = $("#hargaJual").val();
          var pl = (parseInt(300)/60)*(parseInt(480)/40);
          var pt = (parseInt(480)/40)*2.8;
          var lt = (parseInt(300)/60)*2.8;
          var luas = 2*(pl+pt+lt);
          var semen = Math.round((luas*9.68)/50);
          var pasir = Math.round((luas*0.045));
          $.ajax({
            type: 'POST',
            url: 'getPrice.php',
            data: 'semen='+semen+'&pasir='+pasir,
            dataType: 'json',
            success : function(data) {
              if (data.status == 'ok') {
                $("#harga").val(data.totalHarga);
                $("#totalHarga").val(parseInt(hargaJual)+parseInt(data.totalHarga));
                $("#ukuran").val((parseInt(300)/60)+" x "+(parseInt(480)/40));
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
  <form method="post">
    <label class="control-label">Rumah Type</label>
    <input type="text" class="form-control" id="rumah_name" name="rumah_name" required />
    <label class="control-label">Alamat</label>
    <input type="text" class="form-control" id="alamat" name="alamat" required />
    <label class="control-label">Ukuran</label>
    <input type="text" class="form-control" id="ukuran" name="ukuran" required />
    <label class="control-label">Harga Modal</label>
    <input type="text" class="form-control" id="hargaJual" name="hargaJual" value=0 required />
    <label class="control-label">Harga Semen + Pasir</label>
    <input type="text" class="form-control" id="harga" name="harga" required />
    <label class="control-label">Total Jual</label>
    <input type="text" class="form-control" id="totalHarga" name="totalHarga" value=0 required />
    <label class="form-label">Upload Design:</label>
    <input type="file" name="photo_pict" class="filestyle" data-icon="false" accept="image/*">
    <button type="submit" name="save" class="btn btn-primary">Save</button>           
    <?php
      $user = $_SESSION['user_name'];
      if(isset($_POST['upload'])){
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
  </form>
  <div class="col-lg-12">
    <br>
    <label class="control-label">NB:</label>
    <ul>
      <li>Ukuran denah 6:4 secara Default Tanah dalam meter : 5 x 12</li>
      <li>Jenis Pintu ada 2 Dorong dan tarik</li>
      <li>Ukuran Ruangan dan kamar Mandi 4:4 secara Default Ruangan dalam meter : 4 x 4</li>
    </ul>
  </div>
  <div class="col-lg-12">
    <hr>
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
          <div id="draggable" class="ui-widget-content tool-master" name="jendela-v">
            <img src="gfx/Window_V.png" alt="Jendela Vertical" width="50" height="50" />
          </div>
          <div id="draggable" class="ui-widget-content tool-master" name="jendela-h">
            <img src="gfx/Window_H.png" alt="Jendela Horizontal" width="50" height="50" />
          </div>
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
        $(this).draggable({
          cursor: "move",
          containment: ".dropzone"
        });
        $(this).resizable({
          grid: 1,
          containment: ".dropzone"
        });
        $(this).resize(function() {
          var tWid = $(this).css("width");
          var tHei = $(this).css("height");
          var hargaJual = $("#hargaJual").val();
          var t = "P:"+tHei+" <br />L:"+tWid;
          if(itemType=="tanah"){
            var totalharga = 0;
            var pl = (parseInt(tWid)/60)*(parseInt(tHei)/40);
            var pt = (parseInt(tHei)/40)*2.8;
            var lt = (parseInt(tWid)/60)*2.8;
            var luas = 2*(pl+pt+lt);
            var semen = Math.round((luas*9.68)/50);
            var pasir = Math.round((luas*0.045));
            $.ajax({
              type: 'POST',
              url: 'getPrice.php',
              data: 'semen='+semen+'&pasir='+pasir,
              dataType: 'json',
              success : function(data) {
                if (data.status == 'ok') {
                  $("#harga").val(data.totalHarga);
                  $("#totalHarga").val(parseInt(hargaJual)+parseInt(data.totalHarga));
                  $("#ukuran").val((parseInt(tWid)/60)+" x "+(parseInt(tHei)/40));
                }else{
                  alert('Some problem occured, please try again.');
                }
              }
            });
            $(this)
              .find("p")
              .html(t);
          } else {
            var totalharga = $("#harga").val();
            var pl = (parseInt(tWid)/60)*(parseInt(tHei)/40);
            var pt = (parseInt(tHei)/40)*2.8;
            var lt = (parseInt(tWid)/60)*2.8;
            var luas = 2*(pl+pt+lt);
            var semen = Math.round((luas*9.68)/50);
            var pasir = Math.round((luas*0.045));
            $.ajax({
              type: 'POST',
              url: 'getPrice.php',
              data: 'semen='+semen+'&pasir='+pasir,
              dataType: 'json',
              success : function(data) {
                if (data.status == 'ok') {
                  $("#harga").val(totalharga+parseInt(data.totalHarga));
                  $("#totalHarga").val(parseInt(hargaJual)+parseInt(data.totalHarga));
                }else{
                  alert('Some problem occured, please try again.');
                }
              }
            });
          }
        });
      });
      $(document).on("click","div.item-child", function(event){
        $(this).addEventListener('keydown', function (event) {
          if (event.keyCode == 8) {
              console.log('BACKSPACE was pressed');

              // Call event.preventDefault() to stop the character before the cursor
              // from being deleted. Remove this line if you don't want to do that.
              event.preventDefault();
          }
          if (event.keyCode == 46) {
              console.log('DELETE was pressed');

              // Call event.preventDefault() to stop the character after the cursor
              // from being deleted. Remove this line if you don't want to do that.
              event.preventDefault();
          }
        });
      });
    </script>
    <hr>
    <script type="text/javascript" src="./js/html2canvas.js"></script>
    <button id="btn-success" class="btn btn-success">Set</button>
    <button id="btn-clear" class="btn btn-danger">Clear</button>
    <button id="btn-exit" class="btn btn-info">Keluar</button>
    <script>
      $('#btn-success').click(function(){
        var filename = $("#rumah_name").val();
        if(filename==null){
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
      $("#btn-clear").click(function() {
        $( ".dropzone" ).html("");
      });
      $("#btn-exit").click(function() {
        window.location = "../index.php";
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
  </div>
</body>
</html>