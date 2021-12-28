
<div class="tab-pane  <?php if($say>0): ?> fade <?php else: ?> active <?php endif; ?>" id="tab-<?php echo e($say+1); ?>"  aria-labelledby="tab<?php echo e($say+1); ?>" >

  <h3><?php echo e(trans("messages.lutfengumrukbilgigiriniz")); ?> - <?php echo e($say+1); ?></h3>
  <hr />

    <table class="table table-bordered malYuklemeBosaltmaTablolari" width="100%" cellspacing="0">
      <thead>
          <tr>
            <th><?php echo e(trans("messages.plaka")); ?></th>
            <th><?php echo e(trans("messages.gonderici")); ?></th>
            <th><?php echo e(trans("messages.date")); ?></th>
          </tr>
      </thead>
      <tbody>
          <tr id="sampletr<?php echo e($say); ?>">
            <td><input type="text" class="form-control" name="plaka" required="required"/></td>
            <td><input type="text" class="form-control" name="gonderici" required="required" value="<?php echo e($name); ?>" /></td>
            <td><input type="text" class="form-control" name="date" required="required" value="<?php echo e(Carbon\Carbon::parse('now')->format("Y-m-d H:i:s")); ?>" /></td>
          </tr>
      </tbody>
    </table>


</div>
