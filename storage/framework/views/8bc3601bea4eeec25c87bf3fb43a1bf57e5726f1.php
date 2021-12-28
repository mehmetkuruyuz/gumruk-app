

<?php if(count($evm->talimat)>0): ?>
      <table class="table table-bordered" cellspacing="0">
        <thead>
          <tr>
            <th>	<?php echo e(trans('messages.cekiciplaka')); ?></th>
            <th>	<?php echo e(trans('messages.dorseplaka')); ?></th>
            <th>	<?php echo e(trans('messages.autoBarcode')); ?></th>
            <th>	<?php echo e(trans('messages.talimattipi')); ?></th>
            <th>	<?php echo e(trans('messages.createddate')); ?></th>
            <th>	<?php echo e(trans('messages.bolgehangisi')); ?></th>
            <th>	<?php echo e(trans('messages.bolgeilgilenen')); ?></th>
            <th>	<?php echo e(trans('messages.talimatevrakyuklemebaslik')); ?></th>
            <th>	<?php echo e(trans('messages.durum')); ?></th>
            <th colspan="5"><?php echo e(trans('messages.operasyonislem')); ?></th>
          </tr>

        </thead>
          <tbody>
          <?php $__currentLoopData = $evm->talimat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fm=>$fevm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($fevm->cekiciPlaka); ?></td>
                <td><?php echo e($fevm->dorsePlaka); ?></td>
                <td><?php echo e($fevm->autoBarcode); ?></td>
                <td><?php echo e(trans("messages.".$fevm->talimatTipi)); ?></td>
                <td><?php echo e(\Carbon\Carbon::parse($fevm->created_at)->format("d-m-Y H:i:s")); ?></td>
                <td>	<?php if(!empty($fevm->bolge->name)): ?><?php echo e($fevm->bolge->name); ?> <?php endif; ?></td>
                <td>	<?php if(!empty($fevm->ilgili->name)): ?><?php echo e($fevm->ilgili->name); ?> <?php endif; ?></td>
                <td>
                     <?php if($fevm->durum=="tamamlandi" && $fevm->talimatTipi=="listex"): ?>
                        <a href='/operationexcel/<?php echo e($fevm->id); ?>' target="_blank"><?php echo e(trans("messages.dosyaindir")); ?></a><br />
                     <?php endif; ?>

                     <?php if(!empty($fevm->evrak[0])): ?>
                        <?php $__currentLoopData = $fevm->evrak; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $evkey => $evvalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <a href='/uploads/<?php echo e($evvalue->fileName); ?>' class="btn btn-alert btn-sm" target="_blank"><?php echo e(($evvalue->kacinci)+1); ?>. <?php echo e(trans("messages.gumruk")); ?>  <?php echo e($evvalue->belgetipi); ?> - <?php echo e(trans("messages.yuk")); ?> <?php echo e(($evvalue->yukId)+1); ?> - <?php echo e(trans("messages.dosya")); ?>  <?php echo e(($evvalue->siraId)+1); ?> <?php echo e(trans("messages.indir")); ?></a><br  />
                            <!-- <a href='/uploads/<?php echo e($evvalue->fileName); ?>' target="_blank"><?php echo e(trans("messages.dosyaindir")); ?></a><br /> -->

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      <?php else: ?>

                     <?php endif; ?>
                </td>
                <td>	<?php echo e(trans("messages.".$fevm->durum)); ?></td>




                <td><a title="<?php echo e(trans("messages.show")); ?>"  href='/operasyon/goster/<?php echo e($fevm->id); ?>'><i class="fa fa-file-text" aria-hidden="true" style='color:brown'></i></a></td>
                <td><a   title="<?php echo e(trans("messages.print")); ?>" href='javascript:void(0)' onclick="PopupCenter('/operation/print/<?php echo e($fevm->id); ?>','xtf','930','500'); "><i class="fa fa-print" aria-hidden="true" style='color:brown'></i></a></td>
                <td><a href='/operation/edit/<?php echo e($fevm->id); ?>'><i class="fa fa-pencil" aria-hidden="true" style='color:orange'></i></a></td>
                <td><a  title="<?php echo e(trans("messages.uploadfile")); ?>"  href='javascript:void(0)' onclick="PopupCenter('/operation/upload/<?php echo e($fevm->id); ?>','xtf','930','500'); "><i class="fa fa-file-pdf-o" aria-hidden="true" style='color:orange'></i></a></td>
              </tr>



            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
                    </table>
    <?php endif; ?>
