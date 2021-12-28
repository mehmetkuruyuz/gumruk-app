@extends('layouts.app')

@section('kirinti')
	{{trans("messages.editinvoiceheader")}}
@endsection

@section('scripts')
    <link href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" rel="stylesheet"/>

@endsection
@section('endscripts')
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>

<script>
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

<form action='/muhasebe/update' method="post" name='a' id='actionFormElement' enctype="multipart/form-data"  onsubmit="return confirm('{{trans("messages.formconfirm")}}');" >
{{ csrf_field() }}
   <div class='row' style='margin-left:2px;margin-top:4px;background:#fff;'>
       		<div class='col-md-8'>
       		<input type='hidden' name="id"  value="{{$muhasebeOne->id}}" />
       		<h2>{{trans("messages.invoicecompanyheader")}}</h2>
       		<br />
           	 @if (\Auth::user()->role=='admin')

           		<label for="firmaId">{{trans("messages.companyname")}}</label>
           		@if (!empty($userlist))
           		<select name='firmaId' class="form-control" >
           			@foreach($userlist as $z=>$m)
           				<option value='{{$m["id"]}}' @if ($m['id']==$muhasebeOne->user->id) selected='selected' @endif>{{$m["name"]}}</option>
           			@endforeach
           		</select>
           		@endif

           	@else
           	   <div class="form-group col-md-8">
                  <label for="orderNo">{{trans("messages.companyname")}}</label>
                  <input type='hidden' name='firmaId'  value='{{\Auth::user()->id}}' />
                  <input type="text" disabled="disabled" value='{{\Auth::user()->name}}' class="form-control" name='__firmaAdi' id="__firmaAdi" placeholder="Firma Adı">
           	  </div>
           	 @endif
 		</div>



      <div class="form-group col-md-8 temizlenebilir">
        <label for="faturaTarihi">{{trans("messages.invoicedate")}}</label>
        <input type="text" class="form-control" name='faturaTarihi' id="faturaTarihi" placeholder="{{trans("messages.invoicedate")}}"  data-provide="datepicker"   value="{{$muhasebeOne->faturaTarihi}}" data-date-format="yyyy-mm-dd" required="required" />
      </div>
      <div class="form-group col-md-8 temizlenebilir">
        <label for="senaryo">{{trans("messages.invoicescene")}}</label>
        <input type="text" class="form-control" name='senaryo' id="senaryo" placeholder="{{trans("messages.invoicescene")}}"  value="{{$muhasebeOne->senaryo}}"/>
      </div>
      <div class="form-group col-md-8 temizlenebilir">
        <label for="tipi">{{trans("messages.invoicetype")}}</label>
        <input type="text" class="form-control" name='tipi' id="tipi" placeholder="{{trans("messages.invoicetype")}}" value="{{$muhasebeOne->tipi}}" />
      </div>
      <div class="form-group col-md-8 temizlenebilir">
        <label for="faturaReferans">{{trans("messages.invoicerefence")}}</label>
        <input type="text" class="form-control" name='faturaReferans' id="faturaReferans" placeholder="{{trans("messages.invoicerefence")}}"  value="{{$muhasebeOne->faturaReferans}}" />
      </div>
      <div class="form-group col-md-8 temizlenebilir">
        <label for="faturaNo">{{trans("messages.invoicenumber")}}</label>
        <input type="text" class="form-control" name='faturaNo' id="faturaNo" placeholder="{{trans("messages.invoicescene")}}"  value="{{$muhasebeOne->faturaNo}}" />
      </div>
      <div class="form-group col-md-8 temizlenebilir">
        <label for="FaturaTutari">{{trans("messages.invoiceprice")}}</label>
        <input type="text" class="form-control" name='price' id="FaturaTutari" placeholder="{{trans("messages.invoiceprice")}}" value="{{$muhasebeOne->price}}" />
      </div>
            <div class="form-group col-md-8 temizlenebilir">
       <label for="firmaId">{{trans("messages.parabirimi")}}</label>
       		<select name='moneytype' class="form-control" >
  				<option value='TL' @if ($muhasebeOne->moneytype=='TL') selected='selected' @endif> TL</option>
  				<option value='EURO' @if ($muhasebeOne->moneytype=='EURO') selected='selected' @endif>Euro</option>
  				<option value='DOLAR' @if ($muhasebeOne->moneytype=='DOLAR') selected='selected' @endif>Dolar</option>
  				<option value='POUND' @if ($muhasebeOne->moneytype=='POUND') selected='selected' @endif>Pound</option>
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
