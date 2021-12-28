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


	$("#cekiciPlaka").removeClass("d-none");
	$("#dorsePlaka").removeClass("d-none");

	$("#labelCekici").removeClass("d-none");
	$("#labelDorse").removeClass("d-none");


	var firmaId=$("#firmaXixD").val();
	if (firmaId<1) {alert("{{trans('messages.firmaseciniz')}}"); $(t).val(0);return false;}

	switch (data) {
		case "bondeshortie":
			$("#cekiciPlaka").addClass("d-none");
			$("#dorsePlaka").addClass("d-none");
			$("#labelCekici").addClass("d-none");
			$("#labelDorse").addClass("d-none");
		break;
		case "ithalatimport":
			$("#cekiciPlaka").removeClass("d-none");
			$("#dorsePlaka").removeClass("d-none");
			$("#labelCekici").removeClass("d-none");
			$("#labelDorse").removeClass("d-none");

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
var num = parseInt( newsample.match(/\d+/g), 10 );
	//$(sample).parent().children( 'tr:not(:first)' ).remove();
	$(sample).parent().children( 'tr:not(:first)' ).remove();
	for (i=1;i<adet;i++)
	{
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
	@if (\Auth::user()->role=='admin')
		var firmaid=$("#firmaXixD").val();
	@else
		var firmaid={{\Auth::user()->id}}
	@endif

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
		var firmaId=$("#firmaXixD").val();
		var t;

		$("#myTab").children().remove();
		$("#myTabContent").children().remove();

		$.get("/arac/talimatgetir/"+talimatTipi+"/"+say+"/"+firmaId,
	   function(data, status){
			 	$("#myTabContent").children().remove();
					$.each(data, function (index, value)
							 {

								 	$("#myTabContent").append(value);

								});
								for(t=1;t<=say;t++)
								{
										$("#myTab").append('<li class="nav-item"><a class="nav-link " id="linktab-'+t+'" data-toggle="tab" href="#tab-'+t+'" role="tab" aria-controls="tab'+t+'" aria-selected="false"> {{trans("messages.gumruk")}} '+(t)+' </a>');
								}

								$(".varisGumruk").easyAutocomplete(options);

								$(".yukcinsi").easyAutocomplete(optionsAJAX);
	   });


		 var firmaId=$("#firmaXixD").val();
		 muhasebeDataGetir(talimatTipi,firmaId);


}


function muhasebeDataGetir(tip,firma)
{
		$.get("/muhasebe/fiyatgetir/"+tip+"/"+firma, function(data, status){

			//	console.log(data);

				$("#fiyatlamagoster").children().remove();
				$("#fiyatlamagoster").append("<div class='alert alert-info'>{{trans('messages.birimfiyati')}} "+data.talimattipi+" "+data.fiyat+" "+data.fiyatbirim+"</div>");
				var say=$("#nmo").val();
				$("#faturabedel").val(data.fiyat*say);
				//console.log();
		});
}
</script>
@endsection

@section('content')
<form action='/arac/ithalat/save' method="post" name='a' id='actionFormElement' enctype="multipart/form-data"   onsubmit="return confirm('{{trans("messages.formconfirm")}}');">
	{{ csrf_field() }}
      <div class='row' style='margin-left:2px;margin-top:4px;background: #FFF;'>

       		<div class='col-md-12 border pt-5'>
       		<h2>{{trans("messages.ithalatimport")}}</h2>
       		<br />
					<div class="row">
							<div class="col-md-4">
								<label for="autoBarcode">{{trans("messages.autoBarcode")}}</label>
								<input type='text' readonly name="autoBarcode" id="autoBarcode" value="{{$barcode}}" class="form-control" />
							</div>
							<div class="form-group col-md-4 temizlenebilir">
						<label for="bolgeSecim">{{trans("messages.bolge")}}</label>
						@if (\Auth::user()->role=="admin")
								<select name='bolgeSecim' class="form-control"  id="" >
										<option value='0'>({{trans("messages.choose")}})</option>
											@if (!empty($bolge))
												@foreach($bolge as $z=>$m)
													<option value='{{$m->id}}'>{{$m->name}}</option>
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
									<input type="hidden" value="{{\Auth::user()->bolgeId}}" name="bolgeSecim"  />
						@endif
							</div>
					</div>
					 <br />
       		 <div class='row'>
           	 @if (\Auth::user()->role=='admin' || \Auth::user()->role="bolgeadmin")
           		<div class="form-group col-md-4">
							<label for="firmaId">{{trans("messages.companyname")}}</label>
           		@if (!empty($userlist))
           		<select name='firmaId' class="form-control"  id="firmaXixD"  onchange="getPlakaList()" >
								<option value='0'>({{trans("messages.choose")}})</option>
           			@foreach($userlist as $z=>$m)
           				<option value='{{$m["id"]}}'>{{$m["name"]}}</option>
           			@endforeach
           		</select>

           		@endif

         		 </div>

           	@else
           	   <div class="form-group col-md-4">
                  <label for="orderNo">{{trans("messages.companyname")}}</label>
                  <input type='hidden' name='firmaId'  value='{{\Auth::user()->id}}'  id="firmaXixD" />
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
                		<label for="cekiciPlaka"  id="labelCekici">{{trans("messages.cekiciplaka")}}</label>
                    <input type="text" class="form-control" name='cekiciPlaka' id="cekiciPlaka" >
                  </div>
									<div class="form-group col-md-4 temizlenebilir">
										<label for="dorsePlaka" id="labelDorse" >{{trans("messages.dorseplaka")}}</label>
										<input type="text" class="form-control" name='dorsePlaka' id="dorsePlaka" placeholder="Dorse Çekici Plaka">
									</div>
              </div>
							  <div class='row'>
						 <div class="form-group col-md-4 temizlenebilir">
								<label for="" id="">{{trans("messages.talimat")}}</label>


									<select name='talimatTipi' class="form-control" id='talimatTipi' onchange='changeTalimatData(this)'>
											<option value='0'>({{trans("messages.choose")}})</option>
											@if (\Auth::user()->role!='admin')
												@if (in_array("bondeshortie", $yetkiler))
													<option value="bondeshortie">{{trans("messages.bondeshortie")}}</option>
												@endif
												@if(in_array("ithalatimport", $yetkiler))
													<option value="ithalatimport">{{trans("messages.ithalatimport")}}</option>
												@endif
											@else
													<option value="bondeshortie">{{trans("messages.bondeshortie")}}</option>
													<option value="ithalatimport">{{trans("messages.ithalatimport")}}</option>
											@endif

								</select>

							</div>

							<div class="form-group col-md-4 temizlenebilir d-none">
								<label for="gumrukAdedi">{{trans("messages.gumrukadet")}}</label>
								<select name='gumrukAdedi' id='nmo' class="form-control d-none" onchange='addTabData()'>
									<!-- <option value='0'>({{trans("messages.choose")}})</option> -->
									 @for ($i = 1; $i < 2; $i++)
										 <option value="{{ $i }}">{{ $i }}</option>
									 @endfor
								</select>
							</div>

			 				</div>
					 <div class='row'>

						</div>
            <div id='idXLKO'></div>
            	<ul class="nav nav-tabs" id="myTab">
               	<li class="nav-item">

								</li>
              </ul>
              <div class="tab-content col-md-12 py-5  border-3" id="myTabContent" >


              </div>
              <br />


   		</div>
		</div>
		<div class='col-12' style='margin-left:2px;margin-top:4px;background: #FFF;'>
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
									<input type="text" name='faturabedeli' class='form-control' id="faturabedel" />
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
			<div class='row' style='margin-left:2px;margin-top:4px;background: #FFF;'>
					<div class='col-md-12 border'>
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

   </div>
	 	 @include('submits.forms')

</form>

@endsection
