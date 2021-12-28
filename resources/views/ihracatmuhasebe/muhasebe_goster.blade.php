@extends('layouts.app')

@section('kirinti')
	{{trans("messages.newinvoiceheader")}}
@endsection

@section('scripts')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" rel="stylesheet"/>

@endsection
@section('endscripts')


	<script>
	function PopupCenter(url, title, w, h) {
	    // Fixes dual-screen position                         Most browsers      Firefox
	    var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : window.screenX;
	    var dualScreenTop = window.screenTop != undefined ? window.screenTop : window.screenY;

	    var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
	    var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

	    var left = ((width / 2) - (w / 2)) + dualScreenLeft;
	    var top = ((height / 2) - (h / 2)) + dualScreenTop;
	    var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

	    // Puts focus on the newWindow
	    if (window.focus) {
	        newWindow.focus();
	    }
	}

function formTemizle()
{

$(':input','.temizlenebilir')
.not(':button, :submit, :reset')
.val('')
.prop('checked', false)
.prop('selected', false);

}
</script>
@endsection

@section('content')

  <div class="card">
      <div class="card-header">

      </div>
      <div class="card-body">
				<div class='row mb-4'>

					<div class='col-md'>
						{{trans("messages.muhasebeodemecheck")}}</div>

								@php
										$toplam=array();
										$whatiswhat=array();
										if (!empty($data->altmodel))
										{
												foreach ($data->altmodel as $key => $value)
												{
														if (empty($toplam[$value->moneytype])) {$toplam[$value->moneytype]=0;}
														$toplam[$value->moneytype]=$value->price+$toplam[$value->moneytype];
														if (empty($whatiswhat[$value->tipi])) {$whatiswhat[$value->tipi]=0;}
														$whatiswhat[$value->tipi]=$whatiswhat[$value->tipi]+1;
												}
										}

								//		print_r($toplam);
								@endphp
							<div class='col-md-2 text-right'>
								<a href='javascript:void(0)' onclick="PopupCenter('/ihracat/muhasebe/faturayazdir/{{$data->id}}','xtf','930','500'); " class="btn btn-danger align-left">{{trans("messages.faturayazdir")}}</a>
							</div>
              	@if ($data->faturadurumu=="kapali")
							<div class='col-md-2 text-right'>
							 <a href='javascript:void(0)' onclick="PopupCenter('/ihracat/muhasebe/makbuz/{{$data->id}}','xtf','930','500'); " class="btn btn-danger align-right">{{trans("messages.makbuzyazdir")}}</a>
						 </div>
				 		@endif
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
							<td>
									@foreach ($whatiswhat as $key => $value)
										<span>{{trans("messages.".$key)}} : {{$value}}</span>	<br />
									@endforeach</td>
						</tr>
						<tr>
							<td>{{trans("messages.invoicerefence")}}</td>
							<td>{{$data->faturaReferans}}</td>
							<td>{{trans("messages.invoicenumber")}}</td>
							<td>@if (!empty($data->faturaNo)) {{$data->faturaNo}} @else {{$data->autoBarcode}} @endif</td>
						</tr>
						<tr>
							<td>{{trans("messages.invoiceprice")}}</td>
							<td colspan="3">
								@foreach ($toplam as $key => $value)
									<span>{{$key}} : {{$value}}</span>	<br />
								@endforeach
						</td>
						</tr>
						<tr>
							<td>{{trans("messages.odemecinsi")}}</td>
							<td>{{trans("messages.".$data->odemecinsi)}}</td>
							<td>{{trans("messages.faturadurumu")}}</td>
							<td>{{trans("messages.fatura".$data->faturadurumu)}} @if($data->faturadurumu=="acik") <a href="/ihracat/muhasebe/kapa/{{$data->id}}" class="btn btn-danger">{{trans("messages.faturakapat")}}</a> @endif</td>
						</tr>
						<tr>
							<td>{{trans("messages.bolgeilgilenen")}}</td>
							<td>{{$data->yapan->name}}</td>
							<td>{{trans("messages.autoBarcode")}}</td>
							<td>{{$data->autoBarcode}}</td>
						</tr>
            <tr>
              <td>{{trans("messages.muhasebeodemecheck")}}</td>
              <td>@if (!empty($data->odeme))
								@foreach ($data->odeme as $key => $value)
									{{-- $data->odeme->durumu=='odendi' 								 {{trans("messages.odendi")}}  @else {{trans("messages.odenmedi")}} @endif</td>
									              <td>{{trans("messages.odemealan")}} --}}
								@endforeach
							@endif
								</td>
              <td>
								@if (!empty($data->odeme))
									@foreach ($data->odeme as $key => $value)
										 	{{$data->odeme[0]->odemealanname}}							
									@endforeach
							@endif		
              </td>
            </tr>
					</table>
      </div>
  </div>

@endsection
