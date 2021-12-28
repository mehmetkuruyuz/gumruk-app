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

<form action='/muhasebe/ozelfiyatlamakaydet' method="post" name='a' id='actionFormElement' enctype="multipart/form-data"   onsubmit="return confirm('{{trans("messages.formconfirm")}}');">
{{ csrf_field() }}
   <div class='row' style='margin-left:2px;margin-top:4px;background:#FFF; '>
      <div class='col-md-8'>

       		<h2>{{trans("messages.ozelfiyatlama")}}</h2>
       		<br />
           	 @if (\Auth::user()->role=='admin')

           		<label for="firmaId">{{trans("messages.companyname")}}</label>
           		@if (!empty($userlist))
           		<select name='firmaId' class="form-control" >
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

      <div class="form-group col-md-8 temizlenebilir">
        <label for="senaryo">{{trans("messages.invoicescene")}}</label>
        <input type="text" class="form-control" name='senaryo' id="senaryo" placeholder="{{trans("messages.invoicescene")}}" />
      </div>
      <div class="form-group col-md-8 temizlenebilir">
				@if (!empty($talimatList))
					@foreach ($talimatList as $key => $value)
						<div class="form-group temizlenebilir row">
							<div class="col-sm-4">
							<label>{{$value->kodName}}</label>

							</div>
							<div class="col-sm-4">
										<label for="FaturaTutari">{{trans("messages.invoiceprice")}}</label>
										<input type="text" class="form-control" name='price[{{$value->kisaKod}}]' id="FaturaTutari" placeholder="{{trans("messages.invoiceprice")}}" />

							</div>
							<div class="form-group col-sm-4 temizlenebilir">
							 <label for="firmaId">{{trans("messages.parabirimi")}}</label>
									<select name='moneytype[{{$value->kisaKod}}]' class="form-control" >
										<option value='TL'>TL</option>
										<option value='EURO'>Euro</option>
										<option value='DOLAR'>Dolar</option>
										<option value='POUND'>Pound</option>
								 </select>
							</div>
						</div>

						@if ($value->kisaKod=="t2")
							<div class="form-group temizlenebilir row">
								<div class="col-sm-4">
								<label>{{$value->kodName}} {{trans("messages.t2ekbilgi")}}</label>

								</div>
								<div class="col-sm-4">
											<label for="FaturaTutari">{{trans("messages.invoiceprice")}}</label>
											<input type="text" class="form-control" name='price[{{$value->kisaKod}}ek]' id="FaturaTutari" placeholder="{{trans("messages.invoiceprice")}}" />

								</div>
								<div class="form-group col-sm-4 temizlenebilir">
								 <label for="firmaId">{{trans("messages.parabirimi")}}</label>
										<select name='moneytype[{{$value->kisaKod}}ek]' class="form-control" >
											<option value='TL'>TL</option>
											<option value='EURO'>Euro</option>
											<option value='DOLAR'>Dolar</option>
											<option value='POUND'>Pound</option>
									 </select>
								</div>
							</div>
						@endif
					@endforeach
				@endif
				<div class="form-group temizlenebilir row">
					<div class="col-sm-4">
					<label>{{trans("messages.bondeshortie")}}</label>


					</div>
					<div class="col-sm-4">
								<label for="FaturaTutari">{{trans("messages.invoiceprice")}}</label>
								<input type="text" class="form-control" name='price[bondeshortie]' id="FaturaTutari" placeholder="{{trans("messages.invoiceprice")}}" />

					</div>
					<div class="form-group col-sm-4 temizlenebilir">
					 <label for="firmaId">{{trans("messages.parabirimi")}}</label>
							<select name='moneytype[bondeshortie]' class="form-control" >
								<option value='TL'>TL</option>
								<option value='EURO'>Euro</option>
								<option value='DOLAR'>Dolar</option>
								<option value='POUND'>Pound</option>
						 </select>
					</div>
				</div>
				<div class="form-group temizlenebilir row">
					<div class="col-sm-4">
					<label>{{trans("messages.ithalatimport")}}</label>

					</div>
					<div class="col-sm-4">
								<label for="FaturaTutari">{{trans("messages.invoiceprice")}}</label>
								<input type="text" class="form-control" name='price[ithalatimport]' id="FaturaTutari" placeholder="{{trans("messages.invoiceprice")}}" />

					</div>
					<div class="form-group col-sm-4 temizlenebilir">
					 <label for="firmaId">{{trans("messages.parabirimi")}}</label>
							<select name='moneytype[ithalatimport]' class="form-control" >
								<option value='TL'>TL</option>
								<option value='EURO'>Euro</option>
								<option value='DOLAR'>Dolar</option>
								<option value='POUND'>Pound</option>
						 </select>
					</div>
				</div>
				{{--
      <div class="form-group col-md-8 temizlenebilir">
				<div class="col-sm-4">
				<label>T1 Passage Adet Fiyatı</label>

				</div>
				<div class="col-sm-4">
							<label for="FaturaTutari">{{trans("messages.invoiceprice")}}</label>
							<input type="text" class="form-control" name='price[t1passage]' id="FaturaTutari" placeholder="{{trans("messages.invoiceprice")}}" />

				</div>
				<div class="form-group col-sm-4 temizlenebilir">
				 <label for="firmaId">{{trans("messages.parabirimi")}}</label>
						<select name='moneytype[t1passage]' class="form-control" >
							<option value='TL'>TL</option>
							<option value='EURO'>Euro</option>
							<option value='DOLAR'>Dolar</option>
							<option value='POUND'>Pound</option>
					 </select>
				</div>
			</div>
			<div class="form-group col-md-8 temizlenebilir">
				<div class="col-sm-4">
					<label>T1 Creation Adet Fiyatı</label>

				</div>
				<div class="col-sm-4">
							<label for="FaturaTutari">{{trans("messages.invoiceprice")}}</label>
			        <input type="text" class="form-control" name='price[t1creation]' id="FaturaTutari" placeholder="{{trans("messages.invoiceprice")}}" />
				</div>
				<div class="form-group col-sm-4 temizlenebilir">
				 <label for="firmaId">{{trans("messages.parabirimi")}}</label>
						<select name='moneytype[t1creation]' class="form-control" >
							<option value='TL'>TL</option>
							<option value='EURO'>Euro</option>
							<option value='DOLAR'>Dolar</option>
							<option value='POUND'>Pound</option>
					 </select>
				</div>

			</div>
			<div class="form-group col-md-8 temizlenebilir">
								<div class="col-sm-4">
					<label>Carnet Passage Fiyatı</label>

				</div>
				<div class="col-sm-4">
							<label for="FaturaTutari">{{trans("messages.invoiceprice")}}</label>
			        <input type="text" class="form-control" name='price[carnetpassage]' id="FaturaTutari" placeholder="{{trans("messages.invoiceprice")}}" />
				</div>
				<div class="form-group col-sm-4 temizlenebilir">
				 <label for="firmaId">{{trans("messages.parabirimi")}}</label>
						<select name='moneytype[carnetpassage]' class="form-control" >
							<option value='TL'>TL</option>
							<option value='EURO'>Euro</option>
							<option value='DOLAR'>Dolar</option>
							<option value='POUND'>Pound</option>
					 </select>
				</div>

			</div>
			<div class="form-group col-md-8 temizlenebilir">
				<div class="col-sm-4">
				<label>Carnet Creation Fiyatı</label>

			</div>
			<div class="col-sm-4">
						<label for="FaturaTutari">{{trans("messages.invoiceprice")}}</label>
						<input type="text" class="form-control" name='price[carnetcreation]' id="FaturaTutari" placeholder="{{trans("messages.invoiceprice")}}" />
			</div>
			<div class="form-group col-sm-4 temizlenebilir">
			 <label for="firmaId">{{trans("messages.parabirimi")}}</label>
					<select name='moneytype[carnetcreation]' class="form-control" >
						<option value='TL'>TL</option>
						<option value='EURO'>Euro</option>
						<option value='DOLAR'>Dolar</option>
						<option value='POUND'>Pound</option>
				 </select>
			</div>

			</div>
			      <div class="form-group col-md-8 temizlenebilir">
							<div class="col-sm-4">
							<label>T2 Adet Fiyatı </label>

						</div>
						<div class="col-sm-4">
									<label for="FaturaTutari">{{trans("messages.invoiceprice")}}</label>
					        <input type="text" class="form-control" name='price[t2]' id="FaturaTutari" placeholder="{{trans("messages.invoiceprice")}}" />
						</div>
						<div class="form-group col-sm-4 temizlenebilir">
						 <label for="firmaId">{{trans("messages.parabirimi")}}</label>
								<select name='moneytype[t2]' class="form-control" >
									<option value='TL'>TL</option>
									<option value='EURO'>Euro</option>
									<option value='DOLAR'>Dolar</option>
									<option value='POUND'>Pound</option>
							 </select>
						</div>

						</div>
				      <div class="form-group col-md-8 temizlenebilir">
								<div class="col-sm-4">
									<label>Ex1 Adet Fiyatı </label>


								</div>
								<div class="col-sm-4">
											<label for="FaturaTutari">{{trans("messages.invoiceprice")}}</label>
											<input type="text" class="form-control" name='price[ex1]' id="FaturaTutari" placeholder="{{trans("messages.invoiceprice")}}" />
								</div>
								<div class="form-group col-sm-4 temizlenebilir">
								 <label for="firmaId">{{trans("messages.parabirimi")}}</label>
										<select name='moneytype[ex1]' class="form-control" >
											<option value='TL'>TL</option>
											<option value='EURO'>Euro</option>
											<option value='DOLAR'>Dolar</option>
											<option value='POUND'>Pound</option>
									 </select>
								</div>
						</div>
				      <div class="form-group col-md-8 temizlenebilir">
								<div class="col-sm-4">
								<label>ATR Adet Fiyatı  </label>

							</div>
							<div class="col-sm-4">
										<label for="FaturaTutari">{{trans("messages.invoiceprice")}}</label>
										<input type="text" class="form-control" name='price[atr]' id="FaturaTutari" placeholder="{{trans("messages.invoiceprice")}}" />
							</div>
							<div class="form-group col-sm-4 temizlenebilir">
							 <label for="firmaId">{{trans("messages.parabirimi")}}</label>
									<select name='moneytype[atr]' class="form-control" >
										<option value='TL'>TL</option>
										<option value='EURO'>Euro</option>
										<option value='DOLAR'>Dolar</option>
										<option value='POUND'>Pound</option>
								 </select>
							</div>
						</div>
				      <div class="form-group col-md-8 temizlenebilir">
								<div class="col-sm-4">
								<label>Liste Adet Fiyatı  </label>

							</div>
							<div class="col-sm-4">
										<label for="FaturaTutari">{{trans("messages.invoiceprice")}}</label>
										<input type="text" class="form-control" name='price[liste]' id="FaturaTutari" placeholder="{{trans("messages.invoiceprice")}}" />
							</div>
							<div class="form-group col-sm-4 temizlenebilir">
							 <label for="firmaId">{{trans("messages.parabirimi")}}</label>
									<select name='moneytype[liste]' class="form-control" >
										<option value='TL'>TL</option>
										<option value='EURO'>Euro</option>
										<option value='DOLAR'>Dolar</option>
										<option value='POUND'>Pound</option>
								 </select>
							</div>

						</div>
				      <div class="form-group col-md-8 temizlenebilir">
								<div class="col-sm-4">
										<label>Fiziki Kontrol Fiyatı  </label>

									</div>
									<div class="col-sm-4">
												<label for="FaturaTutari">{{trans("messages.invoiceprice")}}</label>
												<input type="text" class="form-control" name='price[fiziki]' id="FaturaTutari" placeholder="{{trans("messages.invoiceprice")}}" />
									</div>
									<div class="form-group col-sm-4 temizlenebilir">
									 <label for="firmaId">{{trans("messages.parabirimi")}}</label>
											<select name='moneytype[fiziki]' class="form-control" >
												<option value='TL'>TL</option>
												<option value='EURO'>Euro</option>
												<option value='DOLAR'>Dolar</option>
												<option value='POUND'>Pound</option>
										 </select>
									</div>
						</div>
				      <div class="form-group col-md-8 temizlenebilir">
								<div class="col-sm-4">
									<label>Gümrük Vergisi </label>

								</div>
								<div class="col-sm-4">
											<label for="FaturaTutari">{{trans("messages.invoiceprice")}}</label>
											<input type="text" class="form-control" name='price[gumruk]' id="FaturaTutari" placeholder="{{trans("messages.invoiceprice")}}" />
								</div>
								<div class="form-group col-sm-4 temizlenebilir">
								 <label for="firmaId">{{trans("messages.parabirimi")}}</label>
										<select name='moneytype[gumruk]' class="form-control" >
											<option value='TL'>TL</option>
											<option value='EURO'>Euro</option>
											<option value='DOLAR'>Dolar</option>
											<option value='POUND'>Pound</option>
									 </select>
								</div>

						</div>
						--}}
<!--
        <label for="talimatTipi">{{trans("messages.talimattipi")}}</label>
           @if (!empty($talimatList))
           <select name='talimatTipi' class="form-control" id='talimatTipi' onchange='karneBilgisiEkle(this)'>
            @foreach($talimatList as $key=>$value)
               <option value="{{ $value->kisaKod }}">{{ $value->kodName }}</option>
              @endforeach
           </select>
           @endif
      </div>

      <div class="form-group col-md-8 temizlenebilir">
        <label for="FaturaTutari">{{trans("messages.invoiceprice")}}</label>
        <input type="text" class="form-control" name='price' id="FaturaTutari" placeholder="{{trans("messages.invoiceprice")}}" />
      </div>
		-->

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
