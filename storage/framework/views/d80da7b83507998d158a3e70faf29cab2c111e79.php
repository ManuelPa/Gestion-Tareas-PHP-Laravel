<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Vista ejemplo</title>
</head>
<body>
	
	<?php $__env->startSection('content'); ?>

    <h1>Hola mundo desde Laravel</h1>

    <?php $__env->stopSection(); ?>
</body>
</html>
<?php echo $__env->make('layouts/app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>