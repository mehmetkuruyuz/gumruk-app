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
	PopupCenter("/ihracatfilepartdownload/"+urlx,"donwload",20,20);

}

</script>
<link href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" rel="stylesheet"/>
@endsection
@section('endscripts')
	<script type="text/javascript">

	    require(['daterangepicker'], function() {



				$(function() {

				  $('input[name="createddate"]').daterangepicker({
				      autoUpdateInput: false,
				      locale: {
				          cancelLabel: 'Clear'
				      }
				  });


				  $('input[name="createddate"]').on('apply.daterangepicker', function(ev, picker) {
				      $(this).val(picker.startDate.format('YYYY-MM-DD') + ' / ' + picker.endDate.format('YYYY-MM-DD'));
				  });

				  $('input[name="createddate"]').on('cancel.daterangepicker', function(ev, picker) {
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
						<form action="/{{Route::current()->uri()}}" name="xc" method="get" class="row d-none hidden">
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
            <table class="table table-bordered" cellspacing="0" id="mytable">
              <thead>
                <tr>
									<th>#</th>
                  <th> 	{{trans('messages.companyname')}}</th>
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
								<tr>
									<form action="/{{Route::current()->uri()}}" name="xc" method="get" class="row">
										<input type="hidden" name="inhear" value="1" />
											<th>#</th>
											<th><input type="text" name="companyname" class="form-control"  value="{{Request::input('companyname')}}" /></th>
		                  <th><input type="text" name="cekiciplaka" class="form-control"  value="{{Request::input('cekiciplaka')}}" /></th>
		                  <th><input type="text" name="dorseplaka" class="form-control"   value="{{Request::input('dorseplaka')}}" /></th>
											<th><input type="text" name="autoBarcode" class="form-control"  value="{{Request::input('autoBarcode')}}" /></th>
											<th></th>
											<th><input type="text" name="createddate" class="form-control"   value="{{Request::input('createddate')}}"/></th>
											<th>
												<select name="bolgehangisi" class="form-control">
												@if (!empty($bolgeList))
													@foreach ($bolgeList as $key => $value)
														<option value="{{$value->id}}"  @if (Request::input('bolgehangisi')==$value->id) selected @endif>{{$value->name}}</option>
													@endforeach
												@endif
											</select></th>
											<th><input type="text" name="kayitilgilenen" class="form-control"  value="{{Request::input('kayitilgilenen')}}"/></th>
											<th><input type="text" name="islemilgilenen" class="form-control"  value="{{Request::input('islemilgilenen')}}"/></th>
											<th><button type="submit" class="btn btn-danger">{{trans("messages.ara")}}</button></th>
		  								<th colspan="6"></th>
										</form>
								</tr>
              </thead>
              <tbody>
								@if (!empty($operasyonList))
									@foreach($operasyonList as $m=>$evm)
										<tr>
											<td>
												<i class="fa fa-circle @if ($evm->islemdurum=='bosta') text-green @elseif($evm->islemdurum=='tamamlandi') text-muted @else text-red @endif" aria-hidden="true"></i>
											</td>

											<td class="companyname">@if (!empty($evm->user)){{$evm->user->name}} @endif</td>
											<td class="cekiciplaka">{{$evm->cekiciPlaka}}</td>
											<td class="dorseplaka">{{$evm->dorsePlaka}}</td>
											<td class="autoBarcode">{{$evm->autoBarcode}}</td>
											<td class="talimattipi">@if($evm->altmodeljustname)
												@if(!empty($justname[$evm->id]))
													@foreach ($justname[$evm->id] as $xcky => $xvlx)
																{{trans("messages.".$xcky."")}}:{{$xvlx}}<br/>
													@endforeach
												@endif
													{{--
														@foreach ($evm->altmodeljustname as $xekey => $xevalue)
																 trans("messages.".$xevalue->talimatTipi)}} <br />
														@endforeach
														--}}
													@endif</td>
											<td class="createddate">{{\Carbon\Carbon::parse($evm->created_at)->format("d-m-Y H:i:s")}}</td>
											<td class="bolgehangisi">	@if (!empty($evm->bolge->name)){{$evm->bolge->name}} @endif</td>
											<td class="kayitilgilenen">	@if (!empty($evm->ilgili->name)){{$evm->ilgili->name}} @endif</td>
											<td class="islemilgilenen">	@if (!empty($evm->ilgilikayit->name)){{$evm->ilgilikayit->name}} @endif</td>
											<td>
												<div style="height:120px;overflow-y:scroll;;">

													 @if ($evm->durum=="tamamlandi" && $evm->talimatTipi=="listex")
														 	<a href='/operationexcel/{{$evm->id}}' target="_blank">{{trans("messages.dosyaindir")}}</a><br />
													 @endif

													 @if (!empty($evm->evrak[0]))
														 <a href='/ihracatfiledownload/{{$evm->id}}' target="_blank" class="btn btn-info btn-sm">{{trans("messages.tumunuindir")}}</a>
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

											<td><a title="{{trans("messages.print")}}" href='javascript:void(0)' onclick="PopupCenter('/ihracat/operasyon/print/{{$evm->id}}','xtf','930','500'); "><i class="fa fa-print" aria-hidden="true" style='color:brown'></i></a></td>
											<td><a title="{{trans("messages.show")}}" href='/ihracat/operasyon/goster/{{$evm->id}}' @if ($evm->islemdurum=='bosta' && (\Auth::user()->role=='admin' || \Auth::user()->role=='bolgeadmin' )) onclick="return onaylavegit()" @endif><i class="fa fa-file-text" aria-hidden="true" style='color:brown'></i></a></td>
											@if (\Auth::user()->role=='admin' || \Auth::user()->role=='bolgeadmin')
												<td><a  title="{{trans("messages.edit")}}" href='/ihracat/operasyon/edit/{{$evm->id}}'><i class="fa fa-pencil" aria-hidden="true" style='color:orange'></i></a></td>
											@else
												<td>&nbsp;</td>
											@endif
											<td><a title="{{trans("messages.uploadfile")}}" href='javascript:void(0)' onclick="PopupCenter('/ihracat/operasyon/upload/{{$evm->id}}','xtf','930','500'); "><i class="fa fa-file-pdf-o" aria-hidden="true" style='color:orange'></i></a></td>
											<!-- <td><a href='/talimat/sil/'><i class="fa fa-trash" aria-hidden="true" style='color:red'></i></a></td> -->
										</tr>
                	@endforeach
									<tr>
										<td colspan="14">
											{{$operasyonList->render("pagination::bootstrap-4")}}
										</td>
									</tr>
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
