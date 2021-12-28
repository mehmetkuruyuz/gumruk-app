@extends('layouts.app')

@section('kirinti')
	{{trans('messages.allmessages')}}

@endsection
@section('scripts')

@endsection
@section('content')



    <section class="content">
      <div class="row">
				<div class="col-md-3">
				                <h3 class="page-title mb-5">Mail Service</h3>
				                <div>
				                  <div class="list-group list-group-transparent mb-0">
														<a href="/mesaj/yeni" class="btn btn-secondary btn-block mb-5">{{trans('messages.newmessage')}}</a>


				                    <a href="/mesaj" class="list-group-item list-group-item-action d-flex align-items-center active">
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
        <!-- /.col -->
        <div class="col-md-9">
            <div class="card">
              <div class="card-body">
              <h3 class="card-title">{{trans('messages.inbox')}}</h3>

              <div class="box-tools pull-right">
                <div class="has-feedback">

                  <span class="glyphicon  glyphicons-info-sign form-control-feedback"></span>
                </div>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="card-body no-padding">
              <div class="mailbox-controls">
                <!-- Check all button -->

                <div class="btn-group">
                  @if (!empty($mesaj["id"]))
                    <a href='/mesaj/sil/{{$mesaj["id"]}}' onclick="return confirm('{{trans("messages.messageconfirmdelete")}}');" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></a>
                    <a href='/mesaj/cevapla/{{$mesaj["id"]}}' class="btn btn-default btn-sm"><i class="fa fa-reply"></i></a>
                  @endif
                </div>
                <!-- /.btn-group -->
                <!-- /.pull-right -->
              </div>

        	         <div class="table-responsive mailbox-messages">
                      @if (!empty($mesaj["mesajTitle"]))
              	      <div class="mailbox-read-info">
                        <h3>{{$mesaj["mesajTitle"]}}</h3>
                        <h5>Alıcı: {{$mesaj["to_user"]['name']}} </h5>
                        <h5>Gönderen: {{$mesaj["from_user"]['name']}}  <span class="mailbox-read-time pull-right">{{ Carbon\Carbon::parse($mesaj['dateTime'])->format('d-m-Y h:i')}}</span></h5>
              </div>
              @endif
              <!-- /.mailbox-read-info -->

              <!-- /.mailbox-controls -->
                  @if (!empty($mesaj["mesajIcerigi"])) 
              <div class="mailbox-read-message">
              		{!!$mesaj["mesajIcerigi"]!!}
              </div>
            @endif
        	  </div>
        </div>
</section>



@endsection
