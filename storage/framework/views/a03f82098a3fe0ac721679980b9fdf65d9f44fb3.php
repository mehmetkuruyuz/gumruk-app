
              <a   class="dropdown-item" href="javascript:void(0)"><?php echo e(trans('messages.total')); ?> <?php if(!empty($mesajlar)): ?> <?php echo e(count($mesajlar)); ?> <?php echo e(trans('messages.newmessagedesc')); ?> <?php else: ?> 0 <?php echo e(trans('messages.nonewmessage')); ?> <?php endif; ?></a>
              <div class="dropdown-divider"></div>
                   <?php if(!empty($mesajlar)): ?>
           						<?php $__currentLoopData = $mesajlar; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <a href="/mesaj/read/<?php echo e($value['id']); ?>" class="dropdown-item d-flex">

                        <div>
                          <strong><?php echo e($value["from_user"]["name"]); ?></strong> <?php echo e($value["mesajTitle"]); ?>

                          <div class="small text-muted"><?php echo e($value['dateTime']); ?></div>
                        </div>
                      </a>
           						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
           					<?php endif; ?>
