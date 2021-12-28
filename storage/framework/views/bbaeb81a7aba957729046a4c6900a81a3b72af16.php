

<?php $__env->startSection('kirinti'); ?>
	<?php echo e(trans("messages.newinvoiceheader")); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" rel="stylesheet"/>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('endscripts'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>
<script>
		function deleteTableItem(t)
		{

			var answer = confirm("<?php echo e(trans('messages.silmeeminmisiniz')); ?>");
		        if (answer)
						{
							$(t).parent().parent().remove();
		        }
		}
		</script>
<script>
function formTemizle()
{

$(':input','.temizlenebilir')
.not(':button, :submit, :reset')
.val('')
.prop('checked', false)
.prop('selected', false);

}

function addTalimatForUser()
{
	var firma=$("#firmaId").val();
	var talimat=$("#talimattipi").val();
		if (firma<1) {alert("<?php echo e(trans("messages.firmaseciniz")); ?>"); return false;}
		if (talimat<1) {alert("<?php echo e(trans("messages.talimatseciniz")); ?>"); return false;}


		$.get("/muhasebe/yeni/ozelparametreler/"+talimat, function(data, status){
			$("#talimataction").append(data);
			console.log();
		});

}
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
      <div class="card-header">
          	<h2><?php echo e(trans("messages.ozelfiyatlama")); ?></h2>
      </div>
			<div class="card-body ">
				<form action="/muhasebe/yeni/ozelfiyatlamakaydet" method="post" name="d" class="row">
					<?php echo e(csrf_field()); ?>

					<div class='col-md-12'>
		           		<label for="firmaId"><?php echo e(trans("messages.companyname")); ?></label>
		           		<?php if(!empty($companylist)): ?>
		           		<select name='firmaId' class="form-control" id="firmaId" >
										<option value="0"><?php echo e(trans("messages.choose")); ?></option>
		           			<?php $__currentLoopData = $companylist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $z=>$m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		           				<option value='<?php echo e($m->id); ?>'><?php echo e($m->name); ?></option>
		           			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		           		</select>
		           		<?php endif; ?>

		 		</div>
			<div class="col-md-5" id="talimaticinalan">
					<h4><?php echo e(trans("messages.gumruktalimatilist")); ?></h4>
					<table class="table table-bordered">
							<thead>
								<th>Talimat Tipi</th>
								<th>Talimat Ücreti</th>
								<th>Talimat Para Birim</th>
								<th>Talimat'a Toplu Fiyat Uygula</th>
							</thead>
							<tbody id="talimataction">

							</tbody>
					</table>
			</div>
			<div class="col-md-7">

				<div class='col-md-12'>
					 <label for="talimat"><?php echo e(trans("messages.talimattipi")); ?></label>
			  		<?php if(!empty($talimatList)): ?>
							<select name='talimat' class="form-control" id="talimattipi" >
								<option value="0"><?php echo e(trans("messages.choose")); ?></option>
								<?php $__currentLoopData = $talimatList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $z=>$m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<option value='<?php echo e($m->id); ?>'><?php echo e($m->kodName); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</select>
						<?php endif; ?>
				</div>
				<div class="col-md-12 mt-2">
						<button class="btn btn-success" onclick="addTalimatForUser()" type="button"><?php echo e(trans("messages.add")); ?></button>
				</div>
			</div>
			<button type="submit" class="btn btn-danger"><?php echo e(trans("messages.save")); ?></button>
		</form>


</div>
    </div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>