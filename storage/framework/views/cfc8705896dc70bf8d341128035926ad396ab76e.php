<?php $__env->startSection('kirinti'); ?>
	<?php echo e(trans('messages.usersaveheader')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('endscripts'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<form action="/users/save" method="post" name='a'>

 <div class="card  mx-auto mt-2" style="width: 550px">
      <div class="card-header"><?php echo e(trans('messages.usersaveheader')); ?></div>
      <div class="card-body">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">

            				<hr />
                            <div class="panel-body">

                                    <?php echo e(csrf_field()); ?>


                                    <div class="form-group<?php echo e($errors->has('name') ? ' has-error' : ''); ?>">
                                        <label for="name" class="col-md-4 control-label"><?php echo e(trans('messages.registerfirmaname')); ?></label>

                                        <div class="col-md-12">
                                            <input id="name" type="text" class="form-control" name="name" value="<?php echo e(old('name')); ?>" required autofocus>

                                            <?php if($errors->has('name')): ?>
                                                <span class="help-block">
                                                    <strong><?php echo e($errors->first('name')); ?></strong>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                                        <label for="email" class="col-md-12 control-label"><?php echo e(trans('messages.loginemail')); ?></label>

                                        <div class="col-md-12">
                                            <input id="email" type="email" class="form-control" name="email" value="<?php echo e(old('email')); ?>" required>

                                            <?php if($errors->has('email')): ?>
                                                <span class="help-block">
                                                    <strong><?php echo e($errors->first('email')); ?></strong>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
																	<div class="form-group">
																			<label for="bolgeSecim"><?php echo e(trans("messages.bolge")); ?></label>
																			<div class="col-md-12">
																				<select name='bolgeSecim' class="form-control"  id="" >
																						<option value='0'>(<?php echo e(trans("messages.choose")); ?>)</option>
																							<?php if(!empty($bolge)): ?>
																								<?php $__currentLoopData = $bolge; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $z=>$m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
																									<option value='<?php echo e($m->id); ?>'><?php echo e($m->name); ?></option>
																								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
																							<?php endif; ?>
																				</select>
																			</div>

																		</div>

                                    <div class="form-group<?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
                                        <label for="password" class="col-md-12 control-label"><?php echo e(trans('messages.loginpassword')); ?></label>

                                        <div class="col-md-12">
                                            <input id="password" type="password" class="form-control" name="password" required>

                                            <?php if($errors->has('password')): ?>
                                                <span class="help-block">
                                                    <strong><?php echo e($errors->first('password')); ?></strong>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                     <div class="form-group">
                                        <label for="vergiNo" class="col-md-12 control-label"><?php echo e(trans('messages.firmavergi')); ?></label>


                                        <div class="col-md-12">
                                            <input id="vergiNo" type="text" class="form-control" name="vergiNo" value="<?php echo e(old('vergiNo')); ?>" required>
                                        </div>
                                    </div>
                                     <div class="form-group">
                                        <label for="vergiDairesi" class="col-md-12 control-label"><?php echo e(trans('messages.firmavergidaire')); ?></label>
                                        <div class="col-md-12">
                                            <input id="vergiDairesi" type="text" class="form-control" name="vergiDairesi" value="<?php echo e(old('vergiDairesi')); ?>" required>
                                        </div>
                                    </div>
                                     <div class="form-group">
                                        <label for="telefonNo" class="col-md-12 control-label"><?php echo e(trans('messages.firmatelefon')); ?></label>
                                        <div class="col-md-12">
                                            <input id="telefonNo" type="text" class="form-control" name="telefonNo" value="<?php echo e(old('telefonNo')); ?>" required>
                                        </div>
                                    </div>
                                     <div class="form-group">
                                        <label for="address" class="col-md-12 control-label"><?php echo e(trans('messages.firmaadres')); ?></label>
                                        <div class="col-md-12">
                                            <input id="address" type="text" class="form-control" name="address" value="<?php echo e(old('address')); ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-md-offset-4">
                                            <button type="submit" class="btn btn-primary">
                                                <?php echo e(trans('messages.save')); ?>

                                            </button>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

</div>
</div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>