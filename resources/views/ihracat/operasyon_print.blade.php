
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
					<div class='col-8'><i class="fa fa-table"></i> <span>{{trans('messages.createddate')}} : {{\Carbon\Carbon::parse($talimat->created_at)->format('d-m-Y H:i')}} / {{trans('messages.updateddate')}} : {{\Carbon\Carbon::parse($talimat->updated_at)->format('d-m-Y H:i')}}</span></div>

          <div class='col-sm-6'>
               <h5>{{trans("messages.talimatverenkullanici")}}</h5>
                    <table class="table table-bordered" cellspacing="0" >
                    <tr>
                      <td><strong>{{trans("messages.companyname")}}</strong></td>
                      <td>{{$talimat->user->name}}</td>
                    </tr>
                    <tr>
                      <td><strong>{{trans("messages.autoBarcode")}}</strong></td>
                      <td>
                        <span style="font-size:2em;">{{$talimat->autoBarcode}}</span>
                        <div>
                          {!!$barcode!!}
                        </div>
                      </td>

                    </tr>


                    <tr>
                        <td><strong>{{trans("messages.loginmail")}}</strong></td>
                        <td>{{$talimat->user->email}}</td>
                      </tr>
                      <tr>
                        <td><strong>{{trans("messages.firmavergi")}} / {{trans("messages.firmavergidaire")}}</strong></td>
                        <td>{{$talimat->user->vergiDairesi}}</td>
                      </tr>
                        <tr>
                        <td><strong>{{trans("messages.firmatelefon")}}</strong> </td>
                        <td>{{$talimat->user->telefonNo}}</td>
                      </tr>
                        <tr>
                        <td><strong>{{trans("messages.firmaadres")}}</strong></td>
                        <td>{{$talimat->user->address}}</td>
                      </tr>
                      <tr>
                          <td colspan="2"><hr /></td>
                      </tr>
                      <tr>
                       <td><strong>{{trans("messages.ozelplaka")}}</strong></td>
                       <td>{{$talimat->plaka}}</td>
                      </tr>
                      <tr>
                       <td><strong>{{trans("messages.sertifikano")}}</strong></td>
                       <td>{{$talimat->sertifikano}}</td>
                      </tr>
                      <tr>
                        <td colspan="2">
                          <h3>{{trans("messages.aciklama")}}</h3>
                          <div>{{$talimat->note}}</div>
                        </td>
                      </tr>
                    </table>
             </div>
             <div class='col-sm-6'>
                <h5>{{trans("messages.talimatbilgileri")}}</h5>
                  <table class="table table-bordered" cellspacing="0">
                   <tr>
                     <td><strong>{{trans("messages.createddate")}}</strong></td>
                     <td>{{\Carbon\Carbon::parse($talimat->created_at)->format('d-m-Y H:i')}}</td>
                    </tr>

                    <tr>
                     <td><strong>{{trans("messages.cekiciplaka")}}</strong></td>
                     <td>{{$talimat->cekiciPlaka}}</td>
                    </tr>
                    <tr>
                     <td><strong>{{trans("messages.dorseplaka")}}</strong></td>
                     <td>{{$talimat->dorsePlaka}}</td>
                    </tr>
                   <tr>
                     <td><strong>{{trans("messages.gumrukadet")}}</strong></td>
                     <td>{{$talimat->gumrukAdedi}}</td>
                   </tr>
                   <tr>
                     <td><strong>{{trans("messages.kayitilgilenen")}}</strong></td>
                     <td>
                        {{$talimat->ilgili->name}} {{$talimat->ilgili->email}}</td>
                   </tr>
                   <tr>
                      <td><strong>{{trans("messages.islemilgilenen")}}</strong></td>
                      <td>@if (!empty($talimat->ilgilikayit->name)) {{$talimat->ilgilikayit->name}} @endif</td>

                   </tr>
                   <tr>
                     <td><strong>{{trans("messages.muhasebedurumu")}}</strong></td>
                    <td>@if (!empty($fatura)) {{trans("messages.fatura".$fatura->faturadurumu)}} @endif</td>
                   </tr>
                   <tr>
                     <td><strong>{{trans("messages.talimatdurumu")}}</strong></td>
                     <td>
                     <span style='color:red'>
                       @if ($talimat->t2beklemedurumu=='yes')
                         @if (\Auth::user()->id==$talimat->ilgilikayit->id || \Auth::user()->role=="admin")
                            {{trans("messages.t2")}} {{trans("messages.bekliyor")}}
                         @endif
                         <br />
                         <a href="/operation/sendt2/{{$talimat->id}}" class="btn btn-danger">  {{trans("messages.t2")}} {{trans("messages.makeit")}}</a>

                       @else
                        {{trans("messages.".$talimat->durum)}}
                       @endif
                     </span>
                     </td>

                   </tr>
                   <tr>
                     <td><strong>{{trans("messages.pozisyonNo")}}</strong></td>
                     <td>{{$talimat->pozisyonNo}}</td>
                   </tr>
                   <tr>
                     <td><strong>{{trans("messages.teminatTipi")}}</strong></td>
                     <td>{{trans("messages.".$talimat->teminatTipi)}}</td>
                   </tr>
                   <tr>
                     <td><strong>{{trans("messages.tasimaTipi")}}</strong></td>
                     <td>{{trans("messages.".$talimat->tasimaTipi)}}</td>
                   </tr>
                 </table>

             </div>

             <div class='col-sm-12' id="gumrukbilgi">
               <h5>{{trans("messages.gumrukbilgileri")}}</h5>

                  @if (!empty($talimat->altmodel))
                        @foreach($talimat->altmodel as $altkey=>$altvalue)
                       {{trans("messages.".$altvalue->talimatTipi)}}
                       	<div class="col-sm-12 my-2 py-2">
                          @switch($altvalue->talimatTipi)
                            @case("ex1")
                            <table class="table table-bordered" cellspacing="0">
                            <thead>
                              <th>{{trans("messages.gumrukno")}}</th><th>{{trans("messages.sirano")}}</th>
                              <th>{{trans("messages.varisgumruk")}}</th>
                              <th>{{trans("messages.gonderici")}}</th>
                              <th>{{trans("messages.ulkekodu")}}</th>
                              <th>{{trans("messages.alici")}}</th>
                              <th>{{trans("messages.ulkekodu")}}</th>
                              <th>{{trans("messages.kap")}}</th>
                              <th>{{trans("messages.kilo")}}</th>
                              <th>{{trans("messages.yukcinsi")}}</th>
                              <th>{{trans("messages.faturanumara")}}</th>
                              <th>{{trans("messages.faturabedeli")}}</th>

                        </thead>
                            <tbody>
                              <tr>
                                <td>{{$altvalue->gumrukno+1}}</td>
                                <td>{{$altvalue->gumrukSira}}</td>
                                <td style="color:#{{substr(md5($altvalue->varisGumruk),0,6)}};font-weight:bold;" >{{$altvalue->varisGumruk}}</td>
                                <td>{{$altvalue->yuklemeNoktasi}}</td>
                                <td>{{$ulke[$altvalue->yuklemeNoktasiulkekodu]}}</td>
                                <td>{{$altvalue->indirmeNoktasi}}</td>
                                <td>{{$ulke[$altvalue->indirmeNoktasiulkekodu]}}</td>
                                <td>{{$altvalue->tekKap}}</td>
                                <td>{{$altvalue->tekKilo}}</td>
                                <td>{{$altvalue->yukcinsi}}</td>
                                <td>{{$altvalue->faturanumara}}</td>
                                <td>{{$altvalue->faturabedeli}}</td>

                              </tr>
                            </tbody>
                          </table>
                          @break
                          @case("t2")
                            <table class="table table-bordered" cellspacing="0">
                            <thead>
                              <th>{{trans("messages.gumrukno")}}</th>
                              <th>{{trans("messages.sirano")}}</th>
                              <th>{{trans("messages.mrnnumber")}}</th>
                              <th>{{trans("messages.varisgumruk")}}</th>
                              <th>{{trans("messages.gonderici")}}</th>
                              <th>{{trans("messages.ulkekodu")}}</th>
                              <th>{{trans("messages.alici")}}</th>
                              <th>{{trans("messages.ulkekodu")}}</th>
                              <th>{{trans("messages.kap")}}</th>
                              <th>{{trans("messages.kilo")}}</th>

                              <th>{{trans("messages.yukcinsi")}}</th>

                              <th>{{trans("messages.faturanumara")}}</th>
                              <th>{{trans("messages.faturabedeli")}}</th>

                            </thead>
                            <tbody>
                              <tr>
                                <td>{{$altvalue->gumrukno+1}}</td>
                                <td>{{$altvalue->gumrukSira}}</td>
                                <td>{{$altvalue->mrnnumber}}</td>
                                <td style="color:#{{substr(md5($altvalue->varisGumruk),0,6)}};font-weight:bold;" >{{$altvalue->varisGumruk}}</td>
                                <td>{{$altvalue->yuklemeNoktasi}}</td>
                                <td>{{$ulke[$altvalue->yuklemeNoktasiulkekodu]}}</td>
                                <td>{{$altvalue->indirmeNoktasi}}</td>
                                <td>{{$ulke[$altvalue->indirmeNoktasiulkekodu]}}</td>
                                <td>{{$altvalue->tekKap}}</td>
                                <td>{{$altvalue->tekKilo}}</td>
                                <td>{{$altvalue->yukcinsi}}</td>
                                <td>{{$altvalue->faturanumara}}</td>
                                <td>{{$altvalue->faturabedeli}}</td>

                              </tr>
                            </tbody>
                            </table>
                          @break
                          @case("t1")
                            <table class="table table-bordered" cellspacing="0">
                            <thead>
                              <th>{{trans("messages.gumrukno")}}</th><th>{{trans("messages.sirano")}}</th>
                              <th>{{trans("messages.mrnnumber")}}</th>
                              <th>{{trans("messages.varisgumruk")}}</th>
                              <th>{{trans("messages.gonderici")}}</th>
                              <th>{{trans("messages.ulkekodu")}}</th>
                              <th>{{trans("messages.alici")}}</th>
                              <th>{{trans("messages.ulkekodu")}}</th>
                              <th>{{trans("messages.kap")}}</th>
                              <th>{{trans("messages.kilo")}}</th>

                              <th>{{trans("messages.yukcinsi")}}</th>

                              <th>{{trans("messages.faturanumara")}}</th>
                              <th>{{trans("messages.faturabedeli")}}</th>
                    </thead>
                            <tbody>
                              <td>{{$altvalue->gumrukno+1}}</td><td>{{$altvalue->gumrukSira}}</td>
                              <td>{{$altvalue->mrnnumber}}</td>
                              <td style="color:#{{substr(md5($altvalue->varisGumruk),0,6)}};font-weight:bold;" >{{$altvalue->varisGumruk}}</td>
                              <td>{{$altvalue->yuklemeNoktasi}}</td>
                              <td>{{$ulke[$altvalue->yuklemeNoktasiulkekodu]}}</td>
                              <td>{{$altvalue->indirmeNoktasi}}</td>
                              <td>{{$ulke[$altvalue->indirmeNoktasiulkekodu]}}</td>
                              <td>{{$altvalue->tekKap}}</td>
                              <td>{{$altvalue->tekKilo}}</td>
                              <td>{{$altvalue->yukcinsi}}</td>
                              <td>{{$altvalue->faturanumara}}</td>
                              <td>{{$altvalue->faturabedeli}}</td>

                            </tbody>
                            </table>
                          @break
                          @case("passage")
                          <table class="table table-bordered" cellspacing="0">
                          <thead>
                            <th>{{trans("messages.gumrukno")}}</th><th>{{trans("messages.sirano")}}</th>
                            <th>{{trans("messages.tirnumarasi")}}</th>
                            <th>{{trans("messages.gonderici")}}</th>
                            <th>{{trans("messages.ulkekodu")}}</th>
                            <th>{{trans("messages.kap")}}</th>
                            <th>{{trans("messages.kilo")}}</th>
                            <th>{{trans("messages.faturacinsi")}}</th>
                            <th>{{trans("messages.faturanumara")}}</th>
                            <th>{{trans("messages.faturabedeli")}}</th>

                  </thead>
                          <tbody>
                            <td>{{$altvalue->gumrukno+1}}</td><td>{{$altvalue->gumrukSira}}</td>
                            <td>{{$altvalue->tirnumarasi}}</td>
                            <td>{{$altvalue->yuklemeNoktasi}}</td>
                            <td>{{$ulke[$altvalue->yuklemeNoktasiulkekodu]}}</td>
                            <td>{{$altvalue->tekKap}}</td>
                            <td>{{$altvalue->tekKilo}}</td>
                            <td>{{$altvalue->yukcinsi}}</td>
                            <td>{{$altvalue->faturanumara}}</td>
                            <td>{{$altvalue->faturabedeli}}</td>

                          </tbody>
                          </table>
                          @break
                          @case("t1kapama")
                          <table class="table table-bordered" cellspacing="0">
                          <thead>
                            <th>{{trans("messages.gumrukno")}}</th><th>{{trans("messages.sirano")}}</th>
                            <th>{{trans("messages.baslangicgumruk")}}</th>

                            <th>{{trans("messages.gonderici")}}</th>
                            <th>{{trans("messages.ulkekodu")}}</th>
                            <th>{{trans("messages.varisgumruk")}}</th>
                            <th>{{trans("messages.alici")}}</th>
                            <th>{{trans("messages.ulkekodu")}}</th>
                            <th>{{trans("messages.kap")}}</th>
                            <th>{{trans("messages.kilo")}}</th>

                            <th>{{trans("messages.yukcinsi")}}</th>
                            <th>{{trans("messages.faturacinsi")}}</th>
                            <th>{{trans("messages.faturanumara")}}</th>
                            <th>{{trans("messages.faturabedeli")}}</th>

                    </thead>
                          <tbody>
                            <td>{{$altvalue->gumrukno+1}}</td><td>{{$altvalue->gumrukSira}}</td>
                            <td>{{$altvalue->baslangicGumruk}}</td>

                            <td>{{$altvalue->yuklemeNoktasi}}</td>
                            <td>{{$ulke[$altvalue->yuklemeNoktasiulkekodu]}}</td>
                            <td style="color:#{{substr(md5($altvalue->varisGumruk),0,6)}};font-weight:bold;" >{{$altvalue->varisGumruk}}</td>
                            <td>{{$altvalue->indirmeNoktasi}}</td>
                            <td>{{$ulke[$altvalue->indirmeNoktasiulkekodu]}}</td>
                            <td>{{$altvalue->tekKap}}</td>
                            <td>{{$altvalue->tekKilo}}</td>
                            <td>{{$altvalue->yukcinsi}}</td>
                            <td>{{$altvalue->faturanumara}}</td>
                            <td>{{$altvalue->faturabedeli}}</td>

                          </tbody>
                          </table>
                          @break
                          @case("tir")
                          <table class="table table-bordered" cellspacing="0">
                          <thead>
                              <th>{{trans("messages.gumrukno")}}</th><th>{{trans("messages.sirano")}}</th>
                              <th>{{trans("messages.tirnumarasi")}}</th>
                              <th>{{trans("messages.gonderici")}}</th>
                              <th>{{trans("messages.ulkekodu")}}</th>
                              <th>{{trans("messages.kap")}}</th>
                              <th>{{trans("messages.kilo")}}</th>

                              <th>{{trans("messages.faturacinsi")}}</th>
                              <th>{{trans("messages.faturanumara")}}</th>
                              <th>{{trans("messages.faturabedeli")}}</th>
                      </thead>
                          <tbody>
                            <td>{{$altvalue->gumrukno+1}}</td><td>{{$altvalue->gumrukSira}}</td>
                            <td>{{$altvalue->tirnumarasi}}</td>
                            <td>{{$altvalue->yuklemeNoktasi}}</td>
                            <td>{{$ulke[$altvalue->yuklemeNoktasiulkekodu]}}</td>
                            <td>{{$altvalue->tekKap}}</td>
                            <td>{{$altvalue->tekKilo}}</td>
                            <td>{{$altvalue->yukcinsi}}</td>
                            <td>{{$altvalue->faturanumara}}</td>
                            <td>{{$altvalue->faturabedeli}}</td>

                          </tbody>
                          </table>
                          @break
                          @case("ata")
                          <table class="table table-bordered" cellspacing="0">
                          <thead>
                            <th>{{trans("messages.gumrukno")}}</th><th>{{trans("messages.sirano")}}</th>
                            <th>{{trans("messages.tirnumarasi")}}</th>
                            <th>{{trans("messages.gonderici")}}</th>
                            <th>{{trans("messages.ulkekodu")}}</th>
                            <th>{{trans("messages.kap")}}</th>
                            <th>{{trans("messages.kilo")}}</th>

                            <th>{{trans("messages.faturacinsi")}}</th>
                            <th>{{trans("messages.faturanumara")}}</th>
                            <th>{{trans("messages.faturabedeli")}}</th>
          </thead>
                          <tbody>
                            <td>{{$altvalue->gumrukno+1}}</td><td>{{$altvalue->gumrukSira}}</td>
                            <td>{{$altvalue->tirnumarasi}}</td>
                            <td>{{$altvalue->yuklemeNoktasi}}</td>
                            <td>{{$ulke[$altvalue->yuklemeNoktasiulkekodu]}}</td>
                            <td>{{$altvalue->tekKap}}</td>
                            <td>{{$altvalue->tekKilo}}</td>
                            <td>{{$altvalue->yukcinsi}}</td>
                            <td>{{$altvalue->faturanumara}}</td>
                            <td>{{$altvalue->faturabedeli}}</td>

                          </tbody>
                          </table>
                          @break
                          @case("listex")
                          <table class="table table-bordered" cellspacing="0">
                          <thead>
                            <th>{{trans("messages.gumrukno")}}</th><th>{{trans("messages.sirano")}}</th>
                            <th>{{trans("messages.varisgumruk")}}</th>
                            <th>{{trans("messages.gonderici")}}</th>
                            <th>{{trans("messages.ulkekodu")}}</th>
                            <th>{{trans("messages.alici")}}</th>
                            <th>{{trans("messages.ulkekodu")}}</th>
                            <th>{{trans("messages.kap")}}</th>
                            <th>{{trans("messages.kilo")}}</th>

                            <th>{{trans("messages.yukcinsi")}}</th>

                            <th>{{trans("messages.faturanumara")}}</th>
                            <th>{{trans("messages.faturabedeli")}}</th>
                    </thead>
                          <tbody>
                            <td>{{$altvalue->gumrukno+1}}</td><td>{{$altvalue->gumrukSira}}</td>
                            <td style="color:#{{substr(md5($altvalue->varisGumruk),0,6)}};font-weight:bold;" >{{$altvalue->varisGumruk}}</td>
                            <td>{{$altvalue->yuklemeNoktasi}}</td>
                            <td>{{$ulke[$altvalue->yuklemeNoktasiulkekodu]}}</td>
                            <td>{{$altvalue->indirmeNoktasi}}</td>
                            <td>{{$ulke[$altvalue->indirmeNoktasiulkekodu]}}</td>
                            <td>{{$altvalue->tekKap}}</td>
                            <td>{{$altvalue->tekKilo}}</td>
                            <td>{{$altvalue->yukcinsi}}</td>
                            <td>{{$altvalue->faturanumara}}</td>
                            <td>{{$altvalue->faturabedeli}}</td>

                          </tbody>
                          </table>
                          @break
                          @case("ithalatimport")
                          <table class="table table-bordered" cellspacing="0">
                          <thead>
                            <th>{{trans("messages.gumrukno")}}</th><th>{{trans("messages.sirano")}}</th>
                            <th>{{trans("messages.varisgumruk")}}</th>
                            <th>{{trans("messages.gonderici")}}</th>
                            <th>{{trans("messages.ulkekodu")}}</th>
                            <th>{{trans("messages.alici")}}</th>
                            <th>{{trans("messages.ulkekodu")}}</th>
                            <th>{{trans("messages.kap")}}</th>
                            <th>{{trans("messages.kilo")}}</th>

                            <th>{{trans("messages.yukcinsi")}}</th>
                            <th>{{trans("messages.faturacinsi")}}</th>
                            <th>{{trans("messages.faturanumara")}}</th>
                            <th>{{trans("messages.faturabedeli")}}</th>

                          </thead>
                          <tbody>
                            <td>{{$altvalue->gumrukno+1}}</td><td>{{$altvalue->gumrukSira}}</td>
                            <td style="color:#{{substr(md5($altvalue->varisGumruk),0,6)}};font-weight:bold;" >{{$altvalue->varisGumruk}}</td>
                            <td>{{$altvalue->yuklemeNoktasi}}</td>
                            <td>{{$ulke[$altvalue->yuklemeNoktasiulkekodu]}}</td>
                            <td>{{$altvalue->indirmeNoktasi}}</td>
                            <td>{{$ulke[$altvalue->indirmeNoktasiulkekodu]}}</td>
                            <td>{{$altvalue->tekKap}} </td>
                            <td>{{$altvalue->tekKilo}}</td>
                            <td>{{$altvalue->yukcinsi}}</td>
                            <td>{{$altvalue->faturanumara}}</td>
                            <td>{{$altvalue->faturabedeli}}</td>

                          </tbody>
                          </table>
                          @break
                          @case("bondeshortie")
                          <table class="table table-bordered" cellspacing="0">
                          <thead>
                    </thead>
                          <tbody>
                          </tbody>
                          </table>
                          @break
                          @case("ext1t2")
                              <table class="table table-bordered" cellspacing="0">
                              <thead>
                                <th>{{trans("messages.varisgumruk")}}</th>
                                <th>{{trans("messages.mrnnumber")}}</th>
                                <th>{{trans("messages.gonderici")}}</th>
                                <th>{{trans("messages.ulkekodu")}}</th>
                                <th>{{trans("messages.alici")}}</th>
                                <th>{{trans("messages.ulkekodu")}}</th>
                                <th>{{trans("messages.kap")}}</th>
                                <th>{{trans("messages.kilo")}}</th>

                                <th>{{trans("messages.yukcinsi")}}</th>
                                <th>{{trans("messages.faturacinsi")}}</th>
                                <th>{{trans("messages.faturanumara")}}</th>
                                <th>{{trans("messages.faturabedeli")}}</th>

                              </thead>
                              <tbody>
                                <td>{{$altvalue->gumrukno+1}}</td><td>{{$altvalue->gumrukSira}}</td>
                                <td>{{$altvalue->mrnnumber}}</td>
                                <td style="color:#{{substr(md5($altvalue->varisGumruk),0,6)}};font-weight:bold;" >{{$altvalue->varisGumruk}}</td>
                                <td>{{$altvalue->yuklemeNoktasi}}</td>
                                <td>{{$ulke[$altvalue->yuklemeNoktasiulkekodu]}}</td>
                                <td>{{$altvalue->indirmeNoktasi}}</td>
                                <td>{{$ulke[$altvalue->indirmeNoktasiulkekodu]}}</td>
                                <td>{{$altvalue->tekKap}}</td>
                                <td>{{$altvalue->tekKilo}}</td>
                                <td>{{$altvalue->yukcinsi}}</td>
                                <td>{{$altvalue->faturanumara}}</td>
                                <td>{{$altvalue->faturabedeli}}</td>

                              </tbody>
                              </table>
                          @break
                          @case("ihracatE1")
                          <table class="table table-bordered" cellspacing="0">
                            <thead>
                            <th>{{trans("messages.gumrukno")}}</th><th>{{trans("messages.sirano")}}</th>
                              <th>{{trans("messages.tirnumarasi")}}</th>
                              <th>{{trans("messages.gonderici")}}</th>
                              <th>{{trans("messages.gonderici")}} {{trans("messages.ulkekodu")}}</th>
                              <th>{{trans("messages.kap")}}</th>
                              <th>{{trans("messages.kilo")}}</th>

                              <th>{{trans("messages.faturacinsi")}}</th>
                              <th>{{trans("messages.faturanumara")}}</th>
                              <th>{{trans("messages.faturabedeli")}}</th>

                            </thead>
                            <tbody>
                              <td>{{$altvalue->gumrukno+1}}</td><td>{{$altvalue->gumrukSira}}</td>
                              <td>{{$altvalue->tirnumarasi}}</td>
                              <td>{{$altvalue->yuklemeNoktasi}}</td>
                              <td>{{$ulke[$altvalue->yuklemeNoktasiulkekodu]}}</td>
                              <td>{{$altvalue->tekKap}}</td>
                              <td>{{$altvalue->tekKilo}}</td>
                              <td>{{$altvalue->yukcinsi}}</td>
                              <td>{{$altvalue->faturanumara}}</td>
                              <td>{{$altvalue->faturabedeli}}</td>

                            </tbody>
                          </table>
                          @break;
                          @case("ihracatE2")
                          <table class="table table-bordered" cellspacing="0">
                              <thead>
                                  <tr>
                                  <th>{{trans("messages.gumrukno")}}</th>
                                  <th>{{trans("messages.sirano")}}</th>
                                  <th>{{trans("messages.atanumarasi")}}</th>
                                  <th>{{trans("messages.gonderici")}}</th>
                                  <th>{{trans("messages.gonderici")}} {{trans("messages.ulkekodu")}}</th>
                                  <th>{{trans("messages.kap")}}</th>
                                  <th>{{trans("messages.kilo")}}</th>

                                  <th>{{trans("messages.faturacinsi")}}</th>
                                  <th>{{trans("messages.faturanumara")}}</th>

                                  </tr>
                              </thead>
                            </thead>
                            <tbody>
                                <td>{{$altvalue->gumrukno+1}}</td>
                                <td>{{$altvalue->gumrukSira}}</td>
                                <td>{{$altvalue->atanumarasi}}</td>
                                <td>{{$altvalue->yuklemeNoktasi}}</td>
                                <td>{{$ulke[$altvalue->yuklemeNoktasiulkekodu]}}</td>
                                <td>{{$altvalue->tekKap}}</td>
                                <td>{{$altvalue->tekKilo}}</td>
                                <td>{{$altvalue->yukcinsi}}</td>
                                <td>{{$altvalue->faturanumara}}</td>
                                <td>{{$altvalue->faturabedeli}}</td>

                            </tbody>
                          </table>
                          @break;
                          @case("ihracatE3")
                          <table class="table table-bordered" cellspacing="0">
                              <thead>
                                  <tr>
                                    <th>{{trans("messages.gumrukno")}}</th>
                                    <th>{{trans("messages.sirano")}}</th>

                                    <th>{{trans("messages.varisgumruk")}}</th>
                                    <th>{{trans("messages.gonderici")}}</th>
                                    <th>{{trans("messages.gonderici")}} {{trans("messages.ulkekodu")}}</th>
                                    <th>{{trans("messages.alici")}}</th>
                                    <th>{{trans("messages.alici")}} {{trans("messages.ulkekodu")}}</th>
                                    <th>{{trans("messages.kap")}}</th>
                                    <th>{{trans("messages.kilo")}}</th>

                                    <th>{{trans("messages.yukcinsi")}}</th>
                                    <th>{{trans("messages.faturacinsi")}}</th>
                                    <th>{{trans("messages.faturanumara")}}</th>
                                    <th>{{trans("messages.faturabedeli")}}</th>

                                  </tr>
                              </thead>
                            </thead>
                            <tbody>
                                <td>{{$altvalue->gumrukno+1}}</td><td>{{$altvalue->gumrukSira}}</td>

                                <td style="color:#{{substr(md5($altvalue->varisGumruk),0,6)}};font-weight:bold;" >{{$altvalue->varisGumruk}}</td>
                                <td>{{$altvalue->yuklemeNoktasi}}</td>
                                <td>{{$ulke[$altvalue->yuklemeNoktasiulkekodu]}}</td>
                                <td>{{$altvalue->indirmeNoktasi}}</td>
                                <td>{{$ulke[$altvalue->indirmeNoktasiulkekodu]}}</td>
                                <td>{{$altvalue->tekKap}}</td>
                                <td>{{$altvalue->tekKilo}}</td>

                                <td>{{$altvalue->yukcinsi}}</td>
                                <td>{{$altvalue->faturacinsi}}</td>
                                <td>{{$altvalue->faturanumara}}</td>
                                <td>{{$altvalue->faturabedeli}}</td>


                            </tbody>
                          </table>
                          @break;
                          @case("ihracatE4")
                          <table class="table table-bordered" cellspacing="0">
                              <thead>
                                  <tr>
                                      <th>{{trans("messages.gumrukno")}}</th><th>{{trans("messages.sirano")}}</th>
                                      <th style="width:12%">{{trans("messages.mrnnumber")}}</th>
                                      <th style="width:10%">{{trans("messages.varisgumruk")}}</th>
                                      <th style="width:15%">{{trans("messages.gonderici")}}</th>
                                      <th  style="width:5%">{{trans("messages.gonderici")}} {{trans("messages.ulkekodu")}}</th>
                                      <th style="width:15%">{{trans("messages.alici")}}</th>
                                      <th style="width:5%">{{trans("messages.alici")}} {{trans("messages.ulkekodu")}}</th>
                                      <th style="width:7%">{{trans("messages.kap")}}</th>
                                      <th style="width:7%">{{trans("messages.kilo")}}</th>

                                      <th  style="width:5%">{{trans("messages.yukcinsi")}}</th>

                                      <th>{{trans("messages.faturanumara")}}</th>
                                      <th>{{trans("messages.faturabedeli")}}</th>

                                  </tr>
                              </thead>
                            </thead>
                            <tbody>
                              <td>{{$altvalue->gumrukno+1}}</td><td>{{$altvalue->gumrukSira}}</td>
                              <td>{{$altvalue->mrnnumber}}</td>
                              <td style="color:#{{substr(md5($altvalue->varisGumruk),0,6)}};font-weight:bold;" >{{$altvalue->varisGumruk}}</td>
                              <td>{{$altvalue->yuklemeNoktasi}}</td>
                              <td>{{$ulke[$altvalue->yuklemeNoktasiulkekodu]}}</td>
                              <td>{{$altvalue->indirmeNoktasi}}</td>
                              <td>{{$ulke[$altvalue->indirmeNoktasiulkekodu]}}</td>
                              <td>{{$altvalue->tekKap}}</td>
                              <td>{{$altvalue->tekKilo}}</td>
                              <td>{{$altvalue->yukcinsi}}</td>
                              <td>{{$altvalue->faturanumara}}</td>
                              <td>{{$altvalue->faturabedeli}}</td>


                            </tbody>
                          </table>
                          @break;
                          @case("ihracatE5")
                          <table class="table table-bordered" cellspacing="0">
                              <thead>
                                  <tr>
                                  <th>{{trans("messages.gumrukno")}}</th><th>{{trans("messages.sirano")}}</th>
                                  <th>{{trans("messages.varisgumruk")}}</th>
                                  <th>{{trans("messages.gonderici")}}</th>
                                  <th>{{trans("messages.gonderici")}} {{trans("messages.ulkekodu")}}</th>
                                  <th>{{trans("messages.alici")}}</th>
                                  <th>{{trans("messages.alici")}} {{trans("messages.ulkekodu")}}</th>
                                  <th>{{trans("messages.kap")}}</th>
                                  <th>{{trans("messages.kilo")}}</th>

                                  <th>{{trans("messages.yukcinsi")}}</th>
                                  <th>{{trans("messages.faturacinsi")}}</th>
                                  <th>{{trans("messages.faturanumara")}}</th>
                                  <th>{{trans("messages.faturabedeli")}}</th>

                                  </tr>
                              </thead>
                            </thead>
                            <tbody>
                                      <td>{{$altvalue->gumrukno+1}}</td><td>{{$altvalue->gumrukSira}}</td>

                                      <td style="color:#{{substr(md5($altvalue->varisGumruk),0,6)}};font-weight:bold;" >{{$altvalue->varisGumruk}}</td>
                                      <td>{{$altvalue->yuklemeNoktasi}}</td>
                                      <td>{{$ulke[$altvalue->yuklemeNoktasiulkekodu]}}</td>
                                      <td>{{$altvalue->indirmeNoktasi}}</td>
                                      <td>{{$ulke[$altvalue->indirmeNoktasiulkekodu]}}</td>
                                      <td>{{$altvalue->tekKap}}</td>
                                      <td>{{$altvalue->tekKilo}}</td>
                                      <td>{{$altvalue->yukcinsi}}</td>
                                      <td>{{$altvalue->faturanumara}}</td>
                                      <td>{{$altvalue->faturabedeli}}</td>

                            </tbody>
                          </table>
                          @break;
                          @case("ihracatE6")
                          <table class="table table-bordered" cellspacing="0">
                              <thead>
                                  <tr>
                                  <th>{{trans("messages.gumrukno")}}</th><th>{{trans("messages.sirano")}}</th>
                                  <th style="width:12%">{{trans("messages.mrnnumber")}}</th>
                                  <th style="width:10%">{{trans("messages.varisgumruk")}}</th>
                                  <th style="width:15%">{{trans("messages.gonderici")}}</th>
                                  <th  style="width:5%">{{trans("messages.gonderici")}} {{trans("messages.ulkekodu")}}</th>
                                  <th style="width:15%">{{trans("messages.alici")}}</th>
                                  <th style="width:5%">{{trans("messages.alici")}} {{trans("messages.ulkekodu")}}</th>
                                  <th style="width:7%">{{trans("messages.kap")}}</th>
                                  <th style="width:7%">{{trans("messages.kilo")}}</th>

                                  <th  style="width:5%">{{trans("messages.yukcinsi")}}</th>

                                  <th>{{trans("messages.faturanumara")}}</th>
                                  <th>{{trans("messages.faturabedeli")}}</th>

                              </thead>
                            </thead>
                            <tbody>
                                      <td>{{$altvalue->gumrukno+1}}</td><td>{{$altvalue->gumrukSira}}</td>
                                      <td>{{$altvalue->mrnnumber}}</td>
                                      <td style="color:#{{substr(md5($altvalue->varisGumruk),0,6)}};font-weight:bold;" >{{$altvalue->varisGumruk}}</td>
                                      <td>{{$altvalue->yuklemeNoktasi}}</td>
                                      <td>{{$ulke[$altvalue->yuklemeNoktasiulkekodu]}}</td>
                                      <td>{{$altvalue->indirmeNoktasi}}</td>
                                      <td>{{$ulke[$altvalue->indirmeNoktasiulkekodu]}}</td>
                                      <td>{{$altvalue->tekKap}}</td>
                                      <td>{{$altvalue->tekKilo}}</td>
                                      <td>{{$altvalue->yukcinsi}}</td>
                                      <td>{{$altvalue->faturanumara}}</td>
                                      <td>{{$altvalue->faturabedeli}}</td>

                            </tbody>
                          </table>
                          @break;
                          @case("ihracatE7")
                          <table class="table table-bordered" cellspacing="0">
                              <thead>
                              <tr>
                                  <th>{{trans("messages.gumrukno")}}</th><th>{{trans("messages.sirano")}}</th>
                                  <th>{{trans("messages.tirnumarasi")}}</th>
                                  <th>{{trans("messages.gonderici")}}</th>
                                  <th>{{trans("messages.gonderici")}} {{trans("messages.ulkekodu")}}</th>
                                  <th>{{trans("messages.kap")}}</th>
                                  <th>{{trans("messages.kilo")}}</th>

                                  <th>{{trans("messages.faturacinsi")}}</th>
                                  <th>{{trans("messages.faturanumara")}}</th>
                                  <th>{{trans("messages.faturabedeli")}}</th>

                                </tr>
                              </thead>
                            </thead>
                            <tbody>
                            <td>{{$altvalue->gumrukno+1}}</td><td>{{$altvalue->gumrukSira}}</td>
                            <td>{{$altvalue->tirnumarasi}}</td>
                            <td style="color:#{{substr(md5($altvalue->varisGumruk),0,6)}};font-weight:bold;" >{{$altvalue->varisGumruk}}</td>
                            <td>{{$altvalue->yuklemeNoktasi}}</td>
                            <td>{{$ulke[$altvalue->yuklemeNoktasiulkekodu]}}</td>

                            <td>{{$altvalue->tekKap}}</td>
                            <td>{{$altvalue->tekKilo}}</td>
                            <td>{{$altvalue->yukcinsi}}</td>
                            <td>{{$altvalue->faturanumara}}</td>
                            <td>{{$altvalue->faturabedeli}}</td>

                            </tbody>
                          </table>
                          @break;
                          @case("ihracatE8")
                          <table class="table table-bordered" cellspacing="0">
                              <thead>
                                  <tr>
                                <th>{{trans("messages.gumrukno")}}</th><th>{{trans("messages.sirano")}}</th>
                                <th>{{trans("messages.atanumarasi")}}</th>
                                <th>{{trans("messages.gonderici")}}</th>
                                <th>{{trans("messages.gonderici")}} {{trans("messages.ulkekodu")}}</th>
                                <th>{{trans("messages.kap")}}</th>
                                <th>{{trans("messages.kilo")}}</th>

                                <th>{{trans("messages.faturacinsi")}}</th>
                                <th>{{trans("messages.faturanumara")}}</th>
                                <th>{{trans("messages.faturabedeli")}}</th>

                                  </tr>
                              </thead>
                            </thead>
                            <tbody>
                                      <td>{{$altvalue->gumrukno+1}}</td><td>{{$altvalue->gumrukSira}}</td>
                                      <td>{{$altvalue->atanumarasi}}</td>

                                      <td>{{$altvalue->yuklemeNoktasi}}</td>
                                      <td>{{$ulke[$altvalue->yuklemeNoktasiulkekodu]}}</td>

                                      <td>{{$altvalue->tekKap}}</td>
                                      <td>{{$altvalue->tekKilo}}</td>
                                      <td>{{$altvalue->yukcinsi}}</td>
                                      <td>{{$altvalue->faturanumara}}</td>
                                      <td>{{$altvalue->faturabedeli}}</td>

                            </tbody>
                          </table>
                          @break;
                          @case("ihracatE9")
                          <table class="table table-bordered" cellspacing="0">
                              <thead>
                                  <tr>
                                  <th>{{trans("messages.gumrukno")}}</th><th>{{trans("messages.sirano")}}</th>
                                  <th>{{trans("messages.baslangicgumruk")}}</th>

                                  <th>{{trans("messages.gonderici")}}</th>
                                  <th>{{trans("messages.gonderici")}} {{trans("messages.ulkekodu")}}</th>
                                  <th>{{trans("messages.varisgumruk")}}</th>
                                  <th>{{trans("messages.alici")}}</th>
                                  <th>{{trans("messages.alici")}} {{trans("messages.ulkekodu")}}</th>
                                  <th>{{trans("messages.kap")}}</th>
                                  <th>{{trans("messages.kilo")}}</th>

                                  <th>{{trans("messages.yukcinsi")}}</th>
                                  <th>{{trans("messages.faturacinsi")}}</th>
                                  <th>{{trans("messages.faturanumara")}}</th>
                                  <th>{{trans("messages.faturabedeli")}}</th>

                                  </tr>
                              </thead>
                            </thead>
                            <tbody>
                            <td>{{$altvalue->gumrukno+1}}</td><td>{{$altvalue->gumrukSira}}</td>

                            <td>{{$altvalue->baslangicGumruk}}</td>
                            <td>{{$altvalue->yuklemeNoktasi}}</td>
                            <td>{{$ulke[$altvalue->yuklemeNoktasiulkekodu]}}</td>
                            <td style="color:#{{substr(md5($altvalue->varisGumruk),0,6)}};font-weight:bold;" >{{$altvalue->varisGumruk}}</td>
                            <td>{{$altvalue->indirmeNoktasi}}</td>
                            <td>{{$ulke[$altvalue->indirmeNoktasiulkekodu]}}</td>
                            <td>{{$altvalue->tekKap}}</td>
                            <td>{{$altvalue->tekKilo}}</td>
                            <td>{{$altvalue->yukcinsi}}</td>
                            <td>{{$altvalue->faturanumara}}</td>
                            <td>{{$altvalue->faturabedeli}}</td>

                            </tbody>
                          </table>
                          @break;
                          @case("ihracatE10")
                          <table class="table table-bordered" cellspacing="0">
                              <thead>
                                  <tr>
                                  <th>{{trans("messages.gumrukno")}}</th><th>{{trans("messages.sirano")}}</th>
                                  <th>{{trans("messages.baslangicgumruk")}}</th>
                                  <th style="width:12%">{{trans("messages.mrnnumber")}}</th>
                                  <th>{{trans("messages.tirnumarasi")}}</th>

                                  <th>{{trans("messages.gonderici")}}</th>
                                  <th>{{trans("messages.gonderici")}} {{trans("messages.ulkekodu")}}</th>
                                  <th>{{trans("messages.varisgumruk")}}</th>
                                  <th>{{trans("messages.alici")}}</th>
                                  <th>{{trans("messages.alici")}} {{trans("messages.ulkekodu")}}</th>
                                  <th>{{trans("messages.kap")}}</th>
                                  <th>{{trans("messages.kilo")}}</th>

                                  <th>{{trans("messages.yukcinsi")}}</th>
                                  <th>{{trans("messages.faturacinsi")}}</th>
                                  <th>{{trans("messages.faturanumara")}}</th>
                                  <th>{{trans("messages.faturabedeli")}}</th>

                                  </tr>
                              </thead>
                            </thead>
                            <tbody>
                              <td>{{$altvalue->gumrukno+1}}</td><td>{{$altvalue->gumrukSira}}</td>
                              <td>{{$altvalue->baslangicGumruk}}</td>
                              <td>{{$altvalue->mrnnumber}}</td>
                              <td>{{$altvalue->tirnumarasi}}</td>
                              <td>{{$altvalue->yuklemeNoktasi}}</td>
                              <td>{{$ulke[$altvalue->yuklemeNoktasiulkekodu]}}</td>
                              <td style="color:#{{substr(md5($altvalue->varisGumruk),0,6)}};font-weight:bold;" >{{$altvalue->varisGumruk}}</td>
                              <td>{{$altvalue->indirmeNoktasi}}</td>
                              <td>{{$ulke[$altvalue->indirmeNoktasiulkekodu]}}</td>
                              <td>{{$altvalue->tekKap}}</td>
                              <td>{{$altvalue->tekKilo}}</td>
                              <td>{{$altvalue->yukcinsi}}</td>
                              <td>{{$altvalue->faturanumara}}</td>
                              <td>{{$altvalue->faturabedeli}}</td>

                            </tbody>
                          </table>
                          @break;
                          @case("ihracatE11")
                          <table class="table table-bordered" cellspacing="0">
                              <thead>
                                  <tr>
                                  <th>{{trans("messages.gumrukno")}}</th><th>{{trans("messages.sirano")}}</th>
                                  <th>{{trans("messages.plaka")}} </th>
                                  <th>{{trans("messages.plaka")}} {{trans("messages.ulkekodu")}}</th>
                                  <th>{{trans("messages.dorseplaka")}} </th>
                                  <th>{{trans("messages.dorseplaka")}} {{trans("messages.ulkekodu")}}</th>

                                  </tr>
                              </thead>
                            </thead>
                            <tbody>
                              <td>{{$altvalue->gumrukno+1}}</td><td>{{$altvalue->gumrukSira}}</td>
                              <td>{{$altvalue->plaka}}</td>
                              <td>{{$ulke[$altvalue->yuklemeNoktasiulkekodu]}}</td>
                              <td>{{$altvalue->dorse}}</td>
                              <td>{{$ulke[$altvalue->indirmeNoktasiulkekodu]}}</td>

                            </tbody>
                          </table>
                          @break;
                          @case("ihracatE12")
                          <table class="table table-bordered" cellspacing="0">
                              <thead>
                                  <tr>
                                  <th>{{trans("messages.gumrukno")}}</th><th>{{trans("messages.sirano")}}</th>
                                  <th>{{trans("messages.dorseplaka")}} </th>
                                  <th>{{trans("messages.dorseplaka")}} {{trans("messages.ulkekodu")}}</th>

                                  </tr>
                              </thead>
                            </thead>
                            <tbody>
                              <td>{{$altvalue->gumrukno+1}}</td><td>{{$altvalue->gumrukSira}}</td>
                              <td>{{$altvalue->dorse}}</td>
                              <td>{{$ulke[$altvalue->indirmeNoktasiulkekodu]}}</td>

                            </tbody>
                          </table>
                          @break;
                          @case("ihracatE13")
                          <table class="table table-bordered" cellspacing="0">
                              <thead>
                                  <tr>
                                  <th>{{trans("messages.gumrukno")}}</th><th>{{trans("messages.sirano")}}</th>
                                  <th>{{trans("messages.plaka")}} </th>
                                  <th>{{trans("messages.plaka")}} {{trans("messages.ulkekodu")}}</th>
                                  <th>{{trans("messages.dorseplaka")}} </th>
                                  <th>{{trans("messages.dorseplaka")}} {{trans("messages.ulkekodu")}}</th>

                                  </tr>
                              </thead>
                            </thead>
                            <tbody>
                              <td>{{$altvalue->gumrukno+1}}</td><td>{{$altvalue->gumrukSira}}</td>
                              <td>{{$altvalue->plaka}}</td>
                              <td>{{$ulke[$altvalue->yuklemeNoktasiulkekodu]}}</td>
                              <td>{{$altvalue->dorse}}</td>
                              <td>{{$ulke[$altvalue->indirmeNoktasiulkekodu]}}</td>

                            </tbody>
                          </table>
                          @break;

                          @endswitch
                        @endforeach
                      </div>
                  @endif


                  @if (!empty($talimat->altmodel))
                    @php ($toplamkap = 0)
                    @php ($toplamkilo = 0)
                      @foreach($talimat->altmodel as $altkey=>$altvalue)
                        @php ($toplamkap+=$altvalue->tekKap)
                        @php ($toplamkilo+=$altvalue->tekKilo)
                      @endforeach
                    @endif
                      <tr>
                          <td>{{trans("messages.toplamkap")}}</td>
                          <td>{{$toplamkap}}</td>
                          <td>{{trans("messages.toplamkilo")}}</td>
                          <td>{{$toplamkilo}}</td>
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
