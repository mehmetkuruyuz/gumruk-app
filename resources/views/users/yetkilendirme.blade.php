@extends('layouts.app')

@section('kirinti')
	{{trans('messages.usersaveheader')}}
@endsection

@section('scripts')
	<style>
		.border-success{border:1px solid #3f704D;}
	</style>
@endsection
@section('endscripts')

<script>
require(['select2'], function() {

		 $('#select333').select2();
});
function finderAllYetki()
{
	var uid=$('#select333').val();
	if (uid!=0)
	{
	$.ajax({
         url: "/yetkilendirme/show",
         type: "post",
         data: {
					 userid:uid,
					 _token:"{{csrf_token()}}"
				 },
         success: function (response)
				 {
					 $('input:checkbox').prop('checked',false);
					 $('input:checkbox').parent().parent().removeClass("border-success");
					 $.each(response, function(i, item)
					 {
						 $(":checkbox[value='"+item.pageurl+"']").prop("checked",true);
						 $(":checkbox[value='"+item.pageurl+"']").parent().parent().addClass("border-success");
					});
            // You will get response from your PHP page (what you echo or print)
         },
         error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
         }
     });
	 }

}
</script>
@endsection

@section('content')
<form action="/yetkilendirme/save" method="post" >
    {{csrf_field()}}
    <div class="card  mx-auto mt-2">
     <div class="card-header">{{trans('messages.yetkilendirme')}}</div>
     <div class="card-body">
       <div class="row">
         <div class="col-md-6">
           <span class="col-md-12">{{trans("messages.adminsec")}}</span><br />
           @if ($userlist)
             <select name="userid" id="select333" onchange="finderAllYetki()">
							 <option value="0">{{trans("messages.choose")}}</option>
             @foreach ($userlist as $key => $value)
                <option value="{{$value->id}}"> {{$value->name}} ({{trans("messages.$value->role")}}) - {{$value->email}} </option>
             @endforeach
             </select>
           @endif
         </div>
         <div class="col-md-6">
           <div class="row" id="allcheckbox">
	            @if ($urllist)
	              @foreach ($urllist as $key => $value)
	                @if ($value->uri!='checkphpversionforkontrol/{randid?}')
										@if (strpos(trans("messages.".$value->uri),"PASIF")===false)
			                <div class="col-md-2 border p-1 m-1">
			                  <div class="form-check">
			                    <input class="form-check-input" type="checkbox" name="access[]" value="{{$value->uri}}" />
			                    <label class="form-check-label" for="">
			                      {{trans("messages.".$value->uri)}}
			                    </label>
			                  </div>
			                </div>
										@endif
	                @endif
	              @endforeach
	            @endif
          </div>
         </div>
         <div class="">
           <button type="submit" class="btn btn-success">Yetkilendir</button>
         </div>
       </div>

     </div>
   </div>
</form>
@endsection
