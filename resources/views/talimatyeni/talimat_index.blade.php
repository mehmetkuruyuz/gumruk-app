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

<ul class="nav nav-tabs" id="myTab" role="tablist" style='margin-left:25px;'>
	 @if (!empty($talimatList))
	 @foreach($talimatList as $key=>$value)
          <li class="nav-item" style='background:#ffffb8 '>
            	<a class="nav-link @if($loop->iteration==1) active  @endif" id="{{$value->kisaKod}}-tab" data-toggle="tab" href="#{{$value->kisaKod}}" role="tab" aria-controls="{{$value->kisaKod}}" aria-selected="false">{{$value->kodName}}
								 @if (!empty($dataM[$value->kisaKod])) <span style='color:red'>( {{count($dataM[$value->kisaKod])}} )</span> @else (0) @endif</a>
          </li>
      @endforeach
  	@endif
</ul>

<div class="tab-content" id="myTabContent">
 @if (!empty($talimatList))
	 @foreach($talimatList as $m=>$evm)
	<div class="tab-pane @if($loop->iteration==1) fade in active   @endif fade  border-bottom border-left" id="{{$evm->kisaKod}}" role="tabpanel" aria-labelledby="{{$evm->kisaKod}}-tab">
		<div class='col-md-12'>
		<div class="panel panel-default">
        <div class="panel-heading">
          <i class="fa fa-table"></i> {{$evm->kodName}}</div>
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
									<th>	{{trans('messages.ADR')}}</th>
                  <th>	{{trans('messages.cekiciplaka')}}</th>
                  <th>	{{trans('messages.dorseplaka')}}</th>

                  <th>	{{trans('messages.problem')}}</th>

                  <th>	{{trans('messages.gumrukadet')}}</th>
                  <th>	{{trans('messages.aciklama')}}</th>
               <!--    <th style='font-size:0.8em'>Evrak Y??kle</th> -->
                  <th style='font-size:0.8em'>	{{trans('messages.incele')}}</th>
                  <th style='font-size:0.8em'>	{{trans('messages.yazdir')}}</th>
                  <!-- <th style='font-size:0.8em'>	{{trans('messages.edit')}}</th> -->
                  <th style='font-size:0.8em'>	{{trans('messages.delete')}}</th>
                  <th style='font-size:0.8em'>	{{trans('messages.durum')}}</th>
                </tr>

              </thead>
              <tfoot>
                <tr>
                   <th colspan='16'><i class="fa fa-circle" aria-hidden="true" style='color:green'></i> : 	{{trans('messages.yenitalimat')}}
                   <i class="fa fa-circle" aria-hidden="true" style='color:grey'></i> : 	{{trans('messages.gorulmustalimat')}}
                   <i class="fa fa-file-pdf-o" aria-hidden="true" style='color:blue'></i> : 	{{trans('messages.evraklaricin')}}
                   <i class="fa fa-pencil" aria-hidden="true" style='color:orange'></i> : 	{{trans('messages.duzenlemekicin')}}
                   <i class="fa fa-trash" aria-hidden="true" style='color:red'></i> :	{{trans('messages.silmekicin')}}
                   <i class="fa fa-file-text" aria-hidden="true" style='color:brown'></i> :	{{trans('messages.incelemekicin')}} </th>
                </tr>
              </tfoot>
              <tbody>
              	@if (!empty($dataM[$evm->kisaKod]))
									@foreach ($dataM[$evm->kisaKod] as $key => $value)
										<tr>

												<td> {{$value->upone->id}}	</td>
								 			 <td> {{$value->upone->upone->user->name}}	</td>
								 			 <td>	{{$value->upone->upone->autoBarcode}}</td>
								 			 <td>	{{$value->adr}}</td>
								 			 <td>	{{$value->upone->upone->cekiciPlaka}}</td>
								 			 <td>	{{$value->upone->upone->dorsePlaka}}</td>

								 			 <td>	{{$value->upone->problem}}</td>

								 			 <td>	{{$value->upone->upone->gumrukAdedi}}</td>
								 			 <td>	{{$value->upone->aciklama}}</td>
								 		<!--    <th style='font-size:0.8em'>Evrak Y??kle</th> -->
										<td><a href='/talimat_yeni/goster/{{$value->upone->upone->id}}'><i class="fa fa-file-text" aria-hidden="true" style='color:brown'></i></a></td>
	                  <td><a href='javascript:void(0)' onclick="PopupCenter('/talimat/yazdir/{{$value->upone->upone->id}}','xtf','930','500'); ">
											<i class="fa fa-print" aria-hidden="true" style='color:brown'></i></a></td>
	                <!--  <td><a href='/talimat/edit/{{$value->upone->upone->id}}'><i class="fa fa-pencil" aria-hidden="true" style='color:orange'></i></a></td> -->
	                  <td><a href='/talimat/sil/{{$value->upone->upone->id}}'><i class="fa fa-trash" aria-hidden="true" style='color:red'></i></a></td>
	                  <td>

	                  		<select name='durum' id='' onchange='sendMeOrderAction({{$value->upone->upone->id}},this)' @if (\Auth::user()->role!='admin') disabled="disabled"  @endif>
														<option value='0' @if ($value['durum']=='0') selected="selected" @endif>	{{trans('messages.bekleme')}}</option>
														<option value='1' @if ($value['durum']=='1') selected="selected" @endif>	{{trans('messages.firmabekle')}}</option>
														<option value='2' @if ($value['durum']=='2') selected="selected" @endif>	{{trans('messages.tamamlandi')}}</option>
	                  		</select>
	                  </td>


										</tr>
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
        @endforeach
  	@endif

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
