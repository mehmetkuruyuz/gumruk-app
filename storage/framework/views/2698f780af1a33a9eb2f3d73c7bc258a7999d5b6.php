
<div class="tab-pane  <?php if($say>0): ?> fade <?php else: ?> active <?php endif; ?>" id="tab-<?php echo e($say+1); ?>"  aria-labelledby="tab<?php echo e($say+1); ?>" >

  <h3><?php echo e(trans("messages.lutfengumrukbilgigiriniz")); ?> - <?php echo e($say+1); ?></h3>

  <div class="form-check  temizlenebilir alert alert-danger">
    <input  class="form-check-input" type="checkbox" name="ext1tot2"  value="yes" />
    <label class="form-check-label" for="ext1tot2">
      <?php echo e(trans("messages.t2")); ?> <?php echo e(trans("messages.makeit")); ?></label>
  </div>

    <div class="form-group col-md-12 temizlenebilir ">
      <label for="yukleme"><?php echo e(trans("messages.alicigondericiadet")); ?></label>
        <select name="yuklemeNoktasiAdet[<?php echo e($say); ?>][]" class="form-control input-sm yuklemeNoktasi " data-num="1" onchange="noktalarIcinAlanOlustur(this,<?php echo e($say); ?>)" >
          <?php for($i = 1; $i < 100; $i++): ?>
               <option value="<?php echo e($i); ?>"><?php echo e($i); ?></option>
          <?php endfor; ?>
        </select>
      </div>
      <hr />

    <table class="table table-bordered malYuklemeBosaltmaTablolari" width="100%" cellspacing="0">
      <thead>
          <tr>

            <th><?php echo e(trans("messages.varisgumruk")); ?></th>

            <th><?php echo e(trans("messages.gonderici")); ?></th>
            <th><?php echo e(trans("messages.gonderici")); ?> <?php echo e(trans("messages.ulkekodu")); ?></th>
            <th><?php echo e(trans("messages.alici")); ?></th>
            <th><?php echo e(trans("messages.alici")); ?> <?php echo e(trans("messages.ulkekodu")); ?></th>
            <th><?php echo e(trans("messages.kap")); ?></th>
            <th><?php echo e(trans("messages.kilo")); ?></th>

            <th><?php echo e(trans("messages.yukcinsi")); ?></th>
            <th><?php echo e(trans("messages.faturacinsi")); ?></th>
            <th><?php echo e(trans("messages.faturanumara")); ?></th>
            <th><?php echo e(trans("messages.faturabedeli")); ?></th>
          </tr>
      </thead>
      <tbody>
          <tr id="sampletr<?php echo e($say); ?>">


            <td><input type="text" class="form-control varisGumruk"  name='varisGumrugu[<?php echo e($say); ?>][]' id="" placeholder="Varış Gümrüğü" ></td>

          <td><input type="text" class="form-control kolaysay" name="yuklemeNoktasi[<?php echo e($say); ?>][]" required="required"/></td>

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
            <td><input type="text" class="form-control" name="indirmeNoktasi[<?php echo e($say); ?>][]" required="required"/></td>
            <td>
              <select name="indirmeNoktasiulkekodu[<?php echo e($say); ?>][]" class="form-control col-xs-2">
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
            <td><input type="text" class="form-control yukcinsi" name="yukcinsi[<?php echo e($say); ?>][]" required="required"   /> </td>
            <td>
              <select name="faturacinsi[<?php echo e($say); ?>][]" class="form-control col-xs-2">
                <option value="0"><?php echo e(trans("messages.seciniz")); ?></option>
                <option value="EXW">EXW</option>
                <option value="FCA">FCA</option>
                <option value="CPT">CPT</option>
                <option value="CIP">CIP</option>
                <option value="DAT">DAT</option>
                <option value="DAP">DAP</option>
                <option value="DDP">DDP</option>
                <option value="FAS">FAS</option>
                <option value="FOB">FOB</option>
                <option value="CFR">CFR</option>
                <option value="CIF">CIF</option>

              </select>
            </td>
            <td><input type="text" class="form-control" name="faturanumara[<?php echo e($say); ?>][]"  /> </td>
            <td class="faturabedel"><input type="text" class="form-control " name="faturabedeli[<?php echo e($say); ?>][]"  /> </td>

          </tr>
      </tbody>
    </table>
    <hr />
    <div class="form-group col-md-6 temizlenebilir">
      <label for="kap"><?php echo e(trans("messages.toplamkap")); ?></label>
      <input type="text" class="form-control" readonly="readonly" name='kap[<?php echo e($say); ?>]' id="kap" placeholder="Kap"  required="required">
    </div>
    <div class="form-group col-md-6 temizlenebilir">
      <label for="kilo"><?php echo e(trans("messages.toplamkilo")); ?></label>
      <input type="text" class="form-control" readonly="readonly" name='kilo[<?php echo e($say); ?>]' id="kilo" placeholder="Kilo"  required="required">
    </div>
    <div class="col-md-12">
    <h2><?php echo e(trans("messages.ozelevrakyuklemebaslik")); ?></h2>
    <hr />
      <div id="evrakbolumu_<?php echo e($say); ?>">

      </div>
  </div>
</div>
