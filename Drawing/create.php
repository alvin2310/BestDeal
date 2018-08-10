<!doctype html>
<html lang="en">
<head>
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
            var t = "P:"+tWid+" <br />L:"+tHei;
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
          /* if(parseInt($item.css('top'))<0){
            var selisih = 66 - (parseInt($item.css('top'))*-1);
            $item.css("top",selisih );
          } */
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
            <img src="gfx/items-door-01.png" alt="Door Tarik" />
          </div>
          <div id="draggable" class="ui-widget-content tool-master" name="door-push">
            <img src="gfx/items-door-02.png" alt="Door Dorong" />
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
    <!-- <canvas width="500" height="200"></canvas> -->
    <script type="text/javascript">
      $(document).on("mouseover","div.item-child", function(event){
        var itemType = $(this).find("p").text();
        $(this).draggable({
          cursor: "move",
          containment: ".dropzone"
        });
        $(this).resizable({
          grid: 1
        });
        $(this).resize(function() {
          var tWid = $(this).width();
          var tHei = $(this).height();
          var t = "P:"+tWid+" <br />L:"+tHei;
          if(itemType=="Tanah"){
            $(this)
              .find("p")
              .html(t);
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
        html2canvas(document.querySelector('#canvas')).then(function(canvas) {
        console.log(canvas);
        saveAs(canvas.toDataURL(), 'file-name.png');
        });
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
      $('#btn-exit').click(function(){
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