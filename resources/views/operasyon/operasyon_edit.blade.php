@extends('layouts.app')

@section('kirinti')
	{{trans("messages.talimatyenibaslik")}}
@endsection

@section('scripts')

<style>
.gallery div{margin:5px;padding:5px;}
#myTab{font-size:0.9em;}
.easy-autocomplete{
  width:100% !important
}

.easy-autocomplete input{
  width: 100%;
}
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/easy-autocomplete/1.3.5/easy-autocomplete.css" />

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
		      enabled: true
		    }
		  },

		 // theme: "square"
		};




function formTemizle()
{

$(':input','.temizlenebilir')
.not(':button, :submit, :reset')
.val('')
.prop('checked', false)
.prop('selected', false);

}
//h

function openPr(t)
{

	if ($(t).val()=='no')
	{
		$(t).parent().children(".problemYazi").addClass('hidden');
	}
	else
	{
		$(t).parent().children(".problemYazi").removeClass('hidden');
	}

}


function noktalariBaslat(t,kacinci)
{
	var i;
	var adet=1;

	if ($(t).val()=='parsiyal') {adet=10}
	else {
		$(t).parent().children("div").children(".malYuklemeBosaltmaTablolari").children("tbody").empty();
		$(t).parent().children("div").children(".malYuklemeBosaltmaTablolari").children("tbody").append(''+
				'<tr>'+
	        	'<td>'+1+'</td>'+
	            '<td><input type="text" class="form-control" name="yuklemeNoktasi['+kacinci+'][]" required="required"/></td>'+
	            '<td><input type="text" class="form-control" name="indirmeNoktasi['+kacinci+'][]" required="required"/></td>'+
	            '<td><input type="text" class="form-control hesaplanacakKap" name="tekKap['+kacinci+'][]" required="required" onchange="hesaplaKapKilo('+kacinci+')"/></td>'+
	            '<td><input type="text" class="form-control  hesaplanacakKilo" name="tekKilo['+kacinci+'][]" required="required"  onchange="hesaplaKapKilo('+kacinci+')"/></td>'+

	         '</tr>'+
			+'');
	}
	$(t).parent().children("div").children(".yuklemeNoktasi").empty();

	for (i = 1; i <= adet; i++)
	{
		$(t).parent().children("div").children(".yuklemeNoktasi").append("<option value='"+i+"'>"+i+"</option>");
	}



}



function changeTalimatData(t)
{

	var data=$(t).val();
	$("#nmo").removeClass("d-none");
	$("#nmo").attr("disabled", false);

	$("#myTab").children().remove();
	$("#myTabContent").children().remove();

	switch (data) {
		case "ex1":
			//	console.log("Starting Ex1 Data....");
				$("#nmo").val("1");
				$("#nmo").attr("disabled", true);
				$("#nmo").addClass("d-none");


		break;
		default:

	}
	addTabData();
}


function noktalarIcinAlanOlustur(t,kacinci)
{
	var adet=$(t).val();
	var sample=$("#sampletr"+kacinci);
	var newsample;
	newsample=$(sample).html();
	//console.log(newsample);
	//console.log(adet);
  var num = parseInt( newsample.match(/\d+/g), 10 );
  //alert(num);
	//$(sample).parent().children( 'tr:not(:first)' ).remove();

	$(sample).parent().children( 'tr:last' ).remove();
	var sizerd=$(sample).parent().children( 'tr');
	var sayi=sizerd.length;
	for (i=sayi;i<adet;i++)
	{
		//console.log(i);
		$(sample).parent().append("<tr id='mec_"+sayi+"_"+i+"'>"+newsample+"</tr>");
		$("#mec_"+sayi+"_"+i+"").children().find('input').val('');

	}

  	$(".varisGumruk").each(function( index )
    {
      num++;
      $(this).attr("id","each-"+num);
    });

		var rand=Math.floor(Math.random() * 100000000) + 1;
		$(".yukcinsi").each(function( index )
    {
      rand++;
      $(this).attr("id","each-"+rand);
    });

	var talimatTipi=$("#talimatTipi").val();
	 var firmaId=$("#firmaXixD").val();
	 muhasebeDataGetir(talimatTipi,firmaId);

	$(".varisGumruk").easyAutocomplete(options);
	$(".yukcinsi").easyAutocomplete(optionsAJAX);

}


function hesaplaKapKilo(kim)
{
	var toplamkilo=0;
	var toplamkap=0;

	$( "input[type=text][name='tekKap["+kim+"][]']" ).each(function( index ) {
		if (jQuery.type(parseInt($( this ).val()))=='number')
		{
			if (!isNaN(parseInt($( this ).val())))
			{
				toplamkap+=parseInt($( this ).val());
			}
		}
		});

	$( "input[type=text][name='tekKilo["+kim+"][]']"  ).each(function( index ) {
		if (jQuery.type(parseFloat($( this ).val()))=='number')
		{
			if (!isNaN(parseFloat($( this ).val())))
			{
				toplamkilo+=parseFloat($( this ).val());
			}
		}
		});

		$("input[type=text][name='kap["+kim+"]']").val(toplamkap);
		$("input[type=text][name='kilo["+kim+"]']").val(toplamkilo);
		//console.log('Toplam Kilo :'+toplamkilo);
		//console.log('Toplam Kap :'+toplamkap);
}








function karneBilgisiEkle(t)
{


	if ($(t).val()=='tir' || $(t).val()=='ata')
	{
		$(t).parent().children(".karnecik").removeClass('hidden');
	}else
	{
		$(t).parent().children(".karnecik").addClass('hidden');
	}

}



function getPlakaList()
{

		var firmaid=$("#firmaXixD").val();

	var options2 = {

				url: "/plakaliste/cekici/"+firmaid,
					getValue:function(element) {
						return element.plaka;
				},
					list: {
					match: {
						enabled: true
					}
				},
			};


		var options3 = {

					url: "/plakaliste/dorse/"+firmaid,
						getValue:function(element) {
							return element.plaka;
					},
						list: {
						match: {
							enabled: true
						}
					},
				};

		$("#cekiciPlaka").easyAutocomplete(options2);
		$("#dorsePlaka").easyAutocomplete(options3);

}



function gettalimatData(t)
{

	$.post("/talimat_new/talimattipfiyatgetir",
  {
		"_token": "{{ csrf_token() }}",
    firmaId:$("#firmaXixD").val(),
    talimatTipi:$(t).val()
  },
  function(data, status){
		if (data.faturatutari>0)
		{
			var price=data.faturatutari;
		}else {
			var price=0;
		}
		$(t).parent().parent().children(".faturabedel").children("input").val(price);

  });

}



function addTabData()
{

		var say=$("#nmo").val();
		var talimatTipi=$("#talimatTipi").val();
		var t;

		$("#myTab").children().remove();
			$("#myTabContent").children().remove();
			$("#myTabContent").html("");
		$.get("/arac/talimatgetir/"+talimatTipi+"/"+say,
	   function(data, status){
			 	$("#myTabContent").children().remove();
					$("#myTab").children().remove();
					$.each(data, function (index, value)
							 {

								 	$("#myTabContent").append(value);

								});
								for(t=1;t<=say;t++)
								{
										$("#myTab").append('<li class="nav-item"><a class="nav-link " id="linktab-'+t+'" data-toggle="tab" href="#tab-'+t+'" role="tab" aria-controls="tab'+t+'" aria-selected="false"> {{trans("messages.gumruk")}} '+(t)+' </a>');
								}
								var firmaId=$("#firmaXixD").val();
								muhasebeDataGetir(talimatTipi,firmaId);
								$(".varisGumruk").easyAutocomplete(options);

								$(".yukcinsi").easyAutocomplete(optionsAJAX);

	   });





}
function muhasebeDataGetir(tip,firma)
{
		$.get("/muhasebe/fiyatgetir/"+tip+"/"+firma, function(data, status)
		{

			//	console.log(data);

		//		$("#fiyatlamagoster").children().remove();
		//		$("#fiyatlamagoster").append("<div class='alert alert-info'>{{trans('messages.birimfiyati')}} "+data.talimattipi+" "+data.fiyat+" "+data.fiyatbirim+"</div>");


			var say=$("#nmo").val();
			if (tip=="t2") {
				var ekstra=$(".kolaysay").length;
				$.get("/muhasebe/fiyatgetir/t2ek/"+firma, function(datax, statusx)	{

					$("#faturabedeli").val(data.fiyat*say+datax.fiyat*ekstra);
				});



			}else {
				$("#faturabedeli").val(data.fiyat*say);
			}





				//console.log();
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
<form action='/arac/ihracat/update' method="post" name='a' id='actionFormElement' enctype="multipart/form-data"   onsubmit="return kontrolformtoaction()">
	{{ csrf_field() }}
      <input type='hidden' name="talimatId" value="{{$talimat->id}}" />
      <div class='row' style='margin-left:2px;margin-top:4px;background: #FFF;'>

       		<div class='col-md-12 border pt-5'>
       		<h2>{{trans("messages.ihracataracgiris")}}</h2>
       		<br />
					<div class="row">
							<div class="col-md-4">
								<label for="autoBarcode">{{trans("messages.autoBarcode")}}</label>
								<input type='text' readonly name="autoBarcode" id="autoBarcode" value="{{$talimat->autoBarcode}}" class="form-control" />
							</div>
							<div class="form-group col-md-4 temizlenebilir">
						<label for="bolgeSecim">{{trans("messages.bolge")}}</label>
						@if (\Auth::user()->role=="admin" || \Auth::user()->role=="bolgeadmin")

								<select name='bolgeSecim' class="form-control"  id="bolgeSecim" >

										<option value='0'>({{trans("messages.choose")}})</option>
											@if (!empty($bolge))
												@foreach($bolge as $z=>$m)
													<option value='{{$m->id}}' @if ($talimat->bolgeSecim==$m->id) selected="selected"  @endif>{{$m->name}}</option>
												@endforeach
											@endif
								</select>
						@else
							@if (!empty($bolge))
								@foreach($bolge as $z=>$m)
									@if ($m->id==\Auth::user()->bolgeId)
										<br />
										<div class="alert alert-secondary  alert-md"> {{$m->name}} </div>@endif
								@endforeach
							@endif
									<input type="hidden" value="{{\Auth::user()->bolgeId}}" name="bolgeSecim"  id="bolgeSecim" />
						@endif
							</div>
					</div>
					 <br />
       		 <div class='row'>
           	 @if (\Auth::user()->role=='admin'  || \Auth::user()->role=="bolgeadmin")
           		<div class="form-group col-md-4">
							<label for="firmaId">{{trans("messages.companyname")}}</label>
           		@if (!empty($userlist))
           		<select name='firmaId' class="form-control"  id="firmaXixD" onchange="getPlakaList()" >
								<option value='0'>({{trans("messages.choose")}})</option>
           			@foreach($userlist as $z=>$m)
           				<option value='{{$m["id"]}}' @if ($m["id"]==$talimat->firmaId) selected="selected" @endif>{{$m["name"]}}</option>
           			@endforeach
           		</select>

           		@endif

         		 </div>

           	@else
           	   <div class="form-group col-md-4">
                  <label for="orderNo">{{trans("messages.companyname")}}</label>
                  <input type='hidden' name='firmaId' id="firmaXixD"  value='{{\Auth::user()->id}}' />
                  <input type="text" disabled="disabled" value='{{\Auth::user()->name}}' class="form-control" name='__firmaAdi' id="__firmaAdi" placeholder="Firma Adı">
           	  </div>
           	 @endif
						 <div class="form-group col-md-4 temizlenebilir d-none">
							 <label for="externalFirma">{{trans("messages.companyname")}}</label>
							 <input type="text" class="form-control" name='externalFirma' id="externalFirma" >
						 </div>

           	  </div>

   						<div class='row'>
                  <div class="form-group col-md-4 temizlenebilir">
                <label for="cekiciPlaka">{{trans("messages.cekiciplaka")}}</label>

                    <input type="text" class="form-control" name='cekiciPlaka' id="cekiciPlaka" value="{{$talimat->cekiciPlaka}}">
                  </div>
									<div class="form-group col-md-4 temizlenebilir">
								<label for="dorsePlaka">{{trans("messages.dorseplaka")}}</label>
										<input type="text" class="form-control" name='dorsePlaka' id="dorsePlaka" placeholder="Dorse Çekici Plaka"   value="{{$talimat->dorsePlaka}}" required="required">
									</div>
              </div>
							  <div class='row'>
						 <div class="form-group col-md-4 temizlenebilir">
								<label for="">{{trans("messages.talimat")}}</label>

								@if (!empty($talimatList))
									<select name='talimatTipi' class="form-control" id='talimatTipi' onchange='changeTalimatData(this)'>
										<option value='0'>({{trans("messages.choose")}})</option>

											 @foreach($talimatList as $key=>$value)
											 	 @if (\Auth::user()->role!='admin')
													 @if (in_array($value->kisaKod, $yetkiler))
														 <option value="{{ $value->kisaKod }}" @if ($value->kisaKod==$talimat->talimatTipi) selected="selected" @endif>{{ $value->kodName }}</option>
													 @endif
												 @else
													 <option value="{{ $value->kisaKod }}"  @if ($value->kisaKod==$talimat->talimatTipi) selected="selected" @endif>{{ $value->kodName }}</option>
							 					 @endif
											 @endforeach
												</select>
								 @endif
							</div>
							<div class="form-group col-md-4 temizlenebilir">
								<label for="gumrukAdedi">{{trans("messages.gumrukadet")}}</label>

								<select name='gumrukAdedi' id='nmo' class="form-control @if ($talimat->talimatTipi=='ex1') d-none @endif" onchange='addTabData()'>
									<option value='0'>({{trans("messages.choose")}})</option>
									 @for ($i = 1; $i < 11; $i++)
										 <option value="{{ $i }}"  @if (count($altmodel)==$i) selected @endif>{{ $i }}</option>
									 @endfor
								</select>
							</div>
			 				</div>
					 <div class='row'>

						</div>
            <div id='idXLKO'></div>
            	<ul class="nav nav-tabs" id="myTab">

								@foreach($altmodel as $altkey=>$altvalue)
               	<li class="nav-item">
									<a class="nav-link" id="bir-{{$altkey+1}}" data-toggle="tab" href="#tab-{{$altkey+1}}" role="tab" aria-controls="bir" aria-selected="false"> {{trans("messages.gumruk")}} {{$altkey+1}}</a>
								</li>
								@endforeach
              </ul>
              <div class="tab-content col-md-12 py-5  border-3" id="myTabContent" >
  						@foreach($altmodel as $kmodel=>$submodel)
							{{--  --}}
								<div class="tab-pane  @if ($kmodel>0) fade @else active @endif" id="tab-{{$kmodel+1}}"  aria-labelledby="tab{{$altkey+1}}" >

								  <h3>{{trans("messages.lutfengumrukbilgigiriniz")}} - {{$kmodel+1}}</h3>

								    <div class="form-group col-md-12 temizlenebilir ">
								      <label for="yukleme">{{trans("messages.alicigondericiadet")}}</label>
								        <select name="yuklemeNoktasiAdet[{{$kmodel}}][]" class="form-control input-sm yuklemeNoktasi " data-num="1" onchange="noktalarIcinAlanOlustur(this,{{$kmodel}})" >
								          @for ($i = 1; $i < 100; $i++)
								               <option value="{{ $i }}"  @if (count($submodel)==$i) selected @endif>{{ $i }}</option>
								          @endfor
								        </select>
								      </div>
								      <hr />
											<table class="table table-bordered malYuklemeBosaltmaTablolari" width="100%" cellspacing="0">
											@if (!empty($talimat->altmodel))
														@switch($talimat->talimatTipi)
																	@case("ex1")
																	<thead>
																		<th>{{trans("messages.gumrukno")}}</th>
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
																	 	@foreach($submodel as $altkey=>$altvalue)
																		<tr id="sampletr{{$altkey}}">
																				<td class="text-red">{{$altvalue->gumrukId+1}}</td>
																				<td><input class="form-control varisGumruk" type='text' name='varisGumruk[{{$kmodel}}][]' value="{{$altvalue->varisGumruk}}" /></td>
																				<td><input class="form-control" type='text' name='yuklemeNoktasi[{{$kmodel}}][]' value="{{$altvalue->yuklemeNoktasi}}" /></td>
																				<td>
																					<select name="yuklemeNoktasiulkekodu[{{$kmodel}}][]" class="form-control col-xs-2">
														               <option value="0">{{trans("messages.seciniz")}}</option>
														               @if(!empty($ulkeList))
														                  @foreach ($ulkeList as $ulkekey => $ulkevalue)
														                    <option value="{{$ulkevalue->id}}" @if ($ulkevalue->id==$altvalue->yuklemeNoktasiulkekodu) selected="selected" @endif>{{$ulkevalue->global_name}}</option>
														                  @endforeach
														              @endif
														            </select>
																				{{--	<input class="form-control" type='text' name='yuklemeNoktasiulkekodu[{{$kmodel}}][]' value="{{$altvalue->yuklemeNoktasiulkekodu}}" /> --}}

																			</td>
																				<td><input class="form-control" type='text' name='indirmeNoktasi[{{$kmodel}}][]' value="{{$altvalue->indirmeNoktasi}}" /></td>
																				<td>
																					<select name="indirmeNoktasiulkekodu[{{$kmodel}}][]" class="form-control col-xs-2">
																					 <option value="0">{{trans("messages.seciniz")}}</option>
																					 @if(!empty($ulkeList))
																							@foreach ($ulkeList as $ulkekey => $ulkevalue)
																								<option value="{{$ulkevalue->id}}" @if ($ulkevalue->id==$altvalue->indirmeNoktasiulkekodu) selected="selected" @endif>{{$ulkevalue->global_name}}</option>
																							@endforeach
																					@endif
																				</select>
																				{{--	<input class="form-control" type='text' name='indirmeNoktasiulkekodu[{{$kmodel}}][]' value="{{$altvalue->indirmeNoktasiulkekodu}}" /> --}}
																				</td>
																				<td><input class="form-control" type='text' name='tekKap[{{$kmodel}}][]' value="{{$altvalue->tekKap}}" /></td>
																				<td><input class="form-control" type='text' name='tekKilo[{{$kmodel}}][]' value="{{$altvalue->tekKilo}}" /></td>
																				<td><input class="form-control" type='text' name='yukcinsi[{{$kmodel}}][]' value="{{$altvalue->yukcinsi}}" /></td>
																				<td><input class="form-control" type='text' name='faturanumara[{{$kmodel}}][]' value="{{$altvalue->faturanumara}}" /></td>
																				<td><input class="form-control" type='text' name='faturabedeli[{{$kmodel}}][]' value="{{$altvalue->faturabedeli}}" /></td>
																			</tr>
																		@endforeach
																	@break
																	@case("t2")
																			<thead>
																				<th>{{trans("messages.gumrukno")}}</th>
																				<th>{{trans("messages.varisgumruk")}}</th>
																				<th>{{trans("messages.mrnnumber")}}</th>
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
 																		@foreach($submodel as $altkey=>$altvalue)
																			<tr id="sampletr{{$kmodel}}">

																					<td>{{$altvalue->gumrukId+1}}</td>
																					<td><input class="form-control varisGumruk" type='text' name='varisGumruk[{{$kmodel}}][]' value="{{$altvalue->varisGumruk}}" /></td>
																					<td><input class="form-control" type='text' name='mrnnumber[{{$kmodel}}][]' value="{{$altvalue->mrnnumber}}" /></td>
																					<td><input class="form-control" type='text' name='yuklemeNoktasi[{{$kmodel}}][]' value="{{$altvalue->yuklemeNoktasi}}" /></td>
																					<td>
																						<select name="yuklemeNoktasiulkekodu[{{$kmodel}}][]" class="form-control col-xs-2">
															               <option value="0">{{trans("messages.seciniz")}}</option>
															               @if(!empty($ulkeList))
															                  @foreach ($ulkeList as $ulkekey => $ulkevalue)
															                    <option value="{{$ulkevalue->id}}" @if ($ulkevalue->id==$altvalue->yuklemeNoktasiulkekodu) selected="selected" @endif>{{$ulkevalue->global_name}}</option>
															                  @endforeach
															              @endif
															            </select>
																					{{--	<input class="form-control" type='text' name='yuklemeNoktasiulkekodu[{{$kmodel}}][]' value="{{$altvalue->yuklemeNoktasiulkekodu}}" /> --}}

																				</td>
																					<td><input class="form-control" type='text' name='indirmeNoktasi[{{$kmodel}}][]' value="{{$altvalue->indirmeNoktasi}}" /></td>
																					<td>
																						<select name="indirmeNoktasiulkekodu[{{$kmodel}}][]" class="form-control col-xs-2">
																						 <option value="0">{{trans("messages.seciniz")}}</option>
																						 @if(!empty($ulkeList))
																								@foreach ($ulkeList as $ulkekey => $ulkevalue)
																									<option value="{{$ulkevalue->id}}" @if ($ulkevalue->id==$altvalue->indirmeNoktasiulkekodu) selected="selected" @endif>{{$ulkevalue->global_name}}</option>
																								@endforeach
																						@endif
																					</select>
																					{{--	<input class="form-control" type='text' name='indirmeNoktasiulkekodu[{{$kmodel}}][]' value="{{$altvalue->indirmeNoktasiulkekodu}}" /> --}}
																					</td>
																					<td><input class="form-control" type='text' name='tekKap[{{$kmodel}}][]' value="{{$altvalue->tekKap}}" /></td>
																					<td><input class="form-control" type='text' name='tekKilo[{{$kmodel}}][]' value="{{$altvalue->tekKilo}}" /></td>
																					<td><input class="form-control" type='text' name='yukcinsi[{{$kmodel}}][]' value="{{$altvalue->yukcinsi}}" /></td>
																					<td><input class="form-control" type='text' name='faturanumara[{{$kmodel}}][]' value="{{$altvalue->faturanumara}}" /></td>
																					<td><input class="form-control" type='text' name='faturabedeli[{{$kmodel}}][]' value="{{$altvalue->faturabedeli}}" /></td>
																				</tr>
																			@endforeach
																	@break
																@case("passage")
																							<thead>
																	<th>{{trans("messages.gumrukno")}}</th>
																	<th>{{trans("messages.tirnumarasi")}}</th>
																	<th>{{trans("messages.gonderici")}}</th>
																	<th>{{trans("messages.ulkekodu")}}</th>
																	<th>{{trans("messages.kap")}}</th>
																	<th>{{trans("messages.kilo")}}</th>
																	<th>{{trans("messages.faturacinsi")}}</th>
																	<th>{{trans("messages.faturanumara")}}</th>
																	<th>{{trans("messages.faturabedeli")}}</th>
																</thead>
																 	@foreach($submodel as $altkey=>$altvalue)
																	<tr id="sampletr{{$kmodel}}">

																		<td><input class="form-control" type='text' name='' value="{{$altvalue->gumrukId+1}}" /></td>
																		<td><input class="form-control" type='text' name='tirnumarasi[{{$kmodel}}][]' value="{{$altvalue->tirnumarasi}}" /></td>
																		<td><input class="form-control" type='text' name='yuklemeNoktasi[{{$kmodel}}][]' value="{{$altvalue->yuklemeNoktasi}}" /></td>
																		<td>
																			<select name="yuklemeNoktasiulkekodu[{{$kmodel}}][]" class="form-control col-xs-2">
																			 <option value="0">{{trans("messages.seciniz")}}</option>
																			 @if(!empty($ulkeList))
																					@foreach ($ulkeList as $ulkekey => $ulkevalue)
																						<option value="{{$ulkevalue->id}}" @if ($ulkevalue->id==$altvalue->yuklemeNoktasiulkekodu) selected="selected" @endif>{{$ulkevalue->global_name}}</option>
																					@endforeach
																			@endif
																		</select>
																		{{--	<input class="form-control" type='text' name='yuklemeNoktasiulkekodu[{{$kmodel}}][]' value="{{$altvalue->yuklemeNoktasiulkekodu}}" /> --}}

																	</td>
																		<td><input class="form-control" type='text' name='tekKap[{{$kmodel}}][]' value="{{$altvalue->tekKap}}" /></td>
																		<td><input class="form-control" type='text' name='tekKilo[{{$kmodel}}][]' value="{{$altvalue->tekKilo}}" /></td>
																		<td><input class="form-control" type='text' name='yukcinsi[{{$kmodel}}][]' value="{{$altvalue->yukcinsi}}" /></td>
																		<td><input class="form-control" type='text' name='faturanumara[{{$kmodel}}][]' value="{{$altvalue->faturanumara}}" /></td>
																		<td><input class="form-control" type='text' name='faturabedeli[{{$kmodel}}][]' value="{{$altvalue->faturabedeli}}" /></td>
																	</tr>
																	@endforeach
																@break
																@case("t1kapama")
																<thead>
																	<th>{{trans("messages.gumrukno")}}</th>
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
 															@foreach($submodel as $altkey=>$altvalue)
																<tr id="sampletr{{$kmodel}}">
																		<td><input class="form-control" type='text' name='' value="{{$altvalue->gumrukId+1}}" /></td>
																		<td><input class="form-control" type='text' name='baslangicGumruk[{{$kmodel}}][]' value="{{$altvalue->baslangicGumruk}}" /></td>

																		<td><input class="form-control" type='text' name='yuklemeNoktasi[{{$kmodel}}][]' value="{{$altvalue->yuklemeNoktasi}}" /></td>
																		<td>
																			<select name="yuklemeNoktasiulkekodu[{{$kmodel}}][]" class="form-control col-xs-2">
																			 <option value="0">{{trans("messages.seciniz")}}</option>
																			 @if(!empty($ulkeList))
																					@foreach ($ulkeList as $ulkekey => $ulkevalue)
																						<option value="{{$ulkevalue->id}}" @if ($ulkevalue->id==$altvalue->yuklemeNoktasiulkekodu) selected="selected" @endif>{{$ulkevalue->global_name}}</option>
																					@endforeach
																			@endif
																		</select>
																		{{--	<input class="form-control" type='text' name='yuklemeNoktasiulkekodu[{{$kmodel}}][]' value="{{$altvalue->yuklemeNoktasiulkekodu}}" /> --}}

																	</td>
																		<td><input class="form-control varisGumruk" type='text' name='varisGumruk[{{$kmodel}}][]' value="{{$altvalue->varisGumruk}}" /></td>
																		<td><input class="form-control" type='text' name='indirmeNoktasi[{{$kmodel}}][]' value="{{$altvalue->indirmeNoktasi}}" /></td>
																		<td>
																			<select name="indirmeNoktasiulkekodu[{{$kmodel}}][]" class="form-control col-xs-2">
																			 <option value="0">{{trans("messages.seciniz")}}</option>
																			 @if(!empty($ulkeList))
																					@foreach ($ulkeList as $ulkekey => $ulkevalue)
																						<option value="{{$ulkevalue->id}}" @if ($ulkevalue->id==$altvalue->indirmeNoktasiulkekodu) selected="selected" @endif>{{$ulkevalue->global_name}}</option>
																					@endforeach
																			@endif
																		</select>
																		{{--	<input class="form-control" type='text' name='indirmeNoktasiulkekodu[{{$kmodel}}][]' value="{{$altvalue->indirmeNoktasiulkekodu}}" /> --}}
																		</td>
																		<td><input class="form-control" type='text' name='tekKap[{{$kmodel}}][]' value="{{$altvalue->tekKap}}" /></td>
																		<td><input class="form-control" type='text' name='tekKilo[{{$kmodel}}][]' value="{{$altvalue->tekKilo}}" /></td>
																		<td><input class="form-control" type='text' name='yukcinsi[{{$kmodel}}][]' value="{{$altvalue->yukcinsi}}" /></td>
																		<td><input class="form-control" type='text' name='faturanumara[{{$kmodel}}][]' value="{{$altvalue->faturanumara}}" /></td>
																		<td><input class="form-control" type='text' name='faturabedeli[{{$kmodel}}][]' value="{{$altvalue->faturabedeli}}" /></td>
																	</tr>
																@endforeach
																@case("tir")
																<thead>
																	<th>{{trans("messages.gumrukno")}}</th>
																	<th>{{trans("messages.tirnumarasi")}}</th>
																	<th>{{trans("messages.gonderici")}}</th>
																	<th>{{trans("messages.ulkekodu")}}</th>
																	<th>{{trans("messages.kap")}}</th>
																	<th>{{trans("messages.kilo")}}</th>

																	<th>{{trans("messages.faturacinsi")}}</th>
																	<th>{{trans("messages.faturanumara")}}</th>
																	<th>{{trans("messages.faturabedeli")}}</th>
																</thead>
 															@foreach($submodel as $altkey=>$altvalue)
																<tr id="sampletr{{$kmodel}}">
																		<td><input class="form-control" type='text' name='' value="{{$altvalue->gumrukId+1}}" /></td>
																		<td><input class="form-control" type='text' name='tirnumarasi[{{$kmodel}}][]' value="{{$altvalue->tirnumarasi}}" /></td>
																		<td><input class="form-control" type='text' name='yuklemeNoktasi[{{$kmodel}}][]' value="{{$altvalue->yuklemeNoktasi}}" /></td>
																		<td>
																			<select name="yuklemeNoktasiulkekodu[{{$kmodel}}][]" class="form-control col-xs-2">
																			 <option value="0">{{trans("messages.seciniz")}}</option>
																			 @if(!empty($ulkeList))
																					@foreach ($ulkeList as $ulkekey => $ulkevalue)
																						<option value="{{$ulkevalue->id}}" @if ($ulkevalue->id==$altvalue->yuklemeNoktasiulkekodu) selected="selected" @endif>{{$ulkevalue->global_name}}</option>
																					@endforeach
																			@endif
																		</select>
																		{{--	<input class="form-control" type='text' name='yuklemeNoktasiulkekodu[{{$kmodel}}][]' value="{{$altvalue->yuklemeNoktasiulkekodu}}" /> --}}

																	</td>
																		<td><input class="form-control" type='text' name='tekKap[{{$kmodel}}][]' value="{{$altvalue->tekKap}}" /></td>
																		<td><input class="form-control" type='text' name='tekKilo[{{$kmodel}}][]' value="{{$altvalue->tekKilo}}" /></td>
																		<td><input class="form-control" type='text' name='yukcinsi[{{$kmodel}}][]' value="{{$altvalue->yukcinsi}}" /></td>
																		<td><input class="form-control" type='text' name='faturanumara[{{$kmodel}}][]' value="{{$altvalue->faturanumara}}" /></td>
																		<td><input class="form-control" type='text' name='faturabedeli[{{$kmodel}}][]' value="{{$altvalue->faturabedeli}}" /></td>
																	</tr>
																@endforeach
																@break
																@case("ata")
																<thead>
																	<th>{{trans("messages.gumrukno")}}</th>
																	<th>{{trans("messages.tirnumarasi")}}</th>
																	<th>{{trans("messages.gonderici")}}</th>
																	<th>{{trans("messages.ulkekodu")}}</th>
																	<th>{{trans("messages.kap")}}</th>
																	<th>{{trans("messages.kilo")}}</th>

																	<th>{{trans("messages.faturacinsi")}}</th>
																	<th>{{trans("messages.faturanumara")}}</th>
																	<th>{{trans("messages.faturabedeli")}}</th>
																</thead>
 															@foreach($submodel as $altkey=>$altvalue)
																		<tr id="sampletr{{$kmodel}}">
																		<td>{{$altvalue->gumrukId+1}}</td>
																		<td><input class="form-control" type='text' name='tirnumarasi[{{$kmodel}}][]' value="{{$altvalue->tirnumarasi}}" /></td>
																		<td><input class="form-control" type='text' name='yuklemeNoktasi[{{$kmodel}}][]' value="{{$altvalue->yuklemeNoktasi}}" /></td>
																		<td>
																			<select name="yuklemeNoktasiulkekodu[{{$kmodel}}][]" class="form-control col-xs-2">
																			 <option value="0">{{trans("messages.seciniz")}}</option>
																			 @if(!empty($ulkeList))
																					@foreach ($ulkeList as $ulkekey => $ulkevalue)
																						<option value="{{$ulkevalue->id}}" @if ($ulkevalue->id==$altvalue->yuklemeNoktasiulkekodu) selected="selected" @endif>{{$ulkevalue->global_name}}</option>
																					@endforeach
																			@endif
																		</select>
																		{{--	<input class="form-control" type='text' name='yuklemeNoktasiulkekodu[{{$kmodel}}][]' value="{{$altvalue->yuklemeNoktasiulkekodu}}" /> --}}

																	</td>
																		<td><input class="form-control" type='text' name='tekKap[{{$kmodel}}][]' value="{{$altvalue->tekKap}}" /></td>
																		<td><input class="form-control" type='text' name='tekKilo[{{$kmodel}}][]' value="{{$altvalue->tekKilo}}" /></td>
																		<td><input class="form-control" type='text' name='yukcinsi[{{$kmodel}}][]' value="{{$altvalue->yukcinsi}}" /></td>
																		<td><input class="form-control" type='text' name='faturanumara[{{$kmodel}}][]' value="{{$altvalue->faturanumara}}" /></td>
																		<td><input class="form-control" type='text' name='faturabedeli[{{$kmodel}}][]' value="{{$altvalue->faturabedeli}}" /></td>
																	</tr>
																@endforeach
																@break
																@case("listex")
																<thead>
																	<th>{{trans("messages.gumrukno")}}</th>
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
 															@foreach($submodel as $altkey=>$altvalue)
																	<tr id="sampletr{{$kmodel}}">
																		<td>{{$altvalue->gumrukId+1}}</td>
																		<td><input class="form-control varisGumruk" type='text' name='varisGumruk[{{$kmodel}}][]' value="{{$altvalue->varisGumruk}}" /></td>
																		<td><input class="form-control" type='text' name='yuklemeNoktasi[{{$kmodel}}][]' value="{{$altvalue->yuklemeNoktasi}}" /></td>
																		<td>
																			<select name="yuklemeNoktasiulkekodu[{{$kmodel}}][]" class="form-control col-xs-2">
																			 <option value="0">{{trans("messages.seciniz")}}</option>
																			 @if(!empty($ulkeList))
																					@foreach ($ulkeList as $ulkekey => $ulkevalue)
																						<option value="{{$ulkevalue->id}}" @if ($ulkevalue->id==$altvalue->yuklemeNoktasiulkekodu) selected="selected" @endif>{{$ulkevalue->global_name}}</option>
																					@endforeach
																			@endif
																		</select>
																		{{--	<input class="form-control" type='text' name='yuklemeNoktasiulkekodu[{{$kmodel}}][]' value="{{$altvalue->yuklemeNoktasiulkekodu}}" /> --}}

																	</td>
																		<td><input class="form-control" type='text' name='indirmeNoktasi[{{$kmodel}}][]' value="{{$altvalue->indirmeNoktasi}}" /></td>
																		<td>
																			<select name="indirmeNoktasiulkekodu[{{$kmodel}}][]" class="form-control col-xs-2">
																			 <option value="0">{{trans("messages.seciniz")}}</option>
																			 @if(!empty($ulkeList))
																					@foreach ($ulkeList as $ulkekey => $ulkevalue)
																						<option value="{{$ulkevalue->id}}" @if ($ulkevalue->id==$altvalue->indirmeNoktasiulkekodu) selected="selected" @endif>{{$ulkevalue->global_name}}</option>
																					@endforeach
																			@endif
																		</select>
																		{{--	<input class="form-control" type='text' name='indirmeNoktasiulkekodu[{{$kmodel}}][]' value="{{$altvalue->indirmeNoktasiulkekodu}}" /> --}}
																		</td>
																		<td><input class="form-control" type='text' name='tekKap[{{$kmodel}}][]' value="{{$altvalue->tekKap}}" /></td>
																		<td><input class="form-control" type='text' name='tekKilo[{{$kmodel}}][]' value="{{$altvalue->tekKilo}}" /></td>
																		<td><input class="form-control" type='text' name='yukcinsi[{{$kmodel}}][]' value="{{$altvalue->yukcinsi}}" /></td>
																		<td><input class="form-control" type='text' name='faturanumara[{{$kmodel}}][]' value="{{$altvalue->faturanumara}}" /></td>
																		<td><input class="form-control" type='text' name='faturabedeli[{{$kmodel}}][]' value="{{$altvalue->faturabedeli}}" /></td>
																	</tr>
																@endforeach

																@break
																@case("ithalatimport")
															<thead>
																	<th>{{trans("messages.gumrukno")}}</th>
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
 	@foreach($submodel as $altkey=>$altvalue)
																	<tr id="sampletr{{$kmodel}}">
																		<td>{{$altvalue->gumrukId+1}}</td>
																		<td><input class="form-control varisGumruk" type='text' name='varisGumruk[{{$kmodel}}][]' value="{{$altvalue->varisGumruk}}" /></td>
																		<td><input class="form-control" type='text' name='yuklemeNoktasi[{{$kmodel}}][]' value="{{$altvalue->yuklemeNoktasi}}" /></td>
																		<td>
																			<select name="yuklemeNoktasiulkekodu[{{$kmodel}}][]" class="form-control col-xs-2">
																			 <option value="0">{{trans("messages.seciniz")}}</option>
																			 @if(!empty($ulkeList))
																					@foreach ($ulkeList as $ulkekey => $ulkevalue)
																						<option value="{{$ulkevalue->id}}" @if ($ulkevalue->id==$altvalue->yuklemeNoktasiulkekodu) selected="selected" @endif>{{$ulkevalue->global_name}}</option>
																					@endforeach
																			@endif
																		</select>
																		{{--	<input class="form-control" type='text' name='yuklemeNoktasiulkekodu[{{$kmodel}}][]' value="{{$altvalue->yuklemeNoktasiulkekodu}}" /> --}}

																	</td>
																		<td><input class="form-control" type='text' name='indirmeNoktasi[{{$kmodel}}][]' value="{{$altvalue->indirmeNoktasi}}" /></td>
																		<td>
																			<select name="indirmeNoktasiulkekodu[{{$kmodel}}][]" class="form-control col-xs-2">
																			 <option value="0">{{trans("messages.seciniz")}}</option>
																			 @if(!empty($ulkeList))
																					@foreach ($ulkeList as $ulkekey => $ulkevalue)
																						<option value="{{$ulkevalue->id}}" @if ($ulkevalue->id==$altvalue->indirmeNoktasiulkekodu) selected="selected" @endif>{{$ulkevalue->global_name}}</option>
																					@endforeach
																			@endif
																		</select>
																		{{--	<input class="form-control" type='text' name='indirmeNoktasiulkekodu[{{$kmodel}}][]' value="{{$altvalue->indirmeNoktasiulkekodu}}" /> --}}
																		</td>
																		<td><input class="form-control" type='text' name='tekKap[{{$kmodel}}][]' value="{{$altvalue->tekKap}}" /></td>
																		<td><input class="form-control" type='text' name='tekKilo[{{$kmodel}}][]' value="{{$altvalue->tekKilo}}" /></td>
																		<td><input class="form-control" type='text' name='yukcinsi[{{$kmodel}}][]' value="{{$altvalue->yukcinsi}}" /></td>
																		<td><input class="form-control" type='text' name='faturanumara[{{$kmodel}}][]' value="{{$altvalue->faturanumara}}" /></td>
																		<td><input class="form-control" type='text' name='faturabedeli[{{$kmodel}}][]' value="{{$altvalue->faturabedeli}}" /></td>
																	</tr>
@endforeach
																@break
																@case("bondeshortie")
																<thead>
																	<th>{{trans("messages.plaka")}}</th>
																	<th>{{trans("messages.gonderici")}}</th>

																</thead>
																@break
																@case("ext1t2")
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
 	@foreach($submodel as $altkey=>$altvalue)
																	<tr id="sampletr{{$kmodel}}">
																		<td>{{$altvalue->gumrukId+1}}</td>
																		<td><input class="form-control" type='text' name='mrnnumber[{{$kmodel}}][]' value="{{$altvalue->mrnnumber}}" /></td>
																		<td><input class="form-control varisGumruk" type='text' name='varisGumruk[{{$kmodel}}][]' value="{{$altvalue->varisGumruk}}" /></td>
																		<td><input class="form-control" type='text' name='yuklemeNoktasi[{{$kmodel}}][]' value="{{$altvalue->yuklemeNoktasi}}"</td>
																		<td>
																			<select name="yuklemeNoktasiulkekodu[{{$kmodel}}][]" class="form-control col-xs-2">
																			 <option value="0">{{trans("messages.seciniz")}}</option>
																			 @if(!empty($ulkeList))
																					@foreach ($ulkeList as $ulkekey => $ulkevalue)
																						<option value="{{$ulkevalue->id}}" @if ($ulkevalue->id==$altvalue->yuklemeNoktasiulkekodu) selected="selected" @endif>{{$ulkevalue->global_name}}</option>
																					@endforeach
																			@endif
																		</select>
																		{{--	<input class="form-control" type='text' name='yuklemeNoktasiulkekodu[{{$kmodel}}][]' value="{{$altvalue->yuklemeNoktasiulkekodu}}" /> --}}

																	</td>
																		<td><input class="form-control" type='text' name='indirmeNoktasi[{{$kmodel}}][]' value="{{$altvalue->indirmeNoktasi}}" /></td>
																		<td>
																			<select name="indirmeNoktasiulkekodu[{{$kmodel}}][]" class="form-control col-xs-2">
																			 <option value="0">{{trans("messages.seciniz")}}</option>
																			 @if(!empty($ulkeList))
																					@foreach ($ulkeList as $ulkekey => $ulkevalue)
																						<option value="{{$ulkevalue->id}}" @if ($ulkevalue->id==$altvalue->indirmeNoktasiulkekodu) selected="selected" @endif>{{$ulkevalue->global_name}}</option>
																					@endforeach
																			@endif
																		</select>
																		{{--	<input class="form-control" type='text' name='indirmeNoktasiulkekodu[{{$kmodel}}][]' value="{{$altvalue->indirmeNoktasiulkekodu}}" /> --}}
																		</td>
																		<td><input class="form-control" type='text' name='tekKap[{{$kmodel}}][]' value="{{$altvalue->tekKap}}" /></td>
																		<td><input class="form-control" type='text' name='tekKilo[{{$kmodel}}][]' value="{{$altvalue->tekKilo}}" /></td>
																		<td><input class="form-control" type='text' name='yukcinsi[{{$kmodel}}][]' value="{{$altvalue->yukcinsi}}" /></td>
																		<td><input class="form-control" type='text' name='faturanumara[{{$kmodel}}][]' value="{{$altvalue->faturanumara}}" /></td>
																		<td><input class="form-control" type='text' name='faturabedeli[{{$kmodel}}][]' value="{{$altvalue->faturabedeli}}" /></td>
																	</tr>
@endforeach
																@break
														@endswitch
													@endif


													@if (!empty($talimat->altmodel))
														@php ($toplamkap = 0)
														@php ($toplamkilo = 0)
															@foreach($talimat->altmodel as $kmodel=>$altvalue)
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

												</tbody>
										</table>

							</div>
							@endforeach
              </div>
              <br />


   		</div>
		</div>
		<div class="col-md-12 border p-2">
		 <div class="form-group col-md-4 temizlenebilir">
			<h3>{{trans("messages.aciklama")}}</h3>
			<textarea class="form-control" rows="6" name="aciklama">{{$talimat->note}}</textarea>
		</div>
		</div>

		</div>

   </div>
	 @include('submits.forms')

</form>

@endsection
