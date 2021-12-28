
<div class="tab-pane  @if ($say>0) fade @else active @endif" id="tab-{{$say+1}}"  aria-labelledby="tab{{$say+1}}" >

  <h3>{{trans("messages.lutfengumrukbilgigiriniz")}} - {{$say+1}}</h3>
  <hr />

    <table class="table table-bordered malYuklemeBosaltmaTablolari" width="100%" cellspacing="0">
      <thead>
          <tr>
            <th>{{trans("messages.plaka")}}</th>
            <th>{{trans("messages.gonderici")}}</th>
            <th>{{trans("messages.date")}}</th>
          </tr>
      </thead>
      <tbody>
          <tr id="sampletr{{$say}}">
            <td><input type="text" class="form-control" name="plaka" required="required"/></td>
            <td><input type="text" class="form-control" name="gonderici" required="required" value="{{$name}}" /></td>
            <td><input type="text" class="form-control" name="date" required="required" value="{{Carbon\Carbon::parse('now')->format("Y-m-d H:i:s")}}" /></td>
          </tr>
      </tbody>
    </table>


</div>
