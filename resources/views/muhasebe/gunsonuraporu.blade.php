@extends('layouts.app')
@section('kirinti')
	{{trans("messages.newinvoiceheader")}}
@endsection

@section('scripts')
    <link href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" rel="stylesheet"/>
@endsection

@section('endscripts')

<script>
function formTemizle()
{

$(':input','.temizlenebilir')
.not(':button, :submit, :reset')
.val('')
.prop('checked', false)
.prop('selected', false);

}
</script>

<script type="text/javascript">

    require(['daterangepicker'], function() {

			$(function() {

			  $('input[name="datefilter"]').daterangepicker({
			      autoUpdateInput: true,
            "singleDatePicker": true,
			      locale: {
                    format: 'YYYY-MM-DD',
			          cancelLabel: 'Clear'
			      }
			  });

			});

		});

</script>
@endsection

@section("content")
  <div class="col-12">
    <div class="card">
      <div class="card-title p-5">
          <h2>{{trans("messages.gunsonu")}} {{trans("messages.raporlama")}}</h2>
          <form action="/gunsonuraporu" method="post" class="row form-inline float-left">
            {{ csrf_field() }}
            <div class="form-group mx-sm-3 mb-2">
              <label>{{trans("messages.tarihlerarasi")}} </label>
              <input type="text" name="datefilter"  class="form-control" readonly value="{{old('datefilter')}}" />
              <button type="submit" class="btn btn-info">{{trans("messages.gunsonuraporcikar")}} </button>
          </div>

          </form>
      </div>
      <div class="card-body">
        <table class="table">
          <thead>
            <th>Tarih Baslangic</th>
            <th>Tarih Bitis</th>
            <th>{{trans("messages.totaltl")}}</th>
            <th>{{trans("messages.totaleuro")}}</th>
            <th>{{trans("messages.totaldolar")}}</th>
            <th>{{trans("messages.totalpound")}}</th>
            <th>yapanId</th>
          </thead>
          <tbody>
          @if (!empty($gunsonuraporlar))
            @foreach($gunsonuraporlar as $key=>$value)
              <tr>
                <td>{{\Carbon\Carbon::parse($value->tarihbaslangic)->format("Y-m-d")}}</td>
                <td>{{\Carbon\Carbon::parse($value->tarihbitis)->format("Y-m-d")}}</td>
                <td>{{$value->totaltl}}</td>
                <td>{{$value->totaleuro}}</td>
                <td>{{$value->totaldolar}}</td>
                <td>{{$value->totalpound}}</td>
              <td>{{$value->yapanId}}</td>
            </tr>
            @endforeach
          @endif
        </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
