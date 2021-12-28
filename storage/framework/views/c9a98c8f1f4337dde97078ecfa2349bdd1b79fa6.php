

<?php $__env->startSection('kirinti'); ?>
	<?php echo e(trans("messages.newinvoiceheader")); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <link href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" rel="stylesheet"/>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('endscripts'); ?>


<script>
function formTemizle()
{

$(':input','.temizlenebilir')
.not(':button, :submit, :reset')
.val('')
.prop('checked', false)
.prop('selected', false);

}
</script>

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
            <form action="/muhasebe/nakitraporlama" method="post" class="row form-inline float-right">
              <?php echo e(csrf_field()); ?>

              <div class="form-group mx-sm-3 mb-2">
                <label><?php echo e(trans("messages.registerdate")); ?> </label>
                <input type="text" name="datefilter"  class="form-control" readonly value="<?php echo e(old('datefilter')); ?>" />
								<label class="mx-3">Excel Aktar <input type="checkbox"  name="excelcikar" value="1"/></label>
                <button type="submit" class="btn btn-info"><?php echo e(trans("messages.ara")); ?></button>
            </div>

            </form>
          </div>
        </div>
      </div>
  </div>
  <div class="col-md-12">
    <?php if(!empty($bolgelist)): ?>
        <?php $__currentLoopData = $bolgelist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-4">
              <div class="card">
                  <div class="card-header">
                      <?php echo e($key); ?>

                  </div>
                  <div class="card-body">
                    <table class="table">
                      <thead>
                        <th> Firma İsmi </th>
                        <th> Price </th>
                        <th> Ödeme Alan </th>
                        <th> Fatura Tipi </th>
                        <th> Tarih </th>
                      </thead>
                    <?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vell => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <?php
                        if (empty($array[$data->parabirimi])) {$array[$data->parabirimi]=0;}
                          $array[$data->parabirimi]+=$data->odemeFiyat;
                      ?>
                      <tr>
                          <td> <?php echo e($data->muhasebe->user->name); ?> </td>
                          <td> <?php echo e($data->odemeFiyat); ?> <?php echo e($data->parabirimi); ?> </td>
                          <td> <?php echo e($data->odemealanname); ?> </td>
                          <td> <?php echo e(trans("messages.".$data->muhasebe->tipi)); ?> </td>
                          <td> <?php echo e($data->created_at); ?> </td>
                      </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      <?php if(!empty($array)): ?>
                        <?php $__currentLoopData = $array; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $muk => $duk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <tr>
                        <td colspan="3" class="text-right"><?php echo e(trans("messages.total")); ?></td>
                        <td><?php echo e($muk); ?></td>
                        <td><?php echo e($duk); ?></td>
                      </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                    </table>

                  </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>

  </div>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>