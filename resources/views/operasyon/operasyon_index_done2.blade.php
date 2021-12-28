@extends('layouts.app')

@section('kirinti')
	{{trans('messages.operasyonindex')}}
@endsection

@section('scripts')
<script type="text/javascript">
<!--

//-->

function yonlendirTalimatPage(id,t)
{


	var l=confirm("{{trans('messages.talimatyonlendirmemesaj')}}");
	if (l==true)
	{
			window.location.href='/operasyon/ozelislem/'+id+'/'+$(t).val();
	}
}


function modalAc(islem,id)
{
	$('#islemlerModal .modal-body').html('');
    $.ajax({
        type: 'GET',
        url: '/evrak/view/'+id,
        data: {

        },
        error: function (request, error) {
            console.log(arguments);
            alert("{{trans('messages.systemaccesserror')}}" + error);
        },
        success: function (data)
        {
        	$('#islemlerModal .modal-body').html(data);
        	$('#islemlerModal').modal('show');


        }
    });

}


function PopFileUpload()
{
      	var fileInput = document.getElementById('gallery-photo-add');
      	var filename ='';
      	$("#div.gallery").html('');
          for (i = 0; i < fileInput.files.length; i++)
              {
      			filename = fileInput.files[i].name;
      			$("#dgalleryd").append("<div class='alert alert-info'>"+filename+"</div>");
      			//alert(filename);
              }

}

function PopupCenter(url, title, w, h) {
    // Fixes dual-screen position                         Most browsers      Firefox
    var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : window.screenX;
    var dualScreenTop = window.screenTop != undefined ? window.screenTop : window.screenY;

    var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
    var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

    var left = ((width / 2) - (w / 2)) + dualScreenLeft;
    var top = ((height / 2) - (h / 2)) + dualScreenTop;
    var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

    // Puts focus on the newWindow
    if (window.focus) {
        newWindow.focus();
    }
}
</script>
<link href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" rel="stylesheet"/>

@endsection
@section('endscripts')



<script>

	function openfilenew(id)
	{

		var whichone=$("#xx").val();

		$.ajax({
				type: 'GET',
				url: '/operationGetToBack/'+whichone,
				data: {

				},
				error: function (request, error) {
						console.log(arguments);
						alert("{{trans('messages.systemaccesserror')}}" + error);
				},
				success: function (data)
				{
						$("#id_data"+whichone).html(data);
				}
		});

		$(".allfiles").addClass("d-none");
		$("#firma"+whichone).removeClass("d-none");

	}

</script>



	<script type="text/javascript">

	    require(['daterangepicker'], function() {

				$(function() {

				  $('input[name="datefilter"]').daterangepicker({
				      autoUpdateInput: false,
				      locale: {
				          cancelLabel: 'Clear'
				      }
				  });

				  $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
				      $(this).val(picker.startDate.format('YYYY-MM-DD') + ' / ' + picker.endDate.format('YYYY-MM-DD'));
				  });

				  $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
				      $(this).val('');
				  });

				});

			});

	</script>


@endsection

@section('content')
@if($errors->any())
		<div class='row'>
            <div class="alert alert-primary col-md-12" role="alert">
            	{{$errors->first()}}
            </div>
		</div>
		<hr />
@endif
<div class="row">


<div class="col-md-4">
	@if (!empty($operasyonList))
		<select class="form-control" name="x" id="xx" onchange="openfilenew()">
				<option value="0">{{trans("messages.choose")}}</option>
				@foreach($operasyonList as $m=>$evm)
						<option value="{{$evm->id}}">{{$evm->name}}</option>
				@endforeach
		</select>
	@endif
</div>
  <div class="col-md-4">

      <form action="/operation/done" method="post" name="d" >
        {{csrf_field()}}
        <div class="form-group-inline row col-md-8 temizlenebilir">
          <input type="hidden" value="s" name="st" />
          <label class="col-sm-3">{{trans("messages.registerdate")}} </label>
          <div class="col-sm-6">
            <input type="text" name="datefilter"  class="form-control" readonly value="{{Request::input('datefilter')}}"  />
          </div>
          <div class="form-group col-md-2 temizlenebilir">
            <button type="submit" class="btn btn-danger">{{trans("messages.tum")}} {{trans("messages.ara")}}</button>
          </div>
        </div>
    </form>
    </div>

</div>
<hr />
		<div class='col-md-12'>

						@if (!empty($operasyonList))
							@foreach($operasyonList as $m=>$evm)
								<div class="card d-none allfiles" id="firma{{$evm->id}}">
									 <div class="card-status"></div>
									 <div class="card-header">
										 <h4 class="card-title " style="font-size:0.9em;">{{$evm->name}} - {{trans("messages.total")}} {{$evm->talimat_count}} {{trans("messages.operasyon")}}</h4>
										 <div class="card-options">
											 <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
										 </div>
									 </div>
									 <div class="card-body" id="id_data{{($evm->id)}}">
                     <img src='/img/spinner.gif' style="margin:auto" />
										</div>
										 {{--
											@if(count($evm->talimat)>0)

														<table class="table table-bordered" cellspacing="0">
															<thead>
																<tr>
																	<th>	{{trans('messages.cekiciplaka')}}</th>
																	<th>	{{trans('messages.dorseplaka')}}</th>
																	<th>	{{trans('messages.autoBarcode')}}</th>
																	<th>	{{trans('messages.talimattipi')}}</th>
																	<th>	{{trans('messages.createddate')}}</th>
																	<th>	{{trans('messages.bolgehangisi')}}</th>
																	<th>	{{trans('messages.bolgeilgilenen')}}</th>
																	<th>	{{trans('messages.talimatevrakyuklemebaslik')}}</th>
																	<th>	{{trans('messages.durum')}}</th>
																	<th colspan="5">{{trans('messages.operasyonislem')}}</th>
																</tr>

															</thead>
																<tbody>
																@foreach($evm->talimat as $fm=>$fevm)

																	<tr>



																			<td>{{$fevm->cekiciPlaka}}</td>
																			<td>{{$fevm->dorsePlaka}}</td>
																			<td>{{$fevm->autoBarcode}}</td>
																			<td>{{trans("messages.".$fevm->talimatTipi)}}</td>
																			<td>{{\Carbon\Carbon::parse($fevm->created_at)->format("d-m-Y H:i:s")}}</td>
																			<td>	@if (!empty($fevm->bolge->name)){{$fevm->bolge->name}} @endif</td>
																			<td>	@if (!empty($fevm->ilgili->name)){{$fevm->ilgili->name}} @endif</td>
																			<td>
																					 @if ($fevm->durum=="tamamlandi" && $fevm->talimatTipi=="listex")
																							<a href='/operationexcel/{{$fevm->id}}' target="_blank">{{trans("messages.dosyaindir")}}</a><br />
																					 @endif

																					 @if (!empty($fevm->evrak[0]))
																							@foreach ($fevm->evrak as $evkey => $evvalue)
                                                <a href='/uploads/{{$evvalue->fileName}}' class="btn btn-alert btn-sm" target="_blank">{{($evvalue->kacinci)+1}}. {{trans("messages.gumruk")}} {{-- trans("messages.yuk")-}} {{$evvalue->belgetipi}} - {{trans("messages.yuk")}} {{($evvalue->yukId)+1}} - {{trans("messages.dosya")}}  {{($evvalue->siraId)+1}} {{trans("messages.indir")}}</a><br  />

																							@endforeach
																						@else

																					 @endif
																			</td>
																			<td>	{{trans("messages.".$fevm->durum)}}</td>




																			<td><a title="{{trans("messages.show")}}"  href='/operasyon/goster/{{$fevm->id}}'><i class="fa fa-file-text" aria-hidden="true" style='color:brown'></i></a></td>
																			<td><a   title="{{trans("messages.print")}}" href='javascript:void(0)' onclick="PopupCenter('/operation/print/{{$fevm->id}}','xtf','930','500'); "><i class="fa fa-print" aria-hidden="true" style='color:brown'></i></a></td>
																			<td><a href='/operation/edit/{{$fevm->id}}'><i class="fa fa-pencil" aria-hidden="true" style='color:orange'></i></a></td>
																			<td><a  title="{{trans("messages.uploadfile")}}"  href='javascript:void(0)' onclick="PopupCenter('/operation/upload/{{$fevm->id}}','xtf','930','500'); "><i class="fa fa-file-pdf-o" aria-hidden="true" style='color:orange'></i></a></td>
																		</tr>



																	@endforeach
																			</tbody>
																					</table>
													@endif
														</div>
														--}}
												</div>

											@endforeach
							@endif

			 		</div>






<!-- </div>  -->


<div class="modal fade" id="islemlerModal" tabindex="-1" role="dialog" aria-labelledby="islemlerModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="islemlerModalLabel">	{{trans('messages.talimatislem')}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">	{{trans('messages.close')}}</button>
      </div>
    </div>
  </div>
</div>

@endsection
