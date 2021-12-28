<?php $__env->startSection('kirinti'); ?>
	<?php echo e(trans('messages.sendnewmessage')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
  <link rel="stylesheet" href="/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

<?php $__env->stopSection(); ?>

<?php $__env->startSection('endscripts'); ?>
<script src="/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
  <script>
  $(function () {
    //Add text editor
    // alert("asdasd");
    $("#compose-textarea").wysihtml5({
    	  toolbar: {
    		    "font-styles": true, //Font styling, e.g. h1, h2, etc. Default true
    		    "emphasis": false, //Italics, bold, etc. Default true
    		    "lists": true, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
    		    "html": false, //Button which allows you to edit the generated HTML. Default false
    		    "link": false, //Button to insert a link. Default true
    		    "image": false, //Button to insert an image. Default true,
    		    "color": false, //Button to change color of font
    		    "blockquote": false, //Blockquote

    		  }
    		});
  });
</script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>


<form action='/mesaj/save' method="post" name='a'>
<?php echo e(csrf_field()); ?>

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
           <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo e(trans('messages.newmessage')); ?></h3>
            </div>
            <!-- /.box-header -->
                <div class="box-body">
                  <div class="form-group">
                        <label for="messageUserTO"><?php echo e(trans('messages.sendinguser')); ?></label>
                        <select class="form-control" id="messageUserTO" name='userTo' required="required">
                          <option value="0"><?php echo e(trans('messages.choose')); ?></option>
                          <?php if(!empty($users)): ?>
                          	<?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          	<option value="<?php echo e($val['id']); ?>"  <?php if((!empty($ozelId)) && ($ozelId==$val['id'])): ?> selected="selected" <?php endif; ?> ><?php echo e($val['name']); ?> (<?php echo e($val['email']); ?>)</option>
                          	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          <?php endif; ?>
                        </select>
                  </div>
                  <div class="form-group">
                    <label><?php echo e(trans('messages.messagetitle')); ?></label>
                    <input class="form-control" name='messageTitle' id="messageControlTitle" placeholder="Mesaj Başlığı"  required="required">
                  </div>
                  <div class="form-group">
                    <label><?php echo e(trans('messages.messagecontent')); ?></label>
                  	<textarea id="compose-textarea" class="form-control"  name='messageContent' style="height: 300px"  required="required"></textarea>
                 </div>
                  <div class="form-group">
                  		<button type="submit" class="btn btn-primary"><?php echo e(trans('messages.messagesendbutton')); ?></button>
                  </div>
              </div>
            </div>
        </div>

        </div>
</section>


</form>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>