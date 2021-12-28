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
	console.log(newsample);
	console.log(adet);
  var num = parseInt( newsample.match(/\d+/g), 10 );
  //alert(num);
	//$(sample).parent().children( 'tr:not(:first)' ).remove();

	$(sample).parent().children( 'tr:not(:first)' ).remove();
	for (i=1;i<adet;i++)
	{
		console.log(i);
		$(sample).parent().append("<tr>"+newsample+"</tr>");

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


function openFileModal(kacinci,t)
{

	$.get("/dosya/getir/"+kacinci+"/"+t, function(data, status)
	{
			$("#evrakbolumu_"+kacinci).html(data);
	});
}
</script>
@endsection

@section('content')
<form action='/arac/ihracat/savet2' method="post" name='a' id='actionFormElement' enctype="multipart/form-data"   onsubmit="return kontrolformtoaction()">
	{{ csrf_field() }}
      <input type='hidden' name="extalimatIdKapanacak" value="{{$talimat->id}}" />
      <div class='row' style='margin-left:2px;margin-top:4px;background: #FFF;'>

       		<div class='col-md-12 border pt-5'>
       		<h2>{{trans("messages.ex1t2")}}</h2>
       		<br />
					<div class="row">
							<div class="col-md-4">
								<label for="autoBarcode">{{trans("messages.autoBarcode")}}</label>
								<input type='text' readonly name="autoBarcode" id="autoBarcode" value="{{$barcode}}" class="form-control" />
							</div>
							<div class="form-group col-md-4 temizlenebilir">
						<label for="bolgeSecim">{{trans("messages.bolge")}}</label>
						@if (\Auth::user()->role=="admin" || \Auth::user()->role=="bolgeadmin")

								<select name='bolgeSecim' class="form-control"  id="bolgeSecim">

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
							 <input type="text" class="form-control" name='externalFirma' id="externalFirma">
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
										<option value="t2">T2</option>
                  </select>
								 @endif
							</div>

			 				</div>
					 <div class='row'>
             <script>
               $( document ).ready(function() {
                   openFileModal(0,{{count($altmodel[0])}});
               });
               </script>
						</div>
            <div id='idXLKO'></div>
            	<ul class="nav nav-tabs" id="myTab">
								@foreach($altmodel as $kmodel=>$altvalue)
               	<li class="nav-item">
									<a class="nav-link" id="bir-{{$kmodel+1}}" data-toggle="tab" href="#tab-{{$kmodel+1}}" role="tab" aria-controls="bir" aria-selected="false"> {{trans("messages.gumruk")}} {{$kmodel+1}}</a>
								</li>
								@endforeach
              </ul>
              <div class="tab-content col-md-12 py-5  border-3" id="myTabContent" >
            @foreach($altmodel as $kmodel=>$submodel)

								<div class="tab-pane  @if ($kmodel>0) fade @else active @endif" id="tab-{{$kmodel+1}}"  aria-labelledby="tab{{$kmodel+1}}" >

								  <h3>{{trans("messages.lutfengumrukbilgigiriniz")}} - {{$kmodel+1}}</h3>

								    <div class="form-group col-md-12 temizlenebilir ">
								      <label for="yukleme">{{trans("messages.alicigondericiadet")}}</label>
								        <select name="yuklemeNoktasiAdet[{{$kmodel}}][]" class="form-control d-none input-sm yuklemeNoktasi " data-num="1" onchange="noktalarIcinAlanOlustur(this,{{$kmodel}})" >
								          @for ($i = 1; $i < 100; $i++)
								               <option value="{{ $i }}" @if (count($submodel)==$i) selected @endif>{{ $i }}</option>
								          @endfor
								        </select>
								      </div>

								      <hr />
											<table class="table table-bordered malYuklemeBosaltmaTablolari" width="100%" cellspacing="0">
											@if (!empty($talimat->altmodel))
														@switch($talimat->talimatTipi)
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

																			<tr id="sampletr{{$altkey}}">

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
																	<tr id="sampletr{{$altkey}}">
																		<td>{{$altvalue->gumrukId+1}}</td>
																		<td><input class="form-control" type='text' name='mrnnumber[{{$kmodel}}][]' value="{{$altvalue->mrnnumber}}" required /></td>
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
              <div>
              <h2>{{trans("messages.ozelevrakyuklemebaslik")}}</h2>
              <hr />
                <div id="evrakbolumu_0">

                </div>
            </div>
              @endforeach
              </div>

              <br />


   		</div>
		</div>


		</div>
    <h2>{{trans("messages.talimatevrakyuklemebaslik")}}</h2>
		<br />
			<div class="form-group col-md-12">
									<label for="gallery-photo-add">{{trans("messages.evrakyukle")}}</label>
									<small>{{trans("messages.evrakyuklealt")}}</small>
									<input type="file" name='files[]' class='form-control' multiple id="gallery-photo-add">
										<div id='dgalleryd' class="gallery"></div>
								</div>
		</div>

	</div>
  <div class='row' style='margin-left:2px;margin-top:4px;background: #FFF;'>
  <div class='col-md-12 border'>
		<div class='row' style='margin-left:2px;margin-top:4px;background: #FFF;'>
				<div class='col-md-12 border'>
					<div class="row">
							<div class="col-md-6">
								<h2>{{trans("messages.muhasebeheader")}}</h2>
									<br />
										<div class="form-group col-md-12">
											<label for="kimyapmis">{{trans("messages.kayityapanismi")}}</label>
											<input type="text" name='kayitismi' class='form-control' value="{{\Auth::user()->name}}" readonly="readonly" />
										</div>
										<div class="form-group col-md-12">
											<label for="">{{trans("messages.faturabedel")}}</label>
											<select name='odemecinsi' id='' class="form-control">
													 <option value="cari">{{ trans("messages.cariodeme") }}</option>
													 <option value="nakit">{{ trans("messages.nakitodeme") }}</option>
											</select>
										</div>
										<div class="form-group col-md-12">
											<label for="">{{trans("messages.faturabedeli")}}</label>
											<input type="text" name='talimatbedeli' class='form-control' id="faturabedeli" />
										</div>
										<div class="form-group col-md-12">
											<label for="">{{trans("messages.parabirimi")}}</label>
											<select name='moneytype' class="form-control" >
													<option value='TL'>TL</option>
													<option value='EURO'>Euro</option>
													<option value='DOLAR'>Dolar</option>
													<option value='POUND'>Pound</option>
											</select>
										</div>
							</div>
							<div class="col-md-4 offset-md-2" id="fiyatlamagoster">


							</div>
					</div>


		</div>

	</div>
</div>

</div>
   </div>

	 @include('submits.forms')

</form>

@endsection
