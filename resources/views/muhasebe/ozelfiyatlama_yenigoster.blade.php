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
		<div class="panel panel-default">
        <div class="panel-heading">
          <i class="fa fa-table"></i> {{trans('messages.invoicelistheader')}}
        </div>
        <div class="panel-body">
          <div class="table-responsive">
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
