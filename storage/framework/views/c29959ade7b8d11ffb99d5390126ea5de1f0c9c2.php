<?php $__env->startSection('kirinti'); ?>
	<?php echo e(trans("messages.operasyoninceleheader")); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<style>
table {font-size:0.9em;}
</style>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('endscripts'); ?>
	<script>
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

	function talimatAltIslem(tip,id)
	{
			var l=confirm("<?php echo e(trans('messages.formconfirm')); ?>");
			if (l==true)
			{
				window.location.href='/ihracat/operasyon/ozelislem/'+id+'/'+tip;
			}


	}
	function yonlendirTalimatPage(id,t)
	{


		var l=confirm("<?php echo e(trans('messages.talimatyonlendirmemesaj')); ?>");
		if (l==true)
		{
				window.location.href='/operasyon/ozelislem/'+id+'/'+$(t).val();
		}
	}


</script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
	<div class="card mb-3">
				<div class="card-body">
				<div class='row'>

					<div class='col-8'><i class="fa fa-table"></i> <span><?php echo e(trans('messages.createddate')); ?> : <?php echo e(\Carbon\Carbon::parse($talimat->created_at)->format('d-m-Y H:i')); ?> / <?php echo e(trans('messages.updateddate')); ?> : <?php echo e(\Carbon\Carbon::parse($talimat->updated_at)->format('d-m-Y H:i')); ?></span></div>
					<div class='col-4 text-right'><a href='/ihracat/operasyon/print/<?php echo e($talimat->id); ?>'>Yazdırmak İçin <i class="fa fa-print"></i> </a></div>

					<?php if(Auth::user()->role=="admin"): ?>

					<div class='col-12 text-right'>
						<ul class="pagination pagination-sm">
							<li class="disabled"><a href="#"><?php echo e(trans('messages.degisiklikler')); ?></a></li>
									
						</ul>
					</div>
					<?php endif; ?>
				</div>
					<div class="row">
												<div class='col-sm-6'>
														 <h5><?php echo e(trans("messages.talimatverenkullanici")); ?></h5>
																	<table class="table table-bordered" cellspacing="0" >
																	<tr>
																		<td><strong><?php echo e(trans("messages.companyname")); ?></strong></td>
																		<td><?php echo e($talimat->user->name); ?></td>
																	</tr>
																	<tr>
																		<td><strong><?php echo e(trans("messages.autoBarcode")); ?></strong></td>
																		<td>
																			<span style="font-size:3em;"><?php echo e($talimat->autoBarcode); ?></span>
																			<div>
																				<?php echo $barcode; ?>

																			</div>
																		</td>

																	</tr>


																	<tr>
																			<td><strong><?php echo e(trans("messages.loginmail")); ?></strong></td>
																			<td><?php echo e($talimat->user->email); ?></td>
																		</tr>
																		<tr>
																			<td><strong><?php echo e(trans("messages.firmavergi")); ?> / <?php echo e(trans("messages.firmavergidaire")); ?></strong></td>
																			<td><?php echo e($talimat->user->vergiDairesi); ?></td>
																		</tr>
																			<tr>
																			<td><strong><?php echo e(trans("messages.firmatelefon")); ?></strong> </td>
																			<td><?php echo e($talimat->user->telefonNo); ?></td>
																		</tr>
																			<tr>
																			<td><strong><?php echo e(trans("messages.firmaadres")); ?></strong></td>
																			<td><?php echo e($talimat->user->address); ?></td>
																		</tr>
																		<tr>
																				<td colspan="2"><hr /></td>
																		</tr>
																		<tr>
																		 <td><strong><?php echo e(trans("messages.ozelplaka")); ?></strong></td>
																		 <td><?php echo e($talimat->plaka); ?></td>
																		</tr>
																		<tr>
																		 <td><strong><?php echo e(trans("messages.sertifikano")); ?></strong></td>
																		 <td><?php echo e($talimat->sertifikano); ?></td>
																		</tr>
																	</table>
													 </div>
													 <div class='col-sm-6'>
															<h5><?php echo e(trans("messages.talimatbilgileri")); ?></h5>
																<table class="table table-bordered" cellspacing="0">
																 <tr>
																	 <td><strong><?php echo e(trans("messages.createddate")); ?></strong></td>
																	 <td><?php echo e(\Carbon\Carbon::parse($talimat->created_at)->format('d-m-Y H:i')); ?></td>
																	</tr>

																	<tr>
																	 <td><strong><?php echo e(trans("messages.cekiciplaka")); ?></strong></td>
																	 <td><?php echo e($talimat->cekiciPlaka); ?></td>
																	</tr>
																	<tr>
																	 <td><strong><?php echo e(trans("messages.dorseplaka")); ?></strong></td>
																	 <td><?php echo e($talimat->dorsePlaka); ?></td>
																	</tr>
																	<tr>
																		<td><strong><?php echo e(trans("messages.pozisyonNo")); ?></strong></td>
																		<td><?php echo e($talimat->pozisyonNo); ?></td>
																	</tr>
																	<tr>
																		<td><strong><?php echo e(trans("messages.teminatTipi")); ?></strong></td>
																		<td><?php echo e(trans("messages.".$talimat->teminatTipi)); ?></td>
																	</tr>
																	<tr>
																		<td><strong><?php echo e(trans("messages.tasimaTipi")); ?></strong></td>
																		<td><?php echo e(trans("messages.".$talimat->tasimaTipi)); ?></td>
																	</tr>

																 <tr>
																	 <td><strong><?php echo e(trans("messages.gumrukadet")); ?></strong></td>
																	 <td><?php echo e($talimat->gumrukAdedi); ?></td>
																 </tr>
																 <tr>
																	 <td><strong><?php echo e(trans("messages.kayitilgilenen")); ?></strong></td>
																	 <td>
																		 	<?php echo e($talimat->ilgili->name); ?> <?php echo e($talimat->ilgili->email); ?></td>
																 </tr>
																 <tr>
																	 	<td><strong><?php echo e(trans("messages.islemilgilenen")); ?></strong></td>
																	 	<td><?php if(!empty($talimat->ilgilikayit->name)): ?> <?php echo e($talimat->ilgilikayit->name); ?> <?php endif; ?></td>

																 </tr>
																 <tr>
																	 <td><strong><?php echo e(trans("messages.muhasebedurumu")); ?></strong></td>
																 	<td><?php if(!empty($fatura)): ?> <?php echo e(trans("messages.fatura".$fatura->faturadurumu)); ?> <?php endif; ?></td>
																 </tr>
																 <tr>
																	 <td><strong><?php echo e(trans("messages.talimatdurumu")); ?></strong></td>
																	 <td>
																	 <span style='color:red'>
                                     <?php if($talimat->t2beklemedurumu=='yes'): ?>
																			 <?php if(\Auth::user()->id==$talimat->ilgilikayit->id || \Auth::user()->role=="admin"): ?>
                                        	<?php echo e(trans("messages.t2")); ?> <?php echo e(trans("messages.bekliyor")); ?>

																		 	 <?php endif; ?>
																			 <br />
																			 <a href="/operation/sendt2/<?php echo e($talimat->id); ?>" class="btn btn-danger">  <?php echo e(trans("messages.t2")); ?> <?php echo e(trans("messages.makeit")); ?></a>

                                     <?php else: ?>
                                     	<?php echo e(trans("messages.".$talimat->durum)); ?>

                                     <?php endif; ?>
                                   </span>
																	 <?php if(!empty($talimat->ilgilikayit)): ?>
																			<?php if(\Auth::user()->id==$talimat->ilgilikayit->id || \Auth::user()->role=="admin"): ?>
																				<?php if($talimat->durum=="bekleme"): ?>
                                          <hr />
																						<a href="/ihracat/operasyon/donethis/<?php echo e($talimat->id); ?>" class="btn btn-danger"><?php if(\Auth::user()->role=="admin"): ?>Yönetici Olarak <?php endif; ?> Operasyonu Tamamla</a>
																				  <?php endif; ?>
																			<?php endif; ?>
																		<?php endif; ?>
																	 </td>

																 </tr>
															 </table>

													 </div>

												 </div>

													 <div class='col-sm-12'>
														 <h5><?php echo e(trans("messages.gumrukbilgileri")); ?></h5>

																<?php if(!empty($talimat->altmodel)): ?>
																			<?php $__currentLoopData = $talimat->altmodel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $altkey=>$altvalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
																			<?php echo e(trans("messages.".$altvalue->talimatTipi)); ?><hr />
																			<div class="col-sm-12 my-2 py-2" style="">
																				<?php switch($altvalue->talimatTipi):
																					case ("ex1"): ?>
																					<table class="table table-bordered" cellspacing="0">
																					<thead>
																						<th><?php echo e(trans("messages.gumrukno")); ?></th><th><?php echo e(trans("messages.sirano")); ?></th>
																						<th><?php echo e(trans("messages.varisgumruk")); ?></th>
																						<th><?php echo e(trans("messages.gonderici")); ?></th>
																						<th><?php echo e(trans("messages.ulkekodu")); ?></th>
																						<th><?php echo e(trans("messages.alici")); ?></th>
																						<th><?php echo e(trans("messages.ulkekodu")); ?></th>
																						<th><?php echo e(trans("messages.kap")); ?></th>
																						<th><?php echo e(trans("messages.kilo")); ?></th>
																						<th><?php echo e(trans("messages.yukcinsi")); ?></th>
																						<th><?php echo e(trans("messages.faturanumara")); ?></th>
																						<th><?php echo e(trans("messages.faturabedeli")); ?></th>
																						<th colspan="3"><?php echo e(trans("messages.onayla")); ?></th>
																			</thead>
																					<tbody>
																						<tr>
																							<td><?php echo e($altvalue->gumrukno+1); ?></td>
																							<td><?php echo e($altvalue->gumrukSira); ?></td>
																							<td style="color:#<?php echo e(substr(md5($altvalue->varisGumruk),0,6)); ?>;font-weight:bold;" ><?php echo e($altvalue->varisGumruk); ?></td>
																							<td><?php echo e($altvalue->yuklemeNoktasi); ?></td>
																							<td><?php echo e($ulke[$altvalue->yuklemeNoktasiulkekodu]); ?></td>
																							<td><?php echo e($altvalue->indirmeNoktasi); ?></td>
																							<td><?php echo e($ulke[$altvalue->indirmeNoktasiulkekodu]); ?></td>
																							<td><?php echo e($altvalue->tekKap); ?></td>
																							<td><?php echo e($altvalue->tekKilo); ?></td>
																							<td><?php echo e($altvalue->yukcinsi); ?></td>
																							<td><?php echo e($altvalue->faturanumara); ?></td>
																							<td><?php echo e($altvalue->faturabedeli); ?></td>
																							<?php if($altvalue->islemdurumu=="bekliyor"): ?>
																							<td><a href='javascript:void(0)' onclick='talimatAltIslem("tamamlandi","<?php echo e($altvalue->id); ?>")'><i class="fa fa-check"></i></a></td>
																							<td><a href='javascript:void(0)' onclick='talimatAltIslem("iptal","<?php echo e($altvalue->id); ?>")'><i class="fas fa-minus"></i></a></td>
																							<td><a href='javascript:void(0)' onclick='talimatAltIslem("sil","<?php echo e($altvalue->id); ?>")'><i class="fas fa-trash"></i></a></td>
																						<?php else: ?>
																							<td colspan="3"><?php echo e(trans("messages.".$altvalue->islemdurumu)); ?></td>
																						<?php endif; ?>
																						</tr>
																					<td><a title="<?php echo e(trans("messages.uploadfile")); ?>" href='javascript:void(0)' onclick="PopupCenter('/ihracat/operasyon/sub/upload?talimatid=<?php echo e($talimat->id); ?>&gumrukno=<?php echo e($altvalue->gumrukno); ?>&gumruksira=<?php echo e($altvalue->gumrukSira); ?>','xtf','930','500'); "><i class="fa fa-file-pdf-o" aria-hidden="true" style='color:orange'></i></a></td></tbody>
																				</table>
																				<?php break; ?>
																				<?php case ("t2"): ?>
																					<table class="table table-bordered" cellspacing="0">
																					<thead>
																						<th><?php echo e(trans("messages.gumrukno")); ?></th>
																						<th><?php echo e(trans("messages.sirano")); ?></th>
																						<th><?php echo e(trans("messages.mrnnumber")); ?></th>
																						<th><?php echo e(trans("messages.varisgumruk")); ?></th>
																						<th><?php echo e(trans("messages.gonderici")); ?></th>
																						<th><?php echo e(trans("messages.ulkekodu")); ?></th>
																						<th><?php echo e(trans("messages.alici")); ?></th>
																						<th><?php echo e(trans("messages.ulkekodu")); ?></th>
																						<th><?php echo e(trans("messages.kap")); ?></th>
																						<th><?php echo e(trans("messages.kilo")); ?></th>

																						<th><?php echo e(trans("messages.yukcinsi")); ?></th>

																						<th><?php echo e(trans("messages.faturanumara")); ?></th>
																						<th><?php echo e(trans("messages.faturabedeli")); ?></th>
																						<th colspan="3"><?php echo e(trans("messages.onayla")); ?></th>
																					</thead>
																					<tbody>
																						<tr>
																							<td><?php echo e($altvalue->gumrukno+1); ?></td>
																							<td><?php echo e($altvalue->gumrukSira); ?></td>
																							<td><?php echo e($altvalue->mrnnumber); ?></td>
																							<td style="color:#<?php echo e(substr(md5($altvalue->varisGumruk),0,6)); ?>;font-weight:bold;" ><?php echo e($altvalue->varisGumruk); ?></td>
																							<td><?php echo e($altvalue->yuklemeNoktasi); ?></td>
																							<td><?php echo e($ulke[$altvalue->yuklemeNoktasiulkekodu]); ?></td>
																							<td><?php echo e($altvalue->indirmeNoktasi); ?></td>
																							<td><?php echo e($ulke[$altvalue->indirmeNoktasiulkekodu]); ?></td>
																							<td><?php echo e($altvalue->tekKap); ?></td>
																							<td><?php echo e($altvalue->tekKilo); ?></td>
																							<td><?php echo e($altvalue->yukcinsi); ?></td>
																							<td><?php echo e($altvalue->faturanumara); ?></td>
																							<td><?php echo e($altvalue->faturabedeli); ?></td>
																							<?php if($altvalue->islemdurumu=="bekliyor"): ?>
																							<td><a href='javascript:void(0)' onclick='talimatAltIslem("tamamlandi","<?php echo e($altvalue->id); ?>")'><i class="fa fa-check"></i></a></td>
																							<td><a href='javascript:void(0)' onclick='talimatAltIslem("iptal","<?php echo e($altvalue->id); ?>")'><i class="fas fa-minus"></i></a></td>
																							<td><a href='javascript:void(0)' onclick='talimatAltIslem("sil","<?php echo e($altvalue->id); ?>")'><i class="fas fa-trash"></i></a></td>
																						<?php else: ?>
																							<td colspan="3"><?php echo e(trans("messages.".$altvalue->islemdurumu)); ?></td>
																						<?php endif; ?>
																						</tr>
																					<td><a title="<?php echo e(trans("messages.uploadfile")); ?>" href='javascript:void(0)' onclick="PopupCenter('/ihracat/operasyon/sub/upload?talimatid=<?php echo e($talimat->id); ?>&gumrukno=<?php echo e($altvalue->gumrukno); ?>&gumruksira=<?php echo e($altvalue->gumrukSira); ?>','xtf','930','500'); "><i class="fa fa-file-pdf-o" aria-hidden="true" style='color:orange'></i></a></td></tbody>
																					</table>
																				<?php break; ?>
																				<?php case ("t1"): ?>
																					<table class="table table-bordered" cellspacing="0">
																					<thead>
																						<th><?php echo e(trans("messages.gumrukno")); ?></th><th><?php echo e(trans("messages.sirano")); ?></th>
																						<th><?php echo e(trans("messages.mrnnumber")); ?></th>
																						<th><?php echo e(trans("messages.varisgumruk")); ?></th>
																						<th><?php echo e(trans("messages.gonderici")); ?></th>
																						<th><?php echo e(trans("messages.ulkekodu")); ?></th>
																						<th><?php echo e(trans("messages.alici")); ?></th>
																						<th><?php echo e(trans("messages.ulkekodu")); ?></th>
																						<th><?php echo e(trans("messages.kap")); ?></th>
																						<th><?php echo e(trans("messages.kilo")); ?></th>

																						<th><?php echo e(trans("messages.yukcinsi")); ?></th>

																						<th><?php echo e(trans("messages.faturanumara")); ?></th>
																						<th><?php echo e(trans("messages.faturabedeli")); ?></th>
																					<th colspan="3"><?php echo e(trans("messages.onayla")); ?></th></thead>
																					<tbody>
																						<td><?php echo e($altvalue->gumrukno+1); ?></td><td><?php echo e($altvalue->gumrukSira); ?></td>
																						<td><?php echo e($altvalue->mrnnumber); ?></td>
																						<td style="color:#<?php echo e(substr(md5($altvalue->varisGumruk),0,6)); ?>;font-weight:bold;" ><?php echo e($altvalue->varisGumruk); ?></td>
																						<td><?php echo e($altvalue->yuklemeNoktasi); ?></td>
																						<td><?php echo e($ulke[$altvalue->yuklemeNoktasiulkekodu]); ?></td>
																						<td><?php echo e($altvalue->indirmeNoktasi); ?></td>
																						<td><?php echo e($ulke[$altvalue->indirmeNoktasiulkekodu]); ?></td>
																						<td><?php echo e($altvalue->tekKap); ?></td>
																						<td><?php echo e($altvalue->tekKilo); ?></td>
																						<td><?php echo e($altvalue->yukcinsi); ?></td>
																						<td><?php echo e($altvalue->faturanumara); ?></td>
																						<td><?php echo e($altvalue->faturabedeli); ?></td>
																						<?php if($altvalue->islemdurumu=="bekliyor"): ?>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("tamamlandi","<?php echo e($altvalue->id); ?>")'><i class="fa fa-check"></i></a></td>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("iptal","<?php echo e($altvalue->id); ?>")'><i class="fas fa-minus"></i></a></td>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("sil","<?php echo e($altvalue->id); ?>")'><i class="fas fa-trash"></i></a></td>
																					<?php else: ?>
																						<td colspan="3"><?php echo e(trans("messages.".$altvalue->islemdurumu)); ?></td>
																					<?php endif; ?>
																					<td><a title="<?php echo e(trans("messages.uploadfile")); ?>" href='javascript:void(0)' onclick="PopupCenter('/ihracat/operasyon/sub/upload?talimatid=<?php echo e($talimat->id); ?>&gumrukno=<?php echo e($altvalue->gumrukno); ?>&gumruksira=<?php echo e($altvalue->gumrukSira); ?>','xtf','930','500'); "><i class="fa fa-file-pdf-o" aria-hidden="true" style='color:orange'></i></a></td></tbody>
																					</table>
																				<?php break; ?>
																				<?php case ("passage"): ?>
																				<table class="table table-bordered" cellspacing="0">
																				<thead>
																					<th><?php echo e(trans("messages.gumrukno")); ?></th><th><?php echo e(trans("messages.sirano")); ?></th>
																					<th><?php echo e(trans("messages.tirnumarasi")); ?></th>
																					<th><?php echo e(trans("messages.gonderici")); ?></th>
																					<th><?php echo e(trans("messages.ulkekodu")); ?></th>
																					<th><?php echo e(trans("messages.kap")); ?></th>
																					<th><?php echo e(trans("messages.kilo")); ?></th>
																					<th><?php echo e(trans("messages.faturacinsi")); ?></th>
																					<th><?php echo e(trans("messages.faturanumara")); ?></th>
																					<th><?php echo e(trans("messages.faturabedeli")); ?></th>

																				<th colspan="3"><?php echo e(trans("messages.onayla")); ?></th></thead>
																				<tbody>
																					<td><?php echo e($altvalue->gumrukno+1); ?></td><td><?php echo e($altvalue->gumrukSira); ?></td>
																					<td><?php echo e($altvalue->tirnumarasi); ?></td>
																					<td><?php echo e($altvalue->yuklemeNoktasi); ?></td>
																					<td><?php echo e($ulke[$altvalue->yuklemeNoktasiulkekodu]); ?></td>
																					<td><?php echo e($altvalue->tekKap); ?></td>
																					<td><?php echo e($altvalue->tekKilo); ?></td>
																					<td><?php echo e($altvalue->yukcinsi); ?></td>
																					<td><?php echo e($altvalue->faturanumara); ?></td>
																					<td><?php echo e($altvalue->faturabedeli); ?></td>
																					<?php if($altvalue->islemdurumu=="bekliyor"): ?>
																					<td><a href='javascript:void(0)' onclick='talimatAltIslem("tamamlandi","<?php echo e($altvalue->id); ?>")'><i class="fa fa-check"></i></a></td>
																					<td><a href='javascript:void(0)' onclick='talimatAltIslem("iptal","<?php echo e($altvalue->id); ?>")'><i class="fas fa-minus"></i></a></td>
																					<td><a href='javascript:void(0)' onclick='talimatAltIslem("sil","<?php echo e($altvalue->id); ?>")'><i class="fas fa-trash"></i></a></td>
																				<?php else: ?>
																					<td colspan="3"><?php echo e(trans("messages.".$altvalue->islemdurumu)); ?></td>
																				<?php endif; ?>
																				<td><a title="<?php echo e(trans("messages.uploadfile")); ?>" href='javascript:void(0)' onclick="PopupCenter('/ihracat/operasyon/sub/upload?talimatid=<?php echo e($talimat->id); ?>&gumrukno=<?php echo e($altvalue->gumrukno); ?>&gumruksira=<?php echo e($altvalue->gumrukSira); ?>','xtf','930','500'); "><i class="fa fa-file-pdf-o" aria-hidden="true" style='color:orange'></i></a></td></tbody>
																				</table>
																				<?php break; ?>
																				<?php case ("t1kapama"): ?>
																				<table class="table table-bordered" cellspacing="0">
																				<thead>
																					<th><?php echo e(trans("messages.gumrukno")); ?></th><th><?php echo e(trans("messages.sirano")); ?></th>
																					<th><?php echo e(trans("messages.baslangicgumruk")); ?></th>

																					<th><?php echo e(trans("messages.gonderici")); ?></th>
																					<th><?php echo e(trans("messages.ulkekodu")); ?></th>
																					<th><?php echo e(trans("messages.varisgumruk")); ?></th>
																					<th><?php echo e(trans("messages.alici")); ?></th>
																					<th><?php echo e(trans("messages.ulkekodu")); ?></th>
																					<th><?php echo e(trans("messages.kap")); ?></th>
																					<th><?php echo e(trans("messages.kilo")); ?></th>

																					<th><?php echo e(trans("messages.yukcinsi")); ?></th>
																					<th><?php echo e(trans("messages.faturacinsi")); ?></th>
																					<th><?php echo e(trans("messages.faturanumara")); ?></th>
																					<th><?php echo e(trans("messages.faturabedeli")); ?></th>

																					<th colspan="3"><?php echo e(trans("messages.onayla")); ?></th></thead>
																				<tbody>
																					<td><?php echo e($altvalue->gumrukno+1); ?></td><td><?php echo e($altvalue->gumrukSira); ?></td>
																					<td><?php echo e($altvalue->baslangicGumruk); ?></td>

																					<td><?php echo e($altvalue->yuklemeNoktasi); ?></td>
																					<td><?php echo e($ulke[$altvalue->yuklemeNoktasiulkekodu]); ?></td>
																					<td style="color:#<?php echo e(substr(md5($altvalue->varisGumruk),0,6)); ?>;font-weight:bold;" ><?php echo e($altvalue->varisGumruk); ?></td>
																					<td><?php echo e($altvalue->indirmeNoktasi); ?></td>
																					<td><?php echo e($ulke[$altvalue->indirmeNoktasiulkekodu]); ?></td>
																					<td><?php echo e($altvalue->tekKap); ?></td>
																					<td><?php echo e($altvalue->tekKilo); ?></td>
																					<td><?php echo e($altvalue->yukcinsi); ?></td>
																					<td><?php echo e($altvalue->faturanumara); ?></td>
																					<td><?php echo e($altvalue->faturabedeli); ?></td>
																					<?php if($altvalue->islemdurumu=="bekliyor"): ?>
																					<td><a href='javascript:void(0)' onclick='talimatAltIslem("tamamlandi","<?php echo e($altvalue->id); ?>")'><i class="fa fa-check"></i></a></td>
																					<td><a href='javascript:void(0)' onclick='talimatAltIslem("iptal","<?php echo e($altvalue->id); ?>")'><i class="fas fa-minus"></i></a></td>
																					<td><a href='javascript:void(0)' onclick='talimatAltIslem("sil","<?php echo e($altvalue->id); ?>")'><i class="fas fa-trash"></i></a></td>
																				<?php else: ?>
																					<td colspan="3"><?php echo e(trans("messages.".$altvalue->islemdurumu)); ?></td>
																				<?php endif; ?>
																				<td><a title="<?php echo e(trans("messages.uploadfile")); ?>" href='javascript:void(0)' onclick="PopupCenter('/ihracat/operasyon/sub/upload?talimatid=<?php echo e($talimat->id); ?>&gumrukno=<?php echo e($altvalue->gumrukno); ?>&gumruksira=<?php echo e($altvalue->gumrukSira); ?>','xtf','930','500'); "><i class="fa fa-file-pdf-o" aria-hidden="true" style='color:orange'></i></a></td></tbody>
																				</table>
																				<?php break; ?>
																				<?php case ("tir"): ?>
																				<table class="table table-bordered" cellspacing="0">
																				<thead>
																						<th><?php echo e(trans("messages.gumrukno")); ?></th><th><?php echo e(trans("messages.sirano")); ?></th>
																						<th><?php echo e(trans("messages.tirnumarasi")); ?></th>
																						<th><?php echo e(trans("messages.gonderici")); ?></th>
																						<th><?php echo e(trans("messages.ulkekodu")); ?></th>
																						<th><?php echo e(trans("messages.kap")); ?></th>
																						<th><?php echo e(trans("messages.kilo")); ?></th>

																						<th><?php echo e(trans("messages.faturacinsi")); ?></th>
																						<th><?php echo e(trans("messages.faturanumara")); ?></th>
																						<th><?php echo e(trans("messages.faturabedeli")); ?></th>
																						<th colspan="3"><?php echo e(trans("messages.onayla")); ?></th></thead>
																				<tbody>
																					<td><?php echo e($altvalue->gumrukno+1); ?></td><td><?php echo e($altvalue->gumrukSira); ?></td>
																					<td><?php echo e($altvalue->tirnumarasi); ?></td>
																					<td><?php echo e($altvalue->yuklemeNoktasi); ?></td>
																					<td><?php echo e($ulke[$altvalue->yuklemeNoktasiulkekodu]); ?></td>
																					<td><?php echo e($altvalue->tekKap); ?></td>
																					<td><?php echo e($altvalue->tekKilo); ?></td>
																					<td><?php echo e($altvalue->yukcinsi); ?></td>
																					<td><?php echo e($altvalue->faturanumara); ?></td>
																					<td><?php echo e($altvalue->faturabedeli); ?></td>
																					<?php if($altvalue->islemdurumu=="bekliyor"): ?>
																					<td><a href='javascript:void(0)' onclick='talimatAltIslem("tamamlandi","<?php echo e($altvalue->id); ?>")'><i class="fa fa-check"></i></a></td>
																					<td><a href='javascript:void(0)' onclick='talimatAltIslem("iptal","<?php echo e($altvalue->id); ?>")'><i class="fas fa-minus"></i></a></td>
																					<td><a href='javascript:void(0)' onclick='talimatAltIslem("sil","<?php echo e($altvalue->id); ?>")'><i class="fas fa-trash"></i></a></td>
																				<?php else: ?>
																					<td colspan="3"><?php echo e(trans("messages.".$altvalue->islemdurumu)); ?></td>
																				<?php endif; ?>
																				<td><a title="<?php echo e(trans("messages.uploadfile")); ?>" href='javascript:void(0)' onclick="PopupCenter('/ihracat/operasyon/sub/upload?talimatid=<?php echo e($talimat->id); ?>&gumrukno=<?php echo e($altvalue->gumrukno); ?>&gumruksira=<?php echo e($altvalue->gumrukSira); ?>','xtf','930','500'); "><i class="fa fa-file-pdf-o" aria-hidden="true" style='color:orange'></i></a></td></tbody>
																				</table>
																				<?php break; ?>
																				<?php case ("ata"): ?>
																				<table class="table table-bordered" cellspacing="0">
																				<thead>
																					<th><?php echo e(trans("messages.gumrukno")); ?></th><th><?php echo e(trans("messages.sirano")); ?></th>
																					<th><?php echo e(trans("messages.tirnumarasi")); ?></th>
																					<th><?php echo e(trans("messages.gonderici")); ?></th>
																					<th><?php echo e(trans("messages.ulkekodu")); ?></th>
																					<th><?php echo e(trans("messages.kap")); ?></th>
																					<th><?php echo e(trans("messages.kilo")); ?></th>

																					<th><?php echo e(trans("messages.faturacinsi")); ?></th>
																					<th><?php echo e(trans("messages.faturanumara")); ?></th>
																					<th><?php echo e(trans("messages.faturabedeli")); ?></th>
																						<th colspan="3"><?php echo e(trans("messages.onayla")); ?></th></thead>
																				<tbody>
																					<td><?php echo e($altvalue->gumrukno+1); ?></td><td><?php echo e($altvalue->gumrukSira); ?></td>
																					<td><?php echo e($altvalue->tirnumarasi); ?></td>
																					<td><?php echo e($altvalue->yuklemeNoktasi); ?></td>
																					<td><?php echo e($ulke[$altvalue->yuklemeNoktasiulkekodu]); ?></td>
																					<td><?php echo e($altvalue->tekKap); ?></td>
																					<td><?php echo e($altvalue->tekKilo); ?></td>
																					<td><?php echo e($altvalue->yukcinsi); ?></td>
																					<td><?php echo e($altvalue->faturanumara); ?></td>
																					<td><?php echo e($altvalue->faturabedeli); ?></td>
																					<?php if($altvalue->islemdurumu=="bekliyor"): ?>
																					<td><a href='javascript:void(0)' onclick='talimatAltIslem("tamamlandi","<?php echo e($altvalue->id); ?>")'><i class="fa fa-check"></i></a></td>
																					<td><a href='javascript:void(0)' onclick='talimatAltIslem("iptal","<?php echo e($altvalue->id); ?>")'><i class="fas fa-minus"></i></a></td>
																					<td><a href='javascript:void(0)' onclick='talimatAltIslem("sil","<?php echo e($altvalue->id); ?>")'><i class="fas fa-trash"></i></a></td>
																				<?php else: ?>
																					<td colspan="3"><?php echo e(trans("messages.".$altvalue->islemdurumu)); ?></td>
																				<?php endif; ?>
																				<td><a title="<?php echo e(trans("messages.uploadfile")); ?>" href='javascript:void(0)' onclick="PopupCenter('/ihracat/operasyon/sub/upload?talimatid=<?php echo e($talimat->id); ?>&gumrukno=<?php echo e($altvalue->gumrukno); ?>&gumruksira=<?php echo e($altvalue->gumrukSira); ?>','xtf','930','500'); "><i class="fa fa-file-pdf-o" aria-hidden="true" style='color:orange'></i></a></td></tbody>
																				</table>
																				<?php break; ?>
																				<?php case ("listex"): ?>
																				<table class="table table-bordered" cellspacing="0">
																				<thead>
																					<th><?php echo e(trans("messages.gumrukno")); ?></th><th><?php echo e(trans("messages.sirano")); ?></th>
																					<th><?php echo e(trans("messages.varisgumruk")); ?></th>
																					<th><?php echo e(trans("messages.gonderici")); ?></th>
																					<th><?php echo e(trans("messages.ulkekodu")); ?></th>
																					<th><?php echo e(trans("messages.alici")); ?></th>
																					<th><?php echo e(trans("messages.ulkekodu")); ?></th>
																					<th><?php echo e(trans("messages.kap")); ?></th>
																					<th><?php echo e(trans("messages.kilo")); ?></th>

																					<th><?php echo e(trans("messages.yukcinsi")); ?></th>

																					<th><?php echo e(trans("messages.faturanumara")); ?></th>
																					<th><?php echo e(trans("messages.faturabedeli")); ?></th>
																					<th colspan="3"><?php echo e(trans("messages.onayla")); ?></th></thead>
																				<tbody>
																					<td><?php echo e($altvalue->gumrukno+1); ?></td><td><?php echo e($altvalue->gumrukSira); ?></td>
																					<td style="color:#<?php echo e(substr(md5($altvalue->varisGumruk),0,6)); ?>;font-weight:bold;" ><?php echo e($altvalue->varisGumruk); ?></td>
																					<td><?php echo e($altvalue->yuklemeNoktasi); ?></td>
																					<td><?php echo e($ulke[$altvalue->yuklemeNoktasiulkekodu]); ?></td>
																					<td><?php echo e($altvalue->indirmeNoktasi); ?></td>
																					<td><?php echo e($ulke[$altvalue->indirmeNoktasiulkekodu]); ?></td>
																					<td><?php echo e($altvalue->tekKap); ?></td>
																					<td><?php echo e($altvalue->tekKilo); ?></td>
																					<td><?php echo e($altvalue->yukcinsi); ?></td>
																					<td><?php echo e($altvalue->faturanumara); ?></td>
																					<td><?php echo e($altvalue->faturabedeli); ?></td>
																					<?php if($altvalue->islemdurumu=="bekliyor"): ?>
																					<td><a href='javascript:void(0)' onclick='talimatAltIslem("tamamlandi","<?php echo e($altvalue->id); ?>")'><i class="fa fa-check"></i></a></td>
																					<td><a href='javascript:void(0)' onclick='talimatAltIslem("iptal","<?php echo e($altvalue->id); ?>")'><i class="fas fa-minus"></i></a></td>
																					<td><a href='javascript:void(0)' onclick='talimatAltIslem("sil","<?php echo e($altvalue->id); ?>")'><i class="fas fa-trash"></i></a></td>
																				<?php else: ?>
																					<td colspan="3"><?php echo e(trans("messages.".$altvalue->islemdurumu)); ?></td>
																				<?php endif; ?>
																				<td><a title="<?php echo e(trans("messages.uploadfile")); ?>" href='javascript:void(0)' onclick="PopupCenter('/ihracat/operasyon/sub/upload?talimatid=<?php echo e($talimat->id); ?>&gumrukno=<?php echo e($altvalue->gumrukno); ?>&gumruksira=<?php echo e($altvalue->gumrukSira); ?>','xtf','930','500'); "><i class="fa fa-file-pdf-o" aria-hidden="true" style='color:orange'></i></a></td></tbody>
																				</table>
																				<?php break; ?>
																				<?php case ("ithalatimport"): ?>
																				<table class="table table-bordered" cellspacing="0">
																				<thead>
																					<th><?php echo e(trans("messages.gumrukno")); ?></th><th><?php echo e(trans("messages.sirano")); ?></th>
																					<th><?php echo e(trans("messages.varisgumruk")); ?></th>
																					<th><?php echo e(trans("messages.gonderici")); ?></th>
																					<th><?php echo e(trans("messages.ulkekodu")); ?></th>
																					<th><?php echo e(trans("messages.alici")); ?></th>
																					<th><?php echo e(trans("messages.ulkekodu")); ?></th>
																					<th><?php echo e(trans("messages.kap")); ?></th>
																					<th><?php echo e(trans("messages.kilo")); ?></th>

																					<th><?php echo e(trans("messages.yukcinsi")); ?></th>
																					<th><?php echo e(trans("messages.faturacinsi")); ?></th>
																					<th><?php echo e(trans("messages.faturanumara")); ?></th>
																					<th><?php echo e(trans("messages.faturabedeli")); ?></th>
																					<th colspan="3"><?php echo e(trans("messages.onayla")); ?></th>
																				</thead>
																				<tbody>
																					<td><?php echo e($altvalue->gumrukno+1); ?></td><td><?php echo e($altvalue->gumrukSira); ?></td>
																					<td style="color:#<?php echo e(substr(md5($altvalue->varisGumruk),0,6)); ?>;font-weight:bold;" ><?php echo e($altvalue->varisGumruk); ?></td>
																					<td><?php echo e($altvalue->yuklemeNoktasi); ?></td>
																					<td><?php echo e($ulke[$altvalue->yuklemeNoktasiulkekodu]); ?></td>
																					<td><?php echo e($altvalue->indirmeNoktasi); ?></td>
																					<td><?php echo e($ulke[$altvalue->indirmeNoktasiulkekodu]); ?></td>
																					<td><?php echo e($altvalue->tekKap); ?> </td>
																					<td><?php echo e($altvalue->tekKilo); ?></td>
																					<td><?php echo e($altvalue->yukcinsi); ?></td>
																					<td><?php echo e($altvalue->faturanumara); ?></td>
																					<td><?php echo e($altvalue->faturabedeli); ?></td>
																				<?php if($altvalue->islemdurumu=="bekliyor"): ?>
																					<td><a href='javascript:void(0)' onclick='talimatAltIslem("tamamlandi","<?php echo e($altvalue->id); ?>")'><i class="fa fa-check"></i></a></td>
																					<td><a href='javascript:void(0)' onclick='talimatAltIslem("iptal","<?php echo e($altvalue->id); ?>")'><i class="fas fa-minus"></i></a></td>
																					<td><a href='javascript:void(0)' onclick='talimatAltIslem("sil","<?php echo e($altvalue->id); ?>")'><i class="fas fa-trash"></i></a></td>
																				<?php else: ?>
																					<td colspan="3"><?php echo e(trans("messages.".$altvalue->islemdurumu)); ?></td>
																				<?php endif; ?>
																				<td><a title="<?php echo e(trans("messages.uploadfile")); ?>" href='javascript:void(0)' onclick="PopupCenter('/ihracat/operasyon/sub/upload?talimatid=<?php echo e($talimat->id); ?>&gumrukno=<?php echo e($altvalue->gumrukno); ?>&gumruksira=<?php echo e($altvalue->gumrukSira); ?>','xtf','930','500'); "><i class="fa fa-file-pdf-o" aria-hidden="true" style='color:orange'></i></a></td></tbody>
																				</table>
																				<?php break; ?>
																				<?php case ("bondeshortie"): ?>
																				<table class="table table-bordered" cellspacing="0">
																				<thead>
																					<th colspan="3"><?php echo e(trans("messages.onayla")); ?></th></thead>
																				<tbody>
																				<td><a title="<?php echo e(trans("messages.uploadfile")); ?>" href='javascript:void(0)' onclick="PopupCenter('/ihracat/operasyon/sub/upload?talimatid=<?php echo e($talimat->id); ?>&gumrukno=<?php echo e($altvalue->gumrukno); ?>&gumruksira=<?php echo e($altvalue->gumrukSira); ?>','xtf','930','500'); "><i class="fa fa-file-pdf-o" aria-hidden="true" style='color:orange'></i></a></td></tbody>
																				</table>
																				<?php break; ?>
																				<?php case ("ext1t2"): ?>
																						<table class="table table-bordered" cellspacing="0">
																						<thead>
																							<th><?php echo e(trans("messages.varisgumruk")); ?></th>
																							<th><?php echo e(trans("messages.mrnnumber")); ?></th>
																							<th><?php echo e(trans("messages.gonderici")); ?></th>
																							<th><?php echo e(trans("messages.ulkekodu")); ?></th>
																							<th><?php echo e(trans("messages.alici")); ?></th>
																							<th><?php echo e(trans("messages.ulkekodu")); ?></th>
																							<th><?php echo e(trans("messages.kap")); ?></th>
																							<th><?php echo e(trans("messages.kilo")); ?></th>

																							<th><?php echo e(trans("messages.yukcinsi")); ?></th>
																							<th><?php echo e(trans("messages.faturacinsi")); ?></th>
																							<th><?php echo e(trans("messages.faturanumara")); ?></th>
																							<th><?php echo e(trans("messages.faturabedeli")); ?></th>
																							<th colspan="3"><?php echo e(trans("messages.onayla")); ?></th>
																						</thead>
																						<tbody>
																							<td><?php echo e($altvalue->gumrukno+1); ?></td><td><?php echo e($altvalue->gumrukSira); ?></td>
																							<td><?php echo e($altvalue->mrnnumber); ?></td>
																							<td style="color:#<?php echo e(substr(md5($altvalue->varisGumruk),0,6)); ?>;font-weight:bold;" ><?php echo e($altvalue->varisGumruk); ?></td>
																							<td><?php echo e($altvalue->yuklemeNoktasi); ?></td>
																							<td><?php echo e($ulke[$altvalue->yuklemeNoktasiulkekodu]); ?></td>
																							<td><?php echo e($altvalue->indirmeNoktasi); ?></td>
																							<td><?php echo e($ulke[$altvalue->indirmeNoktasiulkekodu]); ?></td>
																							<td><?php echo e($altvalue->tekKap); ?></td>
																							<td><?php echo e($altvalue->tekKilo); ?></td>
																							<td><?php echo e($altvalue->yukcinsi); ?></td>
																							<td><?php echo e($altvalue->faturanumara); ?></td>
																							<td><?php echo e($altvalue->faturabedeli); ?></td>
																							<?php if($altvalue->islemdurumu=="bekliyor"): ?>
																							<td><a href='javascript:void(0)' onclick='talimatAltIslem("tamamlandi","<?php echo e($altvalue->id); ?>")'><i class="fa fa-check"></i></a></td>
																							<td><a href='javascript:void(0)' onclick='talimatAltIslem("iptal","<?php echo e($altvalue->id); ?>")'><i class="fas fa-minus"></i></a></td>
																							<td><a href='javascript:void(0)' onclick='talimatAltIslem("sil","<?php echo e($altvalue->id); ?>")'><i class="fas fa-trash"></i></a></td>
																						<?php else: ?>
																							<td colspan="3"><?php echo e(trans("messages.".$altvalue->islemdurumu)); ?></td>
																						<?php endif; ?>
																						<td><a title="<?php echo e(trans("messages.uploadfile")); ?>" href='javascript:void(0)' onclick="PopupCenter('/ihracat/operasyon/sub/upload?talimatid=<?php echo e($talimat->id); ?>&gumrukno=<?php echo e($altvalue->gumrukno); ?>&gumruksira=<?php echo e($altvalue->gumrukSira); ?>','xtf','930','500'); "><i class="fa fa-file-pdf-o" aria-hidden="true" style='color:orange'></i></a></td></tbody>
																						</table>
																				<?php break; ?>
																				<?php case ("ihracatE1"): ?>
																				<table class="table table-bordered" cellspacing="0">
																					<thead>
																					<th><?php echo e(trans("messages.gumrukno")); ?></th><th><?php echo e(trans("messages.sirano")); ?></th>
																						<th><?php echo e(trans("messages.tirnumarasi")); ?></th>
																            <th><?php echo e(trans("messages.gonderici")); ?></th>
																            <th><?php echo e(trans("messages.gonderici")); ?> <?php echo e(trans("messages.ulkekodu")); ?></th>
																            <th><?php echo e(trans("messages.kap")); ?></th>
																            <th><?php echo e(trans("messages.kilo")); ?></th>

																            <th><?php echo e(trans("messages.faturacinsi")); ?></th>
																            <th><?php echo e(trans("messages.faturanumara")); ?></th>
																            <th><?php echo e(trans("messages.faturabedeli")); ?></th>
																						<th colspan="3"><?php echo e(trans("messages.onayla")); ?></th>
																					</thead>
																					<tbody>
																						<td><?php echo e($altvalue->gumrukno+1); ?></td><td><?php echo e($altvalue->gumrukSira); ?></td>
																						<td><?php echo e($altvalue->tirnumarasi); ?></td>
																						<td><?php echo e($altvalue->yuklemeNoktasi); ?></td>
																						<td><?php echo e($ulke[$altvalue->yuklemeNoktasiulkekodu]); ?></td>
																						<td><?php echo e($altvalue->tekKap); ?></td>
																						<td><?php echo e($altvalue->tekKilo); ?></td>
																						<td><?php echo e($altvalue->yukcinsi); ?></td>
																						<td><?php echo e($altvalue->faturanumara); ?></td>
																						<td><?php echo e($altvalue->faturabedeli); ?></td>
																						<?php if($altvalue->islemdurumu=="bekliyor"): ?>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("tamamlandi","<?php echo e($altvalue->id); ?>")'><i class="fa fa-check"></i></a></td>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("iptal","<?php echo e($altvalue->id); ?>")'><i class="fas fa-minus"></i></a></td>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("sil","<?php echo e($altvalue->id); ?>")'><i class="fas fa-trash"></i></a></td>
																					<?php else: ?>
																						<td colspan="3"><?php echo e(trans("messages.".$altvalue->islemdurumu)); ?></td>
																					<?php endif; ?>
																					<td><a title="<?php echo e(trans("messages.uploadfile")); ?>" href='javascript:void(0)' onclick="PopupCenter('/ihracat/operasyon/sub/upload?talimatid=<?php echo e($talimat->id); ?>&gumrukno=<?php echo e($altvalue->gumrukno); ?>&gumruksira=<?php echo e($altvalue->gumrukSira); ?>','xtf','930','500'); "><i class="fa fa-file-pdf-o" aria-hidden="true" style='color:orange'></i></a></td></tbody>
																				</table>
																				<?php break; ?>;
																				<?php case ("ihracatE2"): ?>
																				<table class="table table-bordered" cellspacing="0">
																						<thead>
																			          <tr>
																								<th><?php echo e(trans("messages.gumrukno")); ?></th>
																								<th><?php echo e(trans("messages.sirano")); ?></th>
																								<th><?php echo e(trans("messages.atanumarasi")); ?></th>
																		            <th><?php echo e(trans("messages.gonderici")); ?></th>
																		            <th><?php echo e(trans("messages.gonderici")); ?> <?php echo e(trans("messages.ulkekodu")); ?></th>
																		            <th><?php echo e(trans("messages.kap")); ?></th>
																		            <th><?php echo e(trans("messages.kilo")); ?></th>

																		            <th><?php echo e(trans("messages.faturacinsi")); ?></th>
																		            <th><?php echo e(trans("messages.faturanumara")); ?></th>
																								<th colspan="3"><?php echo e(trans("messages.onayla")); ?></th>
																			          </tr>
																			      </thead>
																					</thead>
																					<tbody>
																							<td><?php echo e($altvalue->gumrukno+1); ?></td>
																							<td><?php echo e($altvalue->gumrukSira); ?></td>
																							<td><?php echo e($altvalue->atanumarasi); ?></td>
																							<td><?php echo e($altvalue->yuklemeNoktasi); ?></td>
																							<td><?php echo e($ulke[$altvalue->yuklemeNoktasiulkekodu]); ?></td>
																							<td><?php echo e($altvalue->tekKap); ?></td>
																							<td><?php echo e($altvalue->tekKilo); ?></td>
																							<td><?php echo e($altvalue->yukcinsi); ?></td>
																							<td><?php echo e($altvalue->faturanumara); ?></td>
																							<td><?php echo e($altvalue->faturabedeli); ?></td>
																					<?php if($altvalue->islemdurumu=="bekliyor"): ?>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("tamamlandi","<?php echo e($altvalue->id); ?>")'><i class="fa fa-check"></i></a></td>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("iptal","<?php echo e($altvalue->id); ?>")'><i class="fas fa-minus"></i></a></td>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("sil","<?php echo e($altvalue->id); ?>")'><i class="fas fa-trash"></i></a></td>
																					<?php else: ?>
																						<td colspan="3"><?php echo e(trans("messages.".$altvalue->islemdurumu)); ?></td>
																					<?php endif; ?>
																					<td><a title="<?php echo e(trans("messages.uploadfile")); ?>" href='javascript:void(0)' onclick="PopupCenter('/ihracat/operasyon/sub/upload?talimatid=<?php echo e($talimat->id); ?>&gumrukno=<?php echo e($altvalue->gumrukno); ?>&gumruksira=<?php echo e($altvalue->gumrukSira); ?>','xtf','930','500'); "><i class="fa fa-file-pdf-o" aria-hidden="true" style='color:orange'></i></a></td></tbody>
																				</table>
																				<?php break; ?>;
																				<?php case ("ihracatE3"): ?>
																				<table class="table table-bordered" cellspacing="0">
																						<thead>
																								<tr>
																									<th><?php echo e(trans("messages.gumrukno")); ?></th>
																									<th><?php echo e(trans("messages.sirano")); ?></th>

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
																									<th colspan="3"><?php echo e(trans("messages.onayla")); ?></th>
																								</tr>
																						</thead>
																					</thead>
																					<tbody>
																							<td><?php echo e($altvalue->gumrukno+1); ?></td><td><?php echo e($altvalue->gumrukSira); ?></td>

																							<td style="color:#<?php echo e(substr(md5($altvalue->varisGumruk),0,6)); ?>;font-weight:bold;" ><?php echo e($altvalue->varisGumruk); ?></td>
																							<td><?php echo e($altvalue->yuklemeNoktasi); ?></td>
																							<td><?php echo e($ulke[$altvalue->yuklemeNoktasiulkekodu]); ?></td>
																							<td><?php echo e($altvalue->indirmeNoktasi); ?></td>
																							<td><?php echo e($ulke[$altvalue->indirmeNoktasiulkekodu]); ?></td>
																							<td><?php echo e($altvalue->tekKap); ?></td>
																							<td><?php echo e($altvalue->tekKilo); ?></td>

																							<td><?php echo e($altvalue->yukcinsi); ?></td>
																							<td><?php echo e($altvalue->faturacinsi); ?></td>
																							<td><?php echo e($altvalue->faturanumara); ?></td>
																							<td><?php echo e($altvalue->faturabedeli); ?></td>

																					<?php if($altvalue->islemdurumu=="bekliyor"): ?>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("tamamlandi","<?php echo e($altvalue->id); ?>")'><i class="fa fa-check"></i></a></td>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("iptal","<?php echo e($altvalue->id); ?>")'><i class="fas fa-minus"></i></a></td>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("sil","<?php echo e($altvalue->id); ?>")'><i class="fas fa-trash"></i></a></td>
																					<?php else: ?>
																						<td colspan="3"><?php echo e(trans("messages.".$altvalue->islemdurumu)); ?></td>
																					<?php endif; ?>
																					<td><a title="<?php echo e(trans("messages.uploadfile")); ?>" href='javascript:void(0)' onclick="PopupCenter('/ihracat/operasyon/sub/upload?talimatid=<?php echo e($talimat->id); ?>&gumrukno=<?php echo e($altvalue->gumrukno); ?>&gumruksira=<?php echo e($altvalue->gumrukSira); ?>','xtf','930','500'); "><i class="fa fa-file-pdf-o" aria-hidden="true" style='color:orange'></i></a></td></tbody>
																				</table>
																				<?php break; ?>;
																				<?php case ("ihracatE4"): ?>
																				<table class="table table-bordered" cellspacing="0">
																						<thead>
																								<tr>
																										<th><?php echo e(trans("messages.gumrukno")); ?></th><th><?php echo e(trans("messages.sirano")); ?></th>
																										<th style="width:12%"><?php echo e(trans("messages.mrnnumber")); ?></th>
																										<th style="width:10%"><?php echo e(trans("messages.varisgumruk")); ?></th>
																										<th style="width:15%"><?php echo e(trans("messages.gonderici")); ?></th>
																										<th  style="width:5%"><?php echo e(trans("messages.gonderici")); ?> <?php echo e(trans("messages.ulkekodu")); ?></th>
																										<th style="width:15%"><?php echo e(trans("messages.alici")); ?></th>
																										<th style="width:5%"><?php echo e(trans("messages.alici")); ?> <?php echo e(trans("messages.ulkekodu")); ?></th>
																										<th style="width:7%"><?php echo e(trans("messages.kap")); ?></th>
																										<th style="width:7%"><?php echo e(trans("messages.kilo")); ?></th>

																										<th  style="width:5%"><?php echo e(trans("messages.yukcinsi")); ?></th>

																										<th><?php echo e(trans("messages.faturanumara")); ?></th>
																										<th><?php echo e(trans("messages.faturabedeli")); ?></th>
																										<th colspan="3"><?php echo e(trans("messages.onayla")); ?></th>
																								</tr>
																						</thead>
																					</thead>
																					<tbody>
																						<td><?php echo e($altvalue->gumrukno+1); ?></td><td><?php echo e($altvalue->gumrukSira); ?></td>
																						<td><?php echo e($altvalue->mrnnumber); ?></td>
																						<td style="color:#<?php echo e(substr(md5($altvalue->varisGumruk),0,6)); ?>;font-weight:bold;" ><?php echo e($altvalue->varisGumruk); ?></td>
																						<td><?php echo e($altvalue->yuklemeNoktasi); ?></td>
																						<td><?php echo e($ulke[$altvalue->yuklemeNoktasiulkekodu]); ?></td>
																						<td><?php echo e($altvalue->indirmeNoktasi); ?></td>
																						<td><?php echo e($ulke[$altvalue->indirmeNoktasiulkekodu]); ?></td>
																						<td><?php echo e($altvalue->tekKap); ?></td>
																						<td><?php echo e($altvalue->tekKilo); ?></td>
																						<td><?php echo e($altvalue->yukcinsi); ?></td>
																						<td><?php echo e($altvalue->faturanumara); ?></td>
																						<td><?php echo e($altvalue->faturabedeli); ?></td>

																					<?php if($altvalue->islemdurumu=="bekliyor"): ?>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("tamamlandi","<?php echo e($altvalue->id); ?>")'><i class="fa fa-check"></i></a></td>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("iptal","<?php echo e($altvalue->id); ?>")'><i class="fas fa-minus"></i></a></td>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("sil","<?php echo e($altvalue->id); ?>")'><i class="fas fa-trash"></i></a></td>
																					<?php else: ?>
																						<td colspan="3"><?php echo e(trans("messages.".$altvalue->islemdurumu)); ?></td>
																					<?php endif; ?>
																					<td><a title="<?php echo e(trans("messages.uploadfile")); ?>" href='javascript:void(0)' onclick="PopupCenter('/ihracat/operasyon/sub/upload?talimatid=<?php echo e($talimat->id); ?>&gumrukno=<?php echo e($altvalue->gumrukno); ?>&gumruksira=<?php echo e($altvalue->gumrukSira); ?>','xtf','930','500'); "><i class="fa fa-file-pdf-o" aria-hidden="true" style='color:orange'></i></a></td></tbody>
																				</table>
																				<?php break; ?>;
																				<?php case ("ihracatE5"): ?>
																				<table class="table table-bordered" cellspacing="0">
																						<thead>
																								<tr>
																								<th><?php echo e(trans("messages.gumrukno")); ?></th><th><?php echo e(trans("messages.sirano")); ?></th>
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
																								<th colspan="3"><?php echo e(trans("messages.onayla")); ?></th>
																								</tr>
																						</thead>
																					</thead>
																					<tbody>
																										<td><?php echo e($altvalue->gumrukno+1); ?></td><td><?php echo e($altvalue->gumrukSira); ?></td>

																										<td style="color:#<?php echo e(substr(md5($altvalue->varisGumruk),0,6)); ?>;font-weight:bold;" ><?php echo e($altvalue->varisGumruk); ?></td>
																										<td><?php echo e($altvalue->yuklemeNoktasi); ?></td>
																										<td><?php echo e($ulke[$altvalue->yuklemeNoktasiulkekodu]); ?></td>
																										<td><?php echo e($altvalue->indirmeNoktasi); ?></td>
																										<td><?php echo e($ulke[$altvalue->indirmeNoktasiulkekodu]); ?></td>
																										<td><?php echo e($altvalue->tekKap); ?></td>
																										<td><?php echo e($altvalue->tekKilo); ?></td>
																										<td><?php echo e($altvalue->yukcinsi); ?></td>
																										<td><?php echo e($altvalue->faturanumara); ?></td>
																										<td><?php echo e($altvalue->faturabedeli); ?></td>
																					<?php if($altvalue->islemdurumu=="bekliyor"): ?>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("tamamlandi","<?php echo e($altvalue->id); ?>")'><i class="fa fa-check"></i></a></td>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("iptal","<?php echo e($altvalue->id); ?>")'><i class="fas fa-minus"></i></a></td>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("sil","<?php echo e($altvalue->id); ?>")'><i class="fas fa-trash"></i></a></td>
																					<?php else: ?>
																						<td colspan="3"><?php echo e(trans("messages.".$altvalue->islemdurumu)); ?></td>
																					<?php endif; ?>
																					<td><a title="<?php echo e(trans("messages.uploadfile")); ?>" href='javascript:void(0)' onclick="PopupCenter('/ihracat/operasyon/sub/upload?talimatid=<?php echo e($talimat->id); ?>&gumrukno=<?php echo e($altvalue->gumrukno); ?>&gumruksira=<?php echo e($altvalue->gumrukSira); ?>','xtf','930','500'); "><i class="fa fa-file-pdf-o" aria-hidden="true" style='color:orange'></i></a></td></tbody>
																				</table>
																				<?php break; ?>;
																				<?php case ("ihracatE6"): ?>
																				<table class="table table-bordered" cellspacing="0">
																						<thead>
																								<tr>
																								<th><?php echo e(trans("messages.gumrukno")); ?></th><th><?php echo e(trans("messages.sirano")); ?></th>
																								<th style="width:12%"><?php echo e(trans("messages.mrnnumber")); ?></th>
																		            <th style="width:10%"><?php echo e(trans("messages.varisgumruk")); ?></th>
																		            <th style="width:15%"><?php echo e(trans("messages.gonderici")); ?></th>
																		            <th  style="width:5%"><?php echo e(trans("messages.gonderici")); ?> <?php echo e(trans("messages.ulkekodu")); ?></th>
																		            <th style="width:15%"><?php echo e(trans("messages.alici")); ?></th>
																		            <th style="width:5%"><?php echo e(trans("messages.alici")); ?> <?php echo e(trans("messages.ulkekodu")); ?></th>
																		            <th style="width:7%"><?php echo e(trans("messages.kap")); ?></th>
																		            <th style="width:7%"><?php echo e(trans("messages.kilo")); ?></th>

																		            <th  style="width:5%"><?php echo e(trans("messages.yukcinsi")); ?></th>

																		            <th><?php echo e(trans("messages.faturanumara")); ?></th>
																		            <th><?php echo e(trans("messages.faturabedeli")); ?></th>
																								<th colspan="3"><?php echo e(trans("messages.onayla")); ?></th>
																						</thead>
																					</thead>
																					<tbody>
																										<td><?php echo e($altvalue->gumrukno+1); ?></td><td><?php echo e($altvalue->gumrukSira); ?></td>
																										<td><?php echo e($altvalue->mrnnumber); ?></td>
																										<td style="color:#<?php echo e(substr(md5($altvalue->varisGumruk),0,6)); ?>;font-weight:bold;" ><?php echo e($altvalue->varisGumruk); ?></td>
																										<td><?php echo e($altvalue->yuklemeNoktasi); ?></td>
																										<td><?php echo e($ulke[$altvalue->yuklemeNoktasiulkekodu]); ?></td>
																										<td><?php echo e($altvalue->indirmeNoktasi); ?></td>
																										<td><?php echo e($ulke[$altvalue->indirmeNoktasiulkekodu]); ?></td>
																										<td><?php echo e($altvalue->tekKap); ?></td>
																										<td><?php echo e($altvalue->tekKilo); ?></td>
																										<td><?php echo e($altvalue->yukcinsi); ?></td>
																										<td><?php echo e($altvalue->faturanumara); ?></td>
																										<td><?php echo e($altvalue->faturabedeli); ?></td>
																					<?php if($altvalue->islemdurumu=="bekliyor"): ?>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("tamamlandi","<?php echo e($altvalue->id); ?>")'><i class="fa fa-check"></i></a></td>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("iptal","<?php echo e($altvalue->id); ?>")'><i class="fas fa-minus"></i></a></td>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("sil","<?php echo e($altvalue->id); ?>")'><i class="fas fa-trash"></i></a></td>
																					<?php else: ?>
																						<td colspan="3"><?php echo e(trans("messages.".$altvalue->islemdurumu)); ?></td>
																					<?php endif; ?>
																					<td><a title="<?php echo e(trans("messages.uploadfile")); ?>" href='javascript:void(0)' onclick="PopupCenter('/ihracat/operasyon/sub/upload?talimatid=<?php echo e($talimat->id); ?>&gumrukno=<?php echo e($altvalue->gumrukno); ?>&gumruksira=<?php echo e($altvalue->gumrukSira); ?>','xtf','930','500'); "><i class="fa fa-file-pdf-o" aria-hidden="true" style='color:orange'></i></a></td></tbody>
																				</table>
																				<?php break; ?>;
																				<?php case ("ihracatE7"): ?>
																				<table class="table table-bordered" cellspacing="0">
																						<thead>
																						<tr>
																								<th><?php echo e(trans("messages.gumrukno")); ?></th><th><?php echo e(trans("messages.sirano")); ?></th>
																								<th><?php echo e(trans("messages.tirnumarasi")); ?></th>
																		            <th><?php echo e(trans("messages.gonderici")); ?></th>
																		            <th><?php echo e(trans("messages.gonderici")); ?> <?php echo e(trans("messages.ulkekodu")); ?></th>
																		            <th><?php echo e(trans("messages.kap")); ?></th>
																		            <th><?php echo e(trans("messages.kilo")); ?></th>

																		            <th><?php echo e(trans("messages.faturacinsi")); ?></th>
																		            <th><?php echo e(trans("messages.faturanumara")); ?></th>
																								<th><?php echo e(trans("messages.faturabedeli")); ?></th>
																							 <th colspan="3"><?php echo e(trans("messages.onayla")); ?></th>
																							</tr>
																						</thead>
																					</thead>
																					<tbody>
																					<td><?php echo e($altvalue->gumrukno+1); ?></td><td><?php echo e($altvalue->gumrukSira); ?></td>
																					<td><?php echo e($altvalue->tirnumarasi); ?></td>
																					<td style="color:#<?php echo e(substr(md5($altvalue->varisGumruk),0,6)); ?>;font-weight:bold;" ><?php echo e($altvalue->varisGumruk); ?></td>
																					<td><?php echo e($altvalue->yuklemeNoktasi); ?></td>
																					<td><?php echo e($ulke[$altvalue->yuklemeNoktasiulkekodu]); ?></td>

																					<td><?php echo e($altvalue->tekKap); ?></td>
																					<td><?php echo e($altvalue->tekKilo); ?></td>
																					<td><?php echo e($altvalue->yukcinsi); ?></td>
																					<td><?php echo e($altvalue->faturanumara); ?></td>
																					<td><?php echo e($altvalue->faturabedeli); ?></td>
																					<?php if($altvalue->islemdurumu=="bekliyor"): ?>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("tamamlandi","<?php echo e($altvalue->id); ?>")'><i class="fa fa-check"></i></a></td>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("iptal","<?php echo e($altvalue->id); ?>")'><i class="fas fa-minus"></i></a></td>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("sil","<?php echo e($altvalue->id); ?>")'><i class="fas fa-trash"></i></a></td>
																					<?php else: ?>
																						<td colspan="3"><?php echo e(trans("messages.".$altvalue->islemdurumu)); ?></td>
																					<?php endif; ?>
																					<td><a title="<?php echo e(trans("messages.uploadfile")); ?>" href='javascript:void(0)' onclick="PopupCenter('/ihracat/operasyon/sub/upload?talimatid=<?php echo e($talimat->id); ?>&gumrukno=<?php echo e($altvalue->gumrukno); ?>&gumruksira=<?php echo e($altvalue->gumrukSira); ?>','xtf','930','500'); "><i class="fa fa-file-pdf-o" aria-hidden="true" style='color:orange'></i></a></td></tbody>
																				</table>
																				<?php break; ?>;
																				<?php case ("ihracatE8"): ?>
																				<table class="table table-bordered" cellspacing="0">
																						<thead>
																								<tr>
																							<th><?php echo e(trans("messages.gumrukno")); ?></th><th><?php echo e(trans("messages.sirano")); ?></th>
																							<th><?php echo e(trans("messages.atanumarasi")); ?></th>
																	            <th><?php echo e(trans("messages.gonderici")); ?></th>
																	            <th><?php echo e(trans("messages.gonderici")); ?> <?php echo e(trans("messages.ulkekodu")); ?></th>
																	            <th><?php echo e(trans("messages.kap")); ?></th>
																	            <th><?php echo e(trans("messages.kilo")); ?></th>

																	            <th><?php echo e(trans("messages.faturacinsi")); ?></th>
																	            <th><?php echo e(trans("messages.faturanumara")); ?></th>
																	            <th><?php echo e(trans("messages.faturabedeli")); ?></th>
																							 <th colspan="3"><?php echo e(trans("messages.onayla")); ?></th>
																								</tr>
																						</thead>
																					</thead>
																					<tbody>
																										<td><?php echo e($altvalue->gumrukno+1); ?></td><td><?php echo e($altvalue->gumrukSira); ?></td>
																										<td><?php echo e($altvalue->atanumarasi); ?></td>

																										<td><?php echo e($altvalue->yuklemeNoktasi); ?></td>
																										<td><?php echo e($ulke[$altvalue->yuklemeNoktasiulkekodu]); ?></td>

																										<td><?php echo e($altvalue->tekKap); ?></td>
																										<td><?php echo e($altvalue->tekKilo); ?></td>
																										<td><?php echo e($altvalue->yukcinsi); ?></td>
																										<td><?php echo e($altvalue->faturanumara); ?></td>
																										<td><?php echo e($altvalue->faturabedeli); ?></td>
																					<?php if($altvalue->islemdurumu=="bekliyor"): ?>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("tamamlandi","<?php echo e($altvalue->id); ?>")'><i class="fa fa-check"></i></a></td>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("iptal","<?php echo e($altvalue->id); ?>")'><i class="fas fa-minus"></i></a></td>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("sil","<?php echo e($altvalue->id); ?>")'><i class="fas fa-trash"></i></a></td>
																					<?php else: ?>
																						<td colspan="3"><?php echo e(trans("messages.".$altvalue->islemdurumu)); ?></td>
																					<?php endif; ?>
																					<td><a title="<?php echo e(trans("messages.uploadfile")); ?>" href='javascript:void(0)' onclick="PopupCenter('/ihracat/operasyon/sub/upload?talimatid=<?php echo e($talimat->id); ?>&gumrukno=<?php echo e($altvalue->gumrukno); ?>&gumruksira=<?php echo e($altvalue->gumrukSira); ?>','xtf','930','500'); "><i class="fa fa-file-pdf-o" aria-hidden="true" style='color:orange'></i></a></td></tbody>
																				</table>
																				<?php break; ?>;
																				<?php case ("ihracatE9"): ?>
																				<table class="table table-bordered" cellspacing="0">
																						<thead>
																								<tr>
																								<th><?php echo e(trans("messages.gumrukno")); ?></th><th><?php echo e(trans("messages.sirano")); ?></th>
																								<th><?php echo e(trans("messages.baslangicgumruk")); ?></th>

																								<th><?php echo e(trans("messages.gonderici")); ?></th>
																								<th><?php echo e(trans("messages.gonderici")); ?> <?php echo e(trans("messages.ulkekodu")); ?></th>
																								<th><?php echo e(trans("messages.varisgumruk")); ?></th>
																								<th><?php echo e(trans("messages.alici")); ?></th>
																								<th><?php echo e(trans("messages.alici")); ?> <?php echo e(trans("messages.ulkekodu")); ?></th>
																								<th><?php echo e(trans("messages.kap")); ?></th>
																								<th><?php echo e(trans("messages.kilo")); ?></th>

																								<th><?php echo e(trans("messages.yukcinsi")); ?></th>
																								<th><?php echo e(trans("messages.faturacinsi")); ?></th>
																								<th><?php echo e(trans("messages.faturanumara")); ?></th>
																								<th><?php echo e(trans("messages.faturabedeli")); ?></th>
		 																						<th colspan="3"><?php echo e(trans("messages.onayla")); ?></th>
																								</tr>
																						</thead>
																					</thead>
																					<tbody>
																					<td><?php echo e($altvalue->gumrukno+1); ?></td><td><?php echo e($altvalue->gumrukSira); ?></td>

																					<td><?php echo e($altvalue->baslangicGumruk); ?></td>
																					<td><?php echo e($altvalue->yuklemeNoktasi); ?></td>
																					<td><?php echo e($ulke[$altvalue->yuklemeNoktasiulkekodu]); ?></td>
																					<td style="color:#<?php echo e(substr(md5($altvalue->varisGumruk),0,6)); ?>;font-weight:bold;" ><?php echo e($altvalue->varisGumruk); ?></td>
																					<td><?php echo e($altvalue->indirmeNoktasi); ?></td>
																					<td><?php echo e($ulke[$altvalue->indirmeNoktasiulkekodu]); ?></td>
																					<td><?php echo e($altvalue->tekKap); ?></td>
																					<td><?php echo e($altvalue->tekKilo); ?></td>
																					<td><?php echo e($altvalue->yukcinsi); ?></td>
																					<td><?php echo e($altvalue->faturanumara); ?></td>
																					<td><?php echo e($altvalue->faturabedeli); ?></td>
																					<?php if($altvalue->islemdurumu=="bekliyor"): ?>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("tamamlandi","<?php echo e($altvalue->id); ?>")'><i class="fa fa-check"></i></a></td>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("iptal","<?php echo e($altvalue->id); ?>")'><i class="fas fa-minus"></i></a></td>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("sil","<?php echo e($altvalue->id); ?>")'><i class="fas fa-trash"></i></a></td>
																					<?php else: ?>
																						<td colspan="3"><?php echo e(trans("messages.".$altvalue->islemdurumu)); ?></td>
																					<?php endif; ?>
																					<td><a title="<?php echo e(trans("messages.uploadfile")); ?>" href='javascript:void(0)' onclick="PopupCenter('/ihracat/operasyon/sub/upload?talimatid=<?php echo e($talimat->id); ?>&gumrukno=<?php echo e($altvalue->gumrukno); ?>&gumruksira=<?php echo e($altvalue->gumrukSira); ?>','xtf','930','500'); "><i class="fa fa-file-pdf-o" aria-hidden="true" style='color:orange'></i></a></td></tbody>
																				</table>
																				<?php break; ?>;
																				<?php case ("ihracatE10"): ?>
																				<table class="table table-bordered" cellspacing="0">
																						<thead>
																								<tr>
																								<th><?php echo e(trans("messages.gumrukno")); ?></th><th><?php echo e(trans("messages.sirano")); ?></th>
																								<th><?php echo e(trans("messages.baslangicgumruk")); ?></th>
																		            <th style="width:12%"><?php echo e(trans("messages.mrnnumber")); ?></th>
																		            <th><?php echo e(trans("messages.tirnumarasi")); ?></th>

																		            <th><?php echo e(trans("messages.gonderici")); ?></th>
																		            <th><?php echo e(trans("messages.gonderici")); ?> <?php echo e(trans("messages.ulkekodu")); ?></th>
																		            <th><?php echo e(trans("messages.varisgumruk")); ?></th>
																		            <th><?php echo e(trans("messages.alici")); ?></th>
																		            <th><?php echo e(trans("messages.alici")); ?> <?php echo e(trans("messages.ulkekodu")); ?></th>
																		            <th><?php echo e(trans("messages.kap")); ?></th>
																		            <th><?php echo e(trans("messages.kilo")); ?></th>

																		            <th><?php echo e(trans("messages.yukcinsi")); ?></th>
																		            <th><?php echo e(trans("messages.faturacinsi")); ?></th>
																		            <th><?php echo e(trans("messages.faturanumara")); ?></th>
																		            <th><?php echo e(trans("messages.faturabedeli")); ?></th>
																								<th colspan="3"><?php echo e(trans("messages.onayla")); ?></th>
																								</tr>
																						</thead>
																					</thead>
																					<tbody>
																						<td><?php echo e($altvalue->gumrukno+1); ?></td><td><?php echo e($altvalue->gumrukSira); ?></td>
																						<td><?php echo e($altvalue->baslangicGumruk); ?></td>
																						<td><?php echo e($altvalue->mrnnumber); ?></td>
																						<td><?php echo e($altvalue->tirnumarasi); ?></td>
																						<td><?php echo e($altvalue->yuklemeNoktasi); ?></td>
																						<td><?php echo e($ulke[$altvalue->yuklemeNoktasiulkekodu]); ?></td>
																						<td style="color:#<?php echo e(substr(md5($altvalue->varisGumruk),0,6)); ?>;font-weight:bold;" ><?php echo e($altvalue->varisGumruk); ?></td>
																						<td><?php echo e($altvalue->indirmeNoktasi); ?></td>
																						<td><?php echo e($ulke[$altvalue->indirmeNoktasiulkekodu]); ?></td>
																						<td><?php echo e($altvalue->tekKap); ?></td>
																						<td><?php echo e($altvalue->tekKilo); ?></td>
																						<td><?php echo e($altvalue->yukcinsi); ?></td>
																						<td><?php echo e($altvalue->faturanumara); ?></td>
																						<td><?php echo e($altvalue->faturabedeli); ?></td>
																					<?php if($altvalue->islemdurumu=="bekliyor"): ?>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("tamamlandi","<?php echo e($altvalue->id); ?>")'><i class="fa fa-check"></i></a></td>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("iptal","<?php echo e($altvalue->id); ?>")'><i class="fas fa-minus"></i></a></td>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("sil","<?php echo e($altvalue->id); ?>")'><i class="fas fa-trash"></i></a></td>
																					<?php else: ?>
																						<td colspan="3"><?php echo e(trans("messages.".$altvalue->islemdurumu)); ?></td>
																					<?php endif; ?>
																					<td><a title="<?php echo e(trans("messages.uploadfile")); ?>" href='javascript:void(0)' onclick="PopupCenter('/ihracat/operasyon/sub/upload?talimatid=<?php echo e($talimat->id); ?>&gumrukno=<?php echo e($altvalue->gumrukno); ?>&gumruksira=<?php echo e($altvalue->gumrukSira); ?>','xtf','930','500'); "><i class="fa fa-file-pdf-o" aria-hidden="true" style='color:orange'></i></a></td></tbody>
																				</table>
																				<?php break; ?>;
																				<?php case ("ihracatE11"): ?>
																				<table class="table table-bordered" cellspacing="0">
																						<thead>
																								<tr>
																								<th><?php echo e(trans("messages.gumrukno")); ?></th><th><?php echo e(trans("messages.sirano")); ?></th>
																								<th><?php echo e(trans("messages.plaka")); ?> </th>
																								<th><?php echo e(trans("messages.plaka")); ?> <?php echo e(trans("messages.ulkekodu")); ?></th>
																								<th><?php echo e(trans("messages.dorseplaka")); ?> </th>
																								<th><?php echo e(trans("messages.dorseplaka")); ?> <?php echo e(trans("messages.ulkekodu")); ?></th>
																								<th colspan="3"><?php echo e(trans("messages.onayla")); ?></th>
																								</tr>
																						</thead>
																					</thead>
																					<tbody>
																						<td><?php echo e($altvalue->gumrukno+1); ?></td><td><?php echo e($altvalue->gumrukSira); ?></td>
																						<td><?php echo e($altvalue->plaka); ?></td>
																						<td><?php echo e($ulke[$altvalue->yuklemeNoktasiulkekodu]); ?></td>
																						<td><?php echo e($altvalue->dorse); ?></td>
																						<td><?php echo e($ulke[$altvalue->indirmeNoktasiulkekodu]); ?></td>
																					<?php if($altvalue->islemdurumu=="bekliyor"): ?>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("tamamlandi","<?php echo e($altvalue->id); ?>")'><i class="fa fa-check"></i></a></td>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("iptal","<?php echo e($altvalue->id); ?>")'><i class="fas fa-minus"></i></a></td>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("sil","<?php echo e($altvalue->id); ?>")'><i class="fas fa-trash"></i></a></td>
																					<?php else: ?>
																						<td colspan="3"><?php echo e(trans("messages.".$altvalue->islemdurumu)); ?></td>
																					<?php endif; ?>
																					<td><a title="<?php echo e(trans("messages.uploadfile")); ?>" href='javascript:void(0)' onclick="PopupCenter('/ihracat/operasyon/sub/upload?talimatid=<?php echo e($talimat->id); ?>&gumrukno=<?php echo e($altvalue->gumrukno); ?>&gumruksira=<?php echo e($altvalue->gumrukSira); ?>','xtf','930','500'); "><i class="fa fa-file-pdf-o" aria-hidden="true" style='color:orange'></i></a></td></tbody>
																				</table>
																				<?php break; ?>;
																				<?php case ("ihracatE12"): ?>
																				<table class="table table-bordered" cellspacing="0">
																						<thead>
																								<tr>
																								<th><?php echo e(trans("messages.gumrukno")); ?></th><th><?php echo e(trans("messages.sirano")); ?></th>
																								<th><?php echo e(trans("messages.dorseplaka")); ?> </th>
																		            <th><?php echo e(trans("messages.dorseplaka")); ?> <?php echo e(trans("messages.ulkekodu")); ?></th>
																									<th colspan="3"><?php echo e(trans("messages.onayla")); ?></th>
																								</tr>
																						</thead>
																					</thead>
																					<tbody>
																						<td><?php echo e($altvalue->gumrukno+1); ?></td><td><?php echo e($altvalue->gumrukSira); ?></td>
																						<td><?php echo e($altvalue->dorse); ?></td>
																						<td><?php echo e($ulke[$altvalue->indirmeNoktasiulkekodu]); ?></td>
																					<?php if($altvalue->islemdurumu=="bekliyor"): ?>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("tamamlandi","<?php echo e($altvalue->id); ?>")'><i class="fa fa-check"></i></a></td>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("iptal","<?php echo e($altvalue->id); ?>")'><i class="fas fa-minus"></i></a></td>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("sil","<?php echo e($altvalue->id); ?>")'><i class="fas fa-trash"></i></a></td>
																					<?php else: ?>
																						<td colspan="3"><?php echo e(trans("messages.".$altvalue->islemdurumu)); ?></td>
																					<?php endif; ?>
																					<td><a title="<?php echo e(trans("messages.uploadfile")); ?>" href='javascript:void(0)' onclick="PopupCenter('/ihracat/operasyon/sub/upload?talimatid=<?php echo e($talimat->id); ?>&gumrukno=<?php echo e($altvalue->gumrukno); ?>&gumruksira=<?php echo e($altvalue->gumrukSira); ?>','xtf','930','500'); "><i class="fa fa-file-pdf-o" aria-hidden="true" style='color:orange'></i></a></td></tbody>
																				</table>
																				<?php break; ?>;
																				<?php case ("ihracatE13"): ?>
																				<table class="table table-bordered" cellspacing="0">
																						<thead>
																								<tr>
																								<th><?php echo e(trans("messages.gumrukno")); ?></th><th><?php echo e(trans("messages.sirano")); ?></th>
																								<th><?php echo e(trans("messages.plaka")); ?> </th>
																		            <th><?php echo e(trans("messages.plaka")); ?> <?php echo e(trans("messages.ulkekodu")); ?></th>
																		            <th><?php echo e(trans("messages.dorseplaka")); ?> </th>
																		            <th><?php echo e(trans("messages.dorseplaka")); ?> <?php echo e(trans("messages.ulkekodu")); ?></th>
																									<th colspan="3"><?php echo e(trans("messages.onayla")); ?></th>
																								</tr>
																						</thead>
																					</thead>
																					<tbody>
																						<td><?php echo e($altvalue->gumrukno+1); ?></td><td><?php echo e($altvalue->gumrukSira); ?></td>
																						<td><?php echo e($altvalue->plaka); ?></td>
																						<td><?php echo e($ulke[$altvalue->yuklemeNoktasiulkekodu]); ?></td>
																						<td><?php echo e($altvalue->dorse); ?></td>
																						<td><?php echo e($ulke[$altvalue->indirmeNoktasiulkekodu]); ?></td>
																					<?php if($altvalue->islemdurumu=="bekliyor"): ?>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("tamamlandi","<?php echo e($altvalue->id); ?>")'><i class="fa fa-check"></i></a></td>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("iptal","<?php echo e($altvalue->id); ?>")'><i class="fas fa-minus"></i></a></td>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("sil","<?php echo e($altvalue->id); ?>")'><i class="fas fa-trash"></i></a></td>
																					<?php else: ?>
																						<td colspan="3"><?php echo e(trans("messages.".$altvalue->islemdurumu)); ?></td>
																					<?php endif; ?>
																					<td><a title="<?php echo e(trans("messages.uploadfile")); ?>" href='javascript:void(0)' onclick="PopupCenter('/ihracat/operasyon/sub/upload?talimatid=<?php echo e($talimat->id); ?>&gumrukno=<?php echo e($altvalue->gumrukno); ?>&gumruksira=<?php echo e($altvalue->gumrukSira); ?>','xtf','930','500'); "><i class="fa fa-file-pdf-o" aria-hidden="true" style='color:orange'></i></a></td></tbody>
																				</table>
																				<?php break; ?>;

																				<?php endswitch; ?>
																			</div>
																			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

																<?php endif; ?>


																<?php if(!empty($talimat->altmodel)): ?>
																	<?php ($toplamkap = 0); ?>
																	<?php ($toplamkilo = 0); ?>
																		<?php $__currentLoopData = $talimat->altmodel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $altkey=>$altvalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
																			<?php ($toplamkap+=$altvalue->tekKap); ?>
																			<?php ($toplamkilo+=$altvalue->tekKilo); ?>
																		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
																	<?php endif; ?>
																		<tr>
																				<td><?php echo e(trans("messages.toplamkap")); ?></td>
																				<td><?php echo e($toplamkap); ?></td>
																				<td><?php echo e(trans("messages.toplamkilo")); ?></td>
																				<td><?php echo e($toplamkilo); ?></td>
																		</tr>
															 </tbody>

																</table>

																<table class="table table-bordered" cellspacing="0">
																	<thead>
																			<tr>
																					<th colspan="4"><?php echo e(trans("messages.talimatevrakyuklemebaslik")); ?></th>
																			</tr>
																		<th colspan="3"><?php echo e(trans("messages.onayla")); ?></th></thead>
																	<tbody>
																		<?php if(!empty($talimat->evrak)): ?>
				 															<?php $__currentLoopData = $talimat->evrak; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $evkey => $evvalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
																					<tr>
																						<td><?php echo e($evvalue->filerealname); ?></td>
																						<td><?php echo e($evvalue->filetype); ?></td>
																						<td>
																							<?php echo e(($evvalue->kacinci)); ?>. <?php echo e(trans("messages.gumruk")); ?>  <?php echo e(trans("messages.".$evvalue->belgetipi)); ?> - <?php echo e(trans("messages.yuk")); ?> <?php echo e(($evvalue->yukId)); ?> - <?php echo e(trans("messages.dosya")); ?>  <?php echo e(($evvalue->siraId)+1); ?>

																						</td>
																					<td>
				 																			<a href='/uploads/<?php echo e($evvalue->fileName); ?>' target="_blank"><?php echo e(trans("messages.dosyaindir")); ?></a><br />
																						</td>
																						<?php if($talimat->ilgili->id==\Auth::user()->id || \Auth::user()->role=="admin"): ?>
																						<td>

																							<a href='/dosya/sil/<?php echo e($evvalue->id); ?>' onclick="return confirm('<?php echo e(trans("messages.silmeeminmisiniz")); ?>')"><?php echo e(trans("messages.delete")); ?></a>
																						</td>
																					<?php endif; ?>
																					</tr>
				 															<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				 														 <?php endif; ?>
																	</tbody>
																</table>
														 </div>

				 								 	</div>



		 				</div>
						<div class="col-md-12 border p-2">
						 <div class="form-group col-md-4 temizlenebilir">
							<h3><?php echo e(trans("messages.aciklama")); ?></h3>
							<div><?php echo e($talimat->note); ?></div>
						</div>
						</div>

				<?php if(Auth::user()->role=='Xadmin' || Auth::user()->role=='Xbolgeadmin'): ?>
						<form action="/operation/uploadfile" method="post"  enctype="multipart/form-data"   onsubmit="return confirm('<?php echo e(trans("messages.formconfirm")); ?>')">

								<?php echo e(csrf_field()); ?>

								<input type="hidden" value="<?php echo e($talimat->id); ?>" name="talimatId" />
						<div class='row' style='margin-left:2px;margin-top:4px;background: #FFF;'>
						<div class='col-md-12 border'>
							<h2><?php echo e(trans("messages.ozelevrakyuklemebaslik")); ?></h2>
							<div class="form-group col-md-12">
								<label for=""><?php echo e(trans("messages.evrakyukle")); ?></label>
								<small><?php echo e(trans("messages.evrakyuklealt")); ?></small>
								<hr />
								<label><?php echo e(trans("messages.ex1")); ?> <?php echo e(trans("messages.evrakyukle")); ?></label>
								<input type="file" name='specialfiles[ex1][]' multiple class='form-control' >
								<br />
								<label><?php echo e(trans("messages.t2")); ?> <?php echo e(trans("messages.evrakyukle")); ?></label>
								<input type="file" name='specialfiles[t2][]' multiple class='form-control' >
								<br />
								<label><?php echo e(trans("messages.fatura")); ?> <?php echo e(trans("messages.evrakyukle")); ?></label>
								<input type="file" name='specialfiles[fatura][]' multiple class='form-control'>
								<br />
								<label><?php echo e(trans("messages.packinglist")); ?> <?php echo e(trans("messages.evrakyukle")); ?></label>
								<input type="file" name='specialfiles[packinglist][]' multiple class='form-control' >
								<br />
								<label><?php echo e(trans("messages.atr")); ?> <?php echo e(trans("messages.evrakyukle")); ?></label>
								<input type="file" name='specialfiles[atr][]' multiple class='form-control'>
								<br />
								<label><?php echo e(trans("messages.adr")); ?> <?php echo e(trans("messages.evrakyukle")); ?></label>
								<input type="file" name='specialfiles[adr][]' multiple class='form-control' >
								<br />
								<label><?php echo e(trans("messages.cmr")); ?> <?php echo e(trans("messages.evrakyukle")); ?></label>
								<input type="file" name='specialfiles[cmr][]' multiple class='form-control' >
							</div>
							<hr />
						<h2><?php echo e(trans("messages.talimatevrakyuklemebaslik")); ?></h2>
						<br />
							<div class="form-group col-md-12">
													<label for="gallery-photo-add"><?php echo e(trans("messages.evrakyukle")); ?></label>
													<small><?php echo e(trans("messages.evrakyuklealt")); ?></small>
													<input type="file" name='files[]' class='form-control' multiple id="gallery-photo-add">
														<div id='dgalleryd' class="gallery"></div>
												</div>
							</div>
							<button class='btn btn-info' type='submit'><?php echo e(trans("messages.save")); ?></button>


			 </div>
			 		</form>

			<?php endif; ?>
			<div class="col-md-12 border p-2 mt-3">
			 <div class="form-group col-md-12 temizlenebilir">
					<h3>Log</h3>
				<table class="table table-bordered">
					<thead>
					<th><?php echo e(trans("messages.gumrukno")); ?></th><th><?php echo e(trans("messages.sirano")); ?></th>
						<th>Kullanıcı</th>
						<th>Yapılan İşlem</th>
						<th>Zamanı</th>
					</thead>
					<?php if(!empty($logfile)): ?>
						<tbody>
						<?php $__currentLoopData = $logfile; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<tr>
									<td><?php echo e($key); ?></td>
									<td><?php echo e($value->user->name); ?></td>
									<td><?php echo e($value->what); ?></td>
									<td><?php echo e($value->created_at); ?></td>
								</tr>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</tbody>
					<?php endif; ?>
				</table>
			</div>
			</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>