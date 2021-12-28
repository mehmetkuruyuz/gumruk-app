<?php $__env->startSection('kirinti'); ?>
	<?php echo e(trans('messages.plakaliste')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('endscripts'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<div class="panel panel-default mb-3">
        <div class="panel-body">
        	<div class='row'>
            <div class='col-sm-11'>
							<table class="table table-bordered" cellspacing="0" >
								<tr>
									<td colspan="4">

										<form name="x" action="/users/plaka-tek" method="post" enctype="multipart/form-data" class="row">
											<div class="col-sm-7">
												<?php echo e(csrf_field()); ?>


												<input type="hidden" value="<?php echo e($firmaId); ?>" name="firmaId" />
												<label for="name" class="col-md-4 control-label"><?php echo e(trans('messages.plaka')); ?></label>
												<input type="text" class="form-control" name="plaka" value="<?php echo e(old('plaka')); ?>" />
											</div>
											<div class="col-sm-7">
												<label for="name" class="col-md-4 control-label"><?php echo e(trans('messages.plakatipi')); ?></label>
												<select  class="form-control" name="plakatipi">
														<option value='0'><?php echo e(trans("messages.choose")); ?></option>
														<option value="cekici"><?php echo e(trans("messages.cekiciplaka")); ?></option>
														<option value="dorse"><?php echo e(trans("messages.dorseplaka")); ?></option>
												</select>
											</div>
											<div class="col-sm-7 mt-5">
													<button type='submit' class="btn btn-sm btn-info"><?php echo e(trans("messages.save")); ?></button>
											</div>
										</form>
									</td>
								</tr>

						</table>
						</div>
					</div>
			</div>
	</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>