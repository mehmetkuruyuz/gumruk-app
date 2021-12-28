@extends('layouts.app')

@section('kirinti')
	{{trans('messages.yenitalimatbaslik')}}
@endsection

@section('scripts')
<style>
#dataTable {font-size:0.9em;}
</style>
<script type="text/javascript">
</script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" rel="stylesheet"/>

@endsection
@section('endscripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>

    <script src="vendor/datatables/jquery.dataTables.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>

<script>

	function sendMeOrderAction(orderid,element)
	{
		 var elementislem=$(element).val();
		 if (elementislem==2)
		 {
			 	window.location.href='/talimat_yeni/operasyontalimat/'+orderid;
		 }

	}
</script>

@endsection

@section('content')
@if($errors->any())
		<div class='row'>
            <div class="alert alert-primary col-md-12" role="alert">
            	{{$errors->first()}}
            </div>
		</div>
		<hr />
@endif
<div class="tab-content" id="myTabContent">

	<div class="" role="tabpanel" aria-labelledby="tab">
		<div class='col-md-12'>
		<div class="panel panel-default">
        <div class="panel-heading">
          <i class="fa fa-table"></i></div>
        <div class="panel-body">
           <div class="form-group  temizlenebilir">
           <form action='/talimat' method="POST" name='a' >
          {{ csrf_field() }}
           <table class="table" style='width:75%'>
           	<tr>
           	   <td><label for="plaka">	{{trans('messages.plaka')}}</label></td>
           	   <td>
           	   	<input type="text" class="form-control" @if (!empty($plaka)) value='{{$plaka}}' @endif name='plaka' id="plakalar" placeholder="{{trans('messages.plaka')}}">
           	   </td>
           	   <td><label for="tarih">	{{trans('messages.tarih1')}}</label></td>
           	   <td><input type='text'  class="form-control" name="tarih"  data-provide="datepicker"  data-date-format="yyyy-mm-dd"  @if (!empty($tarih)) value='{{$tarih}}' @endif   /></td>
           	   <td><label for="tarih">	{{trans('messages.tarih2')}}</label></td>
           	   <td><input type='text'  class="form-control" name="tarih2"  data-provide="datepicker"  data-date-format="yyyy-mm-dd"  @if (!empty($tarih2)) value='{{$tarih2}}' @endif   /></td>
							 <td><label for="barcode">	{{trans('messages.autoBarcode')}}</label></td>
								<td> <input type="text" class="form-control" name='barcode' value="" placeholder="{{trans('messages.autoBarcode')}}"></td>
           	   <td><button type='submit' class='btn btn-info'> {{trans('messages.ara')}}</button></td>
           	</tr>
           </table>
           </form>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
									<th>
										id
									</th>
									<th>	{{trans('messages.companyname')}}</th>
									<th>	{{trans('messages.autoBarcode')}}</th>

                  <th>	{{trans('messages.cekiciplaka')}}</th>
                  <th>	{{trans('messages.dorseplaka')}}</th>
                  <th>	{{trans('messages.problem')}}</th>
                  <th>	{{trans('messages.aciklama')}}</th>
               <!--    <th style='font-size:0.8em'>Evrak Yükle</th> -->
                  <th style='font-size:0.8em'>	{{trans('messages.incele')}}</th>
                  <th style='font-size:0.8em'>	{{trans('messages.yazdir')}}</th>
                  <!-- <th style='font-size:0.8em'>	{{trans('messages.edit')}}</th> -->
                  <th style='font-size:0.8em'>	{{trans('messages.delete')}}</th>
                  <th style='font-size:0.8em'>	{{trans('messages.durum')}}</th>
                </tr>

              </thead>

              <tbody>
              	@if (!empty($data))
									@foreach ($data as $key => $value)
										<tr>

												<td> {{$value->id}}	</td>
								 			 <td> {{$value->user->name}}	 	</td>
								 			 <td>{{$value->autoBarcode}}</td>

								 			 <td>	{{$value->cekiciPlaka}}</td>
								 			 <td>	{{$value->dorsePlaka}}</td>
							 			 		<td>	{{$value->problem}}</td>
												<td>	{{$value->problemAciklama}}</td>
												<td>	{{$value->aciklama}}</td>
								 		<!--    <th style='font-size:0.8em'>Evrak Yükle</th> -->

	                  <td>

	                  		<select name='durum' id='' onchange='sendMeOrderAction({{$value->id}},this)' @if (\Auth::user()->role=='admin') disabled="disabled"  @endif>
														<option value='0' @if ($value['durum']=='0') selected="selected" @endif>	{{trans('messages.bekleniyor')}}</option>
														<!-- <option value='1' @if ($value['durum']=='1') selected="selected" @endif>	{{trans('messages.islemyapiliyor')}}</option>  -->
														<option value='2' @if ($value['durum']=='2') selected="selected" @endif>	{{trans('messages.tamamlandi')}}</option>
	                  		</select>
	                  </td>
														</tr>
										@if (!empty($value->params))
										<tr>
												<td>&nbsp;</td>
											<td colspan="8">
											 <table class="table table-bordered" cellspacing="0">
												 <thead>
														 <tr>
															 <th>{{trans("messages.gonderici")}}</th>
															<th>{{trans("messages.ulkekodu")}}</th>
															<th>{{trans("messages.alici")}}</th>
															<th>{{trans("messages.ulkekodu")}}</th>
															<th>{{trans("messages.talimattipi")}}</th>
															<th>{{trans("messages.kap")}}</th>
															<th>{{trans("messages.kilo")}}</th>
															<th>{{trans("messages.yukcinsi")}}</th>
															<th>{{trans("messages.faturanumara")}}</th>
															<th>{{trans("messages.faturabedeli")}}</th>
															<th>{{trans("messages.ADR")}}</th>
															<th>{{trans("messages.atr")}}</th>
														 </tr>
												 </thead>
												@foreach($value->params as $paramkey=>$paramvalue)

														<tr>
																<td>{{$paramvalue->yuklemeNoktasi}}</td>
																<td>{{$paramvalue->yuklemeNoktasiulkekodu}}</td>
																<td>{{$paramvalue->indirmeNoktasi}}</td>
																<td>{{$paramvalue->indirmeNoktasiulkekodu}}</td>
																<td>{{$paramvalue->talimatTipi}}</td>
																<td>{{$paramvalue->tekKap}}</td>
																<td>{{$paramvalue->tekKilo}}</td>
																<td>{{$paramvalue->yukcinsi}}</td>
																<td>{{$paramvalue->faturanumara}}</td>

																<td>{{$paramvalue->adr}}</td>
																<td>{{$paramvalue->atr}}</td>
																<td>{{$paramvalue->adtrmessage}}</td>
														</tr>
												@endforeach
											</table>
											</td>
											</tr>
										@endif


	                @endforeach
                @else
                	<tr>
                		<td colspan='14'>	{{trans('messages.girilmistalimatyok')}}</td>
                	</tr>
                @endif
				</tbody>
			</table>
		</div>
	</div>
</div>

</div>
  </div>

</div>

<!-- </div>  -->


<div class="modal fade" id="islemlerModal" tabindex="-1" role="dialog" aria-labelledby="islemlerModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="islemlerModalLabel">	{{trans('messages.talimatislem')}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">	{{trans('messages.close')}}</button>
      </div>
    </div>
  </div>
</div>

@endsection
