@extends('layouts.app')

@section('kirinti')
	{{trans('messages.usersaveheader')}}
@endsection

@section('scripts')
@endsection
@section('endscripts')
<script>
require(['select2'], function() {

		 $('#select333').select2();
});

</script>
@endsection

@section('content')
<form action="/admins/update" method="post" name='a'>

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
																				<input type="hidden" name="userId" value="{{$userList->id}}" />
                                        <div class="col-md-12">
                                            <input id="name" type="text" class="form-control" name="name" value="{{$userList->name}}" required autofocus>

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
                                            <input id="email" type="email" class="form-control" name="email" value="{{$userList->email}}" required>

                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
																		@if (\Auth::user()->role=="admin")
																	<div class="form-group">
																			<label for="bolgeSecim">{{trans("messages.bolge")}}</label>
																			<div class="col-md-12">
																				<select  @if ($userList->role=="muhasebeadmin") name='bolgeSecim[]' multiple @else name='bolgeSecim' @endif  class="form-control"  id="select333" >
																						<option value='0'>({{trans("messages.choose")}})</option>
																							@if (!empty($bolge))
																								@foreach($bolge as $z=>$m)
																									<option value='{{$m->id}}' @if ($userList->bolgeId==$m->id) selected="selected" @endif @if($userList->role=="muhasebeadmin") @if (in_array($m->id,$muhasebebolge)) selected @endif @endif>{{$m->name}}</option>
																								@endforeach
																							@endif
																				</select>
																			</div>

																		</div>
																		@endif
																		<div class="form-group temizlenebilir">
																			<div class="form-label">{{trans("messages.yetkilendirilecektalimattipi")}}</div>
																				<div class="custom-controls-stacked">


																			 @if (!empty($talimatList))
																							@foreach($talimatList as $key=>$value)
																								<label class="custom-control custom-checkbox">
																										<input type="checkbox" class="custom-control-input" name="izinliTalimat[]"  @if (in_array( $value->kisaKod, $yetkiler)) checked="checked" @endif value="{{ $value->kisaKod }}">
																									<span class="custom-control-label">	{{ $value->kodName }}</span>
																								</label>
																							@endforeach
																							<label class="custom-control custom-checkbox">
																									<input type="checkbox" class="custom-control-input" name="izinliTalimat[]"  @if (in_array( "bondeshortie", $yetkiler)) checked="checked" @endif value="bondeshortie">
																								<span class="custom-control-label">{{trans("messages.bondeshortie")}}</span>




																							</label>
																							<label class="custom-control custom-checkbox">
																									<input type="checkbox" class="custom-control-input" name="izinliTalimat[]"  @if (in_array( "ithalatimport", $yetkiler)) checked="checked" @endif value="ithalatimport">
																								<span class="custom-control-label">{{trans("messages.ithalatimport")}}</span>
																							</label>

																				@endif
																		 </div>
																	 </div>
																		<div class="form-group">
																				<label for="">{{trans("messages.admintipi")}}</label>
																				<div class="col-md-12">
																					<select name='admintipi' class="form-control"  id="" >
																							<option value='0'>({{trans("messages.choose")}})</option>
																							<option value='bolgeadmin' @if ($userList->role=="bolgeadmin") selected="selected" @endif>{{trans("messages.admin")}}</option>
																							<option value='muhasebeadmin' @if ($userList->role=="muhasebeadmin") selected="selected" @endif>{{trans("messages.muhasebeadmin")}}</option>
																							<option value='admin' @if ($userList->role=="admin") selected="selected" @endif>{{trans("messages.anaadmin")}}</option>
																							<option value='nakitadmin' @if ($userList->role=="nakitadmin") selected="selected" @endif>{{trans("messages.kasaadmin")}}</option>
																					</select>
																				</div>

																			</div>
                                     <div class="form-group">
                                        <label for="telefonNo" class="col-md-12 control-label">{{trans('messages.adminelemantelefon')}}</label>
                                        <div class="col-md-12">
                                            <input id="telefonNo" type="text" class="form-control" name="telefonNo" value="{{ $userList->telefonNo }}" required>
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

<hr />
<form action="/users/passupdate" method="post" name='a'>
	<div class="card  mx-auto mt-2" style="width: 550px">
			 <div class="card-header">{{trans('messages.passwordupdate')}}</div>
			 <div class="card-body">
				 <label for="sifre">{{trans('messages.loginpassword')}}</label>
				 <div class="col-md-12">
					 {{ csrf_field() }}
					<input id="id" type="hidden" class="form-control" name="id" value="{{$userList->id}}" required autofocus>
				<input id="password" type="text" class="form-control" name="password" value="" required><br />
					<button type="submit" class="btn btn-primary">{{trans('messages.update')}}</button>
		</div>

	</div>

</div>

</form>
@endsection
