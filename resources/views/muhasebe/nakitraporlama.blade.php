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
			      autoUpdateInput: false,
			      locale: {
			          cancelLabel: 'Clear'
			      }
			  });

			  $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
			      $(this).val(picker.startDate.format('YYYY-MM-DD') + ' / ' + picker.endDate.format('YYYY-MM-DD'));
			  });

			  $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
			      $(this).val('');
			  });

			});

		});

</script>
@endsection

@section('content')
  <div class='col-md-12'>
  <div class="card">
      <div class="card-header">
        <div class="container-fluid">
          <div class="row">
            <form action="/muhasebe/nakitraporlama" method="post" class="row form-inline float-right">
              {{ csrf_field() }}
              <div class="form-group mx-sm-3 mb-2">
                <label>{{trans("messages.registerdate")}} </label>
                <input type="text" name="datefilter"  class="form-control" readonly value="{{old('datefilter')}}" />
								<label class="mx-3">Excel Aktar <input type="checkbox"  name="excelcikar" value="1"/></label>
                <button type="submit" class="btn btn-info">{{trans("messages.ara")}}</button>
            </div>

            </form>
          </div>
        </div>
      </div>
  </div>
  <div class="col-md-12">
    @if (!empty($bolgelist))
        @foreach ($bolgelist as $key => $value)
            <div class="col-4">
              <div class="card">
                  <div class="card-header">
                      {{$key}}
                  </div>
                  <div class="card-body">
                    <table class="table">
                      <thead>
                        <th> Firma İsmi </th>
                        <th> Price </th>
                        <th> Ödeme Alan </th>
                        <th> Fatura Tipi </th>
                        <th> Tarih </th>
                      </thead>
                    @foreach ($value as $vell => $data)
                      @php
                        if (empty($array[$data->parabirimi])) {$array[$data->parabirimi]=0;}
                          $array[$data->parabirimi]+=$data->odemeFiyat;
                      @endphp
                      <tr>
                          <td> {{$data->muhasebe->user->name}} </td>
                          <td> {{$data->odemeFiyat}} {{$data->parabirimi}} </td>
                          <td> {{$data->odemealanname}} </td>
                          <td> {{trans("messages.".$data->muhasebe->tipi)}} </td>
                          <td> {{$data->created_at}} </td>
                      </tr>
                    @endforeach
                      @if (!empty($array))
                        @foreach ($array as $muk => $duk)
                      <tr>
                        <td colspan="3" class="text-right">{{trans("messages.total")}}</td>
                        <td>{{$muk}}</td>
                        <td>{{$duk}}</td>
                      </tr>
                        @endforeach
                    @endif
                    </table>

                  </div>
            </div>
        @endforeach
    @endif

  </div>
  </div>
@endsection
