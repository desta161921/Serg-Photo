<!DOCTYPE html>
<html>
<head>
    <?php echo $__env->make('includes.head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
</head>
<body>
<?php echo $__env->make('includes.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<div class="container__album">
    <div class="wrapper__album">
        <div class="album__list">
            <h2 class="album__list-heading"><?php echo e($event->event_Name); ?></h2>
            <p class="album__list-p"><?php echo e($event->event_Description); ?></p>
        </div>
        <?php if((!is_null(DB::table('participants')->where('user_Id', '=', Auth::id())->where('event_Id', '=', $event->event_Id)->where('participant_Role', '=', 'Admin')->first()))): ?>
        <div class="invitation__container">
            <canvas id="canvas" width="700" height="900" style="border:1px solid #d3d3d3;">
            Your browser does not support the HTML5 canvas tag.</canvas>
            <form>
                <input type="text" id="input1" placeholder="Brud" /> 
                <input type="text" id="input2" placeholder="Brudgom" /> 
                <select id="input3">
                    <option value="Arial">Arial</option>
                    <option value="Georgia">Georgia</option>
                    <option value="Times New Roman">Times New Roman</option>
                    <option value="audi">Audi</option>
                </select> 
            </form>
            <input type="button" onclick="uploadEx()" value="Upload" />
            
            <form method="post" id="form1" accept-charset="utf-8" name="form1">
                <input name="hidden_data" id='hidden_data' type="hidden"/>
                <input type="button" value="Upload" action="/invite/save">
            </form>
            <?php else: ?>
                Only admin can edit invitation.
            <?php endif; ?>
        </div>
    </div>
</div>

  <script>
  
    var canvas = document.getElementById('canvas');
        var dataURL = canvas.toDataURL("image/png");
        ctx = canvas.getContext('2d');
        ctx.fillStyle = '#0e70d1';
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        for(i = 1; i < 4; i++) {
            document.getElementById('input' + i).addEventListener('keyup', function() {
                var stringTitle1 = document.getElementById('input1').value;
                var stringTitle2 = document.getElementById('input2').value;
                var stringTitle3 = document.getElementById('input3').value;
                ctx.fillStyle = '#0e70d1';
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                ctx.fillStyle = '#fff';
                ctx.font = '60px ' + stringTitle3;
                ctx.textAlign="center";
                ctx.fillText(stringTitle1, 350, 100);
                ctx.fillText("&", 350, 150);
                ctx.fillText(stringTitle2, 350, 200);
        }); 
    }

    function uploadEx() {
        var canvas = document.getElementById("canvas");
        var dataURL = canvas.toDataURL("image/png");
        var token = $('meta[name="csrf-token"]').attr('content');
        
        
        $.ajax({
            type: "POST",
            url: "http://sergphoto.com:8000/invite/save",
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            
            data: {
                _token:'<?php echo e(csrf_token()); ?>',
                imgBase64: dataURL,
                event: '<?php echo e($event->event_Id); ?>'
            },
            datatype: "json",
            success:function(data){
                alert(data);
            },error:function(){
                alert("error!!!!");
                
            }
            
        });
    };
    </script>
</body>
</html>