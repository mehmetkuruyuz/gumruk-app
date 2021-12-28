

              <a   class="dropdown-item" href="javascript:void(0)">      <?php echo e(trans('messages.total')); ?>    <?php if(!empty($list)): ?> <?php echo e(count($list)); ?> <?php echo e(trans('messages.adet')); ?>   <?php else: ?> 0 <?php endif; ?> <?php echo e(trans('messages.gumruktalimatiheader')); ?>  </a>
              <div class="dropdown-divider"></div>
                <!-- inner menu: contains the actual data -->

                <?php if(!empty($list)): ?>
			            <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <a href="/operasyon/goster/<?php echo e($value->id); ?>" class="dropdown-item d-flex">
                    <div>
                      <strong> <?php echo e($value->user->name); ?></strong>
                            <?php if($value->durum==0): ?>
                            <i class="fa fa-file text-red"></i>, <?php echo e(trans('messages.talimatsended')); ?>

            						 <?php else: ?>
                                 <i class="fa fa-file text-aqua"></i> <?php echo e($value->user->name); ?> <?php echo e(trans('messages.talimatupdated')); ?>

                            <?php endif; ?>
                      <div class="small text-muted">10 minutes ago</div>
                    </div>
                  </a>
                	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                	<?php endif; ?>
