@extends('layouts.app')

@section('kirinti')
	Tüm Mesajlar
@endsection
@section('scripts')
	<script>
		function changeModalData(id,userid)
		{
			$(".mesajCevapla").remove();

			$("#mesajModalLabel").html($("#titleTD_"+id).text());
			$("#messageBody").html($("#messageTD_"+id).html());
			if ({{\Auth::user()->id}}!=userid)
			{
				$(".modal-footer").prepend('<button class="btn btn-primary mesajCevapla"  data-ider="" onclick="cevapla('+id+')" >{{trans("messages.reponsemessage")}}</button>');
			}

			$("#buttonId").data('ider',id);

		}

		$("#mesajModal").modal("hide");

		function cevapla(id)
		{
			 document.location.href='/mesaj/cevapla/'+id;
		}

		function messageReaded()
		{
			var _id=$("#buttonId").data('ider');
			//var token= $('#xcsrftoken').val();

	        $.ajax({
	            headers: {
	                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	            },
	            type: 'GET',
	            url: '/mesaj/oku/'+_id,
	            data: {
	              // _token: token,
	            },
	            error: function (request, error) {
	                console.log(arguments);
	                alert("{{trans('messages.systemaccesserror')}} " + error);
	            },
	            success: function (data)
	            {
	            	console.log("0");
	            }
	        });

		}
	</script>
@endsection
@section('content')

    <section class="content">
      <div class="row">
				<div class="col-md-3">
				                <h3 class="page-title mb-5">Mail Service</h3>
				                <div>
				                  <div class="list-group list-group-transparent mb-0">
														<a href="/mesaj/yeni" class="btn btn-secondary btn-block mb-5">{{trans('messages.newmessage')}}</a>


				                    <a href="/mesaj" class="list-group-item list-group-item-action d-flex align-items-center">
				                      <span class="icon mr-3"><i class="fe fe-inbox"></i></span>{{trans('messages.incoming')}} <span class="ml-auto badge badge-primary">{!! Helper:: newMailCount() !!}</span>
				                    </a>
				                    <a href="/mesaj/yeni" class="list-group-item list-group-item-action d-flex align-items-center">
				                      <span class="icon mr-3"><i class="fe fe-send"></i></span>{{trans('messages.newmessage')}}
				                    </a>
				                    <a href="/mesaj/sent" class="list-group-item list-group-item-action d-flex align-items-center">
				                      <span class="icon mr-3"><i class="fe fe-alert-circle"></i></span>{{trans('messages.sendingmessage')}}
				                    </a>
														@if(Auth::user()->role=='admin')
					                    <a href="/mesaj/deleted" class="list-group-item list-group-item-action d-flex align-items-center">
					                      <span class="icon mr-3"><i class="fe fe-trash-2"></i></span>{{trans('messages.deletedmessage')}}
					                    </a>
														@endif
				                  </div>
				                  <div class="mt-6">
				                    <a href="/mesaj/yeni" class="btn btn-secondary btn-block">{{trans('messages.newmessage')}}</a>
				                  </div>
				                </div>
				</div>


        <div class="col-md-3 d-none">

          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">{{trans('messages.folder')}}</h3>
              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body no-padding">
              <ul class="nav nav-pills nav-stacked">
                <li class="active"><a href="/mesaj"><i class="fa fa-inbox"></i>
                  <span class="label label-primary pull-right"></span></a></li>
                </li>
				<li class="active"><a href=""><i class="fa fa-inbox"></i>
				</a></li>
				@if(Auth::user()->role=='admin')
				<li class="active"><a href=""><i class="fa fa-inbox"></i> {{trans('messages.deletedmessage')}}
				</a></li>
				@endif
              </ul>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">{{trans('messages.inbox')}}</h3>

              <div class="box-tools pull-right">
                <div class="has-feedback">

                  <span class="glyphicon  glyphicons-info-sign form-control-feedback"></span>
                </div>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="mailbox-controls">
                <!-- Check all button -->

                <div class="btn-group">
                  <button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>

                </div>
                <!-- /.btn-group -->
                <!-- /.pull-right -->
              </div>
        	  <div class="table-responsive mailbox-messages">
                <table class="table table-hover table-striped">
                  <tbody>
                   	@if (!empty($mesajlar))
                  		@foreach($mesajlar as $key=>$value)
                          <tr>

                            <td class="mailbox-star"><a href="#"><i class="fa fa-star text-yellow"></i></a></td>
                            <td class="mailbox-name"><a href="/mesaj/read/{{$value["id"]}}">{{$value["from_user"]["name"]}}</a></td>
                            <td class="mailbox-subject">@if ($value['viewed']=='no')<b>{{$value['mesajTitle']}}</b> @else {{$value['mesajTitle']}} @endif - <span class='text-muted'>{{ str_limit( strip_tags($value['mesajIcerigi']), $limit = 50, $end = '...')}}</span>
                            </td>
                            <td class="mailbox-attachment"></td>
                            <td class="mailbox-date">{{\Carbon\Carbon::parse($value['dateTime'])->diffInDays(\Carbon\Carbon::now())}} {{trans('messages.gunonce')}}</td>
                          </tr>
                    	@endforeach
                    	 @else
                        <tr>
                        	<td colspan='5'>
                        	 <div class="alert alert-success alert-dismissable">
                        	 	{{trans('messages.nomessages')}}
                        	 </div>
                        	</td>
                        </tr>
                      @endif

                  </tbody>

                </table>

        </div>
        </div>
</section>
@endsection
