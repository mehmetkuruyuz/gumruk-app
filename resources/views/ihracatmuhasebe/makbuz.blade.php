<!doctype html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Language" content="en" />
    <link rel="icon" href="./favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" type="image/x-icon" href="./favicon.ico" />
    <!-- Generated: 2018-04-16 09:29:05 +0200 -->
    <title></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext">
    <!-- Dashboard Core -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

  </head>
  <body class="" onload="window.print()">
    <div class="container">
      <div class="row">
        <div class="col-8 mx-auto" >
          <div class="card mb-3">
            <div class="card-header">

            </div>
            <div class="card-body">

              <table class="table">
                <tr>
                    <td colspan="2" class="align-right text-right"><img src='/img/0RRZ19.png' class="img-fluid w-50" /></td>
               </tr>
               <tr>
                  <td colspan="2">
                  {{trans("messages.invoicedate")}} : {{$data->faturaTarihi}}</td>

               </tr>
               <tr>
                 <td>{{trans("messages.invoicenumber")}}</td>
                 <td>@if (!empty($data->faturaNo)) {{$data->faturaNo}} @else {{$data->autoBarcode}} @endif</td>
               </tr>
               <tr>
                 <td>{{trans("messages.autoBarcode")}}</td>
                 <td>{{$data->autoBarcode}}</td>
               </tr>
               <tr>
                 <td>{{trans('messages.registerfirmaname')}}</td>
                 <td>{{$data->user->name}}</td>
              </tr>
              @if (!empty($data->odeme))
                @foreach ($data->odeme as $key => $value)
                    <tr>
                      <td colspan="2">
                          <hr />      
                      </td>
                    </tr>

              <tr>
    							<td>{{trans("messages.invoiceprice")}}</td>
    							<td>{{$value->odemeFiyat}} {{$value->parabirimi}}</td>
    						</tr>
    						<tr>
    							<td>{{trans("messages.odemecinsi")}}</td>
    							<td>{{trans("messages.".$data->odemecinsi)}}</td>

                 </tr>
                 @if (!empty($data->yapan))
                 <tr>
                   <td>{{trans("messages.bolgeilgilenen")}}</td>
                   <td>{{$data->yapan->name}}</td>
                 </tr>
                @endif
                 @if (!empty($data->kapayan))
                 <tr>
                   <td>{{trans("messages.odemealan")}}</td>
                   <td>{{$data->kapayan->name}}</td>
                 </tr>
                @endif

                <tr>
                  <td>{{trans("messages.odemealan")}}</td>
                  <td>  @if (!empty($value->odemealanname)) {{$value->odemealanname}}        @endif</td>
                </tr>

                @endforeach
              @endif

              </table>
            </div>
          </div>
        </div>


    </div>
          </div>
  </body>
</html>
