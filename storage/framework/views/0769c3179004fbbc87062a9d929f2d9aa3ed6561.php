<?php $__env->startSection('kirinti'); ?>
	<?php echo e(trans('messages.invoicelistheader')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<style>
#dataTable {font-size:0.9em;}
</style>
<script type="text/javascript">
<!--

//-->
function modalAc(islem,id)
{
	$('#islemlerModal .modal-body').html('');
    $.ajax({
        type: 'GET',
        url: '/muhasebe/view/'+id,
        data: {
            // _token: token, buna ÅŸimdilik gerek yok
        },
        error: function (request, error) {
            console.log(arguments);
            alert(" <?php echo e(trans('messages.systemaccesserror')); ?>  " + error);
        },
        success: function (data)
        {
        	$('#islemlerModal .modal-body').html(data);
        	$('#islemlerModal').modal('show');


        }
    });



}

</script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('endscripts'); ?>

    <script src="vendor/datatables/jquery.dataTables.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>


		<div class='col-md-12'>
		<div class="card panel-default">
        <div class="card-header">
          <i class="fa fa-table"></i> <?php echo e(trans('messages.invoicelistheader')); ?>

        </div>
        <div class="card-body">
          <div class="table-responsive">
						<?php if(\Auth::user()->role=="watcher"): ?>
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th><?php echo e(trans("messages.companyname")); ?></th>

                  <th><?php echo e(trans("messages.invoicescene")); ?></th>
									<th><?php echo e(trans("messages.talimattipi")); ?></th>
									<th><?php echo e(trans("messages.muhasebefiyatlama")); ?></th>

                  <th><?php echo e(trans("messages.invoicetype")); ?></th>
                </tr>

              </thead>

              <tbody>
            <?php if(!empty($list)): ?>
					 			<?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m=>$evm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					 			<tr>
       								<td><?php echo e($evm->user->name); ?></td>
				              <td><?php echo e($evm->senaryo); ?></td>
				              <td><?php echo e($evm->talimattipi); ?></td>
				              <td><?php echo e($evm->faturatutari); ?></td>
											<td><?php echo e($evm->parabirimi); ?></td>
				        </tr>
					 				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					 		<?php endif; ?>
				</tbody>
			</table>
			<?php else: ?>
				<?php if(!empty($array)): ?>
						<?php $__currentLoopData = $array; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m=>$evm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<div class="card card-collapsed">
								 <div class="card-status"></div>
								 <div class="card-header">
									 <h3 class="card-title " style="font-size:0.9em;"><?php echo e($m); ?> <?php echo e(trans("messages.ozelfiyatlama")); ?></h3>
									 <div class="card-options">
										 <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
									 </div>
								 </div>
								 <div class="card-body">
									 	<?php if(!empty($evm)): ?>
											<div class="row">
												<div class="col-3">	<?php echo e(trans("messages.talimattipi")); ?></div>
												<div class="col-5"><?php echo e(trans("messages.faturatutari")); ?></div>
												<div class="col-3"><?php echo e(trans("messages.moneytype")); ?></div>
											</div>
												<?php $__currentLoopData = $evm['talimattipi']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fm=>$fevm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
														<div class="row">
															<div class="col-3">	<?php echo e(trans("messages.".$fevm)); ?></div>
															<div class="col-5"><?php echo e($evm['faturatutari'][$fm]); ?></div>
															<div class="col-3"><?php echo e($evm['parabirimi'][$fm]); ?></div>

														</div>
												<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										<?php endif; ?>
								 </div>
							 </div>

						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					<?php endif; ?>
			<?php endif; ?>
		</div>
	</div>
</div>

</div>


<!-- </div>  -->


<div class="modal fade" id="islemlerModal" tabindex="-1" role="dialog" aria-labelledby="islemlerModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="islemlerModalLabel"><?php echo e(trans("messages.instructionsaction")); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(trans("messages.close")); ?></button>
      </div>
    </div>
  </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>