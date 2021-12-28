@extends('layouts.app')

@section('kirinti')
	{{trans("messages.talimatduzenlebaslik")}}
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/easy-autocomplete/1.3.5/jquery.easy-autocomplete.min.js"></script>


<script>
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



function noktalarIcinAlanOlustur(t,kacinci)
{
	var adet=$(t).val();
	var i=1;
	$(t).parent().parent().children("div").children(".malYuklemeBosaltmaTablolari").children("tbody").empty();
	for (i = 1; i <= adet; i++)
	{
		$(t).parent().parent().children("div").children(".malYuklemeBosaltmaTablolari").children("tbody").append(''+
		'<tr>'+
        	'<td>'+i+'</td>'+
            '<td><input type="text" class="form-control" name="yuklemeNoktasi['+kacinci+'][]" required="required"/></td>'+
            '<td><input type="text" class="form-control" name="indirmeNoktasi['+kacinci+'][]" required="required"/></td>'+
            '<td><input type="text" class="form-control hesaplanacakKap" name="tekKap['+kacinci+'][]" required="required" onchange="hesaplaKapKilo('+kacinci+')"/></td>'+
            '<td><input type="text" class="form-control  hesaplanacakKilo" name="tekKilo['+kacinci+'][]" required="required"  onchange="hesaplaKapKilo('+kacinci+')"/></td>'+
         '</tr>'+
		+'');
	}


}


function hesaplaKapKilo(kim)
{
	var toplamkilo=0;
	var toplamkap=0;

	$( "input[type=text][name^='tekKap["+kim+"]']" ).each(function( index ) {
		if (jQuery.type(parseInt($( this ).val()))=='number')
		{
			if (!isNaN(parseInt($( this ).val())))
			{
				toplamkap+=parseInt($( this ).val());
			}
		}
		});

	$( "input[type=text][name^='tekKilo["+kim+"]']"  ).each(function( index ) {
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



$(document).ready(function() {

	@if (\Auth::user()->role=='watcher')
		getPlakaList();
	@endif
	$(".varisGumruk").easyAutocomplete(options);

    $('#gallery-photo-add').on('change', function() {


    	var fileInput = document.getElementById('gallery-photo-add');
    	var filename ='';
    	$("#div.gallery").html('');
        for (i = 0; i < fileInput.files.length; i++)
            {
    			filename = fileInput.files[i].name;
    			$("#dgalleryd").append("<div class='alert alert-info'>"+filename+"</div>");

            }
    });




});


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


function addTabData()
{
	/*

	    '<div class="form-group col-md-8 temizlenebilir">'+
    '  <label for="malCinsi">Mal Cinsi</label>'+
    '   <select name="malCinsi[]" class="form-control" >'+
 	'        <option value="komple">Komple</option>'+
    '	 	<option value="parsiyal">Parsiyel</option>'+

    '	 </select>'+
    ' </div>  '+




	*/

	var adet=$("#nmo").val();
	$("#myTab").html("");
	$("#myTabContent").html("");


	var f=''+
        '<br />'+
    '<div class="row"> <div class="form-group col-md-4 temizlenebilir">'+
     ' <label for="varisGumrugu">{{trans("messages.varisgumruk")}}</label>'+
     ' <input type="text" class="form-control varisGumruk" size="25" name="varisGumrugu[]" id="" placeholder={{trans("messages.varisgumruk")}}"  required="required">'+
    '</div></div>'+
    ' <div class="row">        	  <div class="form-group col-md-4 temizlenebilir">'+
     '<label for="adr">{{trans("messages.ADR")}}</label>'+
              	 '<select name="adr[]" class="form-control" >'+
              	 '	<option value="no">{{trans("messages.yok")}}</option>'+
              	' 	<option value="yes">{{trans("messages.var")}}</option>'+
              	' </select>'+
             ' </div> </div>'+
     		'  <div class="row"><div class="form-group col-md-4 temizlenebilir">'+
             ' 	  <label for="talimatTipi">{{trans("messages.talimattipi")}}</label>'+
              	 @if (!empty($talimatList))
              '	 <select name="talimatTipi[]" class="form-control" id="" onchange="karneBilgisiEkle(this)">'+
              	 	@foreach($talimatList as $key=>$value)
                  	 ' <option value="{{ $value->kisaKod }}">{{ $value->kodName }}</option>'+
                  	@endforeach
              	' </select>'+
              	 @endif
              	' <div class=" form-group temizlenebilir col-md-12 karnecik  hidden" id="" >'+
               	'	<label for="karneAciklama">{{trans("messages.tirkarnesi")}}</label>'+
               	'	<input type="text" name="tirKarnesi[]" class="form-control" />'+
               '</div>'+
              '</div></div>' +
             	'<div class="row"><div class="form-group col-md-4 temizlenebilir">'+
                '<label for="atr">{{trans("messages.atr")}}</label>'+
                ' <select name="atr[]" class="form-control" id="" >'+
                 '         	 	<option value="no">{{trans("messages.yapilmasin")}}</option>'+
                 '         	 	<option value="yes">{{trans("messages.yapilsin")}}</option>'+
                 '         	 </select>'+
                '</div></div> '+
                '<hr />'+
                '<div class="form-group col-md-12 temizlenebilir">'+
               '   <label for="malCinsi">{{trans("messages.malcinsi")}}</label>'+
                   '<select name="malCinsi[]" class="form-control col-md-6" onchange="noktalariBaslat(this,NUMARADEGISIMDEGISKENI)" >'+
                	 '	<option value="komple">{{trans("messages.komple")}}</option>'+
                	 	'<option value="parsiyal">{{trans("messages.parsiyel")}}</option>'+
                	 '</select>'+
                	 '<br />'+
                   ' <div class="form-group col-md-12 temizlenebilir">'+
                   ' <label for="yukleme">{{trans("messages.alicigondericiadet")}}</label>'+
                   ' 		<select name="yuklemeNoktasiAdet[]" class="form-control yuklemeNoktasi col-md-6" data-num="1" onchange="noktalarIcinAlanOlustur(this,NUMARADEGISIMDEGISKENI)" >'+
          		'				<option value="1">1</option>'+
                '    		</select>'+
                '    </div>     '+
                '    <div class="form-group col-md-12 temizlenebilir malCinsiTabloları">'+
              '			<table class="table table-bordered malYuklemeBosaltmaTablolari" width="100%" cellspacing="0">'+
              '				<thead>'+
              '    				<tr>'+
              '    					<th>{{trans("messages.sira")}}</th>'+
              '    					<th >{{trans("messages.gonderici")}}</th>'+
              '    					<th>{{trans("messages.alici")}}</th>'+
              '    					<th class="col-md-2">{{trans("messages.kap")}}</th>'+
              '    					<th class="col-md-2">{{trans("messages.kilo")}}</th>'+
              '    				</tr>'+
              '				</thead>'+
              '				<tbody>'+
              '    				<tr>'+
              '						<td>1</td>'+
              '    					<td><input type="text" class="form-control" name="yuklemeNoktasi[NUMARADEGISIMDEGISKENI][]" required="required"/></td>'+
              '    					<td><input type="text" class="form-control" name="indirmeNoktasi[NUMARADEGISIMDEGISKENI][]" required="required"/></td>'+
              '<td><input type="text" class="form-control hesaplanacakKap" name="tekKap[NUMARADEGISIMDEGISKENI][]" required="required" onchange="hesaplaKapKilo(NUMARADEGISIMDEGISKENI)"/></td>'+
              '<td><input type="text" class="form-control  hesaplanacakKilo" name="tekKilo[NUMARADEGISIMDEGISKENI][]" required="required"  onchange="hesaplaKapKilo(NUMARADEGISIMDEGISKENI)"/></td>'+

              '    				</tr>'+
              '				</tbody>'+
              '			</table>'+
              '      </div>' 	 +
              '  </div>'+
              '  <hr />'+





    '<div class="form-group col-md-6 temizlenebilir">'+
    '  <label for="kap">{{trans("messages.kap")}}</label>'+
    '  <input type="text" class="form-control" readonly="readonly"  name="kap[NUMARADEGISIMDEGISKENI]" id="" placeholder="{{trans("messages.kap")}}"  required="required">'+
   ' </div>  '+
    '<div class="form-group col-md-6 temizlenebilir">'+
    '  <label for="kilo">{{trans("messages.kilo")}}</label>'+
    '  <input type="text" class="form-control" readonly="readonly" name="kilo[NUMARADEGISIMDEGISKENI]" id="" placeholder="{{trans("messages.kilo")}}"  required="required">'+
   ' </div> '+
   	'	  <div class="form-group col-md-6 temizlenebilir">'+
    '<label for="problem">{{trans("messages.problem")}}</label>'+
    ' <select name="problem[]" class="form-control" id="" onchange="openPr(this)" >'+
     '         	 	<option value="no">{{trans("messages.yok")}}</option>'+
     '         	 	<option value="yes">{{trans("messages.var")}}</option>'+
     '         	 </select>'+
     '           <div class=" form-group col-md-6  temizlenebilir problemYazi hidden" ><label for="problemAciklama ">{{trans("messages.problemaciklama")}}</label><input type="text" name="problemAciklama[]" class="form-control" /></div>'+
              '</div>'+
	'	<div class="form-group col-md-6 temizlenebilir">'+
  	'	 <label for="aciklama">{{trans("messages.aciklama")}}</label>'+
	'	<textarea class="form-control" name="aciklama[]" id="aciklama" rows="5"></textarea>'+
	'	</div>    '+
	'';



	//




	var i;
	for (i = 1; i <= adet; i++)
	{

		var rmu = f.replace(/NUMARADEGISIMDEGISKENI/g,(i-1));

		$("#myTab").append('<li class="nav-item"><a class="nav-link" id="tab-'+i+'" data-toggle="tab" href="#content-'+i+'" role="tab" aria-controls="bir" aria-selected="false">{{trans("messages.gumruk")}} '+i+'</a></li>');
		if (i==1)
		{
			$("#myTabContent").append('<div class="tab-pane active fade in" id="content-'+i+'" role="tabpanel" aria-labelledby="bir-'+i+'"><br /><span class="alert alert-info">{{trans("messages.varisgumruk")}}'+i+' </span><br />'+rmu+'</div>');
		}else
		{


			$("#myTabContent").append('<div class="tab-pane fade" id="content-'+i+'" role="tabpanel" aria-labelledby="bir-'+i+'"><br /><span class="alert alert-info">{{trans("messages.varisgumruk")}}'+i+' </span><br />'+rmu+'</div>');

		}
	}

	 $(".varisGumruk").easyAutocomplete(options);
}


</script>
@endsection

@section('content')

<form action='/talimat/update' method="post" name='a' id='actionFormElement' enctype="multipart/form-data"  onsubmit="return confirm('{{trans("messages.formconfirm")}}');">

<input type='hidden' name='talimatId' value='{{$talimat->id}}' />
   <div class='row' style='margin-left:2px;margin-top:4px;background: #FFF;'>
       		<div class='col-md-10 border'>
       		<input type="hidden" name="_token" value="{{ csrf_token() }}">
       		<h2>{{trans("messages.gumrukbilgileri")}}</h2>
       		<br />
					<div class="row">
							<div class="col-md-4">
								<label for="autoBarcode">{{trans("messages.autoBarcode")}}</label>
								<input type='text' readonly name="autoBarcode" id="autoBarcode" value="{{$talimat->autoBarcode}}" class="form-control" />
							</div>
					</div>
					 <br />
       		<div class='row'>
           	 @if (\Auth::user()->role=='admin')
           		<div class="form-group col-md-4">
           		<label for="firmaId">{{trans("messages.companyname")}}</label>
           		@if (!empty($userlist))
           		<select name='firmaId' class="form-control"  id="firmaXixD"  onchange="getPlakaList(this)">
           			@foreach($userlist as $z=>$m)
           				<option value='{{$m["id"]}}' @if ($m["id"]==$talimat->user->id) selected="selected" @endif>{{$m["name"]}}</option>
           			@endforeach
           		</select>
           		@endif
           		 </div>
           	@else
           	   <div class="form-group col-md-4">
                  <label for="orderNo">{{trans("messages.companyname")}}</label>
                  <input type='hidden' name='firmaId'  value='{{\Auth::user()->id}}' />
                  <input type="text" disabled="disabled" value='{{\Auth::user()->name}}' class="form-control" name='__firmaAdi' id="__firmaAdi" placeholder="Firma Adı">
           	  </div>
           	 @endif
           	 </div>

  			<div class='row'>
              <div class="form-group col-md-4 temizlenebilir">
                <label for="cekiciPlaka">{{trans("messages.cekiciplaka")}}</label>
                <input type="text" class="form-control" name='cekiciPlaka' id="cekiciPlaka" placeholder="Araç Çekici Plaka" value="{{$talimat->cekiciPlaka}}"  required="required">
              </div>
              </div>
              <div class='row'>
              <div class="form-group col-md-4 temizlenebilir">
                <label for="dorsePlaka">{{trans("messages.dorseplaka")}}</label>
                <input type="text" class="form-control" name='dorsePlaka' id="dorsePlaka" placeholder="Dorse Çekici Plaka" value="{{$talimat->dorsePlaka}}"  required="required">
              </div>
			</div>
			<div class='row'>
			<div class="form-group col-md-4 temizlenebilir">
				<label for="gumrukAdedi">{{trans("messages.gumrukadet")}}</label>
				<select name='gumrukAdedi' id='nmo' class="form-control" onchange='addTabData()'>
					 @for ($i = 1; $i < 11; $i++)
			 <option value="{{ $i }}" @if ($talimat->gumrukAdedi==$i) selected="selected"   @endif>{{ $i }}</option>
	 @endfor
				</select>
			</div>
</div>

              <div id='idXLKO'></div>
              <ul class="nav nav-tabs col-md-12" id="myTab" role="tablist">
              	@for ($t=1; $t<($talimat->gumrukAdedi+1);$t++)
              		<li class="nav-item"><a class="nav-link @if ($t==1) active @endif" id="tab-{{$t}}" data-toggle="tab" href="#content-{{$t}}" role="tab" aria-controls="bir" aria-selected="false">{{trans("messages.gumruk")}} {{$t}}</a></li>

              	@endfor
              </ul>
              <div class="tab-content col-md-12   border-bottom border-left" id="myTabContent">
              @foreach($talimat->gumruk as $key=>$value)
              	<div class="tab-pane fade @if ($loop->iteration==1) in active  @endif " id="content-{{$loop->iteration}}" role="tabpanel" aria-labelledby="bir-tab">
                  <br />
                  <div class='row'>
                      <div class='form-group col-md-4 temizlenebilir'>
                        <label for="varisGumrugu">{{trans("messages.varisgumruk")}}</label>
                        <input type="text" class="form-control varisGumruk" value="{{$value->varisGumrugu}}" onkeyup="searchGumruk()" name='varisGumrugu[]' id="" placeholder="Varış Gümrüğü"  required="required">
                      </div>
				 </div>
				 <div class='row'>
             	  <div class="form-group col-md-4 temizlenebilir">
         			<label for="adr">{{trans("messages.ADR")}}</label>
                  	 <select name="adr[]" class="form-control" >
                  	 	<option value="no" @if ($value->adr=='no') selected='selected' @endif>{{trans("messages.yapilmasin")}}</option>
                  	 	<option value="yes"  @if ($value->adr=='yes') selected='selected'  @endif>{{trans("messages.yapilsin")}}</option>
                  	 </select>
                  </div>
                  </div>
                  <div class='row'>
        	  <div class="form-group col-md-4 temizlenebilir">

              	  <label for="talimatTipi">{{trans("messages.talimattipi")}}</label>
              	 @if (!empty($talimatList))
              	 <select name='talimatTipi[]' class="form-control" id='talimatTipi' onchange='karneBilgisiEkle(this)'>
              	 	@foreach($talimatList as $k=>$m)
                  	 <option value="{{ $m->kisaKod }}" @if ($value->talimatTipi==$m->kisaKod)  selected='selected'  @endif>{{ $m->kodName }}</option>
                  	@endforeach
              	 </select>
              	 @endif
              	<div class=' form-group temizlenebilir col-md-12 karnecik @if ($value->talimatTipi!="ata" && $value->talimatTipi!="tir") hidden @endif' id='' >
               		<label for="karneAciklama">{{trans("messages.tirkarnesi")}}</label>
               		<input type='text' name='tirKarnesi[]' value='{{$value->tirKarnesi}}' class="form-control" />
               </div>
              </div>
              </div>
              <div class='row'>
                <div class="form-group col-md-4 temizlenebilir">
         			<label for="atr">A TR Belgesi</label>
                  	 <select name="atr[]" class="form-control" >
                  	 	<option value="no"  @if ($value->atr=='no') selected='selected' @endif>{{trans("messages.yapilmasin")}}</option>
                  	 	<option value="yes"  @if ($value->atr=='yes') selected='selected' @endif>{{trans("messages.yapilsin")}}</option>
                  	 </select>
                  </div>
                 </div>
                  <div class="form-group col-md-12 temizlenebilir">
                    <label for="malCinsi">{{trans("messages.malcinsi")}}</label>
                     <select name='malCinsi[]' class="form-control col-md-6"  onchange="noktalariBaslat(this,{{$key}})"  >
                  	 	<option value='parsiyal'  @if ($value->malCinsi=='parsiyal') selected='selected' @endif>{{trans("messages.parsiyel")}}</option>
                  	 	<option value='komple'  @if ($value->malCinsi=='komple') selected='selected' @endif>{{trans("messages.komple")}}</option>
                  	 </select>
                  	  	 <br />
                      <div class="form-group col-md-12 temizlenebilir">
                      <label for="yukleme">{{trans("messages.alicigondericiadet")}}</label>
                      		<select name="yuklemeNoktasiAdet[]" class="form-control yuklemeNoktasi col-md-6" data-num="1" onchange="noktalarIcinAlanOlustur(this,{{$key}})" >
                     			@if ($value->malCinsi=='komple')
                     					<option value="1">1</option>
                     			@else
                     				@for ($i = 1; $i < 11; $i++)
	            						<option value="{{ $i }}" @if($i==$value->yuklemeNoktasiAdet) selected="selected" @endif>{{ $i }}</option>
        							@endfor
                     			@endif

                      		</select>
                      </div>
                      <div class="form-group col-md-12 temizlenebilir malCinsiTabloları">
                  		 <table class="table table-bordered malYuklemeBosaltmaTablolari" width="100%" cellspacing="0">
            				<thead>
                				<tr>
                					<th>{{trans("messages.sira")}}</th>
                					<th>{{trans("messages.gonderici")}}</th>
                					<th>{{trans("messages.alici")}}</th>
                					<th class='col-md-2'>{{trans("messages.kap")}}</th>
                					<th class='col-md-2'>{{trans("messages.kilo")}}</th>
                				</tr>
            				</thead>
            				<tbody>
            				@if (!empty($value->yukleme))
                				@foreach($value->yukleme as $lolo=>$volo)
                    				<tr>
                						<td>{{$loop->iteration}}</td>
                    					<td><input type="text" class="form-control" name="yuklemeNoktasi[{{$key}}][{{$lolo}}]" value="{{$volo->yuklemeYeri}}" required="required"/></td>
                    					<td><input type="text" class="form-control" name="indirmeNoktasi[{{$key}}][{{$lolo}}]" value="{{$volo->bosaltmaYeri}}" required="required"/></td>
                    					<td><input type="text" class="form-control" name="tekKap[{{$key}}][{{$lolo}}]" value="{{$volo->kap}}"  onchange="hesaplaKapKilo({{$key}})" required="required"/></td>
                    					<td><input type="text" class="form-control" name="tekKilo[{{$key}}][{{$lolo}}]" value="{{$volo->kilo}}"  onchange="hesaplaKapKilo({{$key}})" required="required"/></td>

                    				</tr>
                    			@endforeach
                			@endif
            				</tbody>
            			</table>
                      </div>
                  </div>
                  <div>

                  </div>
                  <div class="form-group col-md-6 temizlenebilir">
                    <label for="kap">{{trans("messages.toplamkap")}}</label>
                    <input type="text" class="form-control" name='kap[{{$key}}]' readonly="readonly" value='{{$value->kap}}' id="kap" placeholder=""  required="required">
                  </div>
                  <div class="form-group col-md-6 temizlenebilir">
                    <label for="kilo">{{trans("messages.toplamkilo")}}</label>
                    <input type="text" class="form-control" name='kilo[{{$key}}]' readonly="readonly" value='{{$value->kilo}}' id="kilo" placeholder=""  required="required">
                  </div>

        	  <div class="form-group col-md-6 temizlenebilir">
              	  <label for="problem">{{trans("messages.problem")}}</label>
              	 <select name="problem[]" class="form-control" id="" onchange="openPr(this)" >
              	 	<option value="no"  @if ($value->problem=='no') selected='selected' @endif >{{trans("messages.yok")}}</option>
              	 	<option value="yes" @if ($value->problem=='yes') selected='selected' @endif>{{trans("messages.var")}}</option>
              	 </select>

                <div class=' form-group col-md-6  temizlenebilir problemYazi   @if ($value->problem=="no") hidden @endif' ><label for="problemAciklama ">{{trans("messages.problemaciklama")}}</label><input type='text' name='problemAciklama[]' value='{{$value->problemAciklama}}' class="form-control" /></div>

              </div>
      			<div class="form-group col-md-8 temizlenebilir">
            	    <label for="aciklama">{{trans("messages.aciklama")}}</label>
                	<textarea class="form-control" name='aciklama[]' id="aciklama"  rows='5'>{{$value->aciklama}}</textarea>
              	</div>
              </div>
       		@endforeach

              <br />
         	</div>

   		</div>

   </div>
        <div class='row' style='margin-top:10px;'>
        	<div class='col-md-4'></div>
        	<div class='col-md-4'>
        		<button class='btn btn-danger' type='button' onclick='formTemizle()'>{{trans("messages.clearform")}}</button>
        		<button class='btn btn-info' type='submit'>{{trans("messages.save")}}</button>
        	</div>
        </div>
</form>

@endsection
