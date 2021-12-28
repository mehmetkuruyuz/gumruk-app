@extends('layouts.app')

@section('kirinti')
	{{trans('messages.usersaveheader')}}
@endsection

@section('scripts')
@endsection
@section('endscripts')

@endsection

@section('content')
<form action="/admins/save" method="post" name='a'>

 <div class="card  mx-auto mt-2" style="width: 550px">
      <div class="card-header">{{trans('messages.usersaveheader')}}</div>
      <div class="card-body">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">{{trans('messages.save')}}</div>
            				<hr />
                            <div class="panel-body">

                                    {{ csrf_field() }}

                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        <label for="name" class="col-md-4 control-label">{{trans('messages.adminusername')}}</label>

                                        <div class="col-md-12">
                                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                            @if ($errors->has('name'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label for="email" class="col-md-12 control-label">{{trans('messages.loginemail')}}</label>

                                        <div class="col-md-12">
                                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
																	<div class="form-group">
																			<label for="bolgeSecim">{{trans("messages.bolge")}}</label>
																			<div class="col-md-12">
																				<select name='bolgeSecim' class="form-control"  id="" >
																						<option value='0'>({{trans("messages.choose")}})</option>
																							@if (!empty($bolge))
																								@foreach($bolge as $z=>$m)
																									<option value='{{$m->id}}'>{{$m->name}}</option>
																								@endforeach
																							@endif
																				</select>
																			</div>

																		</div>
																		<div class="form-group">
																				<label for="">{{trans("messages.admintipi")}}</label>
																				<div class="col-md-12">
																					<select name='admintipi' class="form-control"  id="" >
																							<option value='0'>({{trans("messages.choose")}})</option>
																							<option value='bolgeadmin'>{{trans("messages.admin")}}</option>
																							<option value='muhasebeadmin'>{{trans("messages.muhasebeadmin")}}</option>
																							<option value='admin'>{{trans("messages.anaadmin")}}</option>
																							<option value='nakitadmin'>{{trans("messages.kasaadmin")}}</option>
																					</select>
																				</div>

																			</div>
																		<div class="form-group temizlenebilir" id="dcustomcheck">
																			<div class="form-label">{{trans("messages.yetkilendirilecektalimattipi")}}</div>
																				<div class="custom-controls-stacked">


																			 @if (!empty($talimatList))
																							@foreach($talimatList as $key=>$value)
																								<label class="custom-control custom-checkbox">
																									<input type="checkbox" class="custom-control-input" name="izinliTalimat[]" value="{{ $value->kisaKod }}">
																									<span class="custom-control-label">	{{ $value->kodName }}</span>
																								</label>
																							@endforeach

																				@endif
																		 </div>
																	 </div>

                                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                        <label for="password" class="col-md-12 control-label">{{trans('messages.loginpassword')}}</label>

                                        <div class="col-md-12">
                                            <input id="password" type="password" class="form-control" name="password" required>

                                            @if ($errors->has('password'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                     <div class="form-group">
                                        <label for="telefonNo" class="col-md-12 control-label">{{trans('messages.adminelemantelefon')}}</label>
                                        <div class="col-md-12">
                                            <input id="telefonNo" type="text" class="form-control" name="telefonNo" value="{{ old('telefonNo') }}" required>
                                        </div>
                                    </div>
                                      <div class="form-group">
                                        <div class="col-md-12 col-md-offset-4">
                                            <button type="submit" class="btn btn-primary">
                                                {{trans('messages.save')}}
                                            </button>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

</div>
</div>
</form>
@endsection
