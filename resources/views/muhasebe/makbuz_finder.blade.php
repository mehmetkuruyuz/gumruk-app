@extends('layouts.app')

@section('kirinti')
	{{trans("messages.newinvoiceheader")}}
@endsection

@section('scripts')


@endsection

@section('content')
  <div class="card">
      <div class="card-header">
          <h2>{{trans("messages.ara")}}</h2>
      </div>
      <div class="card-body">
        <table class="table table-bordered" cellspacing="0">
        <tr>
            <td>{{trans("messages.invoicedate")}}</td>
            <td>{{$data->faturaTarihi}}</td>
        </tr>
        <tr>
            <td>{{trans("messages.invoicecompanyheader")}}</td>
            <td>{{$data->user->name}}</td>
        </tr>
        <tr>
            <td>{{trans("messages.invoicetype")}}</td>
            <td>{{$data->tipi}}</td>
        </tr>
        <tr>
            <td>{{trans("messages.invoiceprice")}}</td>
            <td>{{$data->price}} {{$data->moneytype}}</td>
        </tr>
        <tr>
            <td>{{trans("messages.autoBarcode")}}</td>
            <td>{{$data->autoBarcode}}</td>
        </tr>
        <tr>
          <td colspan="2" align="center"><a href='/muhasebe/makbuz/{{$data->id}}' class="btn btn-danger">{{trans("messages.print")}}</a></td>
        </tr>

</table>







          <span></span>
      </div>
  </div>

@endsection
