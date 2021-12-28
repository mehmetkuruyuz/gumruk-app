<?php $__env->startSection('kirinti'); ?>
	<?php echo e(trans('messages.userlistheader')); ?>

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
        url: '/user/view/'+id,
        data: {
            // _token: token, buna ÅŸimdilik gerek yok
        },
        error: function (request, error) {
          //  console.log(arguments);
            alert(" <?php echo e(trans('messages.systemaccesserror')); ?> " + error);
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

<?php if($errors->any()): ?>
		<div class='row'>
            <div class="alert alert-primary col-md-12" role="alert">
            	<?php echo e($errors->first()); ?>

            </div>
		</div>
<?php endif; ?>

	<div class='row'>
	<div class='col-md-12'>
		<div class="panel panel-default mb3">
  		<div class="panel-heading">
          <i class="fa fa-user"></i><?php echo e(trans('messages.userlistheader')); ?>

        </div>
        <div class="panel-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                      <th><?php echo e(trans('messages.registerfirmaname')); ?></th>
                      <th><?php echo e(trans('messages.loginemail')); ?></th>

                      <th><?php echo e(trans('messages.firmavergi')); ?></th>
                      <th><?php echo e(trans('messages.firmavergidaire')); ?></th>
                      <th><?php echo e(trans('messages.firmatelefon')); ?></th>
                      <th><?php echo e(trans('messages.firmaadres')); ?></th>
											<?php if(\Auth::user()->role=='admin'): ?>
												<th><?php echo e(trans('messages.useryetki')); ?></th>
											<?php endif; ?>
                      <th><?php echo e(trans('messages.createddate')); ?></th>
                      <th style='font-size:0.8em'><?php echo e(trans('messages.edit')); ?></th>
                      <th style='font-size:0.8em'><?php echo e(trans('messages.delete')); ?></th>
                </tr>
              </thead>
	          <tbody>
    			<?php $__currentLoopData = $userList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                      <td><?php echo e($value->name); ?></td>
                      <td><?php echo e($value->email); ?></td>
                      <td><?php echo e($value->vergiNo); ?></td>
                      <td><?php echo e($value->vergiDairesi); ?></td>
                      <td><?php echo e($value->telefonNo); ?></tD>
                      <td><?php echo e($value->address); ?></td>
											<?php if(\Auth::user()->role=='admin'): ?>
												<?php if($value->role=='watcher'): ?>
													<td><?php echo e(trans('messages.useryetkigereksiz')); ?></td>
												<?php else: ?>
														<td>
																<?php if(!empty($value->yetki)): ?>
																	<?php $__currentLoopData = $value->yetki; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $yetkikey=>$yetkivalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
																		<?php echo e(trans("messages.".$yetkivalue->talimatType)); ?><br />
																	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
																<?php endif; ?>
														</td>
												<?php endif; ?>

											<?php endif; ?>
                      <td><?php echo e($value->created_at); ?></td>
											<td style='font-size:0.8em'><a href='/admins/edit/<?php echo e($value->id); ?>'><?php echo e(trans('messages.edit')); ?></a></td>
                      <td style='font-size:0.8em'><a href='/users/delete/<?php echo e($value->id); ?>'><?php echo e(trans('messages.delete')); ?></a></td>

                </tr>
								<?php if(!empty($value->ekmail)): ?>
								<tr>
									<td></td>
										<td colspan="8">
													<?php $__currentLoopData = $value->ekmail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ky=>$ve): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
															<a href="mailto:<?php echo e($ve->emailAdres); ?>"><?php echo e($ve->emailAdres); ?></a>
													<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										</td>
								</tr>
								<?php endif; ?>
    			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

              </tbody>
             </table>
             </div>
             </div>
             </div>
             </div>
             </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>