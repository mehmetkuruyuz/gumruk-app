@extends('layouts.app')

@section('kirinti')
	{{trans('messages.plakaliste')}}
@endsection

@section('scripts')
@endsection
@section('endscripts')

@endsection

@section('content')
	<div class="panel panel-default mb-3">
        <div class="panel-body">
        	<div class='row'>
            <div class='col-sm-11'>
							<table class="table table-bordered" cellspacing="0" >
								<tr>
									<td colspan="4">
										Plaka Yükle (excel dosyası)
										<form name="x" action="/users/plaka-upload" method="post" enctype="multipart/form-data" class="row">
											<div class="col-sm-5">
												{{ csrf_field() }}
												<input type="hidden" value="{{$firmaId}}" name="firmaId" />
												<input type="file"  class="form-control" name="excelfile" />
											</div>
											<div class="col-sm-2">
													<button type='submit' class="btn btn-sm btn-info">Plaka Yükle</button>
											</div>
												<div class="col-sm-2">
												<a href='/uploads/sample.xls' target="_blank">{{trans("messages.sampledownload")}}</a>
											</div>
										</form>
									</td>
								</tr>
								<tr>
									<td colspan="4">
											<a href="/users/plaka-tek/{{$firmaId}}">Tek Plaka Kayıt</a>
									</td>
								</tr>
								@foreach ($plakaliste as $key => $value)
									<tr>
											<td>{{$value['plaka']}}</td>
	 										<td>{{trans("messages.".$value['type']."plaka")}}</td>
	  									<td>{{$value['created_at']}}</td>
											<td><a href="/users/plaka-delete/{{$value['id']}}/{{$firmaId}}" onclick="return confirm('{{ trans('messages.silmeeminmisiniz') }}') ">{{trans('messages.delete')}}</a></td>
									</tr>
								@endforeach

						</table>
						</div>
					</div>
			</div>
	</div>

@endsection
