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
        <a href="javascript:void(0)" onclick="toggleDrawingMode()" title="Draw on Screen"
            style="width:50px;height:50px;border-radius:50%;background:#cfa54f;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 8px rgba(0,0,0,0.2);z-index:9999999;">
            <span style="font-size:24px;">✏️</span>
        </a>

        <div id="drawToolbar" style="display:none;position:fixed;top:50%;right:12px;transform:translateY(-50%);z-index:10000000;">
            <div style="display:flex;flex-direction:column;gap:6px;background:#1a1a1a;padding:10px 7px;border-radius:12px;box-shadow:0 4px 20px rgba(0,0,0,0.4);">

                <!-- Color picker -->
                <input type="color" id="drawColor" value="#ff0000" title="Color">

                <!-- Line widths -->
                <button class="draw-btn w-opt active" data-w="2" title="Thin">
                    <span style="width:3px;height:3px;background:#fff;border-radius:50%;display:inline-block;pointer-events:none;"></span>
                </button>
                <button class="draw-btn w-opt" data-w="5" title="Medium">
                    <span style="width:6px;height:6px;background:#fff;border-radius:50%;display:inline-block;pointer-events:none;"></span>
                </button>
                <button class="draw-btn w-opt" data-w="9" title="Thick">
                    <span style="width:10px;height:10px;background:#fff;border-radius:50%;display:inline-block;pointer-events:none;"></span>
                </button>
                <button class="draw-btn w-opt" data-w="14" title="Extra Thick">
                    <span style="width:14px;height:14px;background:#fff;border-radius:50%;display:inline-block;pointer-events:none;"></span>
                </button>

                <span style="height:1px;background:#444;margin:2px 0;display:block;"></span>

                <!-- Shape outlines only (click again to deselect → back to freehand) -->
                <button class="draw-btn shape-opt" data-shape="line"    title="Line">╱</button>
                <button class="draw-btn shape-opt" data-shape="rect"    title="Rectangle">▭</button>
                <button class="draw-btn shape-opt" data-shape="ellipse" title="Ellipse">◯</button>
                <button class="draw-btn shape-opt" data-shape="diamond" title="Diamond">◇</button>
                <button class="draw-btn shape-opt" data-shape="arrow"   title="Arrow">➹</button>

                <span style="height:1px;background:#444;margin:2px 0;display:block;"></span>

                <button class="draw-btn" onclick="undoDraw()"          title="Undo">↶</button>
                <button class="draw-btn" onclick="clearCanvas()"       title="Clear">🗑️</button>
                <button class="draw-btn" onclick="toggleDrawingMode()" title="Close" style="color:#ff5555;">✖️</button>
            </div>
        </div>

        <canvas id="drawCanvas"  style="display:none;position:fixed;top:0;left:0;z-index:9999999;"></canvas>
        <canvas id="drawPreview" style="display:none;position:fixed;top:0;left:0;z-index:9999998;"></canvas>

        <style>
        /* Draw toolbar buttons */
        .draw-btn {
            background:#333;border:none;color:#fff;
            width:32px;height:32px;
            border-radius:7px;font-size:15px;cursor:pointer;
            transition:0.15s;display:flex;align-items:center;justify-content:center;
        }
        .draw-btn:hover  { background:#cfa54f; }
        .draw-btn.active { background:#cfa54f;box-shadow:0 0 6px rgba(207,165,79,.6); }

        /* Color input styling */
        #drawColor {
            -webkit-appearance:none;appearance:none;
            width:32px;height:22px;border:none;border-radius:5px;
            background:none;cursor:pointer;padding:0;display:block;
        }
        #drawColor::-webkit-color-swatch-wrapper { padding:0; }
        #drawColor::-webkit-color-swatch         { border:none;border-radius:4px; }

        /* Responsive: smaller on mobile */
        @media(max-width:575px){
            #drawToolbar { right:4px !important; }
            .draw-btn    { width:26px;height:26px;font-size:12px; }
            #drawColor   { width:26px !important;height:18px !important; }
        }
        </style>

        <script>
      
        var _dm=false,_act=false,_drawShape=null,_lw=2,_col='#ff0000';
        var _dc=null,_dctx=null,_dpv=null,_dpctx=null;
        var _sx=0,_sy=0,_penPts=[],_cmds=[],_redoCmds=[];
        var _tmHandler=null; // touchmove handler ref for cleanup

        function _initDraw(){
            _dc=document.getElementById('drawCanvas');
            _dpv=document.getElementById('drawPreview');
            _dctx=_dc.getContext('2d');
            _dpctx=_dpv.getContext('2d');
            _resizeDraw();
            _bindToolbar();
            document.getElementById('drawColor').addEventListener('input',function(){_col=this.value;});
            window.addEventListener('scroll',function(){if(_dm)_redrawAll();},{passive:true});
        }

        function _bindToolbar(){
            document.querySelectorAll('.w-opt').forEach(function(b){
                b.addEventListener('click',function(){
                    document.querySelectorAll('.w-opt').forEach(function(x){x.classList.remove('active');});
                    b.classList.add('active');_lw=parseInt(b.dataset.w);
                });
            });
            document.querySelectorAll('.shape-opt').forEach(function(b){
                b.addEventListener('click',function(){
                    if(_drawShape===b.dataset.shape){b.classList.remove('active');_drawShape=null;return;}
                    document.querySelectorAll('.shape-opt').forEach(function(x){x.classList.remove('active');});
                    b.classList.add('active');_drawShape=b.dataset.shape;
                });
            });
        }

        function _resizeDraw(){
            _dc.width=_dpv.width=window.innerWidth;
            _dc.height=_dpv.height=window.innerHeight;
            _redrawAll();
        }

        function toggleDrawingMode(){
            if(!_dc)_initDraw();
            _dm=!_dm;
            var tb=document.getElementById('drawToolbar');
            if(_dm){
                _dc.style.display=_dpv.style.display=tb.style.display='block';
                /* ─ Drawing mode ON: add ALL document listeners ─ */
                document.addEventListener('mousedown',_onDown);
                document.addEventListener('mousemove',_onMove);
                document.addEventListener('mouseup',_onUp);
                document.addEventListener('touchstart',_onDown,{passive:true});
                document.addEventListener('touchend',_onUp);
                _tmHandler=function(e){if(_act)e.preventDefault();_onMove(e);};
                document.addEventListener('touchmove',_tmHandler,{passive:false});
            } else {
                _dc.style.display=_dpv.style.display='none';
                tb.style.display='none';
                _act=false;
                if(_dpctx)_dpctx.clearRect(0,0,_dpv.width,_dpv.height);
                /* ─ Drawing mode OFF: remove ALL document listeners ─
                   Isse mobile browser ka scroll bilkul free ho jata hai */
                document.removeEventListener('mousedown',_onDown);
                document.removeEventListener('mousemove',_onMove);
                document.removeEventListener('mouseup',_onUp);
                document.removeEventListener('touchstart',_onDown);
                document.removeEventListener('touchend',_onUp);
                if(_tmHandler){
                    document.removeEventListener('touchmove',_tmHandler);
                    _tmHandler=null;
                }
            }
        }

        function _toPage(cx,cy){return{x:cx+window.scrollX,y:cy+window.scrollY};}
        function _toClient(px,py){return{x:px-window.scrollX,y:py-window.scrollY};}

        function _cpos(e){
            if(e.touches&&e.touches.length)return{x:e.touches[0].clientX,y:e.touches[0].clientY};
            if(e.changedTouches&&e.changedTouches.length)return{x:e.changedTouches[0].clientX,y:e.changedTouches[0].clientY};
            return{x:e.clientX,y:e.clientY};
        }

        function _isUI(e){
            var el=e.target;
            while(el&&el!==document.body){
                if(el.id==='drawToolbar')return true;
                if(['A','BUTTON','INPUT','SELECT','TEXTAREA','LABEL'].indexOf(el.tagName)!==-1)return true;
                el=el.parentElement;
            }
            return false;
        }

        function _applyStyle(c,col,lw){
            c.lineJoin='round';c.lineCap='round';c.lineWidth=lw;
            c.strokeStyle=c.fillStyle=col;c.globalAlpha=1;
            c.globalCompositeOperation='source-over';
        }

        function _shapeRender(c,sh,x1,y1,x2,y2){
            if(sh==='line'){c.beginPath();c.moveTo(x1,y1);c.lineTo(x2,y2);c.stroke();}
            else if(sh==='rect'){c.strokeRect(x1,y1,x2-x1,y2-y1);}
            else if(sh==='ellipse'){c.beginPath();c.ellipse((x1+x2)/2,(y1+y2)/2,Math.abs(x2-x1)/2,Math.abs(y2-y1)/2,0,0,2*Math.PI);c.stroke();}
            else if(sh==='diamond'){var mx=(x1+x2)/2,my=(y1+y2)/2;c.beginPath();c.moveTo(mx,y1);c.lineTo(x2,my);c.lineTo(mx,y2);c.lineTo(x1,my);c.closePath();c.stroke();}
            else if(sh==='arrow'){
                var a=Math.atan2(y2-y1,x2-x1),h=Math.max(12,c.lineWidth*2.5);
                c.beginPath();c.moveTo(x1,y1);c.lineTo(x2,y2);c.stroke();
                c.beginPath();
                c.moveTo(x2,y2);c.lineTo(x2-h*Math.cos(a-Math.PI/6),y2-h*Math.sin(a-Math.PI/6));
                c.moveTo(x2,y2);c.lineTo(x2-h*Math.cos(a+Math.PI/6),y2-h*Math.sin(a+Math.PI/6));
                c.stroke();
            }
        }

        function _renderCmd(c,cmd){
            _applyStyle(c,cmd.col,cmd.lw);
            var ox=-window.scrollX,oy=-window.scrollY;
            if(cmd.type==='pen'&&cmd.pts.length>=2){
                c.beginPath();c.moveTo(cmd.pts[0].x+ox,cmd.pts[0].y+oy);
                for(var i=1;i<cmd.pts.length;i++)c.lineTo(cmd.pts[i].x+ox,cmd.pts[i].y+oy);
                c.stroke();
            }else if(cmd.type==='shape'){
                _shapeRender(c,cmd.shape,cmd.x1+ox,cmd.y1+oy,cmd.x2+ox,cmd.y2+oy);
            }
        }

        function _redrawAll(){
            if(!_dctx)return;
            _dctx.clearRect(0,0,_dc.width,_dc.height);
            _cmds.forEach(function(cmd){_renderCmd(_dctx,cmd);});
            if(_act&&!_drawShape&&_penPts.length>=2){
                _applyStyle(_dctx,_col,_lw);_dctx.beginPath();
                var s=_toClient(_penPts[0].x,_penPts[0].y);_dctx.moveTo(s.x,s.y);
                for(var i=1;i<_penPts.length;i++){var p=_toClient(_penPts[i].x,_penPts[i].y);_dctx.lineTo(p.x,p.y);}
                _dctx.stroke();
            }
        }

        function _onDown(e){
            if(!_dm||_isUI(e))return;
            
            e.preventDefault(); 
            
            var cp=_cpos(e),pp=_toPage(cp.x,cp.y);
            _sx=pp.x;_sy=pp.y;_penPts=[pp];_act=true;
        }

        function _onMove(e){
            if(!_dm||!_act)return;
            var cp=_cpos(e),pp=_toPage(cp.x,cp.y);
            if(_drawShape){
                _dpctx.clearRect(0,0,_dpv.width,_dpv.height);
                var sc=_toClient(_sx,_sy);
                _applyStyle(_dpctx,_col,_lw);
                _shapeRender(_dpctx,_drawShape,sc.x,sc.y,cp.x,cp.y);
            }else{
                var last=_penPts[_penPts.length-1],lc=_toClient(last.x,last.y);
                _applyStyle(_dctx,_col,_lw);
                _dctx.beginPath();_dctx.moveTo(lc.x,lc.y);_dctx.lineTo(cp.x,cp.y);_dctx.stroke();
                _penPts.push(pp);
            }
        }

        function _onUp(e){
            if(!_act)return;_act=false;
            var cp=_cpos(e),pp=_toPage(cp.x,cp.y);
            _dpctx.clearRect(0,0,_dpv.width,_dpv.height);
            if(_drawShape){
                _cmds.push({type:'shape',shape:_drawShape,x1:_sx,y1:_sy,x2:pp.x,y2:pp.y,col:_col,lw:_lw});
                _redrawAll();
            }else if(_penPts.length>=2){
                _cmds.push({type:'pen',pts:_penPts.slice(),col:_col,lw:_lw});
            }
            _redoCmds.length=0;
        }

        function undoDraw(){if(!_cmds.length)return;_redoCmds.push(_cmds.pop());_redrawAll();}
        function clearCanvas(){_cmds.length=0;_redoCmds.length=0;if(_dctx)_dctx.clearRect(0,0,_dc.width,_dc.height);}

        window.addEventListener('resize',function(){if(_dc)_resizeDraw();});
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
