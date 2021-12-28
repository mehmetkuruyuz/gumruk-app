<?php $__env->startSection('kirinti'); ?>
	<?php echo e(trans('messages.allmessages')); ?>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>



    <section class="content">
      <div class="row">
				<div class="col-md-3">
				                <h3 class="page-title mb-5">Mail Service</h3>
				                <div>
				                  <div class="list-group list-group-transparent mb-0">
														<a href="/mesaj/yeni" class="btn btn-secondary btn-block mb-5"><?php echo e(trans('messages.newmessage')); ?></a>


				                    <a href="/mesaj" class="list-group-item list-group-item-action d-flex align-items-center active">
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
        <!-- /.col -->
        <div class="col-md-9">
            <div class="card">
              <div class="card-body">
              <h3 class="card-title"><?php echo e(trans('messages.inbox')); ?></h3>

              <div class="box-tools pull-right">
                <div class="has-feedback">

                  <span class="glyphicon  glyphicons-info-sign form-control-feedback"></span>
                </div>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="card-body no-padding">
              <div class="mailbox-controls">
                <!-- Check all button -->

                <div class="btn-group">
                  <?php if(!empty($mesaj["id"])): ?>
                    <a href='/mesaj/sil/<?php echo e($mesaj["id"]); ?>' onclick="return confirm('<?php echo e(trans("messages.messageconfirmdelete")); ?>');" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></a>
                    <a href='/mesaj/cevapla/<?php echo e($mesaj["id"]); ?>' class="btn btn-default btn-sm"><i class="fa fa-reply"></i></a>
                  <?php endif; ?>
                </div>
                <!-- /.btn-group -->
                <!-- /.pull-right -->
              </div>

        	         <div class="table-responsive mailbox-messages">
                      <?php if(!empty($mesaj["mesajTitle"])): ?>
              	      <div class="mailbox-read-info">
                        <h3><?php echo e($mesaj["mesajTitle"]); ?></h3>
                        <h5>Alıcı: <?php echo e($mesaj["to_user"]['name']); ?> </h5>
                        <h5>Gönderen: <?php echo e($mesaj["from_user"]['name']); ?>  <span class="mailbox-read-time pull-right"><?php echo e(Carbon\Carbon::parse($mesaj['dateTime'])->format('d-m-Y h:i')); ?></span></h5>
              </div>
              <?php endif; ?>
              <!-- /.mailbox-read-info -->

              <!-- /.mailbox-controls -->
                  <?php if(!empty($mesaj["mesajIcerigi"])): ?> 
              <div class="mailbox-read-message">
              		<?php echo $mesaj["mesajIcerigi"]; ?>

              </div>
            <?php endif; ?>
        	  </div>
        </div>
</section>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>