<!DOCTYPE html>
<html>
<head>
    <?php echo $__env->make('includes.head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;    
    <script src="//cdnjs.cloudflare.com/ajax/libs/list.js/1.5.0/list.min.js"></script>
</head>
<body>
<?php echo $__env->make('includes.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;
<div class="container__mainfeed">
    <div class="wrapper__mainfeed top-feed">
        <div class="event__list">
            <h2 class="event__list-heading">Feed</h2>
        </div>
        
        <?php
            use Carbon\Carbon;
            use App\Comment;
            // Get Image from table
            $user_Id = Auth::id();
            
            $userPhotos = DB::table('files')
            ->where('created_at', '>=', \Carbon\Carbon::now()->subHours(24))
            ->orderBy('file_Id', 'desc')
            ->get();
            $i = 0;
        ?>
        <?php if(auth()->guard()->guest()): ?>
        <h2>You are not logged in</h2>
        <?php else: ?>
        <?php if($userPhotos->isempty()): ?>
        <center><h1 class="error-p">No photo has been uploaded the last 48 hours.</h1></center>
        <?php endif; ?>
            
        <?php $__currentLoopData = $userPhotos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userPhoto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(DB::table('events')->where('event_Id', $userPhoto->event_Id)->where('event_Privacy', "public")->exists() OR DB::table('participants')->where('event_Id', $userPhoto->event_Id)->where('user_Id', $user_Id)->exists() OR $userPhoto->event_Id == NULL): ?>
            <?php if(!DB::table('albums')->where('user_Id', $userPhoto->user_Id)->where('album_Id', $userPhoto->album_Id)->where('album_Permission', 'private')->exists()): ?>    
                <div class="mainfeed__post">
                    <p class="mainfeed__post-description mfeed-p"><?php echo e($userPhoto->file_Description); ?></p>
                    <div class="mainfeed__post-flex">
                        <p class="mainfeed__post-location"><?php echo e($userPhoto->file_Location); ?></p>
                        <p class="mainfeed__post-author"><?php echo e(DB::table('users')->where('user_Id', $userPhoto->user_Id)->first()->first_Name); ?>

                        <?php echo e(DB::table('users')->where('user_Id', $userPhoto->user_Id)->first()->last_Name); ?></p>
                    </div>
                    <?php if($userPhoto->event_Id == NULL): ?>
                        <a href="<?php echo e(url('/')); ?>/uploads/users/<?php echo e($userPhoto->user_Id); ?>/<?php echo e(DB::table('albums')->where('album_Id', $userPhoto->album_Id)->pluck('album_Name')->first()); ?>/<?php echo e($userPhoto->file_Name); ?>" data-lightbox="Album" data-title="<?php echo e($userPhoto->file_Description); ?>">
                        <img src='/uploads/users/<?php echo e($userPhoto->user_Id); ?>/<?php echo e(DB::table('albums')->where('album_Id', $userPhoto->album_Id)->pluck('album_Name')->first()); ?>/<?php echo e($userPhoto->file_Name); ?>' class="mainfeed__post-img"></img></a>
                    <?php else: ?> 
                        <a href="<?php echo e(url('/')); ?>/uploads/events/<?php echo e($userPhoto->event_Id); ?>/<?php echo e($userPhoto->file_Name); ?>" data-lightbox="Album" data-title="<?php echo e($userPhoto->file_Description); ?>">
                        <img src='/uploads/events/<?php echo e($userPhoto->event_Id); ?>/<?php echo e($userPhoto->file_Name); ?>' class="mainfeed__post-img"></img></a>
                    <?php endif; ?>
                    <div class="mainfeed__plus">
                   <div id="like-<?php echo e($userPhoto->file_Id); ?>" value="<?php echo e((DB::table('reacts')->where('file_Id', $userPhoto->file_Id)->count())); ?>"><?php echo e((DB::table('reacts')->where('file_Id', $userPhoto->file_Id)->count())); ?></div>
                    <?php
                        $i ++;
                        $reactnames = DB::table('reacts')->where('file_Id', $userPhoto->file_Id)->take(2)->orderBy('created_at', 'desc')->get()
                    ?>
                    <?php $__currentLoopData = $reactnames; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reactname): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo e(app\User::find($reactname->user_Id)->first_Name . " " . app\User::find($reactname->user_Id)->last_Name); ?>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <p>likes this.</p>
                    <form method="POST" id="likeform-<?php echo e($userPhoto->file_Id); ?>" value="<?php echo csrf_token(); ?>">
                        <?php echo e(csrf_field()); ?>

                        <input type="hidden" id="file_Id" name="file_Id" value="<?php echo e($userPhoto->file_Id); ?>">
                        <?php if(!DB::table('reacts')->where('user_Id',Auth::id())->where('file_Id',$userPhoto->file_Id)->exists()): ?>
                            <input type="hidden" id="plusOne" name="plusOneLike" value="+1">
                        <?php else: ?>
                            <input type="hidden" id="plusOne" name="plusOneLike" value="-1">
                        <?php endif; ?>
                    </form>
                        <?php if(!DB::table('reacts')->where('user_Id',Auth::id())->where('file_Id',$userPhoto->file_Id)->exists()): ?>
                            <input type="button" id="likebutton-<?php echo e($userPhoto->file_Id); ?>" onclick="React(<?php echo e($userPhoto->file_Id); ?>, +1)" name="plusOneLike" value="Like">
                        <?php else: ?>
                            <input type="button" id="likebutton-<?php echo e($userPhoto->file_Id); ?>" onclick="React(<?php echo e($userPhoto->file_Id); ?>, -1)" name="plusOneLike" value="Unlike">
                        <?php endif; ?>
                    </div>
                    <div id="list-<?php echo e($i); ?>" class="mainfeed__comments">
                        <ul class="list">
                        <?php
                            $comments = DB::table('comments')
                            ->where('file_Id', $userPhoto->file_Id)
                            ->orderBy('created_at', 'desc')
                            ->get();
                        ?>
                        <li class="list-comments"><div id="new_comment-<?php echo e($userPhoto->file_Id); ?>"></div></li>
                        <?php $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(Carbon::parse($comment->created_at)->diffInDays() <= 1): ?>
                                <?php
                                    $createdAt = Carbon::parse($comment->created_at)->diffForHumans();
                                ?>
                            <?php else: ?>
                                <?php
                                    $createdAt = Carbon::parse($comment->created_at)->formatLocalized('%A %d. %B %Y');  
                                ?>
                            <?php endif; ?>
                            <?php
                                $author = DB::table('users')->where('user_Id', $comment->user_Id)->first();
                            ?>
                            <li class="list-comments"><div class="<?php echo e($comment->comment_Id); ?>"><div class="mainfeed__comments-posts"><?php echo e($author->first_Name); ?> <?php echo e($author->last_Name); ?> - <?php echo e($createdAt); ?>

                            
                            <?php if($comment->user_Id == Auth::id()): ?>
                                <input type="button" class="btn-deleteCmnt" onclick="DeleteComment('<?php echo e($comment->comment_Id); ?>')" value="Delete">
                            <?php endif; ?>
                            </div>
                            <div class="comment-text"><?php echo e($comment->comment_Text); ?></div></div></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                        <ul class="pagination"></ul>
                        <script>
                            var pagination = new List('list-<?php echo e($i); ?>', {
                              valueNames: ['name'],
                              page: 6,
                              pagination: true
                            });
                        </script>
                        <p id="output"></p>
                    </div>

                    <?php if(DB::table('users')->where($user_Id == Auth::Id())): ?>
                        <form class="mfeed-p" id="newcomment-<?php echo e($userPhoto->file_Id); ?>" method="POST" value="<?php echo csrf_token(); ?>" name="_token">
                            <input type="hidden" name="file_Id" value="<?php echo e($userPhoto->file_Id); ?>">
                            <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                            <textarea id="comment-data-<?php echo e($userPhoto->file_Id); ?>" rows="4" cols="50" class="feed-input" name="comment_Text" placeholder="Comment.."></textarea>
                            <input type="button" class="btn btn-upload btn-event-upload" onclick="addComment(<?php echo e($userPhoto->file_Id); ?>)" value="Leave comment">
                        </form>
                    <?php endif; ?> 
                </div>
            <?php endif; ?>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </div>
</div>

<?php if(!empty($comment)): ?>
<script>
    function DeleteComment(pid) {
        var token = $('meta[name="csrf-token"]').attr('content');
        
        $.ajax({
            type: "POST",
            url: "<?php echo e(url('/')); ?>/deleteComment",
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                _token:'<?php echo e(csrf_token()); ?>',
                comment_Id: pid
            },
            success:function(data){
                $('.'+pid).remove();
            },
            error:function(){
                alert("Couldn't load your comment.");
            }
        });
    };
</script>
<?php endif; ?>
<?php if(Auth::check()): ?>
<script>
    function addComment(id) {
        var comment = document.getElementById('comment-data');
        var data = $('#newcomment-'+id).serialize();
        var text = $("#comment-data-"+id).val();
        
        $.ajax({
            type: "POST",
            url: "<?php echo e(url('/')); ?>/newComment",
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: (data)
        })
        $('#new_comment-'+id).prepend('<?php echo e(\Auth::user()->first_Name); ?> <?php echo e(\Auth::user()->last_Name); ?> - Now </br> '+text+'</br>');
        document.getElementById('comment-data-'+id).value = '';
    }
    
    function React(id, value2) {
        var token = $('meta[name="csrf-token"]').attr('content');
        var count = document.getElementById('like-'+id).getAttribute('value');
                
        $.ajax({
            type: "POST",
            url: "<?php echo e(url('/')); ?>/plusOne",
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: $('#likeform-'+id).serialize(),
            success:function(data){
                if (value2 == 1){
                    $('#like-'+id).html(Math.abs(count)+1);
                    document.getElementById('like-'+id).value = Math.abs(count+1);
                    $("#like-"+id).attr("value",Math.abs(count)+1);
                    document.getElementById('likebutton-'+id).value = 'Unlike';
                    $("#likebutton-"+id).attr("onclick","React("+id+", -1)");
                }else{
                    $('#like-'+id).html(Math.abs(count)-1);
                    document.getElementById('like-'+id).value = (Math.abs(count)-1);
                    $("#like-"+id).attr("value",Math.abs(count)-1);
                    document.getElementById('likebutton-'+id).value = 'Like';
                    $("#likebutton-"+id).attr("onclick","React("+id+", +1)");
                }
            },
            error:function(){
                alert("Something went wrong.");
            }
        });
    };
</script>
<?php endif; ?>
<script type="text/javascript" src="<?php echo e(URL::asset('js/lightbox.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('js/pagination.js')); ?>"></script>
<script src="<?php echo e(URL::asset('js/modal.js')); ?>"></script>
</body>
</html>
