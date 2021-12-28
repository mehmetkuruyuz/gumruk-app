
<div class="tab-pane  @if ($say>0) fade @else active @endif" id="tab-{{$say+1}}"  aria-labelledby="tab{{$say+1}}" >

  <h3>{{trans("messages.lutfengumrukbilgigiriniz")}} - {{$say+1}}</h3>
  {{$talimat}}
</div>
