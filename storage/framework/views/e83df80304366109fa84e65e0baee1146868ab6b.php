

<?php $__env->startSection('kirinti'); ?>
	Tüm Mesajlar
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
	<script>
		function changeModalData(id,userid)
		{
			$(".mesajCevapla").remove();

			$("#mesajModalLabel").html($("#titleTD_"+id).text());
			$("#messageBody").html($("#messageTD_"+id).html());
			if (<?php echo e(\Auth::user()->id); ?>!=userid)
			{
				$(".modal-footer").prepend('<button class="btn btn-primary mesajCevapla"  data-ider="" onclick="cevapla('+id+')" ><?php echo e(trans("messages.reponsemessage")); ?></button>');
			}

			$("#buttonId").data('ider',id);

		}

		$("#mesajModal").modal("hide");

		function cevapla(id)
		{
			 document.location.href='/mesaj/cevapla/'+id;
		}

		function messageReaded()
		{
			var _id=$("#buttonId").data('ider');
			//var token= $('#xcsrftoken').val();

	        $.ajax({
	            headers: {
	                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	            },
	            type: 'GET',
	            url: '/mesaj/oku/'+_id,
	            data: {
	              // _token: token,
	            },
	            error: function (request, error) {
	                console.log(arguments);
	                alert("<?php echo e(trans('messages.systemaccesserror')); ?> " + error);
	            },
	            success: function (data)
	            {
	            	console.log("0");
	            }
	        });

		}
	</script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <section class="content">
      <div class="row">
				<div class="col-md-3">
				                <h3 class="page-title mb-5">Mail Service</h3>
				                <div>
				                  <div class="list-group list-group-transparent mb-0">
														<a href="/mesaj/yeni" class="btn btn-secondary btn-block mb-5"><?php echo e(trans('messages.newmessage')); ?></a>


				                    <a href="/mesaj" class="list-group-item list-group-item-action d-flex align-items-center">
				                      <span class="icon mr-3"><i class="fe fe-inbox"></i></span><?php echo e(trans('messages.incoming')); ?> <span class="ml-auto badge badge-primary"><?php echo Helper:: newMailCount(); ?></span>
				                    </a>
				                    <a href="/mesaj/yeni" class="list-group-item list-group-item-action d-flex align-items-center">
				                      <span class="icon mr-3"><i class="fe fe-send"></i></span><?php echo e(trans('messages.newmessage')); ?>

				                    </a>
				                    <a href="/mesaj/sent" class="list-group-item list-group-item-action d-flex align-items-center">
				                      <span class="icon mr-3"><i class="fe fe-alert-circle"></i></span><?php echo e(trans('messages.sendingmessage')); ?>

				                    </a>
														<?php if(Auth::user()->role=='admin'): ?>
					                    <a href="/mesaj/deleted" class="list-group-item list-group-item-action d-flex align-items-center">
					                      <span class="icon mr-3"><i class="fe fe-trash-2"></i></span><?php echo e(trans('messages.deletedmessage')); ?>

					                    </a>
														<?php endif; ?>
				                  </div>
				                  <div class="mt-6">
				                    <a href="/mesaj/yeni" class="btn btn-secondary btn-block"><?php echo e(trans('messages.newmessage')); ?></a>
				                  </div>
				                </div>
				</div>


        <div class="col-md-3 d-none">

          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo e(trans('messages.folder')); ?></h3>
              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body no-padding">
              <ul class="nav nav-pills nav-stacked">
                <li class="active"><a href="/mesaj"><i class="fa fa-inbox"></i>
                  <span class="label label-primary pull-right"></span></a></li>
                </li>
				<li class="active"><a href=""><i class="fa fa-inbox"></i>
				</a></li>
				<?php if(Auth::user()->role=='admin'): ?>
				<li class="active"><a href=""><i class="fa fa-inbox"></i> <?php echo e(trans('messages.deletedmessage')); ?>

				</a></li>
				<?php endif; ?>
              </ul>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo e(trans('messages.inbox')); ?></h3>

              <div class="box-tools pull-right">
                <div class="has-feedback">

                  <span class="glyphicon  glyphicons-info-sign form-control-feedback"></span>
                </div>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="mailbox-controls">
                <!-- Check all button -->

                <div class="btn-group">
                  <button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>

                </div>
                <!-- /.btn-group -->
                <!-- /.pull-right -->
              </div>
        	  <div class="table-responsive mailbox-messages">
                <table class="table table-hover table-striped">
                  <tbody>
                   	<?php if(!empty($mesajlar)): ?>
                  		<?php $__currentLoopData = $mesajlar; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <tr>

                            <td class="mailbox-star"><a href="#"><i class="fa fa-star text-yellow"></i></a></td>
                            <td class="mailbox-name"><a href="/mesaj/read/<?php echo e($value["id"]); ?>"><?php echo e($value["from_user"]["name"]); ?></a></td>
                            <td class="mailbox-subject"><?php if($value['viewed']=='no'): ?><b><?php echo e($value['mesajTitle']); ?></b> <?php else: ?> <?php echo e($value['mesajTitle']); ?> <?php endif; ?> - <span class='text-muted'><?php echo e(str_limit( strip_tags($value['mesajIcerigi']), $limit = 50, $end = '...')); ?></span>
                            </td>
                            <td class="mailbox-attachment"></td>
                            <td class="mailbox-date"><?php echo e(\Carbon\Carbon::parse($value['dateTime'])->diffInDays(\Carbon\Carbon::now())); ?> <?php echo e(trans('messages.gunonce')); ?></td>
                          </tr>
                    	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    	 <?php else: ?>
                        <tr>
                        	<td colspan='5'>
                        	 <div class="alert alert-success alert-dismissable">
                        	 	<?php echo e(trans('messages.nomessages')); ?>

                        	 </div>
                        	</td>
                        </tr>
                      <?php endif; ?>

                  </tbody>

                </table>

        </div>
        </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>