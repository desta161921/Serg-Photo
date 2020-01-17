<!DOCTYPE html>
<html>
<head>
    <?php echo $__env->make('includes.head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;
</head>
<body>
<?php echo $__env->make('includes.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php
            use Carbon\Carbon;
            use App\Comment;
?>
<div class="container__album">
    <div class="wrapper__album">
        <div class="album__list">
            <h2 class="album__list-heading"><?php echo e($album->album_Name); ?></h2>
            <p class="album__list-p"><?php echo e($album->album_Description); ?></p>
        </div>
        <?php if(DB::table('albums')->where('album_Id', $album->album_Id)->where('user_Id', Auth::id())->exists()): ?>
            <div class="album__information">
                <p class="album__information-p">Current privacy: <?php echo e($album->album_Permission); ?></p>
                <div class="album-information-main">
                    
                    <form method="POST" class="album-information-form" action="/updateAlbum" value="<?php echo csrf_token(); ?>">
                        <?php echo e(csrf_field()); ?>

                        <input type="hidden" name="album_Id" value="<?php echo e($album->album_Id); ?>">
                        <div class="album-information-radio">
                        <?php if($album->album_Permission == 'private'): ?>
                            <label class="album-label"><input type="radio" class="album-radio" name="album_Privacy" value="private" checked>Private</input></label>
                            <label class="album-label"><input type="radio" class="album-radio" name="album_Privacy" value="public">Public</input></label>
                        <?php else: ?>
                            <label class="album-label"><input type="radio" class="album-radio" name="album_Privacy" value="private">Private</input></label>
                            <label class="album-label"><input type="radio" class="album-radio" name="album_Privacy" value="public" checked>Public</input></label>
                        <?php endif; ?>
                        </div>
                        <input type="submit" class="btn btnH btn-upload" value="Update privacy">
                    </form>
                    
                                          
                    <form method="POST" action="/deleteAlbum" value="<?php echo csrf_token(); ?>">
                        <?php echo e(csrf_field()); ?>

                        <input type="hidden" name="album_Id" value="<?php echo e($album->album_Id); ?>">
                        <input type="submit" class="btn btnH btn-upload" onclick="return deleteAlbum();" value="Delete album">
                    </form>
                </div>                    
            </div>

            <div id="myModal" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="modal-heading">
                            <h2 class="modal-heading-h">Upload photo</h2>
                        </div>
                        <span class="btn-closeModal">&times;</span>
                    </div>
                    <div class="modal-body-album">
                        <div class="image__upload">
                            <form class="image__upload-form" value="<?php echo csrf_token(); ?>" enctype="multipart/form-data" name="_token" action="/uploadImage"  method="POST">
                                <div class="image__upload-l">
                                    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                                    <input type="hidden" name="album_Id" value="<?php echo e($album->album_Id); ?>">
                                    <input type="text" class="image__upload-input" name="file_Description" placeholder="Caption.." required>
                                    <input type="text" id="geocomplete" class="image__upload-input" name="file_Location" placeholder="Location.." required>
                                </div>
                                <div class="image__upload-r">
                                    <input type="file" accept="image/*" onchange="preview_image(event)" name="profileImages">
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
        <?php if(DB::table('albums')->where('album_Id', $album->album_Id)->where('album_Permission', 'private')->exists() && !DB::table('albums')->where('album_Id', $album->album_Id)->where('user_Id', Auth::id())->exists()): ?>
            <p class="text-mid">Album is private. Only owner can see content.</p>
        <?php else: ?>
            <?php
                $photo = DB::table('files')->where('album_Id', $album->album_Id)->orderBy('file_Id', 'Desc')->paginate(20);
            ?>
            <div class="album__images">
                <div class="profile__gallery-row">
                    <div class="profile__gallery-plus">
                        <a id="myBtn" class="delete__photo-form" href="#"><img class="album__images-plus" src="<?php echo e(url('/')); ?>/img/plus.png"></a>
                    </div>
                    <?php $__currentLoopData = $photo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $photos): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="profile__gallery-column">
                        <?php
                            $comments = DB::table('comments')
                                ->where('file_Id', $photos->file_Id)
                                ->orderBy('created_at', 'desc')
                                ->get(); 
                                
                        ?>
                        <div id="box-<?php echo e($photos->file_Id); ?>" hidden>
                            <div class="album__l">
                                <div class="album__l-l">
                                    <img class="album__l-img" src="<?php echo e(url('/')); ?>/uploads/users/<?php echo e($photos->user_Id); ?>/<?php echo e($album->album_Name); ?>/<?php echo e($photos->file_Name); ?>">
                                </div>
                                <div class="album__l-r"> 
                                    <div class="album__l-d">
                                        <p class="album__l-owner"> <?php echo e(DB::table('users')->where('user_Id', $photos->user_Id)->first()->first_Name); ?> <?php echo e(DB::table('users')->where('user_Id', $photos->user_Id)->first()->last_Name); ?> </p>
                                        <p> <?php echo e($photos->created_at); ?> </p>
                                        
                                        <div class="album__likes"><div id="like-<?php echo e($photos->file_Id); ?>" value="<?php echo e((DB::table('reacts')->where('file_Id', $photos->file_Id)->count())); ?>"><?php echo e((DB::table("reacts")->where("file_Id", $photos->file_Id)->count())); ?></div>&nbsp;like(s)</div> 
                                        
                                        <?php
                                            $reactnames = DB::table("reacts")->where("file_Id", $photos->file_Id)->take(2)->orderBy("created_at", "desc")->get()
                                        ?>
                                        <?php $__currentLoopData = $reactnames; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reactname): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php echo e(app\User::find($reactname->user_Id)->first_Name . " " . app\User::find($reactname->user_Id)->last_Name); ?>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <form method="POST" id="likeform-<?php echo e($photos->file_Id); ?>">
                                            <?php echo e(csrf_field()); ?>

                                            <input type="hidden" name="file_Id" value="<?php echo e($photos->file_Id); ?>">
                                            <?php if(!DB::table("reacts")->where("user_Id",Auth::id())->where("file_Id",$photos->file_Id)->exists()): ?>
                                                <input type="hidden" id="plusOne" name="plusOneLike" value="Like">
                                            <?php else: ?>
                                                <input type="hidden" id="plusOne" name="plusOneLike" value="Unlike">
                                            <?php endif; ?>
                                        </form>
                                        <?php if(!DB::table("reacts")->where("user_Id",Auth::id())->where("file_Id",$photos->file_Id)->exists()): ?>
                                            <input type="button" id="likebutton-<?php echo e($photos->file_Id); ?>" onclick="React(<?php echo e($photos->file_Id); ?>, +1)" name="plusOneLike" value="Like">
                                        <?php else: ?>
                                            <input type="button" id="likebutton-<?php echo e($photos->file_Id); ?>" onclick="React(<?php echo e($photos->file_Id); ?>, -1)" name="plusOneLike" value="Unlike">
                                        <?php endif; ?>
                                    </div>
                                    <div class="album__l-commentsection"><div class="new_comment-<?php echo e($photos->file_Id); ?>"></div>
                                        <?php $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if(Carbon::parse($comment->created_at)->diffInDays() <= 1): ?>
                                                <?php
                                                $createdAt = Carbon::parse($comment->created_at)->diffForHumans();
                                                ?>
                                            <?php else: ?>
                                                <?php
                                                $createdAt = Carbon::parse($comment->created_at)->formatLocalized("%A %d. %B %Y");  
                                                ?>
                                            <?php endif; ?>
                                            <?php
                                                 $author = DB::table("users")->where("user_Id", $comment->user_Id)->first();
                                            ?>
                                            <div class="<?php echo e($comment->comment_Id); ?>"><div class="album__l-comments">
                                                <p class="album__l-author"> <?php echo e($author->first_Name); ?> <?php echo e($author->last_Name); ?> - <?php echo e($createdAt); ?> </p>
                                                <?php if($comment->user_Id == Auth::id()): ?>
                                                    <input type="button" class="btn-deleteCmnt" onclick="DeleteComment(<?php echo e($comment->comment_Id); ?>)" value="Delete">
                                                <?php endif; ?>
                                            </div>
                                            <p class="album__l-comment"> <?php echo e($comment->comment_Text); ?> </p></div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    
            
                                        <form class="album__l-nc" id="newcomment-<?php echo e($photos->file_Id); ?>" method="POST" value="<?php echo csrf_token(); ?>" name="_token">
                                            <input type="hidden" name="file_Id" value="<?php echo e($photos->file_Id); ?>">
                                            <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                                            <textarea id="comment-data-<?php echo e($photos->file_Id); ?>" rows="3" cols="50" class="feed-input" name="comment_Text" placeholder="Comment.." style="width: 100%"></textarea>
                                            <input type="button" class="btn btn-form btn-cmnt" onclick="addComment(<?php echo e($photos->file_Id); ?>)" value="Leave comment">
                                        </form>
                                        
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="#" data-featherlight='#box-<?php echo e($photos->file_Id); ?>'><img class="album__images-img" src="<?php echo e(url('/')); ?>/uploads/users/<?php echo e($photos->user_Id); ?>/<?php echo e($album->album_Name); ?>/<?php echo e($photos->file_Name); ?>"></a>
                        <?php if($photos->user_Id == Auth::id()): ?>
                            <form class="delete__photo-form" method="POST" action="/deletePhoto" value="<?php echo csrf_token(); ?>" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                                <input type="hidden" name="event_Id" value="<?php echo e($photos->event_Id); ?>">
                                <input type="hidden" name="user_Id" value="<?php echo e($photos->user_Id); ?>">
                                <input type="hidden" name="file_Name" value="/uploads/users/<?php echo e($photos->user_Id); ?>/<?php echo e($album->album_Name); ?>/<?php echo e($photos->file_Name); ?>">
                                <input type="submit" class="btn btnH btn-deletephoto" value="Delete">
                            </form>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php echo e($photo->links()); ?>

        <?php endif; ?>
    </div>
</div>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBquHYr7B677DsAk_rvnt09kDyAcJ6KC4U&amp;sensor=false&amp;libraries=places"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo e(URL::asset('js/jquery.geocomplete.min.js')); ?>"></script>
    <script>
      $(function(){
        $("#geocomplete").geocomplete()
      });
    </script>
<script type="text/javascript" src="<?php echo e(URL::asset('js/lightbox.min.js')); ?>"></script>
<script src="//cdn.rawgit.com/noelboss/featherlight/1.7.13/release/featherlight.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo e(URL::asset('js/modal.js')); ?>"></script>
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
        var data = $('.featherlight-inner #newcomment-'+id).serialize();
        var text = $(".featherlight-inner #comment-data-"+id).val();
        
        $.ajax({
            type: "POST",
            url: "<?php echo e(url('/')); ?>/newComment",
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: (data)
        })
        $('.new_comment-'+id).prepend('<p class="album__l-author"><?php echo e(\Auth::user()->first_Name); ?> <?php echo e(\Auth::user()->last_Name); ?> - Now </p></br> <p class="album__l-comment">'+text+'</p></br>');
 	$(".featherlight-inner #comment-data-"+id).val('');       
    }
    
    function React(id, value2) {
        var token = $('meta[name="csrf-token"]').attr('content');
        var count = $('.featherlight-inner #like-'+id).val();
                
        $.ajax({
            type: "POST",
            url: "<?php echo e(url('/')); ?>/plusOne",
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: $('.featherlight-inner #likeform-'+id).serialize(),
            success:function(data){
                if (value2 == 1){
                    $('.featherlight-inner #like-'+id).html(Math.abs(count)+1);
                    $('.featherlight-inner #like-'+id).val(Math.abs(count)+1);
                    $(".featherlight-inner #like-"+id).attr("value",Math.abs(count)+1);
                    $(".featherlight-inner #likebutton-"+id).val('Unlike');
                    $(".featherlight-inner #likebutton-"+id).attr("onclick","React("+id+", -1)");
                }else{
                    $('.featherlight-inner #like-'+id).html(Math.abs(count)-1);
                    $('.featherlight-inner #like-'+id).val(Math.abs(count)-1);
                    $(".featherlight-inner #like-"+id).attr("value",Math.abs(count)-1);
                    $(".featherlight-inner #likebutton-"+id).val('Like');
                    $(".featherlight-inner #likebutton-"+id).attr("onclick","React("+id+", +1)");
                }
            },
            error:function(){
                alert("Something went wrong.");
            }
        });
    };
</script>
</body>
</html>
