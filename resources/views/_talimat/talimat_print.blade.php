<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="author" content="">
  <title>Bosphore GROUP</title>
  <!-- Bootstrap core CSS-->
  <link href="/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template-->
  <link href="/css/sb-admin.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.css" rel="stylesheet">
  </head>

	<body class="fixed-nav sticky-footer bg-dark" id="page-top"  onload="window.print()">
	<div class="card mb-3">
        <div class="card-header">
        <div class='row'>
        	<div class='col-4'><i class="fa fa-table"></i> {{\Carbon\Carbon::parse($talimat->created_at)->format('d-m-Y H:i')}}</div>
        	<!--  <div class='col-8 text-right'>Yazdırmak İçin <i class="fa fa-print"></i> </div>  -->
        </div>
        </div>
        <div class="card-body">
        <div class='row'>
            <div class='col-sm-6'>
          	 	 <h5>{{trans("messages.talimatverenkullanici")}}</h5>
                    <table class="table table-bordered" cellspacing="0">
                    <tr>
                    	<td><strong>{{trans("messages.companyname")}}</strong></td>

                    	<td>{{$talimat->user->name}}</td>
                    </tr>
                  <tr>
                    <td><strong>{{trans("messages.autoBarcode")}}</strong></td>
                    <td>
                      <h2>{{$talimat->autoBarcode}}</h2>
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
                    	<td><strong>{{trans("messages.firmavergi")}} / {{trans("messages.firmavergidairesi")}}</strong></td>
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
               			<td><strong>{{trans("messages.talimatdurumu")}}</strong></td>
               			<td>
                      <h2 style='color:red'>
                   				@if ($talimat->durum==0) {{trans("messages.bekliyor")}}
                   				@elseif ($talimat->durum==1) {{trans("messages.islemyapiliyor")}}
                   				@elseif ($talimat->durum==2) {{trans("messages.tamamlandi")}}
                   				@endif
                   		</h2>
               			</td>
               		</tr>
                   </table>

             </div>
              <div class='col-sm-12'>
             	 <h5>{{trans("messages.gumrukbilgileri")}}</h5>
             	   <table class="table table-bordered" cellspacing="0">
             	   <tbody>
             	   @foreach($talimat->gumruk as $key=>$value)
             	   <tr>
             	   		<td colspan='11'><hr /></td>
             	   </tr>
					<tr>
             	   		<th>{{trans("messages.sira")}}</th>
             	   		<th>{{trans("messages.varisgumruk")}}</th>
             	   		<th>{{trans("messages.ADR")}}</th>
             	   		<th>{{trans("messages.atr")}}</th>
             	   		<th>{{trans("messages.talimattipi")}}</th>
             	   		<th>{{trans("messages.malcinsi")}}</th>
             	   		<th>{{trans("messages.kap")}}</th>
             	   		<th>{{trans("messages.kilo")}}</th>
             	   		<th>{{trans("messages.tirkarnesi")}}</th>
             	   		<th>{{trans("messages.problem")}}</th>
             	   		<th>{{trans("messages.aciklama")}}</th>
             	   	</tr>

             	   	<tr>
             	   		<td>{{$loop->iteration}}</td>
             	   		<td>{{$value->varisGumrugu}}</td>
             	   		<td>@if ($value->adr=='no') {{trans("messages.yok")}} @else {{trans("messages.var")}} @endif</td>
             	   		<td>@if ($value->atr=='no') {{trans("messages.yapilmasin")}} @else {{trans("messages.yapilsin")}} @endif</td>
             	   		<td>
             	   		@foreach($talimatTipList as $m=>$v)
             	   			@if (($v->kisaKod==$value->talimatTipi)) {{ $v->kodName }} @endif
             	   		@endforeach
             	   		</td>
             	   		<td>{{$value->malCinsi}}</td>
             	   		<td>{{$value->kap}}</td>
             	   		<td>{{$value->kilo}}</td>
             	   		<td>{{$value->tirKarnesi}}</td>
             	   		<td>@if ($value->problem=='no') {{trans("messages.yok")}} @else {{$value->problemAciklama}} @endif</td>
             	   		<td>{{$value->aciklama}}</td>
             	   	</tr>
             	   	@if (!empty($value->yukleme))
             	   	<tr>
                 	   	<td colspan='4'>
                 	   	<h6>{{trans("messages.indirmeyuklemealani")}}</h6>
                 	   		<table class="table table-bordered" cellspacing="0" style='font-size:11px'>
                 	   			<thead>
                 	   				<tr>
                     	   				<th>{{trans("messages.sira")}}</th>
                     	   				<th>{{trans("messages.yuklemeyeri")}}</th>
                     	   				<th>{{trans("messages.bosaltmayeri")}}</th>
                     	   				 <th>{{trans("messages.kap")}}</th>
                     	   				<th>{{trans("messages.kilo")}}</th>
                     	   			</tr>
                 	   			</thead>
                 	   			<tbody>
                     	   		@foreach($value->yukleme as $mmm=>$vvv)
                     	   		<tr>
                     	   			<td>{{$loop->iteration}}</td>
                     	   			<td>{{$vvv->yuklemeYeri}}</td>
                     	   			<td>{{$vvv->bosaltmaYeri}}</td>
                     	   			                     	   			<td>{{$vvv->kap}}</td>
                     	   			<td>{{$vvv->kilo}}</td>
                 	   			</tr>
                     	   		@endforeach
                 	   		</tbody>
                 	   		</table>

                 	   		<hr />
                 	   		<h6>{{trans("messages.gumrukdosyalari")}}</h6>
                 	   		     @if (!empty($value->evrak))
                 	   		    <table class="table table-bordered" cellspacing="0" style='font-size:11px'>
                 	   				<thead>
                 	   					<tr>
                 	   						<th>{{trans("messages.sira")}}</th>
                 	   						<th>{{trans("messages.dosyacesidi")}}</th>
                 	   						<th>{{trans("messages.dosyaindir")}}</th>
                 	   						<th>{{trans("messages.dosyatipi")}}</th>
                 	   						<th>{{trans("messages.sil")}}</th>
                 	   					</tr>
                 	   				</thead>
                 	   				<tbody>
                     	   			 @foreach($value->evrak as $uuu=>$ooo)
                         	   			<tr>
                         	   				<td>{{$loop->iteration}}</td>
                         	   				<td>{{$isimArray[$ooo->dosyaTipi]}}</td>
                         	   				<td><a href='/uploads/{{$ooo->fileName}}' target="_blank">{{trans("messages.indir")}}İndir</a></td>
                         	   				<td>{{$ooo->filetype}}</td>
                         	   				<td><a href='/dosya/sil/{{$ooo->id}}' onclick='return confirm("{{trans("messages.silmemesaji")}}")'>{{trans("messages.sil")}}</a></td>
                         	   			</tr>
                     	   			 @endforeach
                     	   			</tbody>
                     	   			</table>
                     	   			 @else
										    {{trans("messages.dosyayok")}}
                     	   			 @endif
                 	   	</td>
                 	   	<td colspan='7'>

                 	   		<table class="table table-bordered" cellspacing="0" style='font-size:11px'>
                 	   		   <thead>
                 	   				<tr>
                 	   					<th>{{trans("messages.gereklidosya")}}</th>
                     	   				<th colspan='3'>{{trans("messages.dosya")}}</th>

                     	   			</tr>
                 	   			</thead>
                 	   			<tbody>
                 	   			@if ($talimat->durum==0)
                 	   				<tr><td colspan='4'>{{trans("messages.islemadminbaslatmamesaj")}}</td></tr>
                 	   			@elseif ($talimat->durum==1)
                 	   				<tr>
                     	   				<td>{{trans("messages.cmr")}}</td>
                     	   				<td><input type='file' name="dosya[cmr][{{$value->id}}]" /></td>
                     	   				<td></td>
                     	   			</tr>
                     	   			<tr>
                     	   				<td>{{trans("messages.fatura")}}</td>
                     	   				<td><input type='file' name="dosya[fatura][{{$value->id}}]" /></td>
                     	   				<td></td>
                     	   			</tr>
                     	   			<tr>
                     	   				<td>{{trans("messages.ATR")}}</td>
                     	   				<td><input type='file' name="dosya[atr][{{$value->id}}]" /></td>
                     	   				<td></td>
                     	   			</tr>
                     	   			<tr>
                     	   				<td>{{trans("messages.transitevrak")}}</td>
                     	   				<td><input type='file' name="dosya[talimat][{{$value->id}}]" /></td>
                     	   				<td></td>
                     	   			</tr>

                 	   			</tbody>
                 	   			@elseif ($talimat->durum==2)
                 	   				<tr>
                     	   				<td>
                     	   				{{$value->varisGumrugu}}
                         	   				@foreach($talimatTipList as $m=>$v)
                 	   							@if (($v->kisaKod==$value->talimatTipi)) {{ $v->kodName }} {{trans("messages.dosyasi")}} @endif
                 	   						@endforeach
             	   						</td>
                     	   				<td><input type='file' name="dosya[{{$value->talimatTipi}}][{{$value->id}}]" /></td>
                     	   				<td></td>
                     	   			</tr>
                 	   			@endif
                 	   		</table>
                 	   	</td>
             	   	</tr>
             	   	@endif
             	   	@endforeach

             	   </tbody>


                   </table>
                </div>

         </div>
        </div>



     </div>
         <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="/vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="/js/sb-admin.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.js"></script>



  </div>
</body>

</html>
