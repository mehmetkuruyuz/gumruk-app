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

	<script src="/assets/plugins/easyautocomplete.js"></script>
	<script>
	var optionsAJAX = {

			  url: "/talimat/yukcinsi",


						  getValue:function(element) {
							    return element.name+" "+element.code;
						  },

						  list: {
						    match: {
						      enabled: true
						    }
						  },

						 // theme: "square"
						};


	var options = {

			  url: "/talimat/gumruklistesi",

			  getValue:function(element) {
				    return element.name+" "+element.code;
			  },
			  list: {
			    match: {
			      enabled: true,
						caseSensitive: false,
			    }
			  },

			 // theme: "square"
			};



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

function removeAltTalimat(id)
{
		var l=confirm("{{trans('messages.yuksilinecektironay')}}");
		if (l==true)
		{
			$.get('/ihracat/operasyon/altparametre/delete/'+id, function(data, status)
			{
					$("#alttalimat_"+id).remove();
					console.log(data);
			});

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



	function addGumrukData()
	{

			var say=1;
			var t;

				$("#myTab").children().remove();
				$("#myTabContent").children().remove();
				$("#myTabContent").html("");


			$.get("/ihracat/gumrukgetir/"+say,
		   function(data, status)
			 {
				 	$("#myTabContent").children().remove();
					$("#myTab").children().remove();
					for(t=1;t<=say;t++)
					{
							$("#myTab").append('<li class="nav-item border-right border-top"><a class="nav-link " id="linktab-'+t+'" data-toggle="tab" href="#tab-'+t+'" role="tab" aria-controls="tab'+t+'" aria-selected="false">  {{trans("messages.gumrukno")}} '+(t)+' </a>');
					}
					$.each(data, function (index, value)
							 {
									$("#myTabContent").append(value);

								});
									console.log("xxXxxxx");
									 $(".varisGumruk").easyAutocomplete(options);
									 $(".yukcinsi").easyAutocomplete(optionsAJAX);
		   });




	}

	//addGumrukData();

	function yonlendirTalimatPage(id,t)
	{


		var l=confirm("{{trans('messages.talimatyonlendirmemesaj')}}");
		if (l==true)
		{
				window.location.href='/operasyon/ozelislem/'+id+'/'+$(t).val();
		}
	}
	function deleteTableItem(t)
	{

		var answer = confirm("{{trans('messages.silmeeminmisiniz')}}");
	        if (answer)
					{
						$(t).parent().parent().parent().parent().remove();
	        }
	}

	function addItemTo(nu)
	{

		var talimattipi=$("#talimatsecici_"+nu).val();
		var totalcount=$("#gumruk_alt_"+nu).children().length;
		var cekiciPlaka=$("#cekiciPlaka").val();
		var dorsePlaka=$("#dorsePlaka").val();
		/*
		if (cekiciPlaka==="") 	{ 	alert("{{trans("messages.lutfencekicibilgigiriniz")}}");	}

		if (dorsePlaka==="") 	{		alert("{{trans("messages.lutfendorsebilgigiriniz")}}");	}
		*/
		$.get("/ihracat/bilgigetir/"+talimattipi+"/"+nu+"?whichplace="+totalcount+"&dorse="+dorsePlaka+"&cekici="+cekiciPlaka, function(data, status)
		{

				$("#gumruk_alt_"+nu).append(data);
				$(".varisGumruk").easyAutocomplete(options);

				$(".yukcinsi").easyAutocomplete(optionsAJAX);
		});

	}

	function kontrolformtoaction()
	{

		 var k=confirm('{{trans("messages.formconfirm")}}');

		 var bolge=$("#bolgeSecim").val();
		 var userId=$("#firmaXixD").val();

		 var messages="";

		 if (bolge<1)	 { k=false; messages='{{trans("messages.bolgehata")}}';}
		 if (userId<1) { k=false; messages='{{trans("messages.kullanicihata")}}'; }
		 if (k==false) {alert(messages);}
	     return k;
	}


</script>
@endsection
@section('content')
	<form method="post" action="/ihracat/operasyon/update" enctype="multipart/form-data" onsubmit="return kontrolformtoaction()" >
	<div class="card mb-3">
				<div class="card-body">

				<div class='row'>

					<div class='col-8'><i class="fa fa-table"></i> <span>{{trans('messages.createddate')}} : {{\Carbon\Carbon::parse($talimat->created_at)->format('d-m-Y H:i')}} / {{trans('messages.updateddate')}} : {{\Carbon\Carbon::parse($talimat->updated_at)->format('d-m-Y H:i')}}</span></div>

				</div>
					<div class="row">
							{{csrf_field()}}
							<input type="hidden" name="id" value="{{$talimat->id}}" />
												<div class='col-sm-6'>
														 <h5>{{trans("messages.talimatverenkullanici")}}</h5>
																	<table class="table table-bordered" cellspacing="0" >
																	<tr>
																		<td><strong>{{trans("messages.companyname")}}</strong></td>
																		<td>
																			{{$talimat->user->name}}
																			@if (\Auth::user()->role=='admin'  || \Auth::user()->role=="bolgeadmin")
																				<input type='hidden' name='firmaId' id="firmaXixD"  value='{{$talimat->user->id}}' />
												            	<div class="form-group hidden d-none">
												 							<label for="firmaId">{{trans("messages.companyname")}}</label>
												            		@if (!empty($userlist))
												            		<select name='firmaIdasd' class="form-control"  id="firmaXixD" onchange="getPlakaList()" >
												 								<option value='0'>({{trans("messages.choose")}})</option>
												            			@foreach($userlist as $z=>$m)
												            				<option value='{{$m["id"]}}' @if ($talimat->user->id==$m["id"]) selected @endif >{{$m["name"]}}</option>
												            			@endforeach
												            		</select>
												            		@endif
												          		 </div>
												            	@else
												            	   <div class="form-group">
												                   <label for="orderNo">{{trans("messages.companyname")}}</label>
												                   <input type='hidden' name='firmaId' id="firmaXixD"  value='{{$talimat->user->id}}' />
												                   <input type="text" disabled="disabled" value='{{\Auth::user()->name}}' class="form-control" name='__firmaAdi' id="__firmaAdi" placeholder="Firma Adı">
												            	  </div>
												            	 @endif
																			</td>
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
																				<td colspan="2"><hr /></td>
																		</tr>
																		<tr>
																		 <td><strong>{{trans("messages.ozelplaka")}}</strong></td>
																		 <td><input type="text" name="plaka" class="form-control" value="{{$talimat->plaka}}" /></td>
																		</tr>
																		<tr>
																		 <td><strong>{{trans("messages.sertifikano")}}</strong></td>
																		 <td><input type="text" name="sertifikano" class="form-control" value="{{$talimat->sertifikano}}" /></td>
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

																	 <td><input type="text" name="cekiciPlaka" class="form-control" id="cekiciPlaka" value="{{$talimat->cekiciPlaka}}" /></td>
																	</tr>
																	<tr>
																	 <td><strong>{{trans("messages.dorseplaka")}}</strong></td>
																	 <td><input type="text" name="dorsePlaka" class="form-control" 		 id="dorsePlaka" value="{{$talimat->dorsePlaka}}" /></td>
																	</tr>
																	<tr>
																		<td><strong>{{trans("messages.pozisyonNo")}}</strong></td>
																		<td><input type="text" name="pozisyonNo" class="form-control" value="{{$talimat->pozisyonNo}}" /></td>
																	</tr>
																	<tr>
																		<td><strong>{{trans("messages.teminatTipi")}}</strong></td>
																		<td>
																				<select name='teminatTipi' class="form-control" id="teminatTipi">
																									<option value='0'>({{trans("messages.choose")}})</option>
																									<option value="SGS" @if ($talimat->teminatTipi=="SGS") selected @endif >{{trans("messages.SGS")}}</option>
																									<option value="TOBB" @if ($talimat->teminatTipi=="TOBB") selected @endif >{{trans("messages.TOBB")}}</option>
																									<option value="MARS" @if ($talimat->teminatTipi=="MARS") selected @endif >{{trans("messages.MARS")}}</option>

																					</select>
																	</tr>
																	<tr>
																		<td><strong>{{trans("messages.tasimaTipi")}}</strong></td>
																		<td>
																				<select name='tasimaTipi' class="form-control" id="tasimaTipi">
																					<option value='0'>({{trans("messages.choose")}})</option>
																					<option value="gemi" @if ($talimat->tasimaTipi=="gemi") selected @endif>{{trans("messages.gemi")}}</option>
																					<option value="tren" @if ($talimat->tasimaTipi=="tren") selected @endif>{{trans("messages.tren")}}</option>
																					<option value="kara" @if ($talimat->tasimaTipi=="kara") selected @endif>{{trans("messages.kara")}}</option>
																				</select>
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
																		<td><strong>{{trans("messages.editislemiyapan")}}</strong></td>
																		<td>{{\Auth::user()->name}}</td>

																 </tr>

															 </table>

													 </div>

												 </div>
												 <div>
													 <div id='idXLKO'></div>
							             	<ul class="nav nav-tabs" id="myTab">
							                	<li class="nav-item">
							 									<a class="nav-link" id="bir-0" data-toggle="tab" href="#tab-0" role="tab" aria-controls="bir" aria-selected="false"> {{trans("messages.gumruk")}} 1</a>
							 								</li>
							               </ul>
							               <div class="tab-content col-md-12 py-5  border-3" id="myTabContent" >

							               </div>
												 </div>
													 <div class='col-sm-12'>
														 <h5>{{trans("messages.gumrukbilgileri")}}</h5>

														 	<hr />
																@if (!empty($talimat->altmodel))
																			@foreach($talimat->altmodel as $altkey=>$altvalue)
																				@php
																				if (empty($oldkontrol)) {$oldkontrol=0;}
																					if ($oldkontrol!=intval($altvalue->gumrukno+1))
																					{
																						$openaadaction="yes";
																						$oldkontrol=intval($altvalue->gumrukno+1);
																					}else {
																						$openaadaction="no";
																					}
																				@endphp


																			<div class="alttalimat" id="alttalimat_{{$altvalue->id}}"> {{trans("messages.".$altvalue->talimatTipi)}} <a href="javascript:void(0)" class="float-right btn btn-sm btn-danger" onclick="removeAltTalimat({{$altvalue->id}})"><i class="fa fa-remove"></i></a>
																				@if ($openaadaction=="yes")
																				<div class="alttalimatyeni row my-2">
																					<div class="col-md-5">
																						<select name="talimatsecici[{{$altvalue->id}}][]" class="form-control" data-num="1" id="talimatsecici_{{$altvalue->id}}">
																							@if (!empty($talimatList))
																								@foreach ($talimatList as $key => $value)
																										<option value="{{$value->kisaKod}}">{{$value->kodName}}</option>
																								@endforeach
																							@endif
																						</select>
																					</div>
																						<div class="col-md-2">
																									<button type="button" class="btn btn-info" onclick="addItemTo({{$altvalue->id}})">{{trans("messages.add")}}</button>
																						</div>
																				</div>
																				@endif

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
																							<td>{{$altvalue->varisGumruk}}</td>
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
																							<td>{{$altvalue->varisGumruk}}</td>
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
																						<td>{{$altvalue->varisGumruk}}</td>
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
																					<td>{{$altvalue->varisGumruk}}</td>
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
																					<td>{{$altvalue->varisGumruk}}</td>
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
																					<td>{{$altvalue->varisGumruk}}</td>
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
																							<td>{{$altvalue->varisGumruk}}</td>
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

																							<td>{{$altvalue->varisGumruk}}</td>
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
																						<td>{{$altvalue->varisGumruk}}</td>
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

																										<td>{{$altvalue->varisGumruk}}</td>
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
																										<td>{{$altvalue->varisGumruk}}</td>
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
																					<td>{{$altvalue->varisGumruk}}</td>
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
																					<td>{{$altvalue->varisGumruk}}</td>
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
																						<td>{{$altvalue->varisGumruk}}</td>
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
																			<div id="gumruk_alt_{{$altvalue->id}}">

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
						<div class="col-md-12 border p-2">
						 <div class="form-group col-md-4 temizlenebilir">
							<h3>{{trans("messages.aciklama")}}</h3>
							<div><textarea name="note" class="form-control">{{$talimat->note}}</textarea></div>
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
			<button class="btn btn-danger" type="submit">{{trans("messages.update")}}</button>
		</form>
@endsection
