<!DOCTYPE html>
<html>
<head>
    @include('includes.head');
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css?family=Great+Vibes" rel="stylesheet">
</head>
<body>
@include('includes.header')
<div class="container__album">
    <div class="wrapper__album">
        <div class="album__list">
            <h2 class="album__list-heading">{{$event->event_Name}}</h2>
            <p class="album__list-p">{{$event->event_Description}}</p>
        </div>
        @if ((!is_null(DB::table('participants')->where('user_Id', '=', Auth::id())->where('event_Id', '=', $event->event_Id)->where('participant_Role', '=', 'Admin')->first())))
        <div class="invitation__container">
            <!-- <img id="template" width="220" height="277" src="{{url('/img/template1.png')}}" alt="The template"> -->
            <div class="canvas-div">
                <div class="canvas-inputs">
                    <input type="text" id="input1" class="canvas-input" placeholder="Bride"> 
                    <input type="text" id="input2" class="canvas-input" placeholder="Bridegroom">
                    <input type="text" id="input3" class="canvas-input" placeholder="Freetext">
                </div>
                <div class="canvas-inputs">
                    <select id="input4" class="canvas-input">
                        <option value="Arial">Arial</option>
                        <option value="Georgia">Georgia</option>
                        <option value="Times New Roman">Times New Roman</option>
                        <option value="Great Vibes">Great Vibes</option>
                    </select>
                    <div class="template">
                        <select id="input5" class="canvas-input">
                            <option value="{{url('/img/weddingtemplate.png')}}">Wedding Template 1</option>
                            <option value="{{url('/img/weddingtemplate2.png')}}">Wedding Template 2</option>
                        </select>
                        <input type="button" class="btn-template" onclick="updateBg()" value="select template">
                    </div>
                </div>
            </div>
            <input type="button" class="btn-canvas" onclick="uploadEx()" value="Save" />
            <canvas id="canvas" width="800" height="900" style="border:1px solid #d3d3d3;">
            Your browser does not support the HTML5 canvas tag.</canvas>
            
            @else
                Only admin can edit invitation.
            @endif
        </div>
    </div>
</div>

  <script>
        var canvas = document.getElementById('canvas');
        var dataURL = canvas.toDataURL("image/png");
        var img = document.getElementById("template");
        base_image = new Image();
        base_image.src = '{{url("/img/weddingtemplate.png")}}';
        ctx = canvas.getContext('2d');
        base_image.onload = function(){
            ctx.drawImage(base_image, 0, 0);
        }
        var x = canvas.width / 2;
        var y = canvas.height / 5;
        var y2 = canvas.height / 2.18;
        var x2 = canvas.width / 3;
        var y3 = canvas.height / 1.69;
        
        function updateBg() {
            var bg = document.getElementById('input5').value;
            base_image.src = bg;
            ctx.drawImage(base_image, 0, 0);
        }
        
        for(i = 1; i < 4; i++) {
            document.getElementById('input' + i).addEventListener('keyup', function() {
                var stringTitle1 = document.getElementById('input1').value;
                var stringTitle2 = document.getElementById('input2').value;
                var stringTitle3 = document.getElementById('input3').value;
                var font = document.getElementById('input4').value;
                ctx.drawImage(base_image, 0, 0);
                ctx.font = '60px ' + font;
                ctx.textAlign = 'center';
                ctx.fillText(stringTitle1, x, y);
                ctx.fillText(stringTitle2, x, y2);
                ctx.textAlign = 'left';
                ctx.font = '45px ' + font;
                ctx.fillText(stringTitle3, x2, y3);
            }); 
        }

    function uploadEx() {
        var canvas = document.getElementById("canvas");
        var dataURL = canvas.toDataURL("image/png");
        var token = $('meta[name="csrf-token"]').attr('content');
        
        
        $.ajax({
            type: "POST",
            url: "{{ url('/') }}/invite/save",
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            
            data: {
                _token:'{{ csrf_token() }}',
                imgBase64: dataURL,
                event: '{{$event->event_Id}}'
            },
            datatype: "json",
            success:function(data){
                alert("Invitation template updated.");
                window.location.href = "{{url('/events/'. $event->event_Id .'/invitation')}}";
            },error:function(){
                alert("We were unavailable to save your invitation.");
                
            }
            
        });
    };
    </script>
</body>
</html>