<div class="row">
<?php for($i=0;$i<$adet;$i++): ?>
<div class="col-md-4">
  <div class="form-group">
    <label for="" class="alert alert-danger"><?php echo e(trans("messages.evrakyukle")); ?> <?php echo e(($i+1)); ?></label>
    <small><?php echo e(trans("messages.evrakyuklealt")); ?></small>
    <hr />
    <label><?php echo e(trans("messages.ex1")); ?> <?php echo e(trans("messages.evrakyukle")); ?></label>
    <input type="file" name='specialfiles[ex1][<?php echo e($kac); ?>][<?php echo e($i); ?>][]' class='form-control' multiple >
    <br />
    <label><?php echo e(trans("messages.t2")); ?> <?php echo e(trans("messages.evrakyukle")); ?></label>
    <input type="file" name='specialfiles[t2][<?php echo e($kac); ?>][<?php echo e($i); ?>][]' class='form-control'  multiple>
    <br />
    <label><?php echo e(trans("messages.fatura")); ?> <?php echo e(trans("messages.evrakyukle")); ?></label>
    <input type="file" name='specialfiles[fatura][<?php echo e($kac); ?>][<?php echo e($i); ?>][]' class='form-control'  multiple>
    <br />
    <label><?php echo e(trans("messages.packinglist")); ?> <?php echo e(trans("messages.evrakyukle")); ?></label>
    <input type="file" name='specialfiles[packinglist][<?php echo e($kac); ?>][<?php echo e($i); ?>][]' class='form-control'  multiple>
    <br />
    <label><?php echo e(trans("messages.atr")); ?> <?php echo e(trans("messages.evrakyukle")); ?></label>
    <input type="file" name='specialfiles[atr][<?php echo e($kac); ?>][<?php echo e($i); ?>][]' class='form-control' multiple>
    <br />
    <label><?php echo e(trans("messages.adr")); ?> <?php echo e(trans("messages.evrakyukle")); ?></label>
    <input type="file" name='specialfiles[adr][<?php echo e($kac); ?>][<?php echo e($i); ?>][]' class='form-control'  multiple>
    <br />
    <label><?php echo e(trans("messages.cmr")); ?> <?php echo e(trans("messages.evrakyukle")); ?></label>
    <input type="file" name='specialfiles[cmr][<?php echo e($kac); ?>][<?php echo e($i); ?>][]' class='form-control'  multiple>
  </div>
</div>
<?php endfor; ?>
</div>
