<?php $__env->startSection('kirinti'); ?>
	<?php echo e(trans('messages.usersaveheader')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('endscripts'); ?>
<script>
require(['select2'], function() {

		 $('#select333').select2();
});

</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<form action="/admins/update" method="post" name='a'>

 <div class="card  mx-auto mt-2" style="width: 550px">
      <div class="card-header"><?php echo e(trans('messages.usersaveheader')); ?></div>
      <div class="card-body">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading"><?php echo e(trans('messages.save')); ?></div>
            				<hr />
                            <div class="panel-body">

                                    <?php echo e(csrf_field()); ?>


                                    <div class="form-group<?php echo e($errors->has('name') ? ' has-error' : ''); ?>">
                                        <label for="name" class="col-md-4 control-label"><?php echo e(trans('messages.adminusername')); ?></label>
																				<input type="hidden" name="userId" value="<?php echo e($userList->id); ?>" />
                                        <div class="col-md-12">
                                            <input id="name" type="text" class="form-control" name="name" value="<?php echo e($userList->name); ?>" required autofocus>

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
                                            <input id="email" type="email" class="form-control" name="email" value="<?php echo e($userList->email); ?>" required>

                                            <?php if($errors->has('email')): ?>
                                                <span class="help-block">
                                                    <strong><?php echo e($errors->first('email')); ?></strong>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
																		<?php if(\Auth::user()->role=="admin"): ?>
																	<div class="form-group">
																			<label for="bolgeSecim"><?php echo e(trans("messages.bolge")); ?></label>
																			<div class="col-md-12">
																				<select  <?php if($userList->role=="muhasebeadmin"): ?> name='bolgeSecim[]' multiple <?php else: ?> name='bolgeSecim' <?php endif; ?>  class="form-control"  id="select333" >
																						<option value='0'>(<?php echo e(trans("messages.choose")); ?>)</option>
																							<?php if(!empty($bolge)): ?>
																								<?php $__currentLoopData = $bolge; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $z=>$m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
																									<option value='<?php echo e($m->id); ?>' <?php if($userList->bolgeId==$m->id): ?> selected="selected" <?php endif; ?> <?php if($userList->role=="muhasebeadmin"): ?> <?php if(in_array($m->id,$muhasebebolge)): ?> selected <?php endif; ?> <?php endif; ?>><?php echo e($m->name); ?></option>
																								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
																							<?php endif; ?>
																				</select>
																			</div>

																		</div>
																		<?php endif; ?>
																		<div class="form-group temizlenebilir">
																			<div class="form-label"><?php echo e(trans("messages.yetkilendirilecektalimattipi")); ?></div>
																				<div class="custom-controls-stacked">


																			 <?php if(!empty($talimatList)): ?>
																							<?php $__currentLoopData = $talimatList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
																								<label class="custom-control custom-checkbox">
																										<input type="checkbox" class="custom-control-input" name="izinliTalimat[]"  <?php if(in_array( $value->kisaKod, $yetkiler)): ?> checked="checked" <?php endif; ?> value="<?php echo e($value->kisaKod); ?>">
																									<span class="custom-control-label">	<?php echo e($value->kodName); ?></span>
																								</label>
																							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
																							<label class="custom-control custom-checkbox">
																									<input type="checkbox" class="custom-control-input" name="izinliTalimat[]"  <?php if(in_array( "bondeshortie", $yetkiler)): ?> checked="checked" <?php endif; ?> value="bondeshortie">
																								<span class="custom-control-label"><?php echo e(trans("messages.bondeshortie")); ?></span>




																							</label>
																							<label class="custom-control custom-checkbox">
																									<input type="checkbox" class="custom-control-input" name="izinliTalimat[]"  <?php if(in_array( "ithalatimport", $yetkiler)): ?> checked="checked" <?php endif; ?> value="ithalatimport">
																								<span class="custom-control-label"><?php echo e(trans("messages.ithalatimport")); ?></span>
																							</label>

																				<?php endif; ?>
																		 </div>
																	 </div>
																		<div class="form-group">
																				<label for=""><?php echo e(trans("messages.admintipi")); ?></label>
																				<div class="col-md-12">
																					<select name='admintipi' class="form-control"  id="" >
																							<option value='0'>(<?php echo e(trans("messages.choose")); ?>)</option>
																							<option value='bolgeadmin' <?php if($userList->role=="bolgeadmin"): ?> selected="selected" <?php endif; ?>><?php echo e(trans("messages.admin")); ?></option>
																							<option value='muhasebeadmin' <?php if($userList->role=="muhasebeadmin"): ?> selected="selected" <?php endif; ?>><?php echo e(trans("messages.muhasebeadmin")); ?></option>
																							<option value='admin' <?php if($userList->role=="admin"): ?> selected="selected" <?php endif; ?>><?php echo e(trans("messages.anaadmin")); ?></option>
																							<option value='nakitadmin' <?php if($userList->role=="nakitadmin"): ?> selected="selected" <?php endif; ?>><?php echo e(trans("messages.kasaadmin")); ?></option>
																					</select>
																				</div>

																			</div>
                                     <div class="form-group">
                                        <label for="telefonNo" class="col-md-12 control-label"><?php echo e(trans('messages.adminelemantelefon')); ?></label>
                                        <div class="col-md-12">
                                            <input id="telefonNo" type="text" class="form-control" name="telefonNo" value="<?php echo e($userList->telefonNo); ?>" required>
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

<hr />
<form action="/users/passupdate" method="post" name='a'>
	<div class="card  mx-auto mt-2" style="width: 550px">
			 <div class="card-header"><?php echo e(trans('messages.passwordupdate')); ?></div>
			 <div class="card-body">
				 <label for="sifre"><?php echo e(trans('messages.loginpassword')); ?></label>
				 <div class="col-md-12">
					 <?php echo e(csrf_field()); ?>

					<input id="id" type="hidden" class="form-control" name="id" value="<?php echo e($userList->id); ?>" required autofocus>
				<input id="password" type="text" class="form-control" name="password" value="" required><br />
					<button type="submit" class="btn btn-primary"><?php echo e(trans('messages.update')); ?></button>
		</div>

	</div>

</div>

</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>