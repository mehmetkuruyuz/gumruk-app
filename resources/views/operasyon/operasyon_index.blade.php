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


function onaylavegit()
{
		var islem=confirm("{{trans('messages.islemzimmetle')}}");
		return islem;
}


function seciliindir(t)
{
	var urlx="/?i=i";
	$(t).parent().children("input:checked").each(function (item) {
		urlx+="&item[]="+$(this).val();
	});
	PopupCenter("/operationfilepartdownload/"+urlx,"donwload",20,20);

}

</script>
<link href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" rel="stylesheet"/>

@endsection
@section('endscripts')


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

		<div class='col-md-12'>
		<div class="panel ">
        <div class="panel-heading">
        <div class="panel-body">
					<div >
						<form action="/operation/continue" name="xc" method="post" class="row">
							{{csrf_field()}}
						<div class="form-group col-md-2 temizlenebilir">
							<label for="plaka">{{trans("messages.plaka")}}</label>
							<input type="text" class="form-control" id="plaka"  name='plaka' placeholder="{{trans("messages.plaka")}}" value="{{Request::input('plaka')}}">
						</div>
						<div class="form-group col-md-2 temizlenebilir">
							<label for="autoBarcode">{{trans("messages.autoBarcode")}}</label>
							<input type="text" class="form-control" id="autoBarcode"  name='autoBarcode' placeholder="{{trans("messages.autoBarcode")}}" value="{{Request::input('autoBarcode')}}">
						</div>
						<div class="form-group col-md-2 temizlenebilir">
							<label>{{trans("messages.registerdate")}} </label>
							<input type="text" name="datefilter"  class="form-control" readonly value="{{Request::input('datefilter')}}"  />
						</div>
						<div class="form-group col-md-2 temizlenebilir p-1">

							<button type="submit" class="btn btn-danger mt-5">{{trans("messages.ara")}}</button>
						</div>
						</form>
					</div>
          <div class="">
            <table class="table table-bordered" cellspacing="0">
              <thead>
                <tr>
                  <th colspan="2"> 	{{trans('messages.companyname')}}</th>
                  <th>	{{trans('messages.cekiciplaka')}}</th>
                  <th>	{{trans('messages.dorseplaka')}}</th>
									<th>	{{trans('messages.autoBarcode')}}</th>
									<th>	{{trans('messages.talimattipi')}}</th>
									<th>	{{trans('messages.createddate')}}</th>
									<th>	{{trans('messages.bolgehangisi')}}</th>
									<th>	{{trans('messages.kayitilgilenen')}}</th>
									<th>	{{trans('messages.islemilgilenen')}}</th>
									<th>	{{trans('messages.talimatevrakyuklemebaslik')}}</th>
                  <th>	{{trans('messages.durum')}}</th>
									<th colspan="5">{{trans('messages.operasyonislem')}}</th>
                </tr>
              </thead>
              <tbody>
								@if (!empty($operasyonList))
									@foreach($operasyonList as $m=>$evm)
										<tr>
											<td>
												<i class="fa fa-circle @if ($evm->islemdurum=='bosta') text-green @elseif($evm->islemdurum=='tamamlandi') text-muted @else text-red @endif" aria-hidden="true"></i>
											</td>
											<td>{{$evm->user->name}}</td>
											<td>{{$evm->cekiciPlaka}}</td>
											<td>{{$evm->dorsePlaka}}</td>
											<td>{{$evm->autoBarcode}}</td>
											<td>{{$evm->talimatTipi}}</td>
											<td>{{\Carbon\Carbon::parse($evm->created_at)->format("d-m-Y H:i:s")}}</td>
											<td>	@if (!empty($evm->bolge->name)){{$evm->bolge->name}} @endif</td>
											<td>	@if (!empty($evm->ilgili->name)){{$evm->ilgili->name}} @endif</td>
												<td>	@if (!empty($evm->ilgilikayit->name)){{$evm->ilgilikayit->name}} @endif</td>
											<td>
												<div style="height:120px;overflow-y:scroll;;">

													 @if ($evm->durum=="tamamlandi" && $evm->talimatTipi=="listex")
														 	<a href='/operationexcel/{{$evm->id}}' target="_blank">{{trans("messages.dosyaindir")}}</a><br />
													 @endif

													 @if (!empty($evm->evrak[0]))
														 <a href='/operationfiledownload/{{$evm->id}}' target="_blank" class="btn btn-info btn-sm">{{trans("messages.tumunuindir")}}</a>
														 <a href='javascript:void(0)' class="btn btn-info btn-sm" onclick="seciliindir(this)">{{trans("messages.seciliindir")}}</a><br  />
															@foreach ($evm->evrak as $evkey => $evvalue)
																	<a href='/uploads/{{$evvalue->fileName}}' class="btn btn-alert btn-sm" target="_blank">{{($evvalue->kacinci)+1}}. {{trans("messages.gumruk")}} {{-- trans("messages.yuk") --}} {{$evvalue->belgetipi}} - {{trans("messages.yuk")}} {{($evvalue->yukId)+1}} - {{trans("messages.dosya")}}  {{($evvalue->siraId)+1}} {{trans("messages.indir")}}</a>
																	<input type='checkbox' name="test[]" value="{{$evvalue->id}}" class="form-control-check"  />
																	<br />
															@endforeach
														@else

													 @endif
												</div>
											</td>
											<td>
                        @if ($evm->t2beklemedurumu=='yes')

                          {{trans("messages.t2")}}
                            <br />
                          {{trans("messages.bekliyor")}}

                        @else
                        	{{trans("messages.".$evm->durum)}}
                        @endif
                      </td>

											<td><a title="{{trans("messages.print")}}" href='javascript:void(0)' onclick="PopupCenter('/operation/print/{{$evm->id}}','xtf','930','500'); "><i class="fa fa-print" aria-hidden="true" style='color:brown'></i></a></td>
											<td><a title="{{trans("messages.show")}}" href='/operasyon/goster/{{$evm->id}}' @if ($evm->islemdurum=='bosta' && (\Auth::user()->role=='admin' || \Auth::user()->role=='bolgeadmin' )) onclick="return onaylavegit()" @endif><i class="fa fa-file-text" aria-hidden="true" style='color:brown'></i></a></td>
											@if (\Auth::user()->role=='admin' || \Auth::user()->role=='bolgeadmin')
												<td><a  title="{{trans("messages.edit")}}" href='/operation/edit/{{$evm->id}}'><i class="fa fa-pencil" aria-hidden="true" style='color:orange'></i></a></td>
											@else
												<td>&nbsp;</td>
											@endif
											<td><a title="{{trans("messages.uploadfile")}}" href='javascript:void(0)' onclick="PopupCenter('/operation/upload/{{$evm->id}}','xtf','930','500'); "><i class="fa fa-file-pdf-o" aria-hidden="true" style='color:orange'></i></a></td>
											<!-- <td><a href='/talimat/sil/'><i class="fa fa-trash" aria-hidden="true" style='color:red'></i></a></td> -->

											{{--
												<td>{{$evm->user->name}}</td>
												<td>{{$evm->cekiciPlaka}}</td>
												<td>{{$evm->dorsePlaka}}</td>

												<td>
													@if (!empty($evm->evrak))
															@foreach($evm->evrak as $evrakkey=>$evrakvalue)
																		{{trans("messages.".$evrakvalue->dosyaTipi)}} / <a href="/uploads/{{$evrakvalue->fileName}}">	{{trans("messages.indir")}}</a> <br />
															@endforeach
												  @endif
												</td>
												<td>	{{trans("messages.".$evm->durum)}}</td>
												<td>
													<select name='durum' @if (\Auth::user()->role!='admin') disabled="disabled"  @endif  onchange='yonlendirTalimatPage({{$evm->id}},this)'>
														 	<option  @if (($evm->durum)=='bekliyor') selected="selected" @endif value='bekliyor'>	{{trans('messages.operasyonbekliyor')}}</option>
															<option @if (($evm->durum)=="red") selected="selected" @endif value='red' >	{{trans('messages.operasyonred')}} </option>
															<option @if (($evm->durum)=='onayli') selected="selected" @endif value='onayli' >	{{trans('messages.tamamlandi')}}</option>
															<option  @if (($evm->durum)=='talimatolan') selected="selected" @endif value='talimatolan'>	{{trans('messages.talimatoldu')}}</option>
												 </select>
												</td>
													<td><a href='/operasyon/goster/{{$evm->id}}'><i class="fa fa-file-text" aria-hidden="true" style='color:brown'></i></a></td>
													<td><a href='/operasyon/edit/{{$evm->id}}'><i class='fa fa-pencil' aria-hidden='true' style='color:orange'></i></a></td>
													<td><a href='/operasyon/sil/{{$evm->id}}'><i class='fa fa-trash' aria-hidden='true' style='color:red'></i></a></td>
--}}
										</tr>

                	@endforeach
                @else
                	<tr>
                		<td colspan='14'>	{{trans('messages.girilmistalimatyok')}}</td>
                	</tr>
                @endif
				</tbody>
			</table>
		</div>
	</div>
</div>

</div>
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
