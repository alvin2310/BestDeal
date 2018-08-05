<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>jQuery UI Droppable - Default functionality</title>
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
		#dropzone {
			width: 100%;
			height: 100%;
		}
		.tools{
			width: 30%;
    }
    .item-child {
      width: 100px;
      height: 360px;
    }
		p {
			text-align: center;
		}
  </style>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

  <script type="text/javascript">
    $( function() {
      $( ".tool-master" ).draggable({ 
        revert: "valid",
        helper: "clone",
        cursor: "move"
      });
      
      $( "#dropzone" ).droppable({
        accept: ".tool-master",
        drop: function( event, ui ) {
          //$(this).html("");
          var $item = ui.draggable.clone();
          $item.attr("id","item-draggable");
          $item.removeClass("ui-draggable ui-draggable-handle tool-master");
          $item.addClass("item-child");
          //$item.appendTo($(this));
          $(this).append($item);
        }
      });
    });

	</script>
</head>
<body>
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
      <div id="draggable" class="ui-widget-content tool-master" name="d-tarik">
        <img src="gfx/items-door-01.png" alt="Door Tarik" />
      </div>
      <div id="draggable" class="ui-widget-content tool-master" name="d-dorong">
        <img src="gfx/items-door-02.png" alt="Door Dorong" />
      </div>
      <div id="draggable" class="ui-widget-content tool-master" name="d-jendela">
        <p>Jendela</p>
      </div>
		</td>
		<td>
			<div id="dropzone" class="ui-widget-header">
				<p>Drop you Item Here</p>
      </div>
		</td>
	</tr>
	</table>
  <script type="text/javascript">
    $(document).on("mouseover","div.item-child", function(event){
      $(this).draggable({
        cursor: "move",
        containment: "#dropzone"
      });
      $(this).resizable({
        grid: 1
      });
      $(this).resize(function() {
        var tWid = $(this).width();
        var tHei = $(this).height();
        var t = "P:"+tWid+" <br />L:"+tHei;
        $(this)
          .find("p")
          .html(t);
      });
    });
  </script>
  <hr>
  <button id="btn-success" class="btn btn-success">Set</button>
  <button id="btn-clear" class="btn btn-danger">Clear</button>
  <button id="btn-exit" class="btn btn-info">Keluar</button>
  <script>
    $("#btn-clear").click(function() {
      alert("Save successfully !");
    });
    $("#btn-clear").click(function() {
      $( "#dropzone" ).html("<p>Drop you Item Here</p>");
    });
  </script>
</body>
</html>