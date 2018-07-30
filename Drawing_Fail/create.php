<script src="http://code.interactjs.io/v1.3.4/interact.min.js"></script>
<style>
  #drag-1, #drag-2 {
    width: 100px;
    height: 100px;
    min-height: 6.5em;
    margin: 3%;

    background-color: #29e;
    color: white;

    border-radius: 0.75em;

    -webkit-transform: translate(0px, 0px);
            transform: translate(0px, 0px);
  }

  #drag-me::before {
    content: "#" attr(id);
    font-weight: bold;
  }

  .tap-target {
    width: 150px;
    height: 150px;
    margin: 3%;

    border-radius: 100%;

    font-size: 1.125em;
    text-align: center;
    color: #fff;
    background-color: #29e;

    cursor: pointer;

    transition: all 0.3s;
  }

  .tap-target.switch-bg {
    background-color: #f40;
  }

  .draggable.switch-bg {
    background-color: #f40;
  }

  .tap-target.large {
    -webkit-transform: scale(1.25);
    transform: scale(1.25);
  }

  .rotate {
    -webkit-transform: rotate(180deg);
    transform: rotate(180deg);
  }
</style>


<div id="drag-1" class="draggable">
  <p> You can drag one element </p>
</div>
<!-- <div id="drag-2" class="draggable">
  <p> with each pointer </p>
</div> -->

<div class="tap-target">
  <p>Tap to change color</p>
  <p>Doubletap to change size</p>
  <p>Hold to rotate</p>
</div>

<script type="text/javascript">
  // target elements with the "draggable" class
  interact('.draggable')
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

  interact('.tap-target')
  .on('tap', function (event) {
    event.currentTarget.classList.toggle('switch-bg');
    event.preventDefault();
  })
  .on('doubletap', function (event) {
    event.currentTarget.classList.toggle('large');
    event.currentTarget.classList.remove('rotate');
    event.preventDefault();
  })
  .on('hold', function (event) {
    event.currentTarget.classList.toggle('rotate');
    event.currentTarget.classList.remove('large');
  });
</script>