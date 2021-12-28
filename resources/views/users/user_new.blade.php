@extends('layouts.app')

@section('kirinti')
	{{trans('messages.usersaveheader')}}
@endsection

@section('scripts')
@endsection
@section('endscripts')

@endsection

@section('content')
<form action="/users/save" method="post" name='a'>

 <div class="card  mx-auto mt-2" style="width: 550px">
      <div class="card-header">{{trans('messages.usersaveheader')}}</div>
      <div class="card-body">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">

            				<hr />
                            <div class="panel-body">

                                    {{ csrf_field() }}

                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        <label for="name" class="col-md-4 control-label">{{trans('messages.registerfirmaname')}}</label>

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
                                        <label for="vergiNo" class="col-md-12 control-label">{{trans('messages.firmavergi')}}</label>


                                        <div class="col-md-12">
                                            <input id="vergiNo" type="text" class="form-control" name="vergiNo" value="{{ old('vergiNo') }}" required>
                                        </div>
                                    </div>
                                     <div class="form-group">
                                        <label for="vergiDairesi" class="col-md-12 control-label">{{trans('messages.firmavergidaire')}}</label>
                                        <div class="col-md-12">
                                            <input id="vergiDairesi" type="text" class="form-control" name="vergiDairesi" value="{{ old('vergiDairesi') }}" required>
                                        </div>
                                    </div>
                                     <div class="form-group">
                                        <label for="telefonNo" class="col-md-12 control-label">{{trans('messages.firmatelefon')}}</label>
                                        <div class="col-md-12">
                                            <input id="telefonNo" type="text" class="form-control" name="telefonNo" value="{{ old('telefonNo') }}" required>
                                        </div>
                                    </div>
                                     <div class="form-group">
                                        <label for="address" class="col-md-12 control-label">{{trans('messages.firmaadres')}}</label>
                                        <div class="col-md-12">
                                            <input id="address" type="text" class="form-control" name="address" value="{{ old('address') }}" required>
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
