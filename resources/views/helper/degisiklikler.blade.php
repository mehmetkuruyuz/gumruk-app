	 	  
	 	  @if (!empty($list))
	 	  	@foreach($list as $key=>$value)
	 	  		<li><a href="javascript:void(0)" onclick='openMyPopup("/talimat/eski/{{$value->id}}", "Değişiklik","750", "550")'>{{$loop->iteration}}</a></li>
	 	  	@endforeach
	 	  @else
	 	  	<li class='disabled'><a href="javascript:void(0)">{{trans('messages.nochange')}}</a></li>
	 	  @endif