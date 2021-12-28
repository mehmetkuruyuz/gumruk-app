<?php $__env->startSection('kirinti'); ?>
	<?php echo e(trans('messages.usereditheader')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('endscripts'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

            <div class="container">
                <div class="row">
                    <div class="col-md-6   padding-md">
                        <div class="panel panel-default">
                            <div class="panel-heading"><?php echo e(trans('messages.update')); ?></div>
                            <div class="panel-body ">
                                <form class="form-horizontal" method="POST" action="/users/update" enctype="multipart/form-data">
                                    <?php echo e(csrf_field()); ?>

            						<input id="id" type="hidden" class="form-control" name="id" value="<?php echo e($userList->id); ?>" required>
                                    <div class="form-group<?php echo e($errors->has('name') ? ' has-error' : ''); ?>">
                                      <div class="col-md-12">
                                        <label for="name" class="col-md-4 "><?php echo e(trans('messages.registerfirmaname')); ?></label>


                                            <input id="name" type="text" class="form-control" name="name" value="<?php echo e($userList->name); ?>" required autofocus>

                                            <?php if($errors->has('name')): ?>
                                                <span class="help-block">
                                                    <strong><?php echo e($errors->first('name')); ?></strong>
                                                </span>
                                            <?php endif; ?>
										</div>
                                    </div>

                                    <div class="form-group">

                                            <div class="col-md-12">
                                            <label for="email"><?php echo e(trans('messages.loginemail')); ?></label>
                                            	<input id="email" type="email" class="form-control" name="email" value="<?php echo e($userList->email); ?>" required>
            								                </div>
                                            <?php if($errors->has('email')): ?>
                                                <span class="help-block">
                                                    <strong><?php echo e($errors->first('email')); ?></strong>
                                                </span>
                                            <?php endif; ?>

                                    </div>
                                    <div class="form-group">
                                      <div class="col-md-12">
                                          <label for="email"><?php echo e(trans('messages.moreemailadd')); ?></label>
                                          <div class="row">
                                              <div class='col-sm-12 text-right'><a href='javascript:void(0)' onclick="addNewEmailForUser(this)"><i class="fa fa-plus"></i></a></div>
                                          </div>
                                          <?php if(!empty($ekMail)): ?>
                                            <?php $__currentLoopData = $ekMail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                              <div class="row">
                                                <br />
                                                  <div class="col-sm-11">
                                                    <input id="email" type="email" class="form-control" name="emailek[]" value="<?php echo e($value->emailAdres); ?>" />
                                                  </div>
                                                  <div class="col-sm-1">
                                                      <a href='javascript:void(0)' onclick="deleteThis(this)"><i class="fa fa-minus"></i></a>
                                                  </div>
                                              </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                          <?php else: ?>
                                          <div class="row">
                                              <div class="col-sm-11">
                                                <input id="email" type="email" class="form-control" name="emailek[]" value="" />
                                              </div>
                                              <div class="col-sm-1">
                                                  <a href='javascript:void(0)' onclick="deleteThis(this)"><i class="fa fa-minus"></i></a>
                                              </div>
                                          </div>
                                          <?php endif; ?>
                                      </div>
                                    </div>
																		<div class="form-group">
																				<label for="bolgeSecim"><?php echo e(trans("messages.bolge")); ?></label>
																				<div class="col-md-12">
																					<select name='bolgeSecim' class="form-control"  id="" >
																							<option value='0'>(<?php echo e(trans("messages.choose")); ?>)</option>
																							<?php if(!empty($bolge)): ?>
																								<?php $__currentLoopData = $bolge; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $z=>$m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
																									<option value='<?php echo e($m->id); ?>' <?php if($userList->bolgeId==$m->id): ?> selected <?php endif; ?>><?php echo e($m->name); ?></option>
																								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
																							<?php endif; ?>
																					</select>
																				</div>

																			</div>

                                     <div class="form-group">
                                        <div class="col-md-12">
                                        	<label for="vergiNo"><?php echo e(trans('messages.firmavergi')); ?></label>
                                            <input id="vergiNo" type="text" class="form-control" name="vergiNo" value="<?php echo e($userList->vergiNo); ?>" <?php if($userList->role=="watcher"): ?> required <?php endif; ?>>
                                        </div>
                                    </div>
                                     <div class="form-group">

                                        <div class="col-md-12">
                                        	<label for="vergiDairesi"><?php echo e(trans('messages.firmavergidaire')); ?></label>
                                            <input id="vergiDairesi" type="text" class="form-control" name="vergiDairesi" value="<?php echo e($userList->vergiDairesi); ?>"  <?php if($userList->role=="watcher"): ?> required  <?php endif; ?>>
                                        </div>
                                    </div>
                                     <div class="form-group">

                                        <div class="col-md-12">
                                        	<label for="telefonNo"><?php echo e(trans('messages.firmatelefon')); ?></label>
                                            <input id="telefonNo" type="text" class="form-control" name="telefonNo" value="<?php echo e($userList->telefonNo); ?>"  <?php if($userList->role=="watcher"): ?> required  <?php endif; ?>>
                                        </div>
                                    </div>
                                     <div class="form-group">

                                        <div class="col-md-12">
                                        	<label for="address"><?php echo e(trans('messages.firmaadres')); ?></label>
                                            <input id="address" type="text" class="form-control" name="address" value="<?php echo e($userList->address); ?>"  <?php if($userList->role=="watcher"): ?> required  <?php endif; ?>>
                                        </div>
                                    </div>
                                    <div class="form-group">

                                        <div class="col-md-12">
                                        	<label for="address"><?php echo e(trans('messages.firmaresim')); ?></label>
                                            <input id="a" type="file" class="form-control" name="resim" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                       <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary">
                                               <?php echo e(trans('messages.update')); ?>

                                            </button>
                                       </div>
                                    </div>
                                </form>

                            </div>

                            <hr />
                          <form action="/users/passupdate" method="post" name='a'>
                          <div class="panel panel-default">
                          	<div class="panel-heading"><?php echo e(trans('messages.passwordupdate')); ?></div>
                          		<div class="panel-body">
                          		<label for="sifre"><?php echo e(trans('messages.loginpassword')); ?></label>
                          			<div class="col-md-12">
                          			       <?php echo e(csrf_field()); ?>

                                			<input id="id" type="hidden" class="form-control" name="id" value="<?php echo e($userList->id); ?>" required autofocus>
                          					<input id="password" type="text" class="form-control" name="password" value="" required><br />
                          				    <button type="submit" class="btn btn-primary"><?php echo e(trans('messages.update')); ?></button>
                          			</div>

                          		</div>

                          	</div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>

<script>

function deleteThis(t)
{
  $(t).parent().parent().remove();
}


function addNewEmailForUser(t)
{
    $(t).parent().parent().parent().after().append( '<div class="row"><br />'+
                                                '<div class="col-sm-11">'+
                                                  '<input id="email" type="email" class="form-control" name="emailek[]" value="" />'+
                                                '</div>'+
                                                '<div class="col-sm-1">'+
                                                    '<a href="javascript:void(0)" onclick="deleteThis(this)"><i class="fa fa-minus"></i></a>'+
                                                '</div>'+
                                            '</div>');

}
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>