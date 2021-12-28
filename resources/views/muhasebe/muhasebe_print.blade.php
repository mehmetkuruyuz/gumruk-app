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
    <div class="container-fluid">
      <div class="row">
        <div class="col-12 mx-auto" >

  <div class="card">
      <div class="card-header">

      </div>
      <div class="card-body">
				<div class='row mb-4'>

					<div class='col-md'>
						{{trans("messages.muhasebeodemecheck")}}</div>

				 </div>
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
						<tr>
							<td>{{trans("messages.companyname")}}</td>
							<td>{{$data->user->name}}</td>
							<td>{{trans("messages.firmatelefon")}}</td>
							<td>{{$data->user->telefonNo}}</td>
						</tr>
						<tr>
							<td>{{trans("messages.invoicedate")}}</td>
							<td>{{$data->faturaTarihi}}</td>
							<td>{{trans("messages.invoicetype")}}</td>
							<td>{{$data->tipi}}</td>
						</tr>
						<tr>
							<td>{{trans("messages.invoicerefence")}}</td>
							<td>{{$data->faturaReferans}}</td>
              <td>{{trans("messages.invoicenumber")}}</td>
							<td>@if (!empty($data->faturaNo)) {{$data->faturaNo}} @else {{$data->autoBarcode}} @endif</td>
						</tr>
						<tr>
							<td>{{trans("messages.invoiceprice")}}</td>
							<td>{{$data->price}}</td>
							<td>{{trans("messages.parabirimi")}}</td>
							<td>{{$data->moneytype}}</td>
						</tr>
						<tr>
							<td>{{trans("messages.odemecinsi")}}</td>
							<td>{{$data->odemecinsi}}</td>
							<td>{{trans("messages.faturadurumu")}}</td>
							<td>{{trans("messages.fatura".$data->faturadurumu)}} </td>
						</tr>
						<tr>
							<td>{{trans("messages.bolgeilgilenen")}}</td>
							<td>{{$data->yapan->name}}</td>
							<td>{{trans("messages.autoBarcode")}}</td>
							<td>{{$data->autoBarcode}}</td>
						</tr>
					</table>
      </div>
  </div>
</body>
</html>
