<?php $__env->startSection('kirinti'); ?>
	<?php echo e(trans('messages.operasyonindex')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script type="text/javascript">
<!--

//-->

function yonlendirTalimatPage(id,t)
{


	var l=confirm("<?php echo e(trans('messages.talimatyonlendirmemesaj')); ?>");
	if (l==true)
	{
			window.location.href='/operasyon/ozelislem/'+id+'/'+$(t).val();
	}
}


function modalAc(islem,id)
{
	$('#islemlerModal .modal-body').html('');
    $.ajax({
        type: 'GET',
        url: '/evrak/view/'+id,
        data: {

        },
        error: function (request, error) {
            console.log(arguments);
            alert("<?php echo e(trans('messages.systemaccesserror')); ?>" + error);
        },
        success: function (data)
        {
        	$('#islemlerModal .modal-body').html(data);
        	$('#islemlerModal').modal('show');


        }
    });

}


function PopFileUpload()
{
      	var fileInput = document.getElementById('gallery-photo-add');
      	var filename ='';
      	$("#div.gallery").html('');
          for (i = 0; i < fileInput.files.length; i++)
              {
      			filename = fileInput.files[i].name;
      			$("#dgalleryd").append("<div class='alert alert-info'>"+filename+"</div>");
      			//alert(filename);
              }

}

function PopupCenter(url, title, w, h) {
    // Fixes dual-screen position                         Most browsers      Firefox
    var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : window.screenX;
    var dualScreenTop = window.screenTop != undefined ? window.screenTop : window.screenY;

    var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
    var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

    var left = ((width / 2) - (w / 2)) + dualScreenLeft;
    var top = ((height / 2) - (h / 2)) + dualScreenTop;
    var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

    // Puts focus on the newWindow
    if (window.focus) {
        newWindow.focus();
    }
}


function onaylavegit()
{
		var islem=confirm("<?php echo e(trans('messages.islemzimmetle')); ?>");
		return islem;
}


function seciliindir(t)
{
	var urlx="/?i=i";
	$(t).parent().children("input:checked").each(function (item) {
		urlx+="&item[]="+$(this).val();
	});
	PopupCenter("/ihracatfilepartdownload/"+urlx,"donwload",20,20);

}

</script>
<link href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" rel="stylesheet"/>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('endscripts'); ?>
	<script type="text/javascript">

	    require(['daterangepicker'], function() {



				$(function() {

				  $('input[name="createddate"]').daterangepicker({
				      autoUpdateInput: false,
				      locale: {
				          cancelLabel: 'Clear'
				      }
				  });


				  $('input[name="createddate"]').on('apply.daterangepicker', function(ev, picker) {
				      $(this).val(picker.startDate.format('YYYY-MM-DD') + ' / ' + picker.endDate.format('YYYY-MM-DD'));
				  });

				  $('input[name="createddate"]').on('cancel.daterangepicker', function(ev, picker) {
				      $(this).val('');
				  });

				});



			});

	</script>





<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php if($errors->any()): ?>
		<div class='row'>
            <div class="alert alert-primary col-md-12" role="alert">
            	<?php echo e($errors->first()); ?>

            </div>
		</div>
		<hr />
<?php endif; ?>

		<div class='col-md-12'>
		<div class="panel ">
        <div class="panel-heading">
        <div class="panel-body">
					<div >
						<form action="/<?php echo e(Route::current()->uri()); ?>" name="xc" method="get" class="row d-none hidden">
							<?php echo e(csrf_field()); ?>

						<div class="form-group col-md-2 temizlenebilir">
							<label for="plaka"><?php echo e(trans("messages.plaka")); ?></label>
							<input type="text" class="form-control" id="plaka"  name='plaka' placeholder="<?php echo e(trans("messages.plaka")); ?>" value="<?php echo e(Request::input('plaka')); ?>">
						</div>
						<div class="form-group col-md-2 temizlenebilir">
							<label for="autoBarcode"><?php echo e(trans("messages.autoBarcode")); ?></label>
							<input type="text" class="form-control" id="autoBarcode"  name='autoBarcode' placeholder="<?php echo e(trans("messages.autoBarcode")); ?>" value="<?php echo e(Request::input('autoBarcode')); ?>">
						</div>
						<div class="form-group col-md-2 temizlenebilir">
							<label><?php echo e(trans("messages.registerdate")); ?> </label>
							<input type="text" name="datefilter"  class="form-control" readonly value="<?php echo e(Request::input('datefilter')); ?>"  />
						</div>
						<div class="form-group col-md-2 temizlenebilir p-1">

							<button type="submit" class="btn btn-danger mt-5"><?php echo e(trans("messages.ara")); ?></button>
						</div>
						</form>
					</div>
          <div class="">
            <table class="table table-bordered" cellspacing="0" id="mytable">
              <thead>
                <tr>
									<th>#</th>
                  <th> 	<?php echo e(trans('messages.companyname')); ?></th>
                  <th>	<?php echo e(trans('messages.cekiciplaka')); ?></th>
                  <th>	<?php echo e(trans('messages.dorseplaka')); ?></th>
									<th>	<?php echo e(trans('messages.autoBarcode')); ?></th>
									<th>	<?php echo e(trans('messages.talimattipi')); ?></th>
									<th>	<?php echo e(trans('messages.createddate')); ?></th>
									<th>	<?php echo e(trans('messages.bolgehangisi')); ?></th>
									<th>	<?php echo e(trans('messages.kayitilgilenen')); ?></th>
									<th>	<?php echo e(trans('messages.islemilgilenen')); ?></th>
									<th>	<?php echo e(trans('messages.talimatevrakyuklemebaslik')); ?></th>
                  <th>	<?php echo e(trans('messages.durum')); ?></th>
									<th colspan="5"><?php echo e(trans('messages.operasyonislem')); ?></th>
                </tr>
								<tr>
									<form action="/<?php echo e(Route::current()->uri()); ?>" name="xc" method="get" class="row">
										<input type="hidden" name="inhear" value="1" />
											<th>#</th>
											<th><input type="text" name="companyname" class="form-control"  value="<?php echo e(Request::input('companyname')); ?>" /></th>
		                  <th><input type="text" name="cekiciplaka" class="form-control"  value="<?php echo e(Request::input('cekiciplaka')); ?>" /></th>
		                  <th><input type="text" name="dorseplaka" class="form-control"   value="<?php echo e(Request::input('dorseplaka')); ?>" /></th>
											<th><input type="text" name="autoBarcode" class="form-control"  value="<?php echo e(Request::input('autoBarcode')); ?>" /></th>
											<th></th>
											<th><input type="text" name="createddate" class="form-control"   value="<?php echo e(Request::input('createddate')); ?>"/></th>
											<th>
												<select name="bolgehangisi" class="form-control">
												<?php if(!empty($bolgeList)): ?>
													<?php $__currentLoopData = $bolgeList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
														<option value="<?php echo e($value->id); ?>"  <?php if(Request::input('bolgehangisi')==$value->id): ?> selected <?php endif; ?>><?php echo e($value->name); ?></option>
													<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
												<?php endif; ?>
											</select></th>
											<th><input type="text" name="kayitilgilenen" class="form-control"  value="<?php echo e(Request::input('kayitilgilenen')); ?>"/></th>
											<th><input type="text" name="islemilgilenen" class="form-control"  value="<?php echo e(Request::input('islemilgilenen')); ?>"/></th>
											<th><button type="submit" class="btn btn-danger"><?php echo e(trans("messages.ara")); ?></button></th>
		  								<th colspan="6"></th>
										</form>
								</tr>
              </thead>
              <tbody>
								<?php if(!empty($operasyonList)): ?>
									<?php $__currentLoopData = $operasyonList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m=>$evm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<tr>
											<td>
												<i class="fa fa-circle <?php if($evm->islemdurum=='bosta'): ?> text-green <?php elseif($evm->islemdurum=='tamamlandi'): ?> text-muted <?php else: ?> text-red <?php endif; ?>" aria-hidden="true"></i>
											</td>

											<td class="companyname"><?php if(!empty($evm->user)): ?><?php echo e($evm->user->name); ?> <?php endif; ?></td>
											<td class="cekiciplaka"><?php echo e($evm->cekiciPlaka); ?></td>
											<td class="dorseplaka"><?php echo e($evm->dorsePlaka); ?></td>
											<td class="autoBarcode"><?php echo e($evm->autoBarcode); ?></td>
											<td class="talimattipi"><?php if($evm->altmodeljustname): ?>
												<?php if(!empty($justname[$evm->id])): ?>
													<?php $__currentLoopData = $justname[$evm->id]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $xcky => $xvlx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
																<?php echo e(trans("messages.".$xcky."")); ?>:<?php echo e($xvlx); ?><br/>
													<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
												<?php endif; ?>
													
													<?php endif; ?></td>
											<td class="createddate"><?php echo e(\Carbon\Carbon::parse($evm->created_at)->format("d-m-Y H:i:s")); ?></td>
											<td class="bolgehangisi">	<?php if(!empty($evm->bolge->name)): ?><?php echo e($evm->bolge->name); ?> <?php endif; ?></td>
											<td class="kayitilgilenen">	<?php if(!empty($evm->ilgili->name)): ?><?php echo e($evm->ilgili->name); ?> <?php endif; ?></td>
											<td class="islemilgilenen">	<?php if(!empty($evm->ilgilikayit->name)): ?><?php echo e($evm->ilgilikayit->name); ?> <?php endif; ?></td>
											<td>
												<div style="height:120px;overflow-y:scroll;;">

													 <?php if($evm->durum=="tamamlandi" && $evm->talimatTipi=="listex"): ?>
														 	<a href='/operationexcel/<?php echo e($evm->id); ?>' target="_blank"><?php echo e(trans("messages.dosyaindir")); ?></a><br />
													 <?php endif; ?>

													 <?php if(!empty($evm->evrak[0])): ?>
														 <a href='/ihracatfiledownload/<?php echo e($evm->id); ?>' target="_blank" class="btn btn-info btn-sm"><?php echo e(trans("messages.tumunuindir")); ?></a>
														 <a href='javascript:void(0)' class="btn btn-info btn-sm" onclick="seciliindir(this)"><?php echo e(trans("messages.seciliindir")); ?></a><br  />
															<?php $__currentLoopData = $evm->evrak; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $evkey => $evvalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
																	<a href='/uploads/<?php echo e($evvalue->fileName); ?>' class="btn btn-alert btn-sm" target="_blank"><?php echo e(($evvalue->kacinci)+1); ?>. <?php echo e(trans("messages.gumruk")); ?>  <?php echo e($evvalue->belgetipi); ?> - <?php echo e(trans("messages.yuk")); ?> <?php echo e(($evvalue->yukId)+1); ?> - <?php echo e(trans("messages.dosya")); ?>  <?php echo e(($evvalue->siraId)+1); ?> <?php echo e(trans("messages.indir")); ?></a>
																	<input type='checkbox' name="test[]" value="<?php echo e($evvalue->id); ?>" class="form-control-check"  />
																	<br />
															<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
														<?php else: ?>

													 <?php endif; ?>
												</div>
											</td>
											<td>
                        <?php if($evm->t2beklemedurumu=='yes'): ?>

                          <?php echo e(trans("messages.t2")); ?>

                            <br />
                          <?php echo e(trans("messages.bekliyor")); ?>


                        <?php else: ?>
                        	<?php echo e(trans("messages.".$evm->durum)); ?>

                        <?php endif; ?>
                      </td>

											<td><a title="<?php echo e(trans("messages.print")); ?>" href='javascript:void(0)' onclick="PopupCenter('/ihracat/operasyon/print/<?php echo e($evm->id); ?>','xtf','930','500'); "><i class="fa fa-print" aria-hidden="true" style='color:brown'></i></a></td>
											<td><a title="<?php echo e(trans("messages.show")); ?>" href='/ihracat/operasyon/goster/<?php echo e($evm->id); ?>' <?php if($evm->islemdurum=='bosta' && (\Auth::user()->role=='admin' || \Auth::user()->role=='bolgeadmin' )): ?> onclick="return onaylavegit()" <?php endif; ?>><i class="fa fa-file-text" aria-hidden="true" style='color:brown'></i></a></td>
											<?php if(\Auth::user()->role=='admin' || \Auth::user()->role=='bolgeadmin'): ?>
												<td><a  title="<?php echo e(trans("messages.edit")); ?>" href='/ihracat/operasyon/edit/<?php echo e($evm->id); ?>'><i class="fa fa-pencil" aria-hidden="true" style='color:orange'></i></a></td>
											<?php else: ?>
												<td>&nbsp;</td>
											<?php endif; ?>
											<td><a title="<?php echo e(trans("messages.uploadfile")); ?>" href='javascript:void(0)' onclick="PopupCenter('/ihracat/operasyon/upload/<?php echo e($evm->id); ?>','xtf','930','500'); "><i class="fa fa-file-pdf-o" aria-hidden="true" style='color:orange'></i></a></td>
											<!-- <td><a href='/talimat/sil/'><i class="fa fa-trash" aria-hidden="true" style='color:red'></i></a></td> -->
										</tr>
                	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									<tr>
										<td colspan="14">
											<?php echo e($operasyonList->render("pagination::bootstrap-4")); ?>

										</td>
									</tr>
                <?php else: ?>
                	<tr>
                		<td colspan='14'>	<?php echo e(trans('messages.girilmistalimatyok')); ?></td>
                	</tr>
                <?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

</div>
  </div>



<!-- </div>  -->


<div class="modal fade" id="islemlerModal" tabindex="-1" role="dialog" aria-labelledby="islemlerModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="islemlerModalLabel">	<?php echo e(trans('messages.talimatislem')); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">	<?php echo e(trans('messages.close')); ?></button>
      </div>
    </div>
  </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>