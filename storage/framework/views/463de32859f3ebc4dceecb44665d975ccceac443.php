<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"> 
                    Tablón de Tareas de <?php echo e($email); ?>. Tab :<?php echo e($tab->name); ?>.
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="tab col-md-12" id="tab<?php echo e($tab->id); ?>" style="background-color: <?php echo e($tab->color); ?>;">
                            <div class="col-md-6">
                                <h3><?php echo e($tab->name); ?></h3>
                            </div>
                            <div class="col-md-6">
                                <button class="btn">voz</button>
                            </div>
                            <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($tab->id == $task->id_tab): ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="<?php echo e(url('deletetaskt')); ?>" method="post">
                                        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>"><!--MUY IMPORTANTE: Necesario para poder enviar datos por post(Metodo de seguridad)-->
                                        <input type="text" class="inputask" name="tasktext<?php echo e($task->id); ?>" id="tasktext<?php echo e($task->id); ?>" value="<?php echo e($task->text); ?>">
                                         <?php if($task->check == 'true'): ?>
                                        <input type="checkbox" name="taskcheck<?php echo e($task->id); ?>" id="taskcheck<?php echo e($task->id); ?>" checked />
                                        <label for="taskcheck<?php echo e($task->id); ?>"></label>
                                        <?php else: ?>
                                        <input type="checkbox" name="taskcheck<?php echo e($task->id); ?>" id="taskcheck<?php echo e($task->id); ?>"/>
                                        <label for="taskcheck<?php echo e($task->id); ?>"></label>
                                        <?php endif; ?>
                                        <input type="hidden" name="id_tab" value="<?php echo e($tab->id); ?>"/>
                                        <input type="hidden" name="id_task" value="<?php echo e($task->id); ?>"/>
                                        <input type="submit" class="btn" value="E">
                                    </form>
                                </div>
                            </div>
                            <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-12">
                                <form action="<?php echo e(url('newtaskt')); ?>" method="post">
                                    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>"><!--MUY IMPORTANTE: Necesario para poder enviar datos por post(Metodo de seguridad)-->
                                    <input type="hidden" name="id_tab" value="<?php echo e($tab->id); ?>"/>
                                    <input type="text" placeholder="Añade una nueva tarea..." class="inputask2" name="tasktextnew<?php echo e($tab->id); ?>" required>
                                    <input type="submit" class="btn" value="Añadir tarea">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>