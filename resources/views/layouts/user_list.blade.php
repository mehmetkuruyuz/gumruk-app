     <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-user-o"></i>
              <span class="label label-success">@if (!empty($userList)) {{ count($userList) }} @else 0 @endif</span>
            </a>
            <ul class="dropdown-menu">
            
              <li class="header"> @if (!empty($userList)) {{trans('messages.total')}} {{ count($userList) }}  {{trans('messages.onlineuser')}} @else {{trans('messages.noonlineuser')}} @endif</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                 
                             @if (!empty($userList))
           						@foreach($userList as $key=>$value)
           						 <li><!-- start message -->
           						       <a href="/mesaj/yeni/{{$value->user->id}}">
                                            <i class="fa fa-user-o"></i> {{$value->user->name}}                                          
                                        </a>
                                      </li>
           						@endforeach
           					@endif	
              
                  <!-- end message -->
                </ul>
              </li>
            </ul> 