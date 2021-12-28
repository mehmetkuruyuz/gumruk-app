<!doctype html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Language" content="en" />
    <meta name="msapplication-TileColor" content="#2d89ef">
    <meta name="theme-color" content="#4188c9">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <link rel="icon" href="./favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" type="image/x-icon" href="./favicon.ico" />
    <!-- Generated: 2018-04-16 09:29:05 +0200 -->
    <title>Bosphore GROUP - {{ trans('messages.pagetitle') }}</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext">

    <script src="/assets/js/require.min.js"></script>
    <script>
      requirejs.config({
          baseUrl: 'http://crea.iskontrol.info/'
      });
    </script>

    <!-- Dashboard Core -->
    <link href="/assets/css/dashboard.css" rel="stylesheet" />
    <script src="/assets/js/dashboard.js"></script>
    <!-- c3.js Charts Plugin -->
    <link href="/assets/plugins/charts-c3/plugin.css" rel="stylesheet" />
    <script src="/assets/plugins/charts-c3/plugin.js"></script>
    <!-- Google Maps Plugin -->
    <link href="/assets/plugins/maps-google/plugin.css" rel="stylesheet" />
    <script src="/assets/plugins/maps-google/plugin.js"></script>
    <!-- Input Mask Plugin -->
    <script src="/assets/plugins/input-mask/plugin.js"></script>
    @yield('scripts')
  </head>
  <body class="">
<div class="container">
  <div class="row">
      <div class="col-8 mx-auto mt-5 text-center" >
        <form action='/operation/file/upload' method="post"  enctype="multipart/form-data" name='a'>
          <div class='col-md-12 border '>
            <h2>{{trans("messages.talimatevrakyuklemebaslik")}}</h2>
            <br />
              <div class="form-group col-md-12">
                          <label for="gallery-photo-add">{{trans("messages.evrakyukle")}}</label>
                          <small>{{trans("messages.evrakyuklealt")}}</small>
                          <input type="file" name='files[]' class='form-control' multiple id="gallery-photo-add">
                            <div id='dgalleryd' class="gallery"></div>
                        </div>
            </div>
          {{ csrf_field() }}
          <input type='hidden' name="talimatId" value="{{$id}}" />
          <button class='btn btn-info' type='submit'>{{trans("messages.dosyayuklekaydet")}}</button>
        </form>
      </div>

  </div>


</div>
</body>
</html>
