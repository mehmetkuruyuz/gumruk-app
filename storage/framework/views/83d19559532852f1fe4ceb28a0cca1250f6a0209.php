

<?php $__env->startSection('kirinti'); ?>
	<?php echo e(trans('messages.operasyonindex')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script type="text/javascript">
<!--

//-->

function yonlendirTalimatPage(id,t)
{


	var l=confirm("<?php echo e(trans('messages.talimatyonlendirmemesaj')); ?>");
	if (l==true)
	{
			window.location.href='/operasyon/ozelislem/'+id+'/'+$(t).val();
	}
}


function modalAc(islem,id)
{
	$('#islemlerModal .modal-body').html('');
    $.ajax({
        type: 'GET',
        url: '/evrak/view/'+id,
        data: {

        },
        error: function (request, error) {
            console.log(arguments);
            alert("<?php echo e(trans('messages.systemaccesserror')); ?>" + error);
        },
        success: function (data)
        {
        	$('#islemlerModal .modal-body').html(data);
        	$('#islemlerModal').modal('show');


        }
    });

}


function PopFileUpload()
{
      	var fileInput = document.getElementById('gallery-photo-add');
      	var filename ='';
      	$("#div.gallery").html('');
          for (i = 0; i < fileInput.files.length; i++)
              {
      			filename = fileInput.files[i].name;
      			$("#dgalleryd").append("<div class='alert alert-info'>"+filename+"</div>");
      			//alert(filename);
              }

}

function PopupCenter(url, title, w, h) {
    // Fixes dual-screen position                         Most browsers      Firefox
    var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : window.screenX;
    var dualScreenTop = window.screenTop != undefined ? window.screenTop : window.screenY;

    var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
    var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

    var left = ((width / 2) - (w / 2)) + dualScreenLeft;
    var top = ((height / 2) - (h / 2)) + dualScreenTop;
    var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

    // Puts focus on the newWindow
    if (window.focus) {
        newWindow.focus();
    }
}
</script>
<link href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" rel="stylesheet"/>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('endscripts'); ?>



<script>

	function openfilenew(id)
	{

		var whichone=$("#xx").val();

		$.ajax({
				type: 'GET',
				url: '/operationGetToBack/'+whichone,
				data: {

				},
				error: function (request, error) {
						console.log(arguments);
						alert("<?php echo e(trans('messages.systemaccesserror')); ?>" + error);
				},
				success: function (data)
				{
						$("#id_data"+whichone).html(data);
				}
		});

		$(".allfiles").addClass("d-none");
		$("#firma"+whichone).removeClass("d-none");

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
<?php if($errors->any()): ?>
		<div class='row'>
            <div class="alert alert-primary col-md-12" role="alert">
            	<?php echo e($errors->first()); ?>

            </div>
		</div>
		<hr />
<?php endif; ?>
<div class="row">


<div class="col-md-4">
	<?php if(!empty($operasyonList)): ?>
		<select class="form-control" name="x" id="xx" onchange="openfilenew()">
				<option value="0"><?php echo e(trans("messages.choose")); ?></option>
				<?php $__currentLoopData = $operasyonList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m=>$evm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<option value="<?php echo e($evm->id); ?>"><?php echo e($evm->name); ?></option>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</select>
	<?php endif; ?>
</div>
  <div class="col-md-4">

      <form action="/operation/done" method="post" name="d" >
        <?php echo e(csrf_field()); ?>

        <div class="form-group-inline row col-md-8 temizlenebilir">
          <input type="hidden" value="s" name="st" />
          <label class="col-sm-3"><?php echo e(trans("messages.registerdate")); ?> </label>
          <div class="col-sm-6">
            <input type="text" name="datefilter"  class="form-control" readonly value="<?php echo e(Request::input('datefilter')); ?>"  />
          </div>
          <div class="form-group col-md-2 temizlenebilir">
            <button type="submit" class="btn btn-danger"><?php echo e(trans("messages.tum")); ?> <?php echo e(trans("messages.ara")); ?></button>
          </div>
        </div>
    </form>
    </div>

</div>
<hr />
		<div class='col-md-12'>

						<?php if(!empty($operasyonList)): ?>
							<?php $__currentLoopData = $operasyonList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m=>$evm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<div class="card d-none allfiles" id="firma<?php echo e($evm->id); ?>">
									 <div class="card-status"></div>
									 <div class="card-header">
										 <h4 class="card-title " style="font-size:0.9em;"><?php echo e($evm->name); ?> - <?php echo e(trans("messages.total")); ?> <?php echo e($evm->talimat_count); ?> <?php echo e(trans("messages.operasyon")); ?></h4>
										 <div class="card-options">
											 <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
										 </div>
									 </div>
									 <div class="card-body" id="id_data<?php echo e(($evm->id)); ?>">
                     <img src='/img/spinner.gif' style="margin:auto" />
										</div>
										 
												</div>

											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php endif; ?>

			 		</div>






<!-- </div>  -->


<div class="modal fade" id="islemlerModal" tabindex="-1" role="dialog" aria-labelledby="islemlerModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="islemlerModalLabel">	<?php echo e(trans('messages.talimatislem')); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">	<?php echo e(trans('messages.close')); ?></button>
      </div>
    </div>
  </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>