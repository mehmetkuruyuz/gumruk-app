    <table class="table table-bordered malYuklemeBosaltmaTablolari" width="100%" cellspacing="0">
      <thead>
          <tr>
            <th><?php echo e(trans("messages.tirnumarasi")); ?></th>
            <th><?php echo e(trans("messages.gonderici")); ?></th>
            <th><?php echo e(trans("messages.gonderici")); ?> <?php echo e(trans("messages.ulkekodu")); ?></th>
            <th><?php echo e(trans("messages.kap")); ?></th>
            <th><?php echo e(trans("messages.kilo")); ?></th>

            <th><?php echo e(trans("messages.faturacinsi")); ?></th>
            <th><?php echo e(trans("messages.faturanumara")); ?></th>
              <th colspan="3"><?php echo e(trans("messages.faturabedeli")); ?></th>
          </tr>
      </thead>
      <tbody>
          <tr><td colspan="12"><?php echo e(trans("messages.".$talimattipi)); ?></td></tr>
          <tr id="sampletr<?php echo e($say); ?>">
            <input type="hidden" name="talimattipi[<?php echo e($say); ?>][]" value="<?php echo e($talimattipi); ?>" />
            <td><input type="text" class="form-control" name="tirnumarasi[<?php echo e($say); ?>][]" required="required"/></td>
            <td><input type="text" class="form-control" name="yuklemeNoktasi[<?php echo e($say); ?>][]" required="required"/></td>
            <td>
              <select name="yuklemeNoktasiulkekodu[<?php echo e($say); ?>][]" class="form-control col-xs-2">
               <option value="0"><?php echo e(trans("messages.seciniz")); ?></option>
                <?php if(!empty($ulkeList)): ?>
                  <?php $__currentLoopData = $ulkeList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ulkekey => $ulkevalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($ulkevalue->id); ?>"><?php echo e($ulkevalue->global_name); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
              </select>
            </td>
            <td><input type="text" class="form-control hesaplanacakKap" name="tekKap[<?php echo e($say); ?>][]" required="required" onchange="hesaplaKapKilo(0)"/></td>
            <td><input type="text" class="form-control  hesaplanacakKilo" name="tekKilo[<?php echo e($say); ?>][]" required="required"  onchange="hesaplaKapKilo(0)"/></td>
            <td><input type="text" class="form-control yukcinsi" name="yukcinsi[<?php echo e($say); ?>][]"   /> </td>
            <td><input type="text" class="form-control" name="faturanumara[<?php echo e($say); ?>][]"   /> </td>
            <td class="faturabedel"><input type="text" class="form-control " name="faturabedeli[<?php echo e($say); ?>][]"    /> </td>
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