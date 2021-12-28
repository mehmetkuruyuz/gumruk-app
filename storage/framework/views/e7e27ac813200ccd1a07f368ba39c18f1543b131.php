
<div class="tab-pane  <?php if($say>0): ?> fade <?php else: ?> active <?php endif; ?>" id="tab-<?php echo e($say+1); ?>"  aria-labelledby="tab<?php echo e($say+1); ?>" >

  <h3> <?php echo e($say+1); ?> - <?php echo e(trans("messages.lutfengumrukbilgigiriniz")); ?> </h3>

  <div class="form-group">
    <div class="row">
      <label for="talimatipi_<?php echo e($say); ?>" class="col-auto col-form-label"><?php echo e(trans("messages.alicigondericiadet")); ?></label>
      <div class="col-sm-6">
        <select name="talimatsecici[<?php echo e($say); ?>][]" class="form-control" data-num="1" id="talimatsecici_<?php echo e($say); ?>">
          <?php if(!empty($talimatList)): ?>
            <?php $__currentLoopData = $talimatList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($value->kisaKod); ?>"><?php echo e($value->kodName); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          <?php endif; ?>
        </select>
      </div>
      <div class="col-sm-2">
        <button type="button" class="btn btn-info" onclick="addItemTo(<?php echo e($say); ?>)"><?php echo e(trans("messages.add")); ?></button>
      </div>
    </div>

  </div>
  <hr />
    <div id='gumruk_alt_<?php echo e($say); ?>'>

    </div>

  </div>
