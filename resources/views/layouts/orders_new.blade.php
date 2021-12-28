

              <a   class="dropdown-item" href="javascript:void(0)">      {{trans('messages.total')}}    @if (!empty($list)) {{ count($list) }} {{trans('messages.adet')}}   @else 0 @endif {{trans('messages.gumruktalimatiheader')}}  </a>
              <div class="dropdown-divider"></div>
                <!-- inner menu: contains the actual data -->

                @if (!empty($list))
			            @foreach($list as $key=>$value)
                  <a href="/operasyon/goster/{{$value->id}}" class="dropdown-item d-flex">
                    <div>
                      <strong> {{$value->user->name}}</strong>
                            @if ($value->durum==0)
                            <i class="fa fa-file text-red"></i>, {{trans('messages.talimatsended')}}
            						 @else
                                 <i class="fa fa-file text-aqua"></i> {{$value->user->name}} {{trans('messages.talimatupdated')}}
                            @endif
                      <div class="small text-muted">10 minutes ago</div>
                    </div>
                  </a>
                	@endforeach
                	@endif
