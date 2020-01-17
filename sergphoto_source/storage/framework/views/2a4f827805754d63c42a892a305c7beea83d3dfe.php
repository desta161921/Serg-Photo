<!DOCTYPE html>
<html>
<head>
    <?php echo $__env->make('includes.head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <script src="//cdnjs.cloudflare.com/ajax/libs/list.js/1.5.0/list.min.js"></script>
</head>
<body>
<?php echo $__env->make('includes.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<div class="container__events">
    <div class="wrapper__events">
        <?php
            use Carbon\Carbon;
            $i = 0;
        ?>
        <?php if( (!is_null(DB::table('events')->where('event_Id', '=', $event->event_Id)->where('event_Privacy', '=', 'private')->first())) and
        (is_null(DB::table('participants')->where('user_Id', '=', Auth::id())->where('event_Id', '=', $event->event_Id)->first()))): ?>
            <div class="event__info">
                <h1 class="event__description-name">You do not have access to this event</h1>
            </div>
        <?php else: ?>
            <div class="event__header" style="background-image: url('<?php echo e(url('/')); ?>/uploads/events/<?php echo e($event->event_Header); ?>')"></div>
            <div class="event__info">
                <h1 class="event__description-name"><?php echo e($event->event_Name); ?></h1>
                <p class="event__description-about e__d-a"><?php echo e($event->event_Description); ?></p> 
            </div>
            <div class="event__btn-group">
            <?php if((is_null(DB::table('participants')->where('user_Id', '=', Auth::id())->where('event_Id', '=', $event->event_Id)->first())) && Auth::check()): ?>
                <form name="_token" method="POST" action="/joinEvent" value="<?php echo csrf_token(); ?>">
                    <?php echo e(csrf_field()); ?>

                    <input type="hidden" name="event_Id" value="<?php echo e($event->event_Id); ?>" action="<?php echo e(action('EventController@joinEvent')); ?>">
                    <button class="btn btn-form event__btn-group" id="join">Click to join</button>
                </form>
            <?php endif; ?>
            <button id="myBtn" class="btn btn-form event__btn-group">Participants</button>
            <?php if((!is_null(DB::table('participants')->where('user_Id', '=', Auth::id())->where('event_Id', '=', $event->event_Id)->first()))): ?>
                <form name="_token" method="POST" action="/leaveEvent" value="<?php echo csrf_token(); ?>">
                    <?php echo e(csrf_field()); ?>

                    <input type="hidden" name="event_Id" value="<?php echo e($event->event_Id); ?>" action="<?php echo e(action('EventController@leaveEvent')); ?>">
                    <button class="btn btn-form event__btn-group" id="join" onclick="return confirmLeave();">Click to leave</button>
                </form>
                <button id="myBtn2" class="btn btn-form event__btn-group">Upload image</button>
            <?php endif; ?>
            <?php if((!is_null(DB::table('participants')->where('user_Id', '=', Auth::id())->where('event_Id', '=', $event->event_Id)->where('participant_Role', '=', 'Admin')->first()))): ?>
                <a class="btn btn-form event__btn-group" href="<?php echo e(url('/events/edit', [$event->event_Id])); ?>" id="edit__event">Edit event</a>
                <a class="btn btn-form event__btn-group" href="<?php echo e(url('/events/'. $event->event_Id .'/invitation')); ?>" id="edit__event">Invitation</a>
            <?php endif; ?>
            </div>
            <div class="event-feed">
                <div class="event-pictures">
                    <?php
                        $eventPhotos = DB::table('files')
                        ->where('event_Id', "=", $event->event_Id)
                        ->orderBy('file_Id', 'desc')
                        ->get();
                    ?>
                    <?php $__currentLoopData = $eventPhotos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $eventPhoto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <p class="mainfeed__post-description mfeed-p"><?php echo e($eventPhoto->file_Description); ?></p>
                        <div class="mainfeed__post-flex">
                            <p class="mainfeed__post-author"><?php echo e($eventPhoto->file_Location); ?></p>
                            <?php if(DB::table('users')->where('user_Id', $eventPhoto->user_Id)->first()->user_Id == Auth::Id() OR DB::table('participants')->where('user_Id', Auth::Id())->where('event_Id', $eventPhoto->event_Id)->where('participant_Role', "Admin")->exists()): ?>
                                <form name="delete__photo" method="POST" action="/deletePhoto" value="<?php echo csrf_token(); ?>" enctype="multipart/form-data">
                                    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                                    <input type="hidden" name="event_Id" value="<?php echo e($eventPhoto->event_Id); ?>">
                                    <input type="hidden" name="user_Id" value="<?php echo e($eventPhoto->user_Id); ?>">
                                    <input type="hidden" name="file_Name" value="/uploads/events/<?php echo e($event->event_Id); ?>/<?php echo e($eventPhoto->file_Name); ?>">
                                    <input type="submit" class="btn-delPhoto" value="Delete photo">
                                </form>
                            <?php endif; ?>
                            <p class="mainfeed__post-author"><?php echo e(DB::table('users')->where('user_Id', $eventPhoto->user_Id)->first()->first_Name); ?> <?php echo e(DB::table('users')->where('user_Id', $eventPhoto->user_Id)->first()->last_Name); ?></p>
                        </div>
                        <img src='/uploads/events/<?php echo e($event->event_Id); ?>/<?php echo e($eventPhoto->file_Name); ?>' class='mainfeed__post-img'></img>
                        <div id="img-<?php echo e($eventPhoto->file_Id); ?>" class="mainfeed__plus">
                            <div id="like-<?php echo e($eventPhoto->file_Id); ?>" value="<?php echo e((DB::table('reacts')->where('file_Id', $eventPhoto->file_Id)->count())); ?>"><?php echo e((DB::table('reacts')->where('file_Id', $eventPhoto->file_Id)->count())); ?></div>
                            <?php
                                $i ++;
                                $reactnames = DB::table('reacts')->where('file_Id', $eventPhoto->file_Id)->take(2)->orderBy('created_at', 'desc')->get()
                            ?>
                            <?php $__currentLoopData = $reactnames; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reactname): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php echo e(app\User::find($reactname->user_Id)->first_Name . " " . app\User::find($reactname->user_Id)->last_Name); ?>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <p>likes this.</p>
                            <form method="POST" id="likeform-<?php echo e($eventPhoto->file_Id); ?>" value="<?php echo csrf_token(); ?>">
                                <?php echo e(csrf_field()); ?>

                                <input type="hidden" id="file_Id" name="file_Id" value="<?php echo e($eventPhoto->file_Id); ?>">
                                <?php if(!DB::table('reacts')->where('user_Id',Auth::id())->where('file_Id',$eventPhoto->file_Id)->exists()): ?>
                                    <input type="hidden" id="plusOne" name="plusOneLike" value="+1">
                                <?php else: ?>
                                    <input type="hidden" id="plusOne" name="plusOneLike" value="-1">
                                <?php endif; ?>
                            </form>
                            <?php if(!DB::table('reacts')->where('user_Id',Auth::id())->where('file_Id',$eventPhoto->file_Id)->exists()): ?>
                                <input type="button" id="likebutton-<?php echo e($eventPhoto->file_Id); ?>" onclick="React(<?php echo e($eventPhoto->file_Id); ?>, +1)" name="plusOneLike" value="Like">
                            <?php else: ?>
                                <input type="button" id="likebutton-<?php echo e($eventPhoto->file_Id); ?>" onclick="React(<?php echo e($eventPhoto->file_Id); ?>, -1)" name="plusOneLike" value="Unlike">
                            <?php endif; ?>
                        </div>
                        <div id="list-<?php echo e($i); ?>" class="mainfeed__comments">
                        <ul class="list">
                        <?php
                            $comments = DB::table('comments')
                            ->where('file_Id', $eventPhoto->file_Id)
                            ->orderBy('created_at', 'desc')
                            ->get();
                        ?>
                        <li class="list-comments"><div id="new_comment-<?php echo e($eventPhoto->file_Id); ?>"></div></li>
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
                        </div>
                        <form class="mfeed-p" id="newcomment-<?php echo e($eventPhoto->file_Id); ?>" action="/newComment" method="POST" value="<?php echo csrf_token(); ?>" name="_token">
                            <input type="hidden" name="file_Id" value="<?php echo e($eventPhoto->file_Id); ?>">
                            <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                            <textarea id="comment-data-<?php echo e($eventPhoto->file_Id); ?>" rows="4" cols="50" class="feed-input" name="comment_Text" placeholder="Comment.." required></textarea>
                            <input type="button" onclick="addComment(<?php echo e($eventPhoto->file_Id); ?>)" class="btn btn-upload btn-event-upload" value="Leave comment">
                        </form>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <div id="myModal" class="modal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="modal-heading">
                                <h2 class="modal-heading-h">Participants</h2>
                            </div>
                            <span class="btn-closeModal">&times;</span>
                        </div>
                        <div class="modal-body">
                            <table class="event__table">
                                <tr>
                                    <td><h3 class="event__table-h">Full name</h3></td>
                                    <td><h3 class="event__table-h">Role</h3></td>
                                </tr>
                                <?php
                                    $row = DB::table('participants')->where('event_Id', $event->event_Id)->get();
                            
                                    foreach ($row as $participants) {
                                        echo "<tr><td><p class='event__table-p'>" . \App\User::find($participants->user_Id)->first_Name. " ". \App\User::find($participants->user_Id)->last_Name . "</td><td><p class='event__table-p'>".  $participants->participant_Role . "</p></tr>" ;
                                    }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            
                <div id="myModal2" class="modal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="modal-heading">
                                <h2 class="modal-heading-h">Upload photo</h2>
                            </div>
                            <span class="btn-closeModal2">&times;</span>
                        </div>
                        <div class="modal-body-image">
                            <div class="image__upload">
                                <form class="image__upload-form" value="<?php echo csrf_token(); ?>" enctype="multipart/form-data" name="_token" action="/uploadImage"  method="POST">
                                    <div class="image__upload-l">
                                        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                                        <input type="hidden" name="event_Id" value="<?php echo e($event->event_Id); ?>">
                                        <input type="text" class="image__upload-input" name="file_Description" placeholder="Caption.." required>
                                        <input type="text" id="geocomplete" class="image__upload-input" name="file_Location" placeholder="Location.." required>
                                    </div>
                                    <div class="image__upload-r">
                                        <input type="file" accept="image/*" onchange="preview_image(event)" name="eventImages">
                                        <select class="image__upload-select" name="filter" id="filter" onchange="changeFilters()">
                                            <option value="Select-filter">Select Filter</option>
                                            <option value="Normal" checked>Normal</option>
                                            <option value="Grayscale">Grayscale</option>
                                            <option value="Invert">Invert</option>
                                            <option value="Sepia">Sepia</option>
                                            <option value="Saturate">Saturate</option>
                                            <option value="Opacity">Opacity</option>
                                            <option value="Hue-rotate">Hue Rotate</option>
                                            <option value="Brightness">Brightness</option>
                                            <option value="Contrast">Contrast</option>
                                        </select>
                                        <input type="submit" class="btn btn-uploadImage" value="Upload image">
                                    </div>
                                </form>
                            </div>
                            <div class="image__upload-bottom">
                                <img class="image__upload-img" id="output_image"/>
                            </div>
                        </div>
                    </div>
                </div>
        <?php endif; ?>
    </div>
</div>
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBquHYr7B677DsAk_rvnt09kDyAcJ6KC4U&amp;sensor=false&amp;libraries=places"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo e(URL::asset('js/jquery.geocomplete.min.js')); ?>"></script>
<script>
$(function(){
    $("#geocomplete").geocomplete()
});
</script>
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
                alert("smekere");
            }
        });
    };
</script>
<script type="text/javascript" src="<?php echo e(URL::asset('js/modal.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(URL::asset('js/main.js')); ?>"></script>


</body>
</html>

