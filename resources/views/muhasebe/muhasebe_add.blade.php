@extends('layouts.app')

@section('kirinti')
	{{trans("messages.newinvoiceheader")}}
@endsection

@section('scripts')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" rel="stylesheet"/>

@endsection
@section('endscripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>

<script>

function fiyatvelistegetir(t)
{
	var m=$(t).val();
	if (m>0)
	{
		var total=0;
		$.get("/talimat_new/talimataltipgetir/"+m,
		 function(data, status){
			 $("#talimattipsbody").children().remove();
			 $.each(data, function (index, value)
						{
									$("#talimattipsbody").append("<tr id='id_"+index+"'></tr>");
									$("#id_"+index).append("<td>"+value.varisGumrugu+"</td>");
									$("#id_"+index).append("<td>"+value.talimatTipi+"</td>");
									$("#id_"+index).append("<td>"+value.tekKap+"</td>");
									$("#id_"+index).append("<td>"+value.tekKilo+"</td>");
									$("#id_"+index).append("<td>"+value.price+"</td>");
									total+=(value.price*1);
						});
						$("#FaturaTutari").val(total);
			 	//console.log(data);
		 });
	}
}

function talimatGetir(t)
{

	var m=$(t).val();
	$.get("/talimat_new/firmatalimatlarigetir/"+m,
	 function(data, status){
		 $("#talimatId").children().remove();
		 $("#talimatId").append("<option value='0'>{{trans('messages.choose')}}</option>");
		 $.each(data, function (index, value)
					{
						$("#talimatId").append("<option value='"+value.id+"'>"+(index+1)+" / "+value.updated_at+"</option>");

					 });

	 });
}

function formTemizle()
{

$(':input','.temizlenebilir')
.not(':button, :submit, :reset')
.val('')
.prop('checked', false)
.prop('selected', false);

}
</script>
@endsection

@section('content')

<form action='/muhasebe/kaydet' method="post" name='a' id='actionFormElement' enctype="multipart/form-data"   onsubmit="return confirm('{{trans("messages.formconfirm")}}');">
{{ csrf_field() }}
   <div class='row' style='margin-left:2px;margin-top:4px;background:#FFF; '>
      <div class='col-md-8 form-group'>

       		<h2>{{trans("messages.invoicecompanyheader")}}</h2>
       		<br />
           	 @if (\Auth::user()->role=='admin')

           		<label for="firmaId">{{trans("messages.companyname")}}</label>
           		@if (!empty($userlist))
           		<select name='firmaId' class="form-control" onchange="talimatGetir(this)" >
									<option value='0'>{{trans("messages.choose")}}</option>
								@foreach($userlist as $z=>$m)
           				<option value='{{$m["id"]}}'>{{$m["name"]}}</option>
           			@endforeach
           		</select>
           		@endif

           	@else
           	   <div class="form-group col-md-8">
                  <label for="orderNo">{{trans("messages.companyname")}}</label>
                  <input type='hidden' name='firmaId'  value='{{\Auth::user()->id}}' />
                  <input type="text" disabled="disabled" value='{{\Auth::user()->name}}' class="form-control" name='__firmaAdi' id="__firmaAdi" placeholder="{{trans("messages.companyname")}}">
           	  </div>
           	 @endif
 		</div>
       <div class="form-group col-md-8">
					<label>{{trans("messages.talimatseciniz")}}</label>
					<select name='talimatId' class="form-control" id="talimatId" onchange="fiyatvelistegetir(this)">

					</select>
			</div>
			<div class="form-group  col-md-8" >
					<table id="talimattips" class="table">
						<thead>
							<tr>
								<th>Varış Gümrüğü</th>
								<th>Talimat Tipi</th>
								<th>Kap</th>
								<th>Kilo</th>
								<th>Ücret</th>
							</tr>
						</thead>
						<tbody id="talimattipsbody">

						</tbody>
					</table>
			</div>

         <div class="form-group col-md-8">
        <label for="faturaTarihi">{{trans("messages.invoicedate")}}</label>
        <input type="text" class="form-control" name='faturaTarihi' id="faturaTarihi" placeholder='{{trans("messages.invoicedate")}}'  data-provide="datepicker"  data-date-format="yyyy-mm-dd" required="required" />
      </div>
      <div class="form-group col-md-8 temizlenebilir">
        <label for="senaryo">{{trans("messages.invoicescene")}}</label>
        <input type="text" class="form-control" name='senaryo' id="senaryo" placeholder="{{trans("messages.invoicescene")}}" />
      </div>
      <div class="form-group col-md-8 temizlenebilir">
        <label for="tipi">{{trans("messages.invoicetype")}}</label>
        <input type="text" class="form-control" name='tipi' id="tipi" placeholder="{{trans("messages.invoicetype")}}" />
      </div>
      <div class="form-group col-md-8 temizlenebilir">
        <label for="faturaReferans">{{trans("messages.invoicerefence")}}</label>
        <input type="text" class="form-control" name='faturaReferans' id="faturaReferans" placeholder="{{trans("messages.invoicerefence")}}" />
      </div>
      <div class="form-group col-md-8 temizlenebilir">
        <label for="faturaNo">{{trans("messages.invoicenumber")}}</label>
        <input type="text" class="form-control" name='faturaNo' id="faturaNo" placeholder="{{trans("messages.invoicenumber")}}" />
      </div>
      <div class="form-group col-md-8 temizlenebilir">
        <label for="FaturaTutari">{{trans("messages.invoiceprice")}}</label>
        <input type="text" class="form-control" name='price' id="FaturaTutari" placeholder="{{trans("messages.invoiceprice")}}" />
      </div>
      <div class="form-group col-md-8 temizlenebilir">
       <label for="firmaId">{{trans("messages.parabirimi")}}</label>
       		<select name='moneytype' class="form-control" >
  				<option value='TL'>TL</option>
  				<option value='EURO'>Euro</option>
  				<option value='DOLAR'>Dolar</option>
  				<option value='POUND'>Pound</option>
        	</select>
      </div>
       <div class="form-group col-md-8 temizlenebilir">
              <div class='row' style='margin-top:10px;'>
        	<div class='col-md-4'></div>
        	<div class='col-md-4'>
        		<button class='btn btn-danger' type='button' onclick='formTemizle()'>{{trans("messages.clearform")}}</button>
        		<button class='btn btn-info' type='submit'>{{trans("messages.save")}}</button>
        	</div>
        </div>
        </div>
 	</form>
 	 	</div>
 @endsection
