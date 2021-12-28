
              <a   class="dropdown-item" href="javascript:void(0)">{{trans('messages.total')}} @if (!empty($mesajlar)) {{ count($mesajlar) }} {{trans('messages.newmessagedesc')}} @else 0 {{trans('messages.nonewmessage')}} @endif</a>
              <div class="dropdown-divider"></div>
                   @if (!empty($mesajlar))
           						@foreach($mesajlar as $key=>$value)
                      <a href="/mesaj/read/{{$value['id']}}" class="dropdown-item d-flex">

                        <div>
                          <strong>{{$value["from_user"]["name"]}}</strong> {{$value["mesajTitle"]}}
                          <div class="small text-muted">{{$value['dateTime']}}</div>
                        </div>
                      </a>
           						@endforeach
           					@endif
