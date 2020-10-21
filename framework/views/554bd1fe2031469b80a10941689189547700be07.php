<?php $__env->startSection('content'); ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 col-md-offset">
            <img src="<?php echo e($user->avatar); ?>" style="width: 150px;height:150px; float: left; border-radius: 50%"/>
            <h2>Profil użytkownika <?php echo e($user->name); ?></h2>
            <form enctype="multipart/form-data" action="profile" method="POST">
                <label>Nowe zdjęcie</label><br/>
                <input type="file" name="avatar"><br/>
                <?php echo csrf_field(); ?>
                <input type="submit" value="Dodaj zdjęcie" class="pull-right btn btn-sm btn-primary"><br/>
                
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\projekt_zespolowy\resources\views/profile.blade.php ENDPATH**/ ?>