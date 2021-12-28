@extends('layouts.app')

@section('kirinti')
	{{trans("messages.operasyonyenibaslik")}}
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
		$(t).parent().children(".problemYazi").removeClass('hidden');
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

		//		alert($("#firmaXixD").val());

		$("#cekiciPlaka").easyAutocomplete(options2);
		$("#dorsePlaka").easyAutocomplete(options3);

}





$(document).ready(function() {

		getPlakaList();

});




</script>
@endsection

@section('content')

<form action='/operasyon/save' method="post" name='a' id='actionFormElement' enctype="multipart/form-data" >
{{ csrf_field() }}
   <div class='row' style='margin-left:2px;margin-top:4px;background: #FFF;'>
       		<div class='col-md-8 border'>
       		<h2>{{trans("messages.operasyondigerevrak")}}</h2>
       		<br />
       		 <div class='row'>
           	 @if (\Auth::user()->role=='admin')

           		<div class="form-group col-md-4">
									<label for="firmaId">{{trans("messages.companyname")}}</label>
		           		@if (!empty($userlist))
			           		<select name='firmaId' class="form-control"  onchange="getPlakaList()" id="firmaXixD">
			           			@foreach($userlist as $z=>$m)
			           				<option value='{{$m["id"]}}'>{{$m["name"]}}</option>
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
							<hr />
							<div class='row'>
								<div class="form-group col-md-4 temizlenebilir">
									<label for="gonderici">{{trans("messages.gonderici")}}</label>
									<input type="text" class="form-control" name='gonderici' placeholder="{{trans("messages.operasyongonderici")}}"  required="required">
								</div>

								<div class="form-group col-md-4 temizlenebilir">
									<label for="alici">{{trans("messages.alici")}}</label>
									<input type="text" class="form-control" name='alici' placeholder="{{trans("messages.operasyonalici")}}"  required="required">
								</div>
							</div>
							<hr />
							<div class='row'>
								<div class="form-group col-md-2 temizlenebilir">
									<label for="kap">{{trans("messages.kap")}}</label>
									<input type="text" class="form-control" name='kap' id="kap" placeholder="{{trans("messages.kap")}}"  required="required">
								</div>

								<div class="form-group col-md-2 temizlenebilir">
									<label for="netkilo">{{trans("messages.netkilo")}}</label>
									<input type="text" class="form-control" name='netkilo' id="netkilo" placeholder="{{trans("messages.netkilo")}}"  required="required">
								</div>
								<div class="form-group col-md-2 temizlenebilir">
									<label for="brutkilo">{{trans("messages.brutkilo")}}</label>
									<input type="text" class="form-control" name='brutkilo' id="brutkilo" placeholder="{{trans("messages.brutkilo")}}"  required="required">
								</div>
								<div class="form-group col-md-2 temizlenebilir">
									<label for="ulkekodu">{{trans("messages.ulkekodu")}}</label>
									<select name="ulkekodu" class="form-control col-xs-2">
										 <option value="0">{{trans("messages.seciniz")}}</option>
										 @if(!empty($ulkeList))
											 	@foreach ($ulkeList as $ulkekey => $ulkevalue)
											 		<option value="{{$ulkevalue->kod_gib}}-{{$ulkevalue->world}}">{{$ulkevalue->global_name}}</option>
											 	@endforeach

										@endif
									</select>
								</div>
								<div class="form-group col-md-2 temizlenebilir">
									<label for="paketcinsi">{{trans("messages.paketcinsi")}}</label>
									<select name='paketcinsi' class="form-control" >
											<option value='0'>{{trans("messages.seciniz")}}</option>
									</select>
								</div>
								<div class="form-group col-md-2 temizlenebilir">
									<label for="malcinsi">{{trans("messages.malcinsi")}}</label>
									<select name="malcinsi" class="form-control col-xs-2">
										 <option value="komple">{{trans("messages.komple")}}</option>
										 <option value="parsiyal">{{trans("messages.parsiyel")}}</option>
									</select>
								</div>
							</div>
   						<div class='row'>
                  <div class="form-group col-md-4 temizlenebilir">
                		<label for="cekiciPlaka">{{trans("messages.cekiciplaka")}}</label>
                    <input type="text" class="form-control" name='cekiciPlaka' id="cekiciPlaka" placeholder="Araç Çekici Plaka"  required="required">
                  </div>

                  <div class="form-group col-md-4 temizlenebilir">
                		<label for="dorsePlaka">{{trans("messages.dorseplaka")}}</label>
                    <input type="text" class="form-control" name='dorsePlaka' id="dorsePlaka" placeholder="Dorse Çekici Plaka"  required="required">
                  </div>
						 </div>
              <br />
   			</div>

   		<div class='col-md-8 border temizlenebilir' style='margin-left:15px'>
			<h2>{{trans("messages.operasyondigerevrak")}}</h2>
			<br />
			<table class="table table-bordered" cellspacing="0">
				 <thead>
					<tr>
						<th>{{trans("messages.gereklidosya")}}</th>
							<th colspan='3'>{{trans("messages.dosya")}}</th>

						</tr>
				</thead>
				<tbody>
			<tr>
					<td>{{trans("messages.cmr")}}</td>
					<td><input type='file' name="dosya[cmr][]" /></td>
					<td></td>
				</tr>
				<tr>
					<td>{{trans("messages.fatura")}}</td>
					<td><input type='file' name="dosya[fatura][]" /></td>
					<td></td>
				</tr>
				<tr>
					<td>{{trans("messages.ATR")}}</td>
					<td><input type='file' name="dosya[atr][]" /></td>
					<td></td>
				</tr>
				<tr>
					<td>{{trans("messages.transitevrak")}}</td>
					<td><input type='file' name="dosya[talimat][]" /></td>
					<td></td>
				</tr>
			</tbody>
		</table>
				<div class="form-group col-md-12">
                    <label for="gallery-photo-add">{{trans("messages.evrakyukle")}}</label>
                    <small>{{trans("messages.evrakyuklealt")}}</small>
                    <input type="file" name='files[]' class='form-control' multiple id="gallery-photo-add">
					<div id='dgalleryd' class="gallery"></div>
                  </div>
   		</div>

   </div>
	 @include('forms.submits')

</form>

@endsection
