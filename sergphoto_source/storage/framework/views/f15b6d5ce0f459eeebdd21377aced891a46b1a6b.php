<!DOCTYPE html>
<html>
<head>
    <title>Welcome to SergPhoto</title>
</head>
 
<body>
<h2>Welcome <?php echo e($user['first_Name']); ?> <?php echo e($user['last_Name']); ?> to SergPhoto</h2>
<br/>
Your registered email is <?php echo e($user['email']); ?>

<br>
<p>Thank you for using our application!</p>
</body>
 
</html>
 