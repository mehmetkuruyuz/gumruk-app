    <table class="table table-bordered malYuklemeBosaltmaTablolari" width="100%" cellspacing="0">
      <thead>
          <tr>


            <th><?php echo e(trans("messages.dorseplaka")); ?> </th>
            <th><?php echo e(trans("messages.dorseplaka")); ?> <?php echo e(trans("messages.ulkekodu")); ?></th>
          </tr>
      </thead>
      <tbody>
          <tr><td colspan="6"><?php echo e(trans("messages.".$talimattipi)); ?></td></tr>
          <tr id="sampletr<?php echo e($say); ?>">


            <td><input type="text" class="form-control" name="dorse[<?php echo e($say); ?>][]" required="required"  value="<?php echo e($dorse); ?>"/></td>
            <td>
              <select name="indirmeNoktasiulkekodu[<?php echo e($say); ?>][]" class="form-control  col-xs-2">
               <option value="0"><?php echo e(trans("messages.seciniz")); ?></option>
               <?php if(!empty($ulkeList)): ?>
                  <?php $__currentLoopData = $ulkeList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ulkekey => $ulkevalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($ulkevalue->id); ?>"><?php echo e($ulkevalue->global_name); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

              <?php endif; ?>
              </select>
            </td>
            <input type="hidden" name="talimattipi[<?php echo e($say); ?>][]" value="<?php echo e($talimattipi); ?>" />

            <td><a href='javascript:void(0)' onclick='deleteTableItem(this)'><i class="fa fa-remove"></i></a></td>
            <td>
              <?php
                $idc=md5(microtime().rand(0,95221115));
              ?>
              <label for="in_<?php echo e($idc); ?>" class="custom-file-upload">
                   <i class="fa fa-file" style="color:#467fcf" ></i>
              </label>
              <input type="file" name="spuserfile[<?php echo e($say); ?>][<?php echo e($which); ?>][]" id="in_<?php echo e($idc); ?>" class="d-none hidden" multiple /></td>
          </tr>
      </tbody>
    </table>
