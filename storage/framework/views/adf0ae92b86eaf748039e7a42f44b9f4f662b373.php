
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
			      autoUpdateInput: true,
            "singleDatePicker": true,
			      locale: {
                    format: 'YYYY-MM-DD',
			          cancelLabel: 'Clear'
			      }
			  });

			});

		});

</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("content"); ?>
  <div class="col-12">
    <div class="card">
      <div class="card-title p-5">
          <h2><?php echo e(trans("messages.gunsonu")); ?> <?php echo e(trans("messages.raporlama")); ?></h2>
          <form action="/gunsonuraporu" method="post" class="row form-inline float-left">
            <?php echo e(csrf_field()); ?>

            <div class="form-group mx-sm-3 mb-2">
              <label><?php echo e(trans("messages.tarihlerarasi")); ?> </label>
              <input type="text" name="datefilter"  class="form-control" readonly value="<?php echo e(old('datefilter')); ?>" />
              <button type="submit" class="btn btn-info"><?php echo e(trans("messages.gunsonuraporcikar")); ?> </button>
          </div>

          </form>
      </div>
      <div class="card-body">
        <table class="table">
          <thead>
            <th>Tarih Baslangic</th>
            <th>Tarih Bitis</th>
            <th><?php echo e(trans("messages.totaltl")); ?></th>
            <th><?php echo e(trans("messages.totaleuro")); ?></th>
            <th><?php echo e(trans("messages.totaldolar")); ?></th>
            <th><?php echo e(trans("messages.totalpound")); ?></th>
            <th>yapanId</th>
          </thead>
          <tbody>
          <?php if(!empty($gunsonuraporlar)): ?>
            <?php $__currentLoopData = $gunsonuraporlar; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr>
                <td><?php echo e(\Carbon\Carbon::parse($value->tarihbaslangic)->format("Y-m-d")); ?></td>
                <td><?php echo e(\Carbon\Carbon::parse($value->tarihbitis)->format("Y-m-d")); ?></td>
                <td><?php echo e($value->totaltl); ?></td>
                <td><?php echo e($value->totaleuro); ?></td>
                <td><?php echo e($value->totaldolar); ?></td>
                <td><?php echo e($value->totalpound); ?></td>
              <td><?php echo e($value->yapanId); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          <?php endif; ?>
        </tbody>
        </table>
      </div>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>