<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>jQuery UI Droppable - Default functionality</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <!-- <link rel="stylesheet" href="/resources/demos/style.css"> -->
  <style>
		table td {
			width: 1024px;
			height: 720px;
		}
		#draggable { 
			width: 100px; 
			height: 100px;
			margin: 10px;
    }
    #item { 
			width: 100px; 
			height: 100px;
			margin: 10px;
		}
		#dropzone {
			width: 100%;
			height: 100%;
		}
		.tools{
			width: 30%;
		}
		p {
			text-align: center;
		}
  </style>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $('#item').draggable({
      revert: "true",
      helper: "clone",
      cursor: "move"
    });

    $('#dropzone').droppable({
      accept: "#item"
      drop: function( event, ui) {
        $(this).append( ui.draggable );
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
			<div id="draggable" class="ui-widget-content" onmouseover="enDrag(this)">
				<p>Floor</p>
			</div>
			<div id="item" onmouseover="enDrag(this)">
        <img src="./gfx/items-door.png" />
			</div>
			<div id="item" onmouseover="enDrag(this)">
        <img src="./gfx/walls-window.png" />
			</div>
		</td>
		<td>
			<div id="dropzone" class="ui-widget-header">
				<p>Drop you Item Here</p>
			</div>
		</td>
	</tr>
	</table>
</body>
</html>