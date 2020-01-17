<html>
    <head>
        <?php echo $__env->make('includes.head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <h1>Upload your file: </h1>
                <form action="<?php echo e(URL::to('upload')); ?>" method="POST" enctype="multipart/form-data">
                    <label>Select your file to upload:</label>
                    <input type="file" name="file" id="file">
                    <input type="submit" value="Upload" name="Submit">
                    <input type="hidden" value="<?php echo e(csrf_token()); ?>" name="_token">
                </form>
            </div>
        </div>
    </body>
</html>