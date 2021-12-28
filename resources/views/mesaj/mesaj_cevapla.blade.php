@extends('layouts.app')

@section('kirinti')
	Cevapla
@endsection
@section('scripts')
  <link rel="stylesheet" href="/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

@endsection

@section('endscripts')
<script src="/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
  <script>
  $(function () {
    //Add text editor
    // alert("asdasd");
    $("#compose-textarea").wysihtml5({
    	  toolbar: {
    		    "font-styles": true, //Font styling, e.g. h1, h2, etc. Default true
    		    "emphasis": false, //Italics, bold, etc. Default true
    		    "lists": true, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
    		    "html": false, //Button which allows you to edit the generated HTML. Default false
    		    "link": false, //Button to insert a link. Default true
    		    "image": false, //Button to insert an image. Default true,
    		    "color": false, //Button to change color of font
    		    "blockquote": false, //Blockquote

    		  }
    		});
  });
</script>
@endsection
@section('content')
<form action='/mesaj/save' method="post" name='a'>
{{ csrf_field() }}
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
           <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">{{trans('messages.newmessage')}}</h3>
            </div>
            <!-- /.box-header -->
                <div class="box-body">
                  <div class="form-group">
                        <label for="messageUserTO">{{trans('messages.remembertouser')}}</label>
                        <select class="form-control" id="messageUserTO" name='userTo' required="required">
                          <option value="0">{{trans('messages.choose')}}</option>
                          @if (!empty($users))
                          	@foreach($users as $key=>$val)
                          	<option value="{{$val['id']}}" @if (!empty($touser)) @if($val['id']==$touser) selected='selected' @endif @endif>{{$val['name']}} ({{$val['email']}})</option>
                          	@endforeach
                          @endif
                        </select>
                  </div>
                  <div class="form-group">
                    <label>{{trans('messages.messagetitle')}}</label>
                    <input class="form-control" name='messageTitle' value="Ce:{{$orjinalMesaj->mesajTitle}}" id="messageControlTitle" placeholder="{{trans('messages.messagetitle')}}"  required="required">
                  </div>
                  <div class="form-group alert alert-info">
                    <hr />
                       {{trans('messages.orginalMessage')}}
                      <br/>
                      {!!$orjinalMesaj->mesajIcerigi!!}
                    <hr/>

                  </hr/>
                  </div>
                        <div class="form-group">
                    <label>{{trans('messages.messagecontent')}}</label>
                  	<textarea id="compose-textarea" class="form-control"  name='messageContent' style="height: 300px"  required="required"></textarea>
                 </div>
                  <div class="form-group">
                  		<button type="submit" class="btn btn-primary">{{trans('messages.messagesendbutton')}}</button>
                  </div>
              </div>
            </div>
        </div>

        </div>
</section>


</form>

@endsection
