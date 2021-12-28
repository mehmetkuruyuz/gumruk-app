
<div class="tab-pane  @if ($say>0) fade @else active @endif" id="tab-{{$say+1}}"  aria-labelledby="tab{{$say+1}}" >

  <h3> {{$say+1}} - {{trans("messages.lutfengumrukbilgigiriniz")}} </h3>

  <div class="form-group">
    <div class="row">
      <label for="talimatipi_{{$say}}" class="col-auto col-form-label">{{trans("messages.alicigondericiadet")}}</label>
      <div class="col-sm-6">
        <select name="talimatsecici[{{$say}}][]" class="form-control" data-num="1" id="talimatsecici_{{$say}}">
          @if (!empty($talimatList))
            @foreach ($talimatList as $key => $value)
                <option value="{{$value->kisaKod}}">{{$value->kodName}}</option>
            @endforeach
          @endif
        </select>
      </div>
      <div class="col-sm-2">
        <button type="button" class="btn btn-info" onclick="addItemTo({{$say}})">{{trans("messages.add")}}</button>
      </div>
    </div>

  </div>
  <hr />
    <div id='gumruk_alt_{{$say}}'>

    </div>

  </div>
