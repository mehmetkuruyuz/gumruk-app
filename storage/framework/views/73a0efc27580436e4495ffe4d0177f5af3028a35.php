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
										Plaka Yükle (excel dosyası)
										<form name="x" action="/users/plaka-upload" method="post" enctype="multipart/form-data" class="row">
											<div class="col-sm-5">
												<?php echo e(csrf_field()); ?>

												<input type="hidden" value="<?php echo e($firmaId); ?>" name="firmaId" />
												<input type="file"  class="form-control" name="excelfile" />
											</div>
											<div class="col-sm-2">
													<button type='submit' class="btn btn-sm btn-info">Plaka Yükle</button>
											</div>
												<div class="col-sm-2">
												<a href='/uploads/sample.xls' target="_blank"><?php echo e(trans("messages.sampledownload")); ?></a>
											</div>
										</form>
									</td>
								</tr>
								<tr>
									<td colspan="4">
											<a href="/users/plaka-tek/<?php echo e($firmaId); ?>">Tek Plaka Kayıt</a>
									</td>
								</tr>
								<?php $__currentLoopData = $plakaliste; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<tr>
											<td><?php echo e($value['plaka']); ?></td>
	 										<td><?php echo e(trans("messages.".$value['type']."plaka")); ?></td>
	  									<td><?php echo e($value['created_at']); ?></td>
											<td><a href="/users/plaka-delete/<?php echo e($value['id']); ?>/<?php echo e($firmaId); ?>" onclick="return confirm('<?php echo e(trans('messages.silmeeminmisiniz')); ?>') "><?php echo e(trans('messages.delete')); ?></a></td>
									</tr>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

						</table>
						</div>
					</div>
			</div>
	</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>