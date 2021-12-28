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
					<div class='col-4 text-right'><a href='/operation/print/<?php echo e($talimat->id); ?>'>Yazdırmak İçin <i class="fa fa-print"></i> </a></div>

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
																		<td><strong><?php echo e(trans("messages.talimattipi")); ?></strong></td>
																		<td>
																			<?php echo e(trans("messages.".$talimat->talimatTipi)); ?>

																		</td>
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
																						<a href="/operation/donethis/<?php echo e($talimat->id); ?>" class="btn btn-danger"><?php if(\Auth::user()->role=="admin"): ?>Yönetici Olarak <?php endif; ?> Operasyonu Tamamla</a>
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
															 <table class="table table-bordered" cellspacing="0">
															 <tbody>
															 <tr>
																	<td colspan='11'><hr /></td>
															 </tr>
																<tbody>
																<?php if(!empty($talimat->altmodel)): ?>
																	<?php switch($talimat->talimatTipi):
    																		case ("ex1"): ?>
																				<tr>
																					<th><?php echo e(trans("messages.gumrukno")); ?></th>
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
																				 </tr>
																					<?php $__currentLoopData = $talimat->altmodel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $altkey=>$altvalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
																						<tr>
																							<td class="text-red"><?php echo e($altvalue->gumrukId+1); ?></td>
																							<td><?php echo e($altvalue->varisGumruk); ?></td>
																							<td><?php echo e($altvalue->yuklemeNoktasi); ?></td>
																							<td><?php echo e($ulke[$altvalue->yuklemeNoktasiulkekodu]); ?></td>
																							<td><?php echo e($altvalue->indirmeNoktasi); ?></td>
																							<td><?php echo e($ulke[$altvalue->indirmeNoktasiulkekodu]); ?></td>
																							<td><?php echo e($altvalue->tekKap); ?></td>
																							<td><?php echo e($altvalue->tekKilo); ?></td>
																							<td><?php echo e($altvalue->yukcinsi); ?></td>
																							<td><?php echo e($altvalue->faturanumara); ?></td>
																							<td><?php echo e($altvalue->faturabedeli); ?></td>
																						</tr>
																					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
																				<?php break; ?>
																				<?php case ("t2"): ?>
																						<tr>
																							<th><?php echo e(trans("messages.gumrukno")); ?></th>
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
																	          </tr>
																						<?php $__currentLoopData = $talimat->altmodel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $altkey=>$altvalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
																							<tr>
																								<td><?php echo e($altvalue->gumrukId+1); ?></td>
																								<td><?php echo e($altvalue->mrnnumber); ?></td>
																										<td><?php echo e($altvalue->varisGumruk); ?></td>
																								<td><?php echo e($altvalue->yuklemeNoktasi); ?></td>
																								<td><?php echo e($ulke[$altvalue->yuklemeNoktasiulkekodu]); ?></td>
																								<td><?php echo e($altvalue->indirmeNoktasi); ?></td>
																								<td><?php echo e($ulke[$altvalue->indirmeNoktasiulkekodu]); ?></td>
																								<td><?php echo e($altvalue->tekKap); ?></td>
																								<td><?php echo e($altvalue->tekKilo); ?></td>
																								<td><?php echo e($altvalue->yukcinsi); ?></td>
																								<td><?php echo e($altvalue->faturanumara); ?></td>
																								<td><?php echo e($altvalue->faturabedeli); ?></td>
																							</tr>
																						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
																				<?php break; ?>
																				<?php case ("t1"): ?>
																						<tr>
																							<th><?php echo e(trans("messages.gumrukno")); ?></th>
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
																						</tr>
																						<?php $__currentLoopData = $talimat->altmodel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $altkey=>$altvalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
																							<tr>
																								<td><?php echo e($altvalue->gumrukId+1); ?></td>
																								<td><?php echo e($altvalue->mrnnumber); ?></td>
																										<td><?php echo e($altvalue->varisGumruk); ?></td>
																								<td><?php echo e($altvalue->yuklemeNoktasi); ?></td>
																								<td><?php echo e($ulke[$altvalue->yuklemeNoktasiulkekodu]); ?></td>
																								<td><?php echo e($altvalue->indirmeNoktasi); ?></td>
																								<td><?php echo e($ulke[$altvalue->indirmeNoktasiulkekodu]); ?></td>
																								<td><?php echo e($altvalue->tekKap); ?></td>
																								<td><?php echo e($altvalue->tekKilo); ?></td>
																								<td><?php echo e($altvalue->yukcinsi); ?></td>
																								<td><?php echo e($altvalue->faturanumara); ?></td>
																								<td><?php echo e($altvalue->faturabedeli); ?></td>
																							</tr>
																						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
																				<?php break; ?>
																		  <?php case ("passage"): ?>
																			<tr>
																				<th><?php echo e(trans("messages.gumrukno")); ?></th>
																				<th><?php echo e(trans("messages.tirnumarasi")); ?></th>
														            <th><?php echo e(trans("messages.gonderici")); ?></th>
														            <th><?php echo e(trans("messages.ulkekodu")); ?></th>
														            <th><?php echo e(trans("messages.kap")); ?></th>
														            <th><?php echo e(trans("messages.kilo")); ?></th>
														            <th><?php echo e(trans("messages.faturacinsi")); ?></th>
														            <th><?php echo e(trans("messages.faturanumara")); ?></th>
														            <th><?php echo e(trans("messages.faturabedeli")); ?></th>
																			</tr>
																			<?php $__currentLoopData = $talimat->altmodel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $altkey=>$altvalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
																				<tr>
																					<td><?php echo e($altvalue->gumrukId+1); ?></td>
																					<td><?php echo e($altvalue->tirnumarasi); ?></td>
																					<td><?php echo e($altvalue->yuklemeNoktasi); ?></td>
																					<td><?php echo e($ulke[$altvalue->yuklemeNoktasiulkekodu]); ?></td>
																					<td><?php echo e($altvalue->tekKap); ?></td>
																					<td><?php echo e($altvalue->tekKilo); ?></td>
																					<td><?php echo e($altvalue->yukcinsi); ?></td>
																					<td><?php echo e($altvalue->faturanumara); ?></td>
																					<td><?php echo e($altvalue->faturabedeli); ?></td>
																				</tr>
																			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
																			<?php break; ?>
																		  <?php case ("t1kapama"): ?>
																			<tr>
																				<th><?php echo e(trans("messages.gumrukno")); ?></th>
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
																			</tr>
																			<?php $__currentLoopData = $talimat->altmodel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $altkey=>$altvalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
																				<tr>
																					<td><?php echo e($altvalue->gumrukId+1); ?></td>
																					<td><?php echo e($altvalue->baslangicGumruk); ?></td>

																					<td><?php echo e($altvalue->yuklemeNoktasi); ?></td>
																					<td><?php echo e($ulke[$altvalue->yuklemeNoktasiulkekodu]); ?></td>
																					<td><?php echo e($altvalue->varisGumruk); ?></td>
																					<td><?php echo e($altvalue->indirmeNoktasi); ?></td>
																					<td><?php echo e($ulke[$altvalue->indirmeNoktasiulkekodu]); ?></td>
																					<td><?php echo e($altvalue->tekKap); ?></td>
																					<td><?php echo e($altvalue->tekKilo); ?></td>
																					<td><?php echo e($altvalue->yukcinsi); ?></td>
																					<td><?php echo e($altvalue->faturanumara); ?></td>
																					<td><?php echo e($altvalue->faturabedeli); ?></td>
																				</tr>
																			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
																		  <?php case ("tir"): ?>
																			<tr>
																				<th><?php echo e(trans("messages.gumrukno")); ?></th>
																				<th><?php echo e(trans("messages.tirnumarasi")); ?></th>
														            <th><?php echo e(trans("messages.gonderici")); ?></th>
														            <th><?php echo e(trans("messages.ulkekodu")); ?></th>
														            <th><?php echo e(trans("messages.kap")); ?></th>
														            <th><?php echo e(trans("messages.kilo")); ?></th>

														            <th><?php echo e(trans("messages.faturacinsi")); ?></th>
														            <th><?php echo e(trans("messages.faturanumara")); ?></th>
														            <th><?php echo e(trans("messages.faturabedeli")); ?></th>
																			</tr>
																			<?php $__currentLoopData = $talimat->altmodel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $altkey=>$altvalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
																				<tr>
																					<td><?php echo e($altvalue->gumrukId+1); ?></td>
																					<td><?php echo e($altvalue->tirnumarasi); ?></td>
																					<td><?php echo e($altvalue->yuklemeNoktasi); ?></td>
																					<td><?php echo e($ulke[$altvalue->yuklemeNoktasiulkekodu]); ?></td>
																					<td><?php echo e($altvalue->tekKap); ?></td>
																					<td><?php echo e($altvalue->tekKilo); ?></td>
																					<td><?php echo e($altvalue->yukcinsi); ?></td>
																					<td><?php echo e($altvalue->faturanumara); ?></td>
																					<td><?php echo e($altvalue->faturabedeli); ?></td>
																				</tr>
																			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
																			<?php break; ?>
																		  <?php case ("ata"): ?>
																			<tr>
																				<th><?php echo e(trans("messages.gumrukno")); ?></th>
																				<th><?php echo e(trans("messages.tirnumarasi")); ?></th>
														            <th><?php echo e(trans("messages.gonderici")); ?></th>
														            <th><?php echo e(trans("messages.ulkekodu")); ?></th>
														            <th><?php echo e(trans("messages.kap")); ?></th>
														            <th><?php echo e(trans("messages.kilo")); ?></th>

														            <th><?php echo e(trans("messages.faturacinsi")); ?></th>
														            <th><?php echo e(trans("messages.faturanumara")); ?></th>
														            <th><?php echo e(trans("messages.faturabedeli")); ?></th>
																			</tr>
																			<?php $__currentLoopData = $talimat->altmodel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $altkey=>$altvalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
																				<tr>
																					<td><?php echo e($altvalue->gumrukId+1); ?></td>
																					<td><?php echo e($altvalue->tirnumarasi); ?></td>
																					<td><?php echo e($altvalue->yuklemeNoktasi); ?></td>
																					<td><?php echo e($ulke[$altvalue->yuklemeNoktasiulkekodu]); ?></td>
																					<td><?php echo e($altvalue->tekKap); ?></td>
																					<td><?php echo e($altvalue->tekKilo); ?></td>
																					<td><?php echo e($altvalue->yukcinsi); ?></td>
																					<td><?php echo e($altvalue->faturanumara); ?></td>
																					<td><?php echo e($altvalue->faturabedeli); ?></td>
																				</tr>
																			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
																			<?php break; ?>
																		  <?php case ("listex"): ?>
																			<tr>
																				<th><?php echo e(trans("messages.gumrukno")); ?></th>
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
																			</tr>
																			<?php $__currentLoopData = $talimat->altmodel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $altkey=>$altvalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
																				<tr>
																					<td><?php echo e($altvalue->gumrukId+1); ?></td>
																					<td><?php echo e($altvalue->varisGumruk); ?></td>
																					<td><?php echo e($altvalue->yuklemeNoktasi); ?></td>
																					<td><?php echo e($ulke[$altvalue->yuklemeNoktasiulkekodu]); ?></td>
																					<td><?php echo e($altvalue->indirmeNoktasi); ?></td>
																					<td><?php echo e($ulke[$altvalue->indirmeNoktasiulkekodu]); ?></td>
																					<td><?php echo e($altvalue->tekKap); ?></td>
																					<td><?php echo e($altvalue->tekKilo); ?></td>
																					<td><?php echo e($altvalue->yukcinsi); ?></td>
																					<td><?php echo e($altvalue->faturanumara); ?></td>
																					<td><?php echo e($altvalue->faturabedeli); ?></td>
																				</tr>
																			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
																			<?php break; ?>
																		  <?php case ("ithalatimport"): ?>
																			<tr>
																				<th><?php echo e(trans("messages.gumrukno")); ?></th>
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
																			</tr>
																			<?php $__currentLoopData = $talimat->altmodel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $altkey=>$altvalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
																				<tr>
																					<td><?php echo e($altvalue->gumrukId+1); ?></td>
																					<td><?php echo e($altvalue->varisGumruk); ?></td>
																					<td><?php echo e($altvalue->yuklemeNoktasi); ?></td>
																					<td><?php echo e($ulke[$altvalue->yuklemeNoktasiulkekodu]); ?></td>
																					<td><?php echo e($altvalue->indirmeNoktasi); ?></td>
																					<td><?php echo e($ulke[$altvalue->indirmeNoktasiulkekodu]); ?></td>
																					<td><?php echo e($altvalue->tekKap); ?> </td>
																					<td><?php echo e($altvalue->tekKilo); ?></td>
																					<td><?php echo e($altvalue->yukcinsi); ?></td>
																					<td><?php echo e($altvalue->faturanumara); ?></td>
																					<td><?php echo e($altvalue->faturabedeli); ?></td>
																				</tr>
																			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
																			<?php break; ?>
																		  <?php case ("bondeshortie"): ?>
																			<tr>
																				<th><?php echo e(trans("messages.plaka")); ?></th>
														            <th><?php echo e(trans("messages.gonderici")); ?></th>

																			</tr>
																			<?php break; ?>
																		  <?php case ("ext1t2"): ?>
																			<tr>
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
																			</tr>
																			<?php $__currentLoopData = $talimat->altmodel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $altkey=>$altvalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
																				<tr>
																					<td><?php echo e($altvalue->gumrukId+1); ?></td>
																					<td><?php echo e($altvalue->mrnnumber); ?></td>
																					<td><?php echo e($altvalue->varisGumruk); ?></td>
																					<td><?php echo e($altvalue->yuklemeNoktasi); ?></td>
																					<td><?php echo e($ulke[$altvalue->yuklemeNoktasiulkekodu]); ?></td>
																					<td><?php echo e($altvalue->indirmeNoktasi); ?></td>
																					<td><?php echo e($ulke[$altvalue->indirmeNoktasiulkekodu]); ?></td>
																					<td><?php echo e($altvalue->tekKap); ?></td>
																					<td><?php echo e($altvalue->tekKilo); ?></td>
																					<td><?php echo e($altvalue->yukcinsi); ?></td>
																					<td><?php echo e($altvalue->faturanumara); ?></td>
																					<td><?php echo e($altvalue->faturabedeli); ?></td>
																				</tr>
																			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
																			<?php break; ?>
																	<?php endswitch; ?>
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
																	</thead>
																	<tbody>
																		<?php if(!empty($talimat->evrak)): ?>
				 															<?php $__currentLoopData = $talimat->evrak; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $evkey => $evvalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
																					<tr>
																						<td><?php echo e($evvalue->filerealname); ?></td>
																						<td><?php echo e($evvalue->filetype); ?></td>
																						<td>
																							<?php echo e(($evvalue->kacinci)+1); ?>. <?php echo e(trans("messages.gumruk")); ?>  <?php echo e(trans("messages.".$evvalue->belgetipi)); ?> - <?php echo e(trans("messages.yuk")); ?> <?php echo e(($evvalue->yukId)+1); ?> - <?php echo e(trans("messages.dosya")); ?>  <?php echo e(($evvalue->siraId)+1); ?>

																						</td>
																						<!-- <td><?php echo e(($evvalue->kacinci)+1); ?> .<?php echo e(trans("messages.gumruk")); ?> - <?php echo e(trans("messages.".$evvalue->belgetipi)); ?> - <?php echo e(($evvalue->siraId)+1); ?></td> -->

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

				<?php if(Auth::user()->role=='admin' || Auth::user()->role=='bolgeadmin'): ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>