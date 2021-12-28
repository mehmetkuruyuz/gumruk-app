@extends('layouts.app')

@section('kirinti')
	{{trans("messages.operasyoninceleheader")}}
@endsection

@section('scripts')
<style>
table {font-size:0.9em;}
</style>

@endsection

@section('endscripts')
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
			var l=confirm("{{trans('messages.formconfirm')}}");
			if (l==true)
			{
				window.location.href='/ihracat/operasyon/ozelislem/'+id+'/'+tip;
			}


	}
	function yonlendirTalimatPage(id,t)
	{


		var l=confirm("{{trans('messages.talimatyonlendirmemesaj')}}");
		if (l==true)
		{
				window.location.href='/operasyon/ozelislem/'+id+'/'+$(t).val();
		}
	}


</script>
@endsection
@section('content')
	<div class="card mb-3">
				<div class="card-body">
				<div class='row'>

					<div class='col-8'><i class="fa fa-table"></i> <span>{{trans('messages.createddate')}} : {{\Carbon\Carbon::parse($talimat->created_at)->format('d-m-Y H:i')}} / {{trans('messages.updateddate')}} : {{\Carbon\Carbon::parse($talimat->updated_at)->format('d-m-Y H:i')}}</span></div>
					<div class='col-4 text-right'><a href='/ihracat/operasyon/print/{{$talimat->id}}'>Yazdırmak İçin <i class="fa fa-print"></i> </a></div>

					@if(Auth::user()->role=="admin")

					<div class='col-12 text-right'>
						<ul class="pagination pagination-sm">
							<li class="disabled"><a href="#">{{trans('messages.degisiklikler')}}</a></li>
									{{-- Helper::getChangeList($talimat->id) --}}
						</ul>
					</div>
					@endif
				</div>
					<div class="row">
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
																			<span style="font-size:3em;">{{$talimat->autoBarcode}}</span>
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
																	 @if (!empty($talimat->ilgilikayit))
																			@if (\Auth::user()->id==$talimat->ilgilikayit->id || \Auth::user()->role=="admin")
																				@if($talimat->durum=="bekleme")
                                          <hr />
																						<a href="/ihracat/operasyon/donethis/{{$talimat->id}}" class="btn btn-danger">@if (\Auth::user()->role=="admin")Yönetici Olarak @endif Operasyonu Tamamla</a>
																				  @endif
																			@endif
																		@endif
																	 </td>

																 </tr>
															 </table>

													 </div>

												 </div>

													 <div class='col-sm-12'>
														 <h5>{{trans("messages.gumrukbilgileri")}}</h5>

																@if (!empty($talimat->altmodel))
																			@foreach($talimat->altmodel as $altkey=>$altvalue)
																			{{trans("messages.".$altvalue->talimatTipi)}}<hr />
																			<div class="col-sm-12 my-2 py-2" style="">
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
																						<th colspan="3">{{trans("messages.onayla")}}</th>
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
																							@if ($altvalue->islemdurumu=="bekliyor")
																							<td><a href='javascript:void(0)' onclick='talimatAltIslem("tamamlandi","{{$altvalue->id}}")'><i class="fa fa-check"></i></a></td>
																							<td><a href='javascript:void(0)' onclick='talimatAltIslem("iptal","{{$altvalue->id}}")'><i class="fas fa-minus"></i></a></td>
																							<td><a href='javascript:void(0)' onclick='talimatAltIslem("sil","{{$altvalue->id}}")'><i class="fas fa-trash"></i></a></td>
																						@else
																							<td colspan="3">{{trans("messages.".$altvalue->islemdurumu)}}</td>
																						@endif
																						</tr>
																					<td><a title="{{trans("messages.uploadfile")}}" href='javascript:void(0)' onclick="PopupCenter('/ihracat/operasyon/sub/upload?talimatid={{$talimat->id}}&gumrukno={{$altvalue->gumrukno}}&gumruksira={{$altvalue->gumrukSira}}','xtf','930','500'); "><i class="fa fa-file-pdf-o" aria-hidden="true" style='color:orange'></i></a></td></tbody>
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
																						<th colspan="3">{{trans("messages.onayla")}}</th>
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
																							@if ($altvalue->islemdurumu=="bekliyor")
																							<td><a href='javascript:void(0)' onclick='talimatAltIslem("tamamlandi","{{$altvalue->id}}")'><i class="fa fa-check"></i></a></td>
																							<td><a href='javascript:void(0)' onclick='talimatAltIslem("iptal","{{$altvalue->id}}")'><i class="fas fa-minus"></i></a></td>
																							<td><a href='javascript:void(0)' onclick='talimatAltIslem("sil","{{$altvalue->id}}")'><i class="fas fa-trash"></i></a></td>
																						@else
																							<td colspan="3">{{trans("messages.".$altvalue->islemdurumu)}}</td>
																						@endif
																						</tr>
																					<td><a title="{{trans("messages.uploadfile")}}" href='javascript:void(0)' onclick="PopupCenter('/ihracat/operasyon/sub/upload?talimatid={{$talimat->id}}&gumrukno={{$altvalue->gumrukno}}&gumruksira={{$altvalue->gumrukSira}}','xtf','930','500'); "><i class="fa fa-file-pdf-o" aria-hidden="true" style='color:orange'></i></a></td></tbody>
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
																					<th colspan="3">{{trans("messages.onayla")}}</th></thead>
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
																						@if ($altvalue->islemdurumu=="bekliyor")
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("tamamlandi","{{$altvalue->id}}")'><i class="fa fa-check"></i></a></td>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("iptal","{{$altvalue->id}}")'><i class="fas fa-minus"></i></a></td>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("sil","{{$altvalue->id}}")'><i class="fas fa-trash"></i></a></td>
																					@else
																						<td colspan="3">{{trans("messages.".$altvalue->islemdurumu)}}</td>
																					@endif
																					<td><a title="{{trans("messages.uploadfile")}}" href='javascript:void(0)' onclick="PopupCenter('/ihracat/operasyon/sub/upload?talimatid={{$talimat->id}}&gumrukno={{$altvalue->gumrukno}}&gumruksira={{$altvalue->gumrukSira}}','xtf','930','500'); "><i class="fa fa-file-pdf-o" aria-hidden="true" style='color:orange'></i></a></td></tbody>
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

																				<th colspan="3">{{trans("messages.onayla")}}</th></thead>
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
																					@if ($altvalue->islemdurumu=="bekliyor")
																					<td><a href='javascript:void(0)' onclick='talimatAltIslem("tamamlandi","{{$altvalue->id}}")'><i class="fa fa-check"></i></a></td>
																					<td><a href='javascript:void(0)' onclick='talimatAltIslem("iptal","{{$altvalue->id}}")'><i class="fas fa-minus"></i></a></td>
																					<td><a href='javascript:void(0)' onclick='talimatAltIslem("sil","{{$altvalue->id}}")'><i class="fas fa-trash"></i></a></td>
																				@else
																					<td colspan="3">{{trans("messages.".$altvalue->islemdurumu)}}</td>
																				@endif
																				<td><a title="{{trans("messages.uploadfile")}}" href='javascript:void(0)' onclick="PopupCenter('/ihracat/operasyon/sub/upload?talimatid={{$talimat->id}}&gumrukno={{$altvalue->gumrukno}}&gumruksira={{$altvalue->gumrukSira}}','xtf','930','500'); "><i class="fa fa-file-pdf-o" aria-hidden="true" style='color:orange'></i></a></td></tbody>
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

																					<th colspan="3">{{trans("messages.onayla")}}</th></thead>
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
																					@if ($altvalue->islemdurumu=="bekliyor")
																					<td><a href='javascript:void(0)' onclick='talimatAltIslem("tamamlandi","{{$altvalue->id}}")'><i class="fa fa-check"></i></a></td>
																					<td><a href='javascript:void(0)' onclick='talimatAltIslem("iptal","{{$altvalue->id}}")'><i class="fas fa-minus"></i></a></td>
																					<td><a href='javascript:void(0)' onclick='talimatAltIslem("sil","{{$altvalue->id}}")'><i class="fas fa-trash"></i></a></td>
																				@else
																					<td colspan="3">{{trans("messages.".$altvalue->islemdurumu)}}</td>
																				@endif
																				<td><a title="{{trans("messages.uploadfile")}}" href='javascript:void(0)' onclick="PopupCenter('/ihracat/operasyon/sub/upload?talimatid={{$talimat->id}}&gumrukno={{$altvalue->gumrukno}}&gumruksira={{$altvalue->gumrukSira}}','xtf','930','500'); "><i class="fa fa-file-pdf-o" aria-hidden="true" style='color:orange'></i></a></td></tbody>
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
																						<th colspan="3">{{trans("messages.onayla")}}</th></thead>
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
																					@if ($altvalue->islemdurumu=="bekliyor")
																					<td><a href='javascript:void(0)' onclick='talimatAltIslem("tamamlandi","{{$altvalue->id}}")'><i class="fa fa-check"></i></a></td>
																					<td><a href='javascript:void(0)' onclick='talimatAltIslem("iptal","{{$altvalue->id}}")'><i class="fas fa-minus"></i></a></td>
																					<td><a href='javascript:void(0)' onclick='talimatAltIslem("sil","{{$altvalue->id}}")'><i class="fas fa-trash"></i></a></td>
																				@else
																					<td colspan="3">{{trans("messages.".$altvalue->islemdurumu)}}</td>
																				@endif
																				<td><a title="{{trans("messages.uploadfile")}}" href='javascript:void(0)' onclick="PopupCenter('/ihracat/operasyon/sub/upload?talimatid={{$talimat->id}}&gumrukno={{$altvalue->gumrukno}}&gumruksira={{$altvalue->gumrukSira}}','xtf','930','500'); "><i class="fa fa-file-pdf-o" aria-hidden="true" style='color:orange'></i></a></td></tbody>
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
																						<th colspan="3">{{trans("messages.onayla")}}</th></thead>
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
																					@if ($altvalue->islemdurumu=="bekliyor")
																					<td><a href='javascript:void(0)' onclick='talimatAltIslem("tamamlandi","{{$altvalue->id}}")'><i class="fa fa-check"></i></a></td>
																					<td><a href='javascript:void(0)' onclick='talimatAltIslem("iptal","{{$altvalue->id}}")'><i class="fas fa-minus"></i></a></td>
																					<td><a href='javascript:void(0)' onclick='talimatAltIslem("sil","{{$altvalue->id}}")'><i class="fas fa-trash"></i></a></td>
																				@else
																					<td colspan="3">{{trans("messages.".$altvalue->islemdurumu)}}</td>
																				@endif
																				<td><a title="{{trans("messages.uploadfile")}}" href='javascript:void(0)' onclick="PopupCenter('/ihracat/operasyon/sub/upload?talimatid={{$talimat->id}}&gumrukno={{$altvalue->gumrukno}}&gumruksira={{$altvalue->gumrukSira}}','xtf','930','500'); "><i class="fa fa-file-pdf-o" aria-hidden="true" style='color:orange'></i></a></td></tbody>
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
																					<th colspan="3">{{trans("messages.onayla")}}</th></thead>
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
																					@if ($altvalue->islemdurumu=="bekliyor")
																					<td><a href='javascript:void(0)' onclick='talimatAltIslem("tamamlandi","{{$altvalue->id}}")'><i class="fa fa-check"></i></a></td>
																					<td><a href='javascript:void(0)' onclick='talimatAltIslem("iptal","{{$altvalue->id}}")'><i class="fas fa-minus"></i></a></td>
																					<td><a href='javascript:void(0)' onclick='talimatAltIslem("sil","{{$altvalue->id}}")'><i class="fas fa-trash"></i></a></td>
																				@else
																					<td colspan="3">{{trans("messages.".$altvalue->islemdurumu)}}</td>
																				@endif
																				<td><a title="{{trans("messages.uploadfile")}}" href='javascript:void(0)' onclick="PopupCenter('/ihracat/operasyon/sub/upload?talimatid={{$talimat->id}}&gumrukno={{$altvalue->gumrukno}}&gumruksira={{$altvalue->gumrukSira}}','xtf','930','500'); "><i class="fa fa-file-pdf-o" aria-hidden="true" style='color:orange'></i></a></td></tbody>
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
																					<th colspan="3">{{trans("messages.onayla")}}</th>
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
																				@if ($altvalue->islemdurumu=="bekliyor")
																					<td><a href='javascript:void(0)' onclick='talimatAltIslem("tamamlandi","{{$altvalue->id}}")'><i class="fa fa-check"></i></a></td>
																					<td><a href='javascript:void(0)' onclick='talimatAltIslem("iptal","{{$altvalue->id}}")'><i class="fas fa-minus"></i></a></td>
																					<td><a href='javascript:void(0)' onclick='talimatAltIslem("sil","{{$altvalue->id}}")'><i class="fas fa-trash"></i></a></td>
																				@else
																					<td colspan="3">{{trans("messages.".$altvalue->islemdurumu)}}</td>
																				@endif
																				<td><a title="{{trans("messages.uploadfile")}}" href='javascript:void(0)' onclick="PopupCenter('/ihracat/operasyon/sub/upload?talimatid={{$talimat->id}}&gumrukno={{$altvalue->gumrukno}}&gumruksira={{$altvalue->gumrukSira}}','xtf','930','500'); "><i class="fa fa-file-pdf-o" aria-hidden="true" style='color:orange'></i></a></td></tbody>
																				</table>
																				@break
																				@case("bondeshortie")
																				<table class="table table-bordered" cellspacing="0">
																				<thead>
																					<th colspan="3">{{trans("messages.onayla")}}</th></thead>
																				<tbody>
																				<td><a title="{{trans("messages.uploadfile")}}" href='javascript:void(0)' onclick="PopupCenter('/ihracat/operasyon/sub/upload?talimatid={{$talimat->id}}&gumrukno={{$altvalue->gumrukno}}&gumruksira={{$altvalue->gumrukSira}}','xtf','930','500'); "><i class="fa fa-file-pdf-o" aria-hidden="true" style='color:orange'></i></a></td></tbody>
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
																							<th colspan="3">{{trans("messages.onayla")}}</th>
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
																							@if ($altvalue->islemdurumu=="bekliyor")
																							<td><a href='javascript:void(0)' onclick='talimatAltIslem("tamamlandi","{{$altvalue->id}}")'><i class="fa fa-check"></i></a></td>
																							<td><a href='javascript:void(0)' onclick='talimatAltIslem("iptal","{{$altvalue->id}}")'><i class="fas fa-minus"></i></a></td>
																							<td><a href='javascript:void(0)' onclick='talimatAltIslem("sil","{{$altvalue->id}}")'><i class="fas fa-trash"></i></a></td>
																						@else
																							<td colspan="3">{{trans("messages.".$altvalue->islemdurumu)}}</td>
																						@endif
																						<td><a title="{{trans("messages.uploadfile")}}" href='javascript:void(0)' onclick="PopupCenter('/ihracat/operasyon/sub/upload?talimatid={{$talimat->id}}&gumrukno={{$altvalue->gumrukno}}&gumruksira={{$altvalue->gumrukSira}}','xtf','930','500'); "><i class="fa fa-file-pdf-o" aria-hidden="true" style='color:orange'></i></a></td></tbody>
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
																						<th colspan="3">{{trans("messages.onayla")}}</th>
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
																						@if ($altvalue->islemdurumu=="bekliyor")
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("tamamlandi","{{$altvalue->id}}")'><i class="fa fa-check"></i></a></td>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("iptal","{{$altvalue->id}}")'><i class="fas fa-minus"></i></a></td>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("sil","{{$altvalue->id}}")'><i class="fas fa-trash"></i></a></td>
																					@else
																						<td colspan="3">{{trans("messages.".$altvalue->islemdurumu)}}</td>
																					@endif
																					<td><a title="{{trans("messages.uploadfile")}}" href='javascript:void(0)' onclick="PopupCenter('/ihracat/operasyon/sub/upload?talimatid={{$talimat->id}}&gumrukno={{$altvalue->gumrukno}}&gumruksira={{$altvalue->gumrukSira}}','xtf','930','500'); "><i class="fa fa-file-pdf-o" aria-hidden="true" style='color:orange'></i></a></td></tbody>
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
																								<th colspan="3">{{trans("messages.onayla")}}</th>
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
																					@if ($altvalue->islemdurumu=="bekliyor")
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("tamamlandi","{{$altvalue->id}}")'><i class="fa fa-check"></i></a></td>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("iptal","{{$altvalue->id}}")'><i class="fas fa-minus"></i></a></td>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("sil","{{$altvalue->id}}")'><i class="fas fa-trash"></i></a></td>
																					@else
																						<td colspan="3">{{trans("messages.".$altvalue->islemdurumu)}}</td>
																					@endif
																					<td><a title="{{trans("messages.uploadfile")}}" href='javascript:void(0)' onclick="PopupCenter('/ihracat/operasyon/sub/upload?talimatid={{$talimat->id}}&gumrukno={{$altvalue->gumrukno}}&gumruksira={{$altvalue->gumrukSira}}','xtf','930','500'); "><i class="fa fa-file-pdf-o" aria-hidden="true" style='color:orange'></i></a></td></tbody>
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
																									<th colspan="3">{{trans("messages.onayla")}}</th>
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

																					@if ($altvalue->islemdurumu=="bekliyor")
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("tamamlandi","{{$altvalue->id}}")'><i class="fa fa-check"></i></a></td>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("iptal","{{$altvalue->id}}")'><i class="fas fa-minus"></i></a></td>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("sil","{{$altvalue->id}}")'><i class="fas fa-trash"></i></a></td>
																					@else
																						<td colspan="3">{{trans("messages.".$altvalue->islemdurumu)}}</td>
																					@endif
																					<td><a title="{{trans("messages.uploadfile")}}" href='javascript:void(0)' onclick="PopupCenter('/ihracat/operasyon/sub/upload?talimatid={{$talimat->id}}&gumrukno={{$altvalue->gumrukno}}&gumruksira={{$altvalue->gumrukSira}}','xtf','930','500'); "><i class="fa fa-file-pdf-o" aria-hidden="true" style='color:orange'></i></a></td></tbody>
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
																										<th colspan="3">{{trans("messages.onayla")}}</th>
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

																					@if ($altvalue->islemdurumu=="bekliyor")
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("tamamlandi","{{$altvalue->id}}")'><i class="fa fa-check"></i></a></td>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("iptal","{{$altvalue->id}}")'><i class="fas fa-minus"></i></a></td>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("sil","{{$altvalue->id}}")'><i class="fas fa-trash"></i></a></td>
																					@else
																						<td colspan="3">{{trans("messages.".$altvalue->islemdurumu)}}</td>
																					@endif
																					<td><a title="{{trans("messages.uploadfile")}}" href='javascript:void(0)' onclick="PopupCenter('/ihracat/operasyon/sub/upload?talimatid={{$talimat->id}}&gumrukno={{$altvalue->gumrukno}}&gumruksira={{$altvalue->gumrukSira}}','xtf','930','500'); "><i class="fa fa-file-pdf-o" aria-hidden="true" style='color:orange'></i></a></td></tbody>
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
																								<th colspan="3">{{trans("messages.onayla")}}</th>
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
																					@if ($altvalue->islemdurumu=="bekliyor")
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("tamamlandi","{{$altvalue->id}}")'><i class="fa fa-check"></i></a></td>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("iptal","{{$altvalue->id}}")'><i class="fas fa-minus"></i></a></td>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("sil","{{$altvalue->id}}")'><i class="fas fa-trash"></i></a></td>
																					@else
																						<td colspan="3">{{trans("messages.".$altvalue->islemdurumu)}}</td>
																					@endif
																					<td><a title="{{trans("messages.uploadfile")}}" href='javascript:void(0)' onclick="PopupCenter('/ihracat/operasyon/sub/upload?talimatid={{$talimat->id}}&gumrukno={{$altvalue->gumrukno}}&gumruksira={{$altvalue->gumrukSira}}','xtf','930','500'); "><i class="fa fa-file-pdf-o" aria-hidden="true" style='color:orange'></i></a></td></tbody>
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
																								<th colspan="3">{{trans("messages.onayla")}}</th>
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
																					@if ($altvalue->islemdurumu=="bekliyor")
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("tamamlandi","{{$altvalue->id}}")'><i class="fa fa-check"></i></a></td>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("iptal","{{$altvalue->id}}")'><i class="fas fa-minus"></i></a></td>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("sil","{{$altvalue->id}}")'><i class="fas fa-trash"></i></a></td>
																					@else
																						<td colspan="3">{{trans("messages.".$altvalue->islemdurumu)}}</td>
																					@endif
																					<td><a title="{{trans("messages.uploadfile")}}" href='javascript:void(0)' onclick="PopupCenter('/ihracat/operasyon/sub/upload?talimatid={{$talimat->id}}&gumrukno={{$altvalue->gumrukno}}&gumruksira={{$altvalue->gumrukSira}}','xtf','930','500'); "><i class="fa fa-file-pdf-o" aria-hidden="true" style='color:orange'></i></a></td></tbody>
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
																							 <th colspan="3">{{trans("messages.onayla")}}</th>
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
																					@if ($altvalue->islemdurumu=="bekliyor")
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("tamamlandi","{{$altvalue->id}}")'><i class="fa fa-check"></i></a></td>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("iptal","{{$altvalue->id}}")'><i class="fas fa-minus"></i></a></td>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("sil","{{$altvalue->id}}")'><i class="fas fa-trash"></i></a></td>
																					@else
																						<td colspan="3">{{trans("messages.".$altvalue->islemdurumu)}}</td>
																					@endif
																					<td><a title="{{trans("messages.uploadfile")}}" href='javascript:void(0)' onclick="PopupCenter('/ihracat/operasyon/sub/upload?talimatid={{$talimat->id}}&gumrukno={{$altvalue->gumrukno}}&gumruksira={{$altvalue->gumrukSira}}','xtf','930','500'); "><i class="fa fa-file-pdf-o" aria-hidden="true" style='color:orange'></i></a></td></tbody>
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
																							 <th colspan="3">{{trans("messages.onayla")}}</th>
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
																					@if ($altvalue->islemdurumu=="bekliyor")
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("tamamlandi","{{$altvalue->id}}")'><i class="fa fa-check"></i></a></td>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("iptal","{{$altvalue->id}}")'><i class="fas fa-minus"></i></a></td>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("sil","{{$altvalue->id}}")'><i class="fas fa-trash"></i></a></td>
																					@else
																						<td colspan="3">{{trans("messages.".$altvalue->islemdurumu)}}</td>
																					@endif
																					<td><a title="{{trans("messages.uploadfile")}}" href='javascript:void(0)' onclick="PopupCenter('/ihracat/operasyon/sub/upload?talimatid={{$talimat->id}}&gumrukno={{$altvalue->gumrukno}}&gumruksira={{$altvalue->gumrukSira}}','xtf','930','500'); "><i class="fa fa-file-pdf-o" aria-hidden="true" style='color:orange'></i></a></td></tbody>
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
		 																						<th colspan="3">{{trans("messages.onayla")}}</th>
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
																					@if ($altvalue->islemdurumu=="bekliyor")
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("tamamlandi","{{$altvalue->id}}")'><i class="fa fa-check"></i></a></td>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("iptal","{{$altvalue->id}}")'><i class="fas fa-minus"></i></a></td>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("sil","{{$altvalue->id}}")'><i class="fas fa-trash"></i></a></td>
																					@else
																						<td colspan="3">{{trans("messages.".$altvalue->islemdurumu)}}</td>
																					@endif
																					<td><a title="{{trans("messages.uploadfile")}}" href='javascript:void(0)' onclick="PopupCenter('/ihracat/operasyon/sub/upload?talimatid={{$talimat->id}}&gumrukno={{$altvalue->gumrukno}}&gumruksira={{$altvalue->gumrukSira}}','xtf','930','500'); "><i class="fa fa-file-pdf-o" aria-hidden="true" style='color:orange'></i></a></td></tbody>
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
																								<th colspan="3">{{trans("messages.onayla")}}</th>
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
																					@if ($altvalue->islemdurumu=="bekliyor")
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("tamamlandi","{{$altvalue->id}}")'><i class="fa fa-check"></i></a></td>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("iptal","{{$altvalue->id}}")'><i class="fas fa-minus"></i></a></td>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("sil","{{$altvalue->id}}")'><i class="fas fa-trash"></i></a></td>
																					@else
																						<td colspan="3">{{trans("messages.".$altvalue->islemdurumu)}}</td>
																					@endif
																					<td><a title="{{trans("messages.uploadfile")}}" href='javascript:void(0)' onclick="PopupCenter('/ihracat/operasyon/sub/upload?talimatid={{$talimat->id}}&gumrukno={{$altvalue->gumrukno}}&gumruksira={{$altvalue->gumrukSira}}','xtf','930','500'); "><i class="fa fa-file-pdf-o" aria-hidden="true" style='color:orange'></i></a></td></tbody>
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
																								<th colspan="3">{{trans("messages.onayla")}}</th>
																								</tr>
																						</thead>
																					</thead>
																					<tbody>
																						<td>{{$altvalue->gumrukno+1}}</td><td>{{$altvalue->gumrukSira}}</td>
																						<td>{{$altvalue->plaka}}</td>
																						<td>{{$ulke[$altvalue->yuklemeNoktasiulkekodu]}}</td>
																						<td>{{$altvalue->dorse}}</td>
																						<td>{{$ulke[$altvalue->indirmeNoktasiulkekodu]}}</td>
																					@if ($altvalue->islemdurumu=="bekliyor")
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("tamamlandi","{{$altvalue->id}}")'><i class="fa fa-check"></i></a></td>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("iptal","{{$altvalue->id}}")'><i class="fas fa-minus"></i></a></td>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("sil","{{$altvalue->id}}")'><i class="fas fa-trash"></i></a></td>
																					@else
																						<td colspan="3">{{trans("messages.".$altvalue->islemdurumu)}}</td>
																					@endif
																					<td><a title="{{trans("messages.uploadfile")}}" href='javascript:void(0)' onclick="PopupCenter('/ihracat/operasyon/sub/upload?talimatid={{$talimat->id}}&gumrukno={{$altvalue->gumrukno}}&gumruksira={{$altvalue->gumrukSira}}','xtf','930','500'); "><i class="fa fa-file-pdf-o" aria-hidden="true" style='color:orange'></i></a></td></tbody>
																				</table>
																				@break;
																				@case("ihracatE12")
																				<table class="table table-bordered" cellspacing="0">
																						<thead>
																								<tr>
																								<th>{{trans("messages.gumrukno")}}</th><th>{{trans("messages.sirano")}}</th>
																								<th>{{trans("messages.dorseplaka")}} </th>
																		            <th>{{trans("messages.dorseplaka")}} {{trans("messages.ulkekodu")}}</th>
																									<th colspan="3">{{trans("messages.onayla")}}</th>
																								</tr>
																						</thead>
																					</thead>
																					<tbody>
																						<td>{{$altvalue->gumrukno+1}}</td><td>{{$altvalue->gumrukSira}}</td>
																						<td>{{$altvalue->dorse}}</td>
																						<td>{{$ulke[$altvalue->indirmeNoktasiulkekodu]}}</td>
																					@if ($altvalue->islemdurumu=="bekliyor")
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("tamamlandi","{{$altvalue->id}}")'><i class="fa fa-check"></i></a></td>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("iptal","{{$altvalue->id}}")'><i class="fas fa-minus"></i></a></td>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("sil","{{$altvalue->id}}")'><i class="fas fa-trash"></i></a></td>
																					@else
																						<td colspan="3">{{trans("messages.".$altvalue->islemdurumu)}}</td>
																					@endif
																					<td><a title="{{trans("messages.uploadfile")}}" href='javascript:void(0)' onclick="PopupCenter('/ihracat/operasyon/sub/upload?talimatid={{$talimat->id}}&gumrukno={{$altvalue->gumrukno}}&gumruksira={{$altvalue->gumrukSira}}','xtf','930','500'); "><i class="fa fa-file-pdf-o" aria-hidden="true" style='color:orange'></i></a></td></tbody>
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
																									<th colspan="3">{{trans("messages.onayla")}}</th>
																								</tr>
																						</thead>
																					</thead>
																					<tbody>
																						<td>{{$altvalue->gumrukno+1}}</td><td>{{$altvalue->gumrukSira}}</td>
																						<td>{{$altvalue->plaka}}</td>
																						<td>{{$ulke[$altvalue->yuklemeNoktasiulkekodu]}}</td>
																						<td>{{$altvalue->dorse}}</td>
																						<td>{{$ulke[$altvalue->indirmeNoktasiulkekodu]}}</td>
																					@if ($altvalue->islemdurumu=="bekliyor")
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("tamamlandi","{{$altvalue->id}}")'><i class="fa fa-check"></i></a></td>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("iptal","{{$altvalue->id}}")'><i class="fas fa-minus"></i></a></td>
																						<td><a href='javascript:void(0)' onclick='talimatAltIslem("sil","{{$altvalue->id}}")'><i class="fas fa-trash"></i></a></td>
																					@else
																						<td colspan="3">{{trans("messages.".$altvalue->islemdurumu)}}</td>
																					@endif
																					<td><a title="{{trans("messages.uploadfile")}}" href='javascript:void(0)' onclick="PopupCenter('/ihracat/operasyon/sub/upload?talimatid={{$talimat->id}}&gumrukno={{$altvalue->gumrukno}}&gumruksira={{$altvalue->gumrukSira}}','xtf','930','500'); "><i class="fa fa-file-pdf-o" aria-hidden="true" style='color:orange'></i></a></td></tbody>
																				</table>
																				@break;

																				@endswitch
																			</div>
																			@endforeach

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

																<table class="table table-bordered" cellspacing="0">
																	<thead>
																			<tr>
																					<th colspan="4">{{trans("messages.talimatevrakyuklemebaslik")}}</th>
																			</tr>
																		<th colspan="3">{{trans("messages.onayla")}}</th></thead>
																	<tbody>
																		@if (!empty($talimat->evrak))
				 															@foreach ($talimat->evrak as $evkey => $evvalue)
																					<tr>
																						<td>{{$evvalue->filerealname}}</td>
																						<td>{{$evvalue->filetype}}</td>
																						<td>
																							{{($evvalue->kacinci)}}. {{trans("messages.gumruk")}}  {{trans("messages.".$evvalue->belgetipi)}} - {{trans("messages.yuk")}} {{($evvalue->yukId)}} - {{trans("messages.dosya")}}  {{($evvalue->siraId)+1}}
																						</td>
																					<td>
				 																			<a href='/uploads/{{$evvalue->fileName}}' target="_blank">{{trans("messages.dosyaindir")}}</a><br />
																						</td>
																						@if ($talimat->ilgili->id==\Auth::user()->id || \Auth::user()->role=="admin")
																						<td>

																							<a href='/dosya/sil/{{$evvalue->id}}' onclick="return confirm('{{trans("messages.silmeeminmisiniz")}}')">{{trans("messages.delete")}}</a>
																						</td>
																					@endif
																					</tr>
				 															@endforeach
				 														 @endif
																	</tbody>
																</table>
														 </div>

				 								 	</div>



		 				</div>
						<div class="col-md-12 border p-2">
						 <div class="form-group col-md-4 temizlenebilir">
							<h3>{{trans("messages.aciklama")}}</h3>
							<div>{{$talimat->note}}</div>
						</div>
						</div>

				@if (Auth::user()->role=='Xadmin' || Auth::user()->role=='Xbolgeadmin')
						<form action="/operation/uploadfile" method="post"  enctype="multipart/form-data"   onsubmit="return confirm('{{trans("messages.formconfirm")}}')">

								{{ csrf_field() }}
								<input type="hidden" value="{{$talimat->id}}" name="talimatId" />
						<div class='row' style='margin-left:2px;margin-top:4px;background: #FFF;'>
						<div class='col-md-12 border'>
							<h2>{{trans("messages.ozelevrakyuklemebaslik")}}</h2>
							<div class="form-group col-md-12">
								<label for="">{{trans("messages.evrakyukle")}}</label>
								<small>{{trans("messages.evrakyuklealt")}}</small>
								<hr />
								<label>{{trans("messages.ex1")}} {{trans("messages.evrakyukle")}}</label>
								<input type="file" name='specialfiles[ex1][]' multiple class='form-control' >
								<br />
								<label>{{trans("messages.t2")}} {{trans("messages.evrakyukle")}}</label>
								<input type="file" name='specialfiles[t2][]' multiple class='form-control' >
								<br />
								<label>{{trans("messages.fatura")}} {{trans("messages.evrakyukle")}}</label>
								<input type="file" name='specialfiles[fatura][]' multiple class='form-control'>
								<br />
								<label>{{trans("messages.packinglist")}} {{trans("messages.evrakyukle")}}</label>
								<input type="file" name='specialfiles[packinglist][]' multiple class='form-control' >
								<br />
								<label>{{trans("messages.atr")}} {{trans("messages.evrakyukle")}}</label>
								<input type="file" name='specialfiles[atr][]' multiple class='form-control'>
								<br />
								<label>{{trans("messages.adr")}} {{trans("messages.evrakyukle")}}</label>
								<input type="file" name='specialfiles[adr][]' multiple class='form-control' >
								<br />
								<label>{{trans("messages.cmr")}} {{trans("messages.evrakyukle")}}</label>
								<input type="file" name='specialfiles[cmr][]' multiple class='form-control' >
							</div>
							<hr />
						<h2>{{trans("messages.talimatevrakyuklemebaslik")}}</h2>
						<br />
							<div class="form-group col-md-12">
													<label for="gallery-photo-add">{{trans("messages.evrakyukle")}}</label>
													<small>{{trans("messages.evrakyuklealt")}}</small>
													<input type="file" name='files[]' class='form-control' multiple id="gallery-photo-add">
														<div id='dgalleryd' class="gallery"></div>
												</div>
							</div>
							<button class='btn btn-info' type='submit'>{{trans("messages.save")}}</button>


			 </div>
			 		</form>

			@endif
			<div class="col-md-12 border p-2 mt-3">
			 <div class="form-group col-md-12 temizlenebilir">
					<h3>Log</h3>
				<table class="table table-bordered">
					<thead>
					<th>{{trans("messages.gumrukno")}}</th><th>{{trans("messages.sirano")}}</th>
						<th>Kullanıcı</th>
						<th>Yapılan İşlem</th>
						<th>Zamanı</th>
					</thead>
					@if (!empty($logfile))
						<tbody>
						@foreach ($logfile as $key => $value)
								<tr>
									<td>{{$key}}</td>
									<td>{{$value->user->name}}</td>
									<td>{{$value->what}}</td>
									<td>{{$value->created_at}}</td>
								</tr>
						@endforeach
					</tbody>
					@endif
				</table>
			</div>
			</div>
@endsection
