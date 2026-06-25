<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" sizes="32x32" type="image/png">
    <title>@yield('title', config('app.name'))</title>
    <link rel="stylesheet" href="{{ asset('assets/css/icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fancybox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery.circliful.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    {{-- for toast --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <link rel="stylesheet" href="{{ asset('assets/css/colors/color.css') }}" title="color" />
    <link rel="alternate stylesheet" href="{{ asset('assets/css/colors/color2.css') }}" title="color2" />
    <link rel="alternate stylesheet" href="{{ asset('assets/css/colors/color3.css') }}" title="color3" />
    <link rel="alternate stylesheet" href="{{ asset('assets/css/colors/color4.css') }}" title="color4" />
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    @yield('custom_css')
    <script>
        if(performance.navigation.type == 2){
            location.reload(true);
        }
    </script>

    <style>
        .dropdown-menu {
    min-width: 200px; /* Set width for dropdown */
}
/* floating */
.floating-buttons {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 9999999;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.floating-buttons a {
    display: inline-block;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease;
}

.floating-buttons a:hover {
    transform: scale(1.1);
}

.floating-buttons img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
}
/* end floating */
.thm-btn, .secndry-btn{
    box-shadow: 0 5px 10px rgba(0,0,0,0.15) !important;
}
header.sticky-active{
    box-shadow: none !important;
}
@media only screen and (min-width: 996px) {

    .sticky{
        position: fixed;
        top: 80px;
        background-color: white;
        z-index: 99;
        box-shadow: 0 3px 5px rgba(0,0,0,.08);
        width: 100%;
        left: 15px;
    }
    .contact-form-row.sticky .contact-form{
        margin-bottom: 10px !important;
    }
}
/* login_register Modal css */
.modal {
display: none;
position: fixed;
z-index: 999;
left: 0;
top: 0;
width: 100%;
height: 100%;
overflow: auto;
background-color: rgb(0,0,0);
background-color: rgba(0,0,0,0.4);
}

.modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 500px;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}
 /* Pageloader css */
.pageloader-wrap {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    width: 100vw;
    background-color: #ffffff; 
    position: fixed;
    top: 0;
    left: 0;
    z-index: 99999;
}

.custom-quran-loader {
    width: 90px;
    height: 90px;
    animation: float-quran 2.5s ease-in-out infinite;
}

.book-path, .rehal-path {
    fill: transparent;
    stroke: #cda253; 
    stroke-width: 3.5;
    stroke-linecap: round;
    stroke-linejoin: round;
}

.book-path {
    stroke-dasharray: 200;
    stroke-dashoffset: 200;
    animation: draw-quran 2s ease-in-out infinite alternate;
}

.rehal-path {
    stroke-dasharray: 50;
    stroke-dashoffset: 50;
    animation: draw-rehal 2s ease-in-out infinite alternate;
    animation-delay: 0.2s; 
}

@keyframes draw-quran {
    0% { stroke-dashoffset: 200; fill: transparent; }
    100% { stroke-dashoffset: 0; fill: rgba(205, 162, 83, 0.15);  }
}

@keyframes draw-rehal {
    0% { stroke-dashoffset: 50; }
    100% { stroke-dashoffset: 0; }
}

@keyframes float-quran {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-12px); }
}
/* End page loader css  */
    .sticky-admission-bar {
        position: fixed;
        bottom: -150%; /* Start hidden below screen */
        left: 0;
        width: 100%;
        background: #1a1a1a; /* Dark premium background */
        border-top: 3px solid #cfa54f; /* Golden border */
        box-shadow: 0 -5px 25px rgba(0,0,0,0.6);
        z-index: 999999;
        padding: 15px 0;
        /* Bouncy slide-up animation */
        transition: bottom 0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }
    
    /* Class to trigger the slide up */
    .sticky-admission-bar.show {
        bottom: 0;
    }

    /* Glowing Button Animation */
    .glow-btn-premium {
        background-color: #cfa54f !important;
        color: #fff !important;
        border: none;
        animation: glowing-gold 2s infinite;
        transition: all 0.3s ease;
        padding: 12px 35px !important;
        font-size: 16px !important;
        display: inline-block;
    }
    .glow-btn-premium:hover {
        background-color: #b38b3f !important;
        transform: translateY(-2px);
    }
    @keyframes glowing-gold {
        0% { box-shadow: 0 0 5px rgba(207, 165, 79, 0.4); }
        50% { box-shadow: 0 0 15px rgba(207, 165, 79, 0.8), 0 0 25px rgba(207, 165, 79, 0.5); }
        100% { box-shadow: 0 0 5px rgba(207, 165, 79, 0.4); }
    }

    /* Blinking Badge */
    .blink-badge {
        background: rgba(207, 165, 79, 0.15); 
        color: #cfa54f; 
        padding: 4px 12px; 
        border-radius: 30px; 
        font-size: 12px; 
        font-weight: bold; 
        border: 1px solid #cfa54f; 
        display: inline-block; 
        text-transform: uppercase; 
        letter-spacing: 1px;
        animation: blinking-text 1.5s infinite;
        margin-right: 15px;
        vertical-align: middle;
    }
    @keyframes blinking-text {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    /* Close Button */
    .close-sticky-bar {
        background: transparent;
        border: none;
        color: #aaaaaa;
        font-size: 26px;
        margin-left: 20px;
        cursor: pointer;
        transition: 0.3s;
        vertical-align: middle;
    }
    .close-sticky-bar:hover {
        color: #cfa54f;
    }

    /* Mobile Responsive Adjustments */
   @media (max-width: 768px) {
    .sticky-txt-wrap { text-align: left; margin-bottom: 15px; } 
    .sticky-btn-wrap { text-align: center; }
    .blink-badge { margin-bottom: 8px; }
    
    .mobile-hd-txt { font-size: 18px !important; }
    .mobile-p-txt { font-size: 13px !important; line-height: 1.4 !important; }
    
    .floating-buttons.lifted {
        bottom: 210px !important; 
    }
}
    </style>

</head>
<body>
    @yield('content')
{{--<script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>--}}
    <script src="{{ asset('assets/js/jquery.min.js') }}?v=3"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/downCount.js') }}"></script>
    <script src="{{ asset('assets/js/fancybox.min.js') }}"></script>
    <script src="{{ asset('assets/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/js/perfectscrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.circliful.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/custom-scripts.js') }}?v=2"></script> --}}
    <script src="{{ asset('assets/js/custom-scripts.js') }}?v={{ filemtime(public_path('assets/js/custom-scripts.js')) }}"></script>


    @yield('custom_js')
    <!-- Floating buttons -->
    <div class="floating-buttons">
    @auth
            <a href="javascript:void(0)" onclick="toggleDrawingMode()" class="draw-button" title="Draw on Screen"
                style=" width:50px; height:50px; border-radius:50%; background:#cfa54f; display:flex; align-items:center; justify-content:center; box-shadow:0 4px 8px rgba(0,0,0,0.2); z-index:9999999;">
                    <span style="font-size:24px;">✏️</span>
            </a>
        <!-- Rail + popout panel -->
<div id="drawToolbar" style="display:none; position:fixed; top:50%; right:20px; transform:translateY(-50%); z-index:10000000; gap:8px; align-items:flex-start;">
    <div style="display:flex; flex-direction:column; gap:8px; background:#1a1a1a; padding:12px 8px; border-radius:12px; box-shadow:0 4px 20px rgba(0,0,0,0.4);">
        <button class="rail-btn active" data-panel="draw" title="Draw">✏️</button>
        <button class="rail-btn" data-panel="shape" title="Shape">▭</button>
        <button class="rail-btn" data-tool="text" title="Text">T</button>
        <button class="rail-btn" data-tool="eraser" title="Eraser">🧽</button>
        <span style="height:1px; background:#444; margin:2px 4px;"></span>
        <button class="rail-btn" onclick="undoDraw()" title="Undo">↶</button>
        <button class="rail-btn" onclick="redoDraw()" title="Redo">↷</button>
        <button class="rail-btn" onclick="clearCanvas()" title="Clear" style="color:#ffcc00;">🗑️</button>
        <button class="rail-btn" onclick="saveCanvas()" title="Save" style="color:#7CFC00;">💾</button>
        <button class="rail-btn" onclick="toggleDrawingMode()" title="Close" style="color:#ff5555;">✖️</button>
    </div>

    <div id="drawPanel" style="background:#1a1a1a; border-radius:12px; padding:14px; width:210px; box-shadow:0 4px 20px rgba(0,0,0,0.4);">
        <!-- Draw section -->
        <div data-section="draw">
            <p class="panel-label">Draw</p>
            <div class="panel-row">
                <button class="opt pen-opt active" data-pen="pen" title="Pen">✏️</button>
                <button class="opt pen-opt" data-pen="marker" title="Marker">🖊️</button>
                <button class="opt pen-opt" data-pen="highlighter" title="Highlighter">🖍️</button>
            </div>
            <p class="panel-label">Line width</p>
            <div class="panel-row">
                <button class="opt w-opt active" data-w="3"><span class="wd" style="width:5px;height:5px;"></span></button>
                <button class="opt w-opt" data-w="6"><span class="wd" style="width:9px;height:9px;"></span></button>
                <button class="opt w-opt" data-w="10"><span class="wd" style="width:13px;height:13px;"></span></button>
                <button class="opt w-opt" data-w="16"><span class="wd" style="width:18px;height:18px;"></span></button>
            </div>
            <p class="panel-label">Color</p>
            <input type="color" id="penColor" value="#ff0000" style="width:100%; height:32px; border:none; border-radius:6px; background:none; cursor:pointer; padding:0;">
        </div>

        <!-- Shape section -->
        <div data-section="shape" style="display:none;">
            <p class="panel-label">Shape — outline</p>
            <div class="panel-grid">
                <button class="opt shape-opt" data-shape="line" data-fill="0" title="Line">╱</button>
                <button class="opt shape-opt" data-shape="rect" data-fill="0" title="Rectangle">▭</button>
                <button class="opt shape-opt" data-shape="ellipse" data-fill="0" title="Ellipse">◯</button>
                <button class="opt shape-opt" data-shape="diamond" data-fill="0" title="Diamond">◇</button>
                <button class="opt shape-opt" data-shape="arrow" data-fill="0" title="Arrow">➹</button>
            </div>
            <p class="panel-label" style="margin-top:12px;">Shape — filled</p>
            <div class="panel-grid">
                <button class="opt shape-opt" data-shape="rect" data-fill="1" title="Filled rectangle">▬</button>
                <button class="opt shape-opt" data-shape="ellipse" data-fill="1" title="Filled ellipse">⬤</button>
                <button class="opt shape-opt" data-shape="diamond" data-fill="1" title="Filled diamond">◆</button>
            </div>
        </div>
    </div>
</div>

<canvas id="drawCanvas" style="display:none; position:fixed; top:0; left:0; z-index:9999999; pointer-events:none;"></canvas>
<canvas id="drawPreview" style="display:none; position:fixed; top:0; left:0; z-index:9999998; pointer-events:none;"></canvas>

<style>
.rail-btn {
    background:#333; border:none; color:#fff; width:38px; height:38px;
    border-radius:8px; font-size:18px; cursor:pointer; transition:0.2s;
    display:flex; align-items:center; justify-content:center;
}
.rail-btn:hover { background:#cfa54f; }
.rail-btn.active { background:#cfa54f; box-shadow:0 0 8px rgba(207,165,79,0.6); }
.panel-label { color:#bbb; font-size:11px; margin:0 0 6px; }
.panel-row { display:flex; gap:8px; margin-bottom:14px; }
.panel-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:8px; }
.opt {
    background:#333; border:none; color:#fff; height:34px; min-width:34px;
    border-radius:7px; cursor:pointer; font-size:16px; transition:0.15s;
    display:inline-flex; align-items:center; justify-content:center;
}
.opt:hover { background:#555; }
.opt.active { background:#cfa54f; color:#1a1a1a; }
.wd { background:currentColor; border-radius:50%; display:inline-block; }
</style>

<script>
let drawing = false;
let isDrawingMode = false;
let penStyle = 'pen';       
let currentTool = 'pen';    
let activeShape = null;    
let fillShape = false;
let lineWidth = 3;
let canvas, ctx, preview, pctx;
let startX = 0, startY = 0, lastX = 0, lastY = 0;
const undoStack = [], redoStack = [];

function initCanvas() {
    canvas  = document.getElementById('drawCanvas');
    preview = document.getElementById('drawPreview');
    ctx  = canvas.getContext('2d');
    pctx = preview.getContext('2d');
    resizeCanvas();
    bindToolbar();
    bindCanvasEvents();
}

function bindToolbar() {
    document.querySelectorAll('.rail-btn[data-panel], .rail-btn[data-tool]').forEach(b => {
        b.addEventListener('click', () => {
            if (b.dataset.panel) {
                document.querySelectorAll('.rail-btn[data-panel],.rail-btn[data-tool]').forEach(x => x.classList.remove('active'));
                b.classList.add('active');
                showPanel(b.dataset.panel);
                document.getElementById('drawPanel').style.display = 'block';
                currentTool = (b.dataset.panel === 'draw') ? penStyle : 'shape';
            } else if (b.dataset.tool) {
                document.querySelectorAll('.rail-btn[data-panel],.rail-btn[data-tool]').forEach(x => x.classList.remove('active'));
                b.classList.add('active');
                currentTool = b.dataset.tool;
                activeShape = null;
                document.getElementById('drawPanel').style.display = 'none';
            }
        });
    });
    document.querySelectorAll('.pen-opt').forEach(b => b.addEventListener('click', () => {
        document.querySelectorAll('.pen-opt').forEach(x => x.classList.remove('active'));
        b.classList.add('active'); penStyle = b.dataset.pen; currentTool = penStyle; activeShape = null;
    }));
    document.querySelectorAll('.w-opt').forEach(b => b.addEventListener('click', () => {
        document.querySelectorAll('.w-opt').forEach(x => x.classList.remove('active'));
        b.classList.add('active'); lineWidth = parseInt(b.dataset.w);
    }));
    document.querySelectorAll('.shape-opt').forEach(b => b.addEventListener('click', () => {
        document.querySelectorAll('.shape-opt').forEach(x => x.classList.remove('active'));
        b.classList.add('active'); activeShape = b.dataset.shape; fillShape = b.dataset.fill === '1'; currentTool = 'shape';
    }));
}

function showPanel(name) {
    document.querySelectorAll('[data-section]').forEach(p => {
        p.style.display = p.dataset.section === name ? 'block' : 'none';
    });
}

function resizeCanvas() {
    const img = canvas.width ? ctx.getImageData(0, 0, canvas.width, canvas.height) : null;
    canvas.width  = window.innerWidth;  canvas.height  = window.innerHeight;
    preview.width = window.innerWidth;  preview.height = window.innerHeight;
    if (img) ctx.putImageData(img, 0, 0);
}

function toggleDrawingMode() {
    if (!canvas) initCanvas();
    isDrawingMode = !isDrawingMode;
    const tb = document.getElementById('drawToolbar');
    if (isDrawingMode) {
        canvas.style.display = 'block';
        preview.style.display = 'block';
        canvas.style.pointerEvents = 'auto';
        canvas.style.cursor = 'crosshair';
        tb.style.display = 'flex';
    } else {
        canvas.style.display = 'none';      
        preview.style.display = 'none';    
        canvas.style.pointerEvents = 'none';
        canvas.style.cursor = 'default';    
        tb.style.display = 'none';
        document.getElementById('drawPanel').style.display = 'none';
        drawing = false;                    
        currentTool = 'pen';  
    }
}

function getPos(e) {
    if (e.touches && e.touches.length) return { x: e.touches[0].clientX, y: e.touches[0].clientY };
    return { x: e.clientX, y: e.clientY };
}

function snapshot() {
    undoStack.push(ctx.getImageData(0, 0, canvas.width, canvas.height));
    if (undoStack.length > 40) undoStack.shift();
    redoStack.length = 0;
}

function applyStroke(c) {
    c.lineJoin = 'round'; c.lineCap = 'round';
    c.lineWidth = lineWidth;
    c.strokeStyle = c.fillStyle = document.getElementById('penColor').value;
    c.globalAlpha = 1; c.globalCompositeOperation = 'source-over';
}

function drawArrow(c, x1, y1, x2, y2) {
    const a = Math.atan2(y2 - y1, x2 - x1), h = Math.max(12, lineWidth * 2.5);
    c.beginPath(); c.moveTo(x1, y1); c.lineTo(x2, y2); c.stroke();
    c.beginPath(); c.moveTo(x2, y2);
    c.lineTo(x2 - h * Math.cos(a - Math.PI/6), y2 - h * Math.sin(a - Math.PI/6));
    c.moveTo(x2, y2);
    c.lineTo(x2 - h * Math.cos(a + Math.PI/6), y2 - h * Math.sin(a + Math.PI/6));
    c.stroke();
}

function drawDiamond(c, x1, y1, x2, y2, fill) {
    const mx = (x1 + x2) / 2, my = (y1 + y2) / 2;
    c.beginPath(); c.moveTo(mx, y1); c.lineTo(x2, my); c.lineTo(mx, y2); c.lineTo(x1, my); c.closePath();
    fill ? c.fill() : c.stroke();
}

function renderShape(c, x, y) {
    if (activeShape === 'line')        { c.beginPath(); c.moveTo(startX, startY); c.lineTo(x, y); c.stroke(); }
    else if (activeShape === 'arrow')  { drawArrow(c, startX, startY, x, y); }
    else if (activeShape === 'rect')   { fillShape ? c.fillRect(startX, startY, x-startX, y-startY) : c.strokeRect(startX, startY, x-startX, y-startY); }
    else if (activeShape === 'ellipse'){ c.beginPath(); c.ellipse((startX+x)/2, (startY+y)/2, Math.abs(x-startX)/2, Math.abs(y-startY)/2, 0, 0, 2*Math.PI); fillShape ? c.fill() : c.stroke(); }
    else if (activeShape === 'diamond'){ drawDiamond(c, startX, startY, x, y, fillShape); }
}

function startDraw(e) {
    if (!isDrawingMode) return;
    const p = getPos(e);
    startX = p.x; startY = p.y; lastX = p.x; lastY = p.y;

    // if (currentTool === 'text') {
    //     const t = prompt('Enter text:');
    //     if (t) {
    //         snapshot();
    //         ctx.fillStyle = document.getElementById('penColor').value;
    //         ctx.font = (lineWidth * 5) + 'px sans-serif';
    //         ctx.fillText(t, p.x, p.y);
    //     }
    //     drawing = false;
    //     return;
    // }
    if (currentTool === 'text') {
    const t = prompt('Enter text:');
    if (t) {
        snapshot();
        ctx.fillStyle = document.getElementById('penColor').value;
        ctx.font = (lineWidth * 5) + 'px sans-serif';
        ctx.fillText(t, p.x, p.y);
    }
    drawing = false;
    currentTool = 'pen';   
    document.querySelectorAll('.rail-btn[data-panel],.rail-btn[data-tool]').forEach(x => x.classList.remove('active'));
    const drawBtn = document.querySelector('.rail-btn[data-panel="draw"]');
    if (drawBtn) drawBtn.classList.add('active');
    document.getElementById('drawPanel').style.display = 'block';
    showPanel('draw');
    return;
}
    drawing = true;
    snapshot();
}

function draw(e) {
    if (!drawing || !isDrawingMode) return;
    e.preventDefault();
    const p = getPos(e);

    if (currentTool === 'pen' || currentTool === 'marker' || currentTool === 'highlighter' || currentTool === 'eraser') {
        applyStroke(ctx);
        if (currentTool === 'marker')      { ctx.lineWidth = lineWidth * 2; }
        if (currentTool === 'highlighter') { ctx.globalAlpha = 0.35; ctx.lineWidth = lineWidth * 4; }
        if (currentTool === 'eraser')      { ctx.globalCompositeOperation = 'destination-out'; ctx.lineWidth = lineWidth * 3; }
        ctx.beginPath(); ctx.moveTo(lastX, lastY); ctx.lineTo(p.x, p.y); ctx.stroke();
        ctx.globalAlpha = 1;
        lastX = p.x; lastY = p.y;
    } else if (currentTool === 'shape' && activeShape) {
        pctx.clearRect(0, 0, preview.width, preview.height);
        applyStroke(pctx);
        renderShape(pctx, p.x, p.y);
    }
}

function stopDraw(e) {
    if (!drawing) return;
    drawing = false;
    const c = e.changedTouches ? e.changedTouches[0] : e;
    const x = c.clientX, y = c.clientY;
    pctx.clearRect(0, 0, preview.width, preview.height);
    if (currentTool === 'shape' && activeShape) {
        applyStroke(ctx);
        renderShape(ctx, x, y);
    }
}

function undoDraw() {
    if (!undoStack.length) return;
    redoStack.push(ctx.getImageData(0, 0, canvas.width, canvas.height));
    ctx.putImageData(undoStack.pop(), 0, 0);
}
function redoDraw() {
    if (!redoStack.length) return;
    undoStack.push(ctx.getImageData(0, 0, canvas.width, canvas.height));
    ctx.putImageData(redoStack.pop(), 0, 0);
}
function clearCanvas() {
    if (!ctx) return;
    snapshot();
    ctx.clearRect(0, 0, canvas.width, canvas.height);
}
function saveCanvas() {
    if (!canvas) return;
    const a = document.createElement('a');
    a.download = 'annotation-' + Date.now() + '.png';
    a.href = canvas.toDataURL('image/png');
    a.click();
}

// document.addEventListener('mousedown', startDraw);
// document.addEventListener('mousemove', draw);
// document.addEventListener('mouseup', stopDraw);
// document.addEventListener('touchstart', startDraw, {passive:false});
// document.addEventListener('touchmove', draw, {passive:false});
// document.addEventListener('touchend', stopDraw);
function bindCanvasEvents() {
    canvas.addEventListener('mousedown', startDraw);
    canvas.addEventListener('mousemove', draw);
    canvas.addEventListener('mouseup', stopDraw);
    canvas.addEventListener('touchstart', startDraw, {passive:false});
    canvas.addEventListener('touchmove', draw, {passive:false});
    canvas.addEventListener('touchend', stopDraw);
}

window.addEventListener('resize', function(){ if(canvas) resizeCanvas(); });
</script>

    @endauth
        @php($info = \App\Information::query()->first())
        <!-- WhatsApp Button -->
        @if(@$info['whatsapp2']['label'] && @$info['whatsapp2']['value'])      
        <a href="https://wa.me/{{$info['whatsapp2']['value']}}" target="_blank" class="whatsapp-button">
            <img src="{{ asset('assets/images/whatsapp.png') }}" alt="WhatsApp">
        </a>
        @endif
        <!-- Skype Button -->
        @if(@$info['skype1']['label'] && @$info['skype1']['value'])        
        <a href="https://teams.microsoft.com/l/call/0/0?users={{$info['skype1']['value']}}" target="_blank" class="skype-button">
            <img src="{{ asset('assets/images/pngwing2.png') }}" alt="Teams">
        </a>
        @endif
    </div>
</body>
</html>
