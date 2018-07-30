<html>
<head>
  <script src="js/interact.min.js"></script>
  <style>
    .resize-drag {
      background-color: #F00;
      color: white;
      font-size: 20px;
      font-family: sans-serif;
      border-radius: 8px;
      padding: 20px;
      margin: 30px 20px;
      height: 360px;
      width: 150px;

      /* This makes things *much* easier */
      box-sizing: border-box;
    }

    .tap-target.red {
      background-color: #F00;
    }
    .tap-target.green {
      background-color: #0F0;
    }
    .tap-target.blue {
      background-color: #00F;
    }

    #in-dropzone {
      height: 70%;
    }

    .dropzone {
      background-color: #fff;
      border: solid 4px transparent;
      border-radius: 4px;
      border-color: #000;
      margin: 30px;
      /* margin: 10px auto 30px;
      padding: 10px; */
      width: 80%;
      transition: background-color 0.3s;
    }

    .drop-active {
      border-color: #aaa;
    }

    .drop-target {
      background-color: #ccc;
      border-color: #fff;
      border-style: solid;
    }

    .drag-drop {
      display: inline-block;
      min-width: 40px;
      padding: 2em 0.5em;

      color: #fff;
      background-color: #29e;
      border: solid 2px #fff;

      -webkit-transform: translate(0px, 0px);
              transform: translate(0px, 0px);
      cursor: pointer;
      transition: background-color 0.3s;
    }
  </style>
</head>
<body>
  <div style="margin: 10px 30px 5px;">
    <button onclick="addNew()" class="btn btn-success">Add Room</button>
    <p>
      <b>NB : </b>
      <ul>
        <li>Merah = Tanah / Lantai</li>
        <li>Biru = Kamar</li>
        <li>Hijau = WC</li>
        <li>Ukuran 3:1 <br>Ex: Pixel 360x150 maka Dalam Meter = (360x150)/10 = (36x15)/3 <br>= 12x5 <br>Jadi Ukuran Rumah P : 12 | L : 5</li>
      </ul>
    </p>
  </div>
  <script>
    function addNew() {
      var para = document.createElement("DIV");
      var t = document.createTextNode("New Room (360x150)");
      para.appendChild(t);
      para.classList.add("col-sm-4");
      para.classList.add("tap-target");
      para.classList.add("resize-drag");
      para.classList.add("red");
      para.id = "item-drop";
      document.getElementById("in-dropzone").appendChild(para);
    }
  </script>
  <div id="in-dropzone" class="dropzone">
  </div>
  <!-- Script Drag, Move and Resize Floor -->
    <script>
      interact('.resize-drag')
        .draggable({
          onmove: window.dragMoveListener,
          restrict: {
            restriction: 'parent',
            elementRect: { top: 0, left: 0, bottom: 1, right: 1 }
          },
        })
        .resizable({
          // resize from all edges and corners
          edges: { left: true, right: true, bottom: true, top: true },

          // keep the edges inside the parent
          restrictEdges: {
            outer: 'parent',
            endOnly: true,
          },

          // minimum size
          restrictSize: {
            min: { width: 100, height: 50 },
          },

          inertia: true,
        })
        .on('resizemove', function (event) {
          var target = event.target,
              x = (parseFloat(target.getAttribute('data-x')) || 0),
              y = (parseFloat(target.getAttribute('data-y')) || 0);

          // update the element's style
          target.style.width  = event.rect.width + 'px';
          target.style.height = event.rect.height + 'px';

          // translate when resizing from top or left edges
          x += event.deltaRect.left;
          y += event.deltaRect.top;

          target.style.webkitTransform = target.style.transform =
              'translate(' + x + 'px,' + y + 'px)';

          target.setAttribute('data-x', x);
          target.setAttribute('data-y', y);
          target.textContent = Math.round(event.rect.width) + '\u00D7' + Math.round(event.rect.height);
        });

        function dragMoveListener (event) {
          var target = event.target,
              // keep the dragged position in the data-x/data-y attributes
              x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx,
              y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;

          // translate the element
          target.style.webkitTransform =
          target.style.transform =
            'translate(' + x + 'px, ' + y + 'px)';

          // update the posiion attributes
          target.setAttribute('data-x', x);
          target.setAttribute('data-y', y);
        }

      // this is used later in the resizing and gesture demos
      window.dragMoveListener = dragMoveListener;

      interact('.dropzone').dropzone({
        // only accept elements matching this CSS selector
        accept: '#item-drop',
        // Require a 75% element overlap for a drop to be possible
        overlap: 0.75,

        // listen for drop related events:

        ondropactivate: function (event) {
          // add active dropzone feedback
          event.target.classList.add('drop-active');
        },
        ondragenter: function (event) {
          var draggableElement = event.relatedTarget,
              dropzoneElement = event.target;

          // feedback the possibility of a drop
          dropzoneElement.classList.add('drop-target');
          //draggableElement.classList.add('selected');
          //draggableElement.textContent = 'Dragged in';
        },
        ondragleave: function (event) {
          // remove the drop feedback style
          event.target.classList.remove('drop-target');
          //event.relatedTarget.classList.remove('selected');
          event.relatedTarget.textContent = 'Dragged out';
        },
        ondrop: function (event) {
          //event.relatedTarget.textContent = 'Dropped';
        },
        ondropdeactivate: function (event) {
          // remove active dropzone feedback
          event.target.classList.remove('drop-active');
          event.target.classList.remove('drop-target');
        }
      });

      interact('.tap-target')
      .on('tap', function (event) {
        //event.currentTarget.classList.toggle('switch-bg');
        var x = event.currentTarget;
        if(x.classList.contains("red")){
          x.classList.remove("red");
          x.classList.add("blue");
        } else if(x.classList.contains("blue")){
          x.classList.remove("blue");
          x.classList.add("green");
        } else {
          x.classList.remove("green");
          x.classList.add("red")
        }
        event.preventDefault();
      });
    </script>
  <!-- End Script -->
</body>
</html>