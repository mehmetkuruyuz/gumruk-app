@extends('layouts.app')

@section('kirinti')
	{{trans('messages.userlistheader')}}
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
        url: '/user/view/'+id,
        data: {
            // _token: token, buna ÅŸimdilik gerek yok
        },
        error: function (request, error) {
          //  console.log(arguments);
            alert(" {{trans('messages.systemaccesserror')}} " + error);
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

@if($errors->any())
		<div class='row'>
            <div class="alert alert-primary col-md-12" role="alert">
            	{{$errors->first()}}
            </div>
		</div>
@endif

	<div class='row'>
	<div class='col-md-12'>
		<div class="panel panel-default mb3">
  		<div class="panel-heading">
          <i class="fa fa-user"></i>{{trans('messages.userlistheader')}}
        </div>
        <div class="panel-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                      <th>{{trans('messages.registerfirmaname')}}</th>
                      <th>{{trans('messages.loginemail')}}</th>

                      <th>{{trans('messages.firmavergi')}}</th>
                      <th>{{trans('messages.firmavergidaire')}}</th>
                      <th>{{trans('messages.firmatelefon')}}</th>
                      <th>{{trans('messages.firmaadres')}}</th>
											@if (\Auth::user()->role=='admin')
												<th>{{trans('messages.useryetki')}}</th>
											@endif
                      <th>{{trans('messages.createddate')}}</th>
											<th style='font-size:0.8em'>{{trans('messages.plakaliste')}}</th>
											@if (\Auth::user()->role=='admin')
												<th style='font-size:0.8em'>{{trans('messages.ozelfiyatlamagoster')}}</th>
											@endif
                      <th style='font-size:0.8em'>{{trans('messages.edit')}}</th>
                      <th style='font-size:0.8em'>{{trans('messages.delete')}}</th>
                </tr>
              </thead>
	          <tbody>
    			@foreach($userList as $key=>$value)
                <tr>
                      <td>{{$value->name}}</td>
                      <td>{{$value->email}}</td>
                      <td>{{$value->vergiNo}}</td>
                      <td>{{$value->vergiDairesi}}</td>
                      <td>{{$value->telefonNo}}</tD>
                      <td>{{$value->address}}</td>
											@if (\Auth::user()->role=='admin')
												@if($value->role=='watcher')
													<td>{{trans('messages.useryetkigereksiz')}}</td>
												@else
														<td>
																@if (!empty($value->yetki))
																	@foreach($value->yetki as $yetkikey=>$yetkivalue)
																		{{trans("messages.".$yetkivalue->talimatType)}}<br />
																	@endforeach
																@endif
														</td>
												@endif

											@endif
                      <td>{{$value->created_at}}</td>
											<td style='font-size:0.8em'><a href='/users/plaka/{{$value->id}}'>{{trans('messages.plakalisteduzenle')}}</a></td>
											 @if (\Auth::user()->role=='admin')
												<td><a href='/muhasebe/ozelfiyatlamagoster/{{$value->id}}'>{{trans('messages.ozelfiyatlamagoster')}}</a></td>
											@endif
											<td style='font-size:0.8em'><a href='/users/edit/{{$value->id}}'>{{trans('messages.edit')}}</a></td>
                      <td style='font-size:0.8em'><a href='/users/delete/{{$value->id}}'>{{trans('messages.delete')}}</a></td>

                </tr>
								@if (!empty($value->ekmail))
								<tr>
									<td></td>
										<td colspan="8">
													@foreach($value->ekmail as $ky=>$ve)
															<a href="mailto:{{$ve->emailAdres}}">{{$ve->emailAdres}}</a>
													@endforeach
										</td>
								</tr>
								@endif
    			@endforeach

              </tbody>
             </table>
             </div>
             </div>
             </div>
             </div>
             </div>

@endsection
