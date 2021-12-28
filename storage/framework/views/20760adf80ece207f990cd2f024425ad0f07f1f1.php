
<!doctype html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Language" content="en" />
    <link rel="icon" href="./favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" type="image/x-icon" href="./favicon.ico" />
    <!-- Generated: 2018-04-16 09:29:05 +0200 -->
    <title>Bosphore GROUP - Yönetim Sayfası</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext">
    <!-- Dashboard Core -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<style>
  th,td{font-size: 0.7em;padding:1px;margin:1px}
  #gumrukbilgi{font-size:0.9em;}
</style>
  </head>
  <body class="" onload="window.print()">
    <div class="page    bg-white text-dark">
      <div class="page-main">
        <div class="header py-4">
          <div class="container-fluid">


	<div class="card mb-3">
    <div class="card-header">
      <img src='/img/logo.png' class="img-fluid w-50" />
    </div>
				<div class="card-body">
				<div class='row'>
					<div class='col-8'><i class="fa fa-table"></i> <span><?php echo e(trans('messages.createddate')); ?> : <?php echo e(\Carbon\Carbon::parse($talimat->created_at)->format('d-m-Y H:i')); ?> / <?php echo e(trans('messages.updateddate')); ?> : <?php echo e(\Carbon\Carbon::parse($talimat->updated_at)->format('d-m-Y H:i')); ?></span></div>

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
                        <span style="font-size:2em;"><?php echo e($talimat->autoBarcode); ?></span>
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
                      <tr>
                        <td colspan="2">
                          <h3><?php echo e(trans("messages.aciklama")); ?></h3>
                          <div><?php echo e($talimat->note); ?></div>
                        </td>
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
                     </td>

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
                 </table>

             </div>

             <div class='col-sm-12' id="gumrukbilgi">
               <h5><?php echo e(trans("messages.gumrukbilgileri")); ?></h5>

                  <?php if(!empty($talimat->altmodel)): ?>
                        <?php $__currentLoopData = $talimat->altmodel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $altkey=>$altvalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                       <?php echo e(trans("messages.".$altvalue->talimatTipi)); ?>

                       	<div class="col-sm-12 my-2 py-2">
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

                              </tr>
                            </tbody>
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

                              </tr>
                            </tbody>
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

                            </tbody>
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

                          </tbody>
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

                          </tbody>
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

                          </tbody>
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

                          </tbody>
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

                          </tbody>
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

                          </tbody>
                          </table>
                          <?php break; ?>
                          <?php case ("bondeshortie"): ?>
                          <table class="table table-bordered" cellspacing="0">
                          <thead>
                    </thead>
                          <tbody>
                          </tbody>
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

                              </tbody>
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

                            </tbody>
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

                            </tbody>
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


                            </tbody>
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


                            </tbody>
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

                            </tbody>
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

                            </tbody>
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

                            </tbody>
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

                            </tbody>
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

                            </tbody>
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

                            </tbody>
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

                                  </tr>
                              </thead>
                            </thead>
                            <tbody>
                              <td><?php echo e($altvalue->gumrukno+1); ?></td><td><?php echo e($altvalue->gumrukSira); ?></td>
                              <td><?php echo e($altvalue->plaka); ?></td>
                              <td><?php echo e($ulke[$altvalue->yuklemeNoktasiulkekodu]); ?></td>
                              <td><?php echo e($altvalue->dorse); ?></td>
                              <td><?php echo e($ulke[$altvalue->indirmeNoktasiulkekodu]); ?></td>

                            </tbody>
                          </table>
                          <?php break; ?>;
                          <?php case ("ihracatE12"): ?>
                          <table class="table table-bordered" cellspacing="0">
                              <thead>
                                  <tr>
                                  <th><?php echo e(trans("messages.gumrukno")); ?></th><th><?php echo e(trans("messages.sirano")); ?></th>
                                  <th><?php echo e(trans("messages.dorseplaka")); ?> </th>
                                  <th><?php echo e(trans("messages.dorseplaka")); ?> <?php echo e(trans("messages.ulkekodu")); ?></th>

                                  </tr>
                              </thead>
                            </thead>
                            <tbody>
                              <td><?php echo e($altvalue->gumrukno+1); ?></td><td><?php echo e($altvalue->gumrukSira); ?></td>
                              <td><?php echo e($altvalue->dorse); ?></td>
                              <td><?php echo e($ulke[$altvalue->indirmeNoktasiulkekodu]); ?></td>

                            </tbody>
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

                                  </tr>
                              </thead>
                            </thead>
                            <tbody>
                              <td><?php echo e($altvalue->gumrukno+1); ?></td><td><?php echo e($altvalue->gumrukSira); ?></td>
                              <td><?php echo e($altvalue->plaka); ?></td>
                              <td><?php echo e($ulke[$altvalue->yuklemeNoktasiulkekodu]); ?></td>
                              <td><?php echo e($altvalue->dorse); ?></td>
                              <td><?php echo e($ulke[$altvalue->indirmeNoktasiulkekodu]); ?></td>

                            </tbody>
                          </table>
                          <?php break; ?>;

                          <?php endswitch; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </div>
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


               </div>


             </div>



             </div>
             <div class="col-md-12 border p-2">
             <div class="form-group col-md-4 temizlenebilir">

             </div>
             </div>

				</div>
 				</div>
			 </div>

</div>
</div>
</div>
</div>
</body>
</html>
