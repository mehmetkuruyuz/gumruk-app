<?php $__env->startSection("content"); ?>
  <div class="col-12">
    <div class="card">
      <div class="card-title p-5">
          <h2><?php echo e(trans("messages.talimat")); ?> <?php echo e(trans("messages.raporlama")); ?></h2>
      </div>
      <div class="card-body">
        <table class="table table-hover table-outline table-vcenter text-nowrap card-table">
             <thead>
               <tr>
                 <th><?php echo e(trans("messages.bolge")); ?></th>
                 <th><?php echo e(trans("messages.bekleme")); ?></th>
                 <th><?php echo e(trans("messages.firmabekleme")); ?></th>
                 <th><?php echo e(trans("messages.tamamlandi")); ?></th>
               </tr>
             </thead>
             <tbody>
                <?php if(!empty($data)): ?>
                 <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                   <tr>
                       <td><?php echo e($key); ?></td>

                       <td><?php if(!empty($value["talimatdurumu"]["bekleme"])): ?> <?php echo e($value["talimatdurumu"]["bekleme"]); ?> <?php endif; ?></td>
                       <td><?php if(!empty($value["talimatdurumu"]["firmabekleme"])): ?> <?php echo e($value["talimatdurumu"]["firmabekleme"]); ?> <?php endif; ?></td>
                       <td><?php if(!empty($value["talimatdurumu"]["tamamlandi"])): ?> <?php echo e($value["talimatdurumu"]["tamamlandi"]); ?> <?php endif; ?></td>
                   </tr>
                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               <?php endif; ?>
            </tbody>
          </table>
      </div>
    </div>
  </div>


  <div class="col-12">
    <div class="card">
      <div class="card-title p-5">
          <h2><?php echo e(trans("messages.invoicelistheader")); ?> <?php echo e(trans("messages.raporlama")); ?></h2>
      </div>
      <div class="card-body">
        <table class="table table-hover table-outline table-vcenter text-nowrap card-table">
             <thead>
               <tr>
                 <th><?php echo e(trans("messages.bolge")); ?></th>
                 <th><?php echo e(trans("messages.faturaacik")); ?></th>
                 <th><?php echo e(trans("messages.faturakapali")); ?></th>
                 <th><?php echo e(trans("messages.cariodeme")); ?></th>
                 <th><?php echo e(trans("messages.nakitodeme")); ?></th>
               </tr>
             </thead>
             <tbody>
                <?php if(!empty($data)): ?>
                 <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                   <tr>
                       <td><?php echo e($key); ?></td>
                       <td><?php if(!empty($value["muhasebe"]["cari"])): ?> <?php echo e($value["muhasebe"]["cari"]); ?> <?php endif; ?></td>
                       <td><?php if(!empty($value["muhasebe"]["nakit"])): ?> <?php echo e($value["muhasebe"]["nakit"]); ?> <?php endif; ?></td>
                       <td><?php if(!empty($value["muhasebe"]["acik"])): ?><?php echo e($value["muhasebe"]["acik"]); ?> <?php endif; ?></td>
                       <td><?php if(!empty($value["muhasebe"]["kapali"])): ?><?php echo e($value["muhasebe"]["kapali"]); ?> <?php endif; ?></td>
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