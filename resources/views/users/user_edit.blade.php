@extends('layouts.app')

@section('kirinti')
	{{trans('messages.usereditheader')}}
@endsection

@section('scripts')
@endsection
@section('endscripts')

@endsection

@section('content')

            <div class="container">
                <div class="row">
                    <div class="col-md-6   padding-md">
                        <div class="panel panel-default">
                            <div class="panel-heading">{{trans('messages.update')}}</div>
                            <div class="panel-body ">
                                <form class="form-horizontal" method="POST" action="/users/update" enctype="multipart/form-data">
                                    {{ csrf_field() }}
            						<input id="id" type="hidden" class="form-control" name="id" value="{{$userList->id}}" required>
                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                      <div class="col-md-12">
                                        <label for="name" class="col-md-4 ">{{trans('messages.registerfirmaname')}}</label>


                                            <input id="name" type="text" class="form-control" name="name" value="{{$userList->name}}" required autofocus>

                                            @if ($errors->has('name'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif
										</div>
                                    </div>

                                    <div class="form-group">

                                            <div class="col-md-12">
                                            <label for="email">{{trans('messages.loginemail')}}</label>
                                            	<input id="email" type="email" class="form-control" name="email" value="{{$userList->email}}" required>
            								                </div>
                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif

                                    </div>
                                    <div class="form-group">
                                      <div class="col-md-12">
                                          <label for="email">{{trans('messages.moreemailadd')}}</label>
                                          <div class="row">
                                              <div class='col-sm-12 text-right'><a href='javascript:void(0)' onclick="addNewEmailForUser(this)"><i class="fa fa-plus"></i></a></div>
                                          </div>
                                          @if (!empty($ekMail))
                                            @foreach ($ekMail as $key => $value)
                                              <div class="row">
                                                <br />
                                                  <div class="col-sm-11">
                                                    <input id="email" type="email" class="form-control" name="emailek[]" value="{{$value->emailAdres}}" />
                                                  </div>
                                                  <div class="col-sm-1">
                                                      <a href='javascript:void(0)' onclick="deleteThis(this)"><i class="fa fa-minus"></i></a>
                                                  </div>
                                              </div>
                                            @endforeach
                                          @else
                                          <div class="row">
                                              <div class="col-sm-11">
                                                <input id="email" type="email" class="form-control" name="emailek[]" value="" />
                                              </div>
                                              <div class="col-sm-1">
                                                  <a href='javascript:void(0)' onclick="deleteThis(this)"><i class="fa fa-minus"></i></a>
                                              </div>
                                          </div>
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
																									<option value='{{$m->id}}' @if ($userList->bolgeId==$m->id) selected @endif>{{$m->name}}</option>
																								@endforeach
																							@endif
																					</select>
																				</div>

																			</div>

                                     <div class="form-group">
                                        <div class="col-md-12">
                                        	<label for="vergiNo">{{trans('messages.firmavergi')}}</label>
                                            <input id="vergiNo" type="text" class="form-control" name="vergiNo" value="{{$userList->vergiNo}}" @if($userList->role=="watcher") required @endif>
                                        </div>
                                    </div>
                                     <div class="form-group">

                                        <div class="col-md-12">
                                        	<label for="vergiDairesi">{{trans('messages.firmavergidaire')}}</label>
                                            <input id="vergiDairesi" type="text" class="form-control" name="vergiDairesi" value="{{$userList->vergiDairesi}}"  @if($userList->role=="watcher") required  @endif>
                                        </div>
                                    </div>
                                     <div class="form-group">

                                        <div class="col-md-12">
                                        	<label for="telefonNo">{{trans('messages.firmatelefon')}}</label>
                                            <input id="telefonNo" type="text" class="form-control" name="telefonNo" value="{{$userList->telefonNo}}"  @if($userList->role=="watcher") required  @endif>
                                        </div>
                                    </div>
                                     <div class="form-group">

                                        <div class="col-md-12">
                                        	<label for="address">{{trans('messages.firmaadres')}}</label>
                                            <input id="address" type="text" class="form-control" name="address" value="{{$userList->address}}"  @if($userList->role=="watcher") required  @endif>
                                        </div>
                                    </div>
                                    <div class="form-group">

                                        <div class="col-md-12">
                                        	<label for="address">{{trans('messages.firmaresim')}}</label>
                                            <input id="a" type="file" class="form-control" name="resim" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                       <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary">
                                               {{trans('messages.update')}}
                                            </button>
                                       </div>
                                    </div>
                                </form>

                            </div>

                            <hr />
                          <form action="/users/passupdate" method="post" name='a'>
                          <div class="panel panel-default">
                          	<div class="panel-heading">{{trans('messages.passwordupdate')}}</div>
                          		<div class="panel-body">
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

                        </div>
                    </div>
                </div>
            </div>

<script>

function deleteThis(t)
{
  $(t).parent().parent().remove();
}


function addNewEmailForUser(t)
{
    $(t).parent().parent().parent().after().append( '<div class="row"><br />'+
                                                '<div class="col-sm-11">'+
                                                  '<input id="email" type="email" class="form-control" name="emailek[]" value="" />'+
                                                '</div>'+
                                                '<div class="col-sm-1">'+
                                                    '<a href="javascript:void(0)" onclick="deleteThis(this)"><i class="fa fa-minus"></i></a>'+
                                                '</div>'+
                                            '</div>');

}
</script>

@endsection
