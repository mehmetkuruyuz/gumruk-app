

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

<?php $__env->startSection("endscripts"); ?>

	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />




<script type="text/javascript">

    require(['daterangepicker'], function() {

			$(function() {

			  $('input[name="datefilter"]').daterangepicker({
			      autoUpdateInput: false,
			      locale: {
			          cancelLabel: 'Clear'
			      }
			  });

			  $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
			      $(this).val(picker.startDate.format('YYYY-MM-DD') + ' / ' + picker.endDate.format('YYYY-MM-DD'));
			  });

			  $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
			      $(this).val('');
			  });

			});

		});

</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>


		<div class='col-md-12'>
		<div class="card">
        <div class="card-header">
					<div class="container-fluid">
						<div class="row">
								<div class="col-3"><span class="card-title"><i class="fa fa-table"></i> <?php echo e(trans('messages.invoicelistheader')); ?></span></div>
								<div class="col-9 text-right">

									<form action="/muhasebe" method="post" class="row form-inline float-right">
										<?php echo e(csrf_field()); ?>

										<div class="form-group mx-sm-3 mb-2">
											<label><?php echo e(trans("messages.registerdate")); ?> </label>
											<input type="text" name="datefilter"  class="form-control" readonly value="<?php echo e(old('datefilter')); ?>" />

											<button type="submit" class="btn btn-info"><?php echo e(trans("messages.ara")); ?></button>
									</div>

									</form>
								</div>
							</div>
					</div>
				</div>
        <div class="card-body">
          <?php if(\Auth::user()->role=="watcher"): ?>
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr >
                  <th style='font-size:0.8em'><?php echo e(trans("messages.companyname")); ?></th>
									<th  style='font-size:0.8em'><?php echo e(trans("messages.firmatelefon")); ?></th>
                  <th style='font-size:0.8em'><?php echo e(trans("messages.invoicedate")); ?></th>
                  <th style='font-size:0.8em'><?php echo e(trans("messages.invoicetype")); ?></th>
                  <th style='font-size:0.8em'><?php echo e(trans("messages.invoicerefence")); ?></th>
                  <th style='font-size:0.8em'><?php echo e(trans("messages.invoicenumber")); ?></th>
                  <th style='font-size:0.8em'><?php echo e(trans("messages.invoiceprice")); ?></th>
                  <th style='font-size:0.8em'><?php echo e(trans("messages.parabirimi")); ?></th>
									<th style='font-size:0.8em'><?php echo e(trans("messages.odemecinsi")); ?></th>
									<th style='font-size:0.8em'><?php echo e(trans("messages.faturadurumu")); ?></th>
                 <?php if(\Auth::user()->role=='XXXXXX'): ?>
 								 	<th style='font-size:0.8em'><?php echo e(trans("messages.edit")); ?></th>
                  <th style='font-size:0.8em'><?php echo e(trans("messages.delete")); ?></th>
								<?php endif; ?>
									<th style='font-size:0.8em'><?php echo e(trans("messages.talimat")); ?> <?php echo e(trans("messages.show")); ?></th>
									<th style='font-size:0.8em'><?php echo e(trans("messages.faturakapat")); ?></th>

                </tr>

              </thead>

              <tbody>
            <?php if(!empty($muhasebeList)): ?>
					 			<?php $__currentLoopData = $muhasebeList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m=>$evm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					 			<tr>
                  <td><?php echo e($evm->user->name); ?></td>
                  <td><?php echo e($evm->user->telefonNo); ?></td>
                  <td><?php echo e(\Carbon\Carbon::parse($evm->faturaTarihi)->format('d-m-Y')); ?></td>

                  <td><?php echo e($evm->tipi); ?></td>
                  <td><?php echo e($evm->faturaReferans); ?></td>
                  <td><?php if(!empty($evm->faturaNo)): ?> <?php echo e($evm->faturaNo); ?> <?php else: ?> <?php echo e($evm->autoBarcode); ?> <?php endif; ?> </td>
                  <td><?php echo e($evm->price); ?></td>
                  <td><?php echo e($evm->moneytype); ?></td>
									<td><?php echo e(trans("messages.".$evm->odemecinsi)); ?></td>
									<td><?php echo e(trans("messages.fatura".$evm->faturadurumu)); ?></td>
                   <?php if(\Auth::user()->role=='XXXXX'): ?>
                  <td style='font-size:0.9em'><a href='/muhasebe/duzenle/<?php echo e($evm->id); ?>'><i class="fa fa-pencil" aria-hidden="true" style='color:orange'></a></i></td>
                     <td style='font-size:0.9em'><a href='/muhasebe/sil/<?php echo e($evm->id); ?>'><i class="fa fa-trash" aria-hidden="true" style='color:red'></i></a></td>
									 <?php endif; ?>

										 <td><a href='/operasyon/goster/<?php echo e($evm->id); ?>'><i class="fa fa-file-text" aria-hidden="true" style='color:brown'></i></a></td>
										 <td>
											 <?php if($evm->faturadurumu=="acik"): ?>
											 <a href='/muhasebe/fatura/<?php echo e($evm->id); ?>'><small><?php echo e(trans("messages.faturakapat")); ?></small></a></td>
										 	<?php else: ?>
												<a href='/muhasebe/fatura/<?php echo e($evm->id); ?>'><small><?php echo e(trans("messages.faturakapali")); ?> <?php echo e(trans("messages.show")); ?></small></a></td>
											<?php endif; ?>
                </tr>
	 				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	 		<?php endif; ?>
				</tbody>
			</table>
		</div>
  <?php else: ?>
    <?php if(!empty($hiperlist)): ?>
        <?php $__currentLoopData = $hiperlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $no=>$mve): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="card card-collapsed">
             <div class="card-status"></div>
             <div class="card-header">
               <h3 class="card-title " style="font-size:0.9em;"><?php echo e($no); ?> <?php echo e(trans('messages.invoicelistheader')); ?></h3>
               <div class="card-options">
                 <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
               </div>
             </div>
             <div class="card-body">
               <div class="table-responsive">
                 <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                   <thead>
                     <tr >
                       <th style='font-size:0.8em'><?php echo e(trans("messages.companyname")); ?></th>
                       <th  style='font-size:0.8em'><?php echo e(trans("messages.firmatelefon")); ?></th>
                       <th style='font-size:0.8em'><?php echo e(trans("messages.invoicedate")); ?></th>
                       <th style='font-size:0.8em'><?php echo e(trans("messages.invoicetype")); ?></th>
                       <th style='font-size:0.8em'><?php echo e(trans("messages.invoicerefence")); ?></th>
                       <th style='font-size:0.8em'><?php echo e(trans("messages.invoicenumber")); ?></th>
                       <th style='font-size:0.8em'><?php echo e(trans("messages.invoiceprice")); ?></th>
                       <th style='font-size:0.8em'><?php echo e(trans("messages.parabirimi")); ?></th>
                       <th style='font-size:0.8em'><?php echo e(trans("messages.odemecinsi")); ?></th>
                       <th style='font-size:0.8em'><?php echo e(trans("messages.faturadurumu")); ?></th>
                      <?php if(\Auth::user()->role=='XXXXXX'): ?>
                       <th style='font-size:0.8em'><?php echo e(trans("messages.edit")); ?></th>
                       <th style='font-size:0.8em'><?php echo e(trans("messages.delete")); ?></th>
                     <?php endif; ?>
                       <th style='font-size:0.8em'><?php echo e(trans("messages.talimat")); ?> <?php echo e(trans("messages.show")); ?></th>
                       <th style='font-size:0.8em'><?php echo e(trans("messages.faturakapat")); ?></th>

                     </tr>

                   </thead>

                   <tbody>
                       <?php if(!empty($mve)): ?>
                           <?php $__currentLoopData = $mve; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m=>$evm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <tr>
                             <td><?php echo e($evm->user->name); ?></td>
                             <td><?php echo e($evm->user->telefonNo); ?></td>
                             <td><?php echo e(\Carbon\Carbon::parse($evm->faturaTarihi)->format('d-m-Y')); ?></td>

                             <td><?php echo e($evm->tipi); ?></td>
                             <td><?php echo e($evm->faturaReferans); ?></td>
                             <td><?php if(!empty($evm->faturaNo)): ?> <?php echo e($evm->faturaNo); ?> <?php else: ?> <?php echo e($evm->autoBarcode); ?> <?php endif; ?> </td>
                             <td><?php echo e($evm->price); ?></td>
                             <td><?php echo e($evm->moneytype); ?></td>
                             <td><?php echo e(trans("messages.".$evm->odemecinsi)); ?></td>
                             <td><?php echo e(trans("messages.fatura".$evm->faturadurumu)); ?></td>
                              <?php if(\Auth::user()->role=='XXXXX'): ?>
                             <td style='font-size:0.9em'><a href='/muhasebe/duzenle/<?php echo e($evm->id); ?>'><i class="fa fa-pencil" aria-hidden="true" style='color:orange'></a></i></td>
                                <td style='font-size:0.9em'><a href='/muhasebe/sil/<?php echo e($evm->id); ?>'><i class="fa fa-trash" aria-hidden="true" style='color:red'></i></a></td>
                              <?php endif; ?>

                                <td><a href='/operasyon/goster/<?php echo e($evm->id); ?>'><i class="fa fa-file-text" aria-hidden="true" style='color:brown'></i></a></td>
                                <td>
                                  <?php if($evm->faturadurumu=="acik"): ?>
                                  <a href='/muhasebe/fatura/<?php echo e($evm->id); ?>'><small><?php echo e(trans("messages.faturakapat")); ?></small></a></td>
                                 <?php else: ?>
                                   <a href='/muhasebe/fatura/<?php echo e($evm->id); ?>'><small><?php echo e(trans("messages.faturakapali")); ?> <?php echo e(trans("messages.show")); ?></small></a></td>
                                 <?php endif; ?>
                           </tr>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                 <?php endif; ?>
                   </tbody>
                 </table>
               </div>
             </div>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      <?php endif; ?>
  <?php endif; ?>
	</div>
</div>

</div>




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