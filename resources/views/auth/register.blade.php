@php

  exit;
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Bosphore GROUP</title>
  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">

  <style type="text/css">
    body{background: url("/img/cargo-ship-01.jpg") no-repeat;}
  </style>
</head>
{{ Helper::langSet() }}
<body class="bg-dark" >
  <div class="container">
      <div class="card  mx-auto mt-2" style="width: 550px">
      <div class="card-header">{{ trans('messages.loginheader') }}</div>
      <div class="card-body">

            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-md-offset-2">
                        <div class="panel panel-default">
                            <div class="panel-heading">{{ trans('messages.loginheadermessage') }}</div>
            				<hr />
                            <div class="panel-body">
                                <form class="form-horizontal" method="POST" action="{{ route('register') }}">
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
                                        <label for="password-confirm" class="col-md-12 control-label">{{trans('messages.loginpasswordagain')}}</label>

                                        <div class="col-md-12">
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
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
                                                {{trans('messages.kaydet')}}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

</div>
</div>
</div>
</body>
</html>
