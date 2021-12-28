@extends('layouts.app')

@section('kirinti')
	{{trans('messages.invoicelistheader')}}
@endsection

@section('scripts')
<style>
#dataTable {font-size:0.9em;}
</style>
<script type="text/javascript">

<!--

//-->
function modalAc(islem,id)
{
	$('#islemlerModal .modal-body').html('');
    $.ajax({
        type: 'GET',
        url: '/muhasebe/view/'+id,
        data: {
            // _token: token, buna ÅŸimdilik gerek yok
        },
        error: function (request, error) {
            console.log(arguments);
            alert(" {{trans('messages.systemaccesserror')}}  " + error);
        },
        success: function (data)
        {
        	$('#islemlerModal .modal-body').html(data);
        	$('#islemlerModal').modal('show');


        }
    });



}

</script>
@endsection

@section("endscripts")

	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />




<script type="text/javascript">

    require(['daterangepicker'], function() {

			$(function() {

			  $('input[name="datefilter"]').daterangepicker({
			      autoUpdateInput: false,
			      locale: {
			          cancelLabel: 'Clear'
			      }
			  });

			  $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
			      $(this).val(picker.startDate.format('YYYY-MM-DD') + ' / ' + picker.endDate.format('YYYY-MM-DD'));
			  });

			  $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
			      $(this).val('');
			  });

			});

		});

</script>
@endsection

@section('content')


		<div class='col-md-12'>
		<div class="card">
        <div class="card-header">
					<div class="container-fluid">
						<div class="row">
								<div class="col-3"><span class="card-title"><i class="fa fa-table"></i> {{trans('messages.invoicelistheader')}}</span></div>
								<div class="col-9 text-right">

									<form action="/muhasebe" method="post" class="row form-inline float-right">
										{{ csrf_field() }}
										<div class="form-group mx-sm-3 mb-2">
											<label>{{trans("messages.registerdate")}} </label>
											<input type="text" name="datefilter"  class="form-control" readonly value="{{old('datefilter')}}" />

											<button type="submit" class="btn btn-info">{{trans("messages.ara")}}</button>
									</div>

									</form>
								</div>
							</div>
					</div>
				</div>
        <div class="card-body">
          @if (\Auth::user()->role=="watcher")
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr >
                  <th style='font-size:0.8em'>{{trans("messages.companyname")}}</th>
									<th  style='font-size:0.8em'>{{trans("messages.firmatelefon")}}</th>
                  <th style='font-size:0.8em'>{{trans("messages.invoicedate")}}</th>
                  <th style='font-size:0.8em'>{{trans("messages.invoicetype")}}</th>
                  <th style='font-size:0.8em'>{{trans("messages.invoicerefence")}}</th>
                  <th style='font-size:0.8em'>{{trans("messages.invoicenumber")}}</th>
                  <th style='font-size:0.8em'>{{trans("messages.invoiceprice")}}</th>
                  <th style='font-size:0.8em'>{{trans("messages.parabirimi")}}</th>
									<th style='font-size:0.8em'>{{trans("messages.odemecinsi")}}</th>
									<th style='font-size:0.8em'>{{trans("messages.faturadurumu")}}</th>
                 @if (\Auth::user()->role=='XXXXXX')
 								 	<th style='font-size:0.8em'>{{trans("messages.edit")}}</th>
                  <th style='font-size:0.8em'>{{trans("messages.delete")}}</th>
								@endif
									<th style='font-size:0.8em'>{{trans("messages.talimat")}} {{trans("messages.show")}}</th>
									<th style='font-size:0.8em'>{{trans("messages.faturakapat")}}</th>

                </tr>

              </thead>

              <tbody>
            @if (!empty($muhasebeList))
					 			@foreach($muhasebeList as $m=>$evm)
					 			<tr>
                  <td>{{$evm->user->name}}</td>
                  <td>{{$evm->user->telefonNo}}</td>
                  <td>{{ \Carbon\Carbon::parse($evm->faturaTarihi)->format('d-m-Y') }}</td>

                  <td>{{$evm->tipi}}</td>
                  <td>{{$evm->faturaReferans}}</td>
                  <td>@if (!empty($evm->faturaNo)) {{$evm->faturaNo}} @else {{$evm->autoBarcode}} @endif </td>
                  <td>{{$evm->price}}</td>
                  <td>{{$evm->moneytype}}</td>
									<td>{{trans("messages.".$evm->odemecinsi)}}</td>
									<td>{{trans("messages.fatura".$evm->faturadurumu)}}</td>
                   @if (\Auth::user()->role=='XXXXX')
                  <td style='font-size:0.9em'><a href='/muhasebe/duzenle/{{$evm->id}}'><i class="fa fa-pencil" aria-hidden="true" style='color:orange'></a></i></td>
                     <td style='font-size:0.9em'><a href='/muhasebe/sil/{{$evm->id}}'><i class="fa fa-trash" aria-hidden="true" style='color:red'></i></a></td>
									 @endif

										 <td><a href='/operasyon/goster/{{$evm->id}}'><i class="fa fa-file-text" aria-hidden="true" style='color:brown'></i></a></td>
										 <td>
											 @if ($evm->faturadurumu=="acik")
											 <a href='/muhasebe/fatura/{{$evm->id}}'><small>{{trans("messages.faturakapat")}}</small></a></td>
										 	@else
												<a href='/muhasebe/fatura/{{$evm->id}}'><small>{{trans("messages.faturakapali")}} {{trans("messages.show")}}</small></a></td>
											@endif
                </tr>
	 				@endforeach
	 		@endif
				</tbody>
			</table>
		</div>
  @else
    @if (!empty($hiperlist))
        @foreach($hiperlist as $no=>$mve)
          <div class="card card-collapsed">
             <div class="card-status"></div>
             <div class="card-header">
               <h3 class="card-title " style="font-size:0.9em;">{{$no}} {{trans('messages.invoicelistheader')}}</h3>
               <div class="card-options">
                 <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
               </div>
             </div>
             <div class="card-body">
               <div class="table-responsive">
                 <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                   <thead>
                     <tr >
                       <th style='font-size:0.8em'>{{trans("messages.companyname")}}</th>
                       <th  style='font-size:0.8em'>{{trans("messages.firmatelefon")}}</th>
                       <th style='font-size:0.8em'>{{trans("messages.invoicedate")}}</th>
                       <th style='font-size:0.8em'>{{trans("messages.invoicetype")}}</th>
                       <th style='font-size:0.8em'>{{trans("messages.invoicerefence")}}</th>
                       <th style='font-size:0.8em'>{{trans("messages.invoicenumber")}}</th>
                       <th style='font-size:0.8em'>{{trans("messages.invoiceprice")}}</th>
                       <th style='font-size:0.8em'>{{trans("messages.parabirimi")}}</th>
                       <th style='font-size:0.8em'>{{trans("messages.odemecinsi")}}</th>
                       <th style='font-size:0.8em'>{{trans("messages.faturadurumu")}}</th>
                      @if (\Auth::user()->role=='XXXXXX')
                       <th style='font-size:0.8em'>{{trans("messages.edit")}}</th>
                       <th style='font-size:0.8em'>{{trans("messages.delete")}}</th>
                     @endif
                       <th style='font-size:0.8em'>{{trans("messages.talimat")}} {{trans("messages.show")}}</th>
                       <th style='font-size:0.8em'>{{trans("messages.faturakapat")}}</th>

                     </tr>

                   </thead>

                   <tbody>
                       @if (!empty($mve))
                           @foreach($mve as $m=>$evm)
                           <tr>
                             <td>{{$evm->user->name}}</td>
                             <td>{{$evm->user->telefonNo}}</td>
                             <td>{{ \Carbon\Carbon::parse($evm->faturaTarihi)->format('d-m-Y') }}</td>

                             <td>{{$evm->tipi}}</td>
                             <td>{{$evm->faturaReferans}}</td>
                             <td>@if (!empty($evm->faturaNo)) {{$evm->faturaNo}} @else {{$evm->autoBarcode}} @endif </td>
                             <td>{{$evm->price}}</td>
                             <td>{{$evm->moneytype}}</td>
                             <td>{{trans("messages.".$evm->odemecinsi)}}</td>
                             <td>{{trans("messages.fatura".$evm->faturadurumu)}}</td>
                              @if (\Auth::user()->role=='XXXXX')
                             <td style='font-size:0.9em'><a href='/muhasebe/duzenle/{{$evm->id}}'><i class="fa fa-pencil" aria-hidden="true" style='color:orange'></a></i></td>
                                <td style='font-size:0.9em'><a href='/muhasebe/sil/{{$evm->id}}'><i class="fa fa-trash" aria-hidden="true" style='color:red'></i></a></td>
                              @endif

                                <td><a href='/operasyon/goster/{{$evm->id}}'><i class="fa fa-file-text" aria-hidden="true" style='color:brown'></i></a></td>
                                <td>
                                  @if ($evm->faturadurumu=="acik")
                                  <a href='/muhasebe/fatura/{{$evm->id}}'><small>{{trans("messages.faturakapat")}}</small></a></td>
                                 @else
                                   <a href='/muhasebe/fatura/{{$evm->id}}'><small>{{trans("messages.faturakapali")}} {{trans("messages.show")}}</small></a></td>
                                 @endif
                           </tr>
                     @endforeach
                 @endif
                   </tbody>
                 </table>
               </div>
             </div>
          </div>
        @endforeach
      @endif
  @endif
	</div>
</div>

</div>




<div class="modal fade" id="islemlerModal" tabindex="-1" role="dialog" aria-labelledby="islemlerModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="islemlerModalLabel">{{trans("messages.instructionsaction")}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans("messages.close")}}</button>
      </div>
    </div>
  </div>
</div>

@endsection
