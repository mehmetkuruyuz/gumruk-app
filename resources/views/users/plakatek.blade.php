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

										<form name="x" action="/users/plaka-tek" method="post" enctype="multipart/form-data" class="row">
											<div class="col-sm-7">
												{{ csrf_field() }}

												<input type="hidden" value="{{$firmaId}}" name="firmaId" />
												<label for="name" class="col-md-4 control-label">{{trans('messages.plaka')}}</label>
												<input type="text" class="form-control" name="plaka" value="{{ old('plaka') }}" />
											</div>
											<div class="col-sm-7">
												<label for="name" class="col-md-4 control-label">{{trans('messages.plakatipi')}}</label>
												<select  class="form-control" name="plakatipi">
														<option value='0'>{{trans("messages.choose")}}</option>
														<option value="cekici">{{trans("messages.cekiciplaka")}}</option>
														<option value="dorse">{{trans("messages.dorseplaka")}}</option>
												</select>
											</div>
											<div class="col-sm-7 mt-5">
													<button type='submit' class="btn btn-sm btn-info">{{trans("messages.save")}}</button>
											</div>
										</form>
									</td>
								</tr>

						</table>
						</div>
					</div>
			</div>
	</div>

@endsection
