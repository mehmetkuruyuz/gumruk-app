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
@section('endscripts')

    <script src="vendor/datatables/jquery.dataTables.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>


@endsection

@section('content')


		<div class='col-md-12'>
		<div class="card panel-default">
        <div class="card-header">
          <i class="fa fa-table"></i> {{trans('messages.invoicelistheader')}}
        </div>
        <div class="card-body">
          <div class="table-responsive">
						@if (\Auth::user()->role=="watcher")
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>{{trans("messages.companyname")}}</th>

                  <th>{{trans("messages.invoicescene")}}</th>
									<th>{{trans("messages.talimattipi")}}</th>
									<th>{{trans("messages.muhasebefiyatlama")}}</th>

                  <th>{{trans("messages.invoicetype")}}</th>
                </tr>

              </thead>

              <tbody>
            @if (!empty($list))
					 			@foreach($list as $m=>$evm)
					 			<tr>
       								<td>{{$evm->user->name}}</td>
				              <td>{{$evm->senaryo}}</td>
				              <td>{{$evm->talimattipi}}</td>
				              <td>{{$evm->faturatutari}}</td>
											<td>{{$evm->parabirimi}}</td>
				        </tr>
					 				@endforeach
					 		@endif
				</tbody>
			</table>
			@else
				@if (!empty($array))
						@foreach($array as $m=>$evm)
							<div class="card card-collapsed">
								 <div class="card-status"></div>
								 <div class="card-header">
									 <h3 class="card-title " style="font-size:0.9em;">{{$m}} {{trans("messages.ozelfiyatlama")}}</h3>
									 <div class="card-options">
										 <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
									 </div>
								 </div>
								 <div class="card-body">
									 	@if(!empty($evm))
											<div class="row">
												<div class="col-3">	{{trans("messages.talimattipi")}}</div>
												<div class="col-5">{{trans("messages.faturatutari")}}</div>
												<div class="col-3">{{trans("messages.moneytype")}}</div>
											</div>
												@foreach($evm['talimattipi'] as $fm=>$fevm)
														<div class="row">
															<div class="col-3">	{{trans("messages.".$fevm)}}</div>
															<div class="col-5">{{$evm['faturatutari'][$fm]}}</div>
															<div class="col-3">{{$evm['parabirimi'][$fm]}}</div>

														</div>
												@endforeach
										@endif
								 </div>
							 </div>

						@endforeach
					@endif
			@endif
		</div>
	</div>
</div>

</div>


<!-- </div>  -->


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
