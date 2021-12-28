@extends('layouts.app')
@section("content")
  <div class="col-12">
    <div class="card">
      <div class="card-title p-5">
          <h2>{{trans("messages.talimat")}} {{trans("messages.raporlama")}}</h2>
      </div>
      <div class="card-body">
        <table class="table table-hover table-outline table-vcenter text-nowrap card-table">
             <thead>
               <tr>
                 <th>{{trans("messages.bolge")}}</th>
                 <th>{{trans("messages.bekleme")}}</th>
                 <th>{{trans("messages.firmabekleme")}}</th>
                 <th>{{trans("messages.tamamlandi")}}</th>
               </tr>
             </thead>
             <tbody>
                @if (!empty($data))
                 @foreach ($data as $key => $value)
                   <tr>
                       <td>{{$key}}</td>

                       <td>@if (!empty($value["talimatdurumu"]["bekleme"])) {{$value["talimatdurumu"]["bekleme"]}} @endif</td>
                       <td>@if (!empty($value["talimatdurumu"]["firmabekleme"])) {{$value["talimatdurumu"]["firmabekleme"]}} @endif</td>
                       <td>@if (!empty($value["talimatdurumu"]["tamamlandi"])) {{$value["talimatdurumu"]["tamamlandi"]}} @endif</td>
                   </tr>
                 @endforeach
               @endif
            </tbody>
          </table>
      </div>
    </div>
  </div>


  <div class="col-12">
    <div class="card">
      <div class="card-title p-5">
          <h2>{{trans("messages.invoicelistheader")}} {{trans("messages.raporlama")}}</h2>
      </div>
      <div class="card-body">
        <table class="table table-hover table-outline table-vcenter text-nowrap card-table">
             <thead>
               <tr>
                 <th>{{trans("messages.bolge")}}</th>
                 <th>{{trans("messages.faturaacik")}}</th>
                 <th>{{trans("messages.faturakapali")}}</th>
                 <th>{{trans("messages.cariodeme")}}</th>
                 <th>{{trans("messages.nakitodeme")}}</th>
               </tr>
             </thead>
             <tbody>
                @if (!empty($data))
                 @foreach ($data as $key => $value)
                   <tr>
                       <td>{{$key}}</td>
                       <td>@if (!empty($value["muhasebe"]["cari"])) {{$value["muhasebe"]["cari"]}} @endif</td>
                       <td>@if (!empty($value["muhasebe"]["nakit"])) {{$value["muhasebe"]["nakit"]}} @endif</td>
                       <td>@if (!empty($value["muhasebe"]["acik"])){{$value["muhasebe"]["acik"]}} @endif</td>
                       <td>@if (!empty($value["muhasebe"]["kapali"])){{$value["muhasebe"]["kapali"]}} @endif</td>
                   </tr>
                 @endforeach
               @endif
            </tbody>
          </table>
      </div>
    </div>
  </div>
@endsection
