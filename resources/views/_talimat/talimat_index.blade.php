@extends('layouts.app')

@section('kirinti')
	{{trans('messages.yenitalimatbaslik')}}
@endsection

@section('scripts')
<style>
#dataTable {font-size:0.9em;}
</style>
<script type="text/javascript">
<!--

//-->

function sendMeOrderAction(id,t)
{


	var l=confirm("{{trans('messages.talimatyonlendirmemesaj')}}");
	if (l==true)
	{
		window.location.href='/talimat/ozelislem/'+id+'/'+$(t).val();
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
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" rel="stylesheet"/>

@endsection
@section('endscripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>

    <script src="vendor/datatables/jquery.dataTables.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>


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

<ul class="nav nav-tabs" id="myTab" role="tablist" style='margin-left:25px;'>
	 @if (!empty($talimatList))
	 @foreach($talimatList as $key=>$value)
          <li class="nav-item" style='background:#ffffb8 '>
            	<a class="nav-link @if($loop->iteration==1) active  @endif" id="{{$value->kisaKod}}-tab" data-toggle="tab" href="#{{$value->kisaKod}}" role="tab" aria-controls="{{$value->kisaKod}}" aria-selected="false">{{$value->kodName}} @if (!empty($viewList[$value->kisaKod]['genel'])) <span style='color:red'>( {{count($viewList[$value->kisaKod]['genel'])}} )</span> @else (0) @endif</a>
          </li>
      @endforeach
  	@endif
</ul>

<div class="tab-content" id="myTabContent">
 @if (!empty($talimatList))
	 @foreach($talimatList as $m=>$evm)
	<div class="tab-pane @if($loop->iteration==1) fade in active   @endif fade  border-bottom border-left" id="{{$evm->kisaKod}}" role="tabpanel" aria-labelledby="{{$evm->kisaKod}}-tab">
		<div class='col-md-12'>
		<div class="panel panel-default">
        <div class="panel-heading">
          <i class="fa fa-table"></i> {{$evm->kodName}}</div>
        <div class="panel-body">
           <div class="form-group  temizlenebilir">
           <form action='/talimat' method="POST" name='a' >
          {{ csrf_field() }}
           <table class="table" style='width:75%'>
           	<tr>
           	   <td><label for="plaka">	{{trans('messages.plaka')}}</label></td>
           	   <td>
           	   	<input type="text" class="form-control" @if (!empty($plaka)) value='{{$plaka}}' @endif name='plaka' id="plakalar" placeholder="{{trans('messages.plaka')}}">
           	   </td>
           	   <td><label for="tarih">	{{trans('messages.tarih1')}}</label></td>
           	   <td><input type='text'  class="form-control" name="tarih"  data-provide="datepicker"  data-date-format="yyyy-mm-dd"  @if (!empty($tarih)) value='{{$tarih}}' @endif   /></td>
           	   <td><label for="tarih">	{{trans('messages.tarih2')}}</label></td>
           	   <td><input type='text'  class="form-control" name="tarih2"  data-provide="datepicker"  data-date-format="yyyy-mm-dd"  @if (!empty($tarih2)) value='{{$tarih2}}' @endif   /></td>
							 <td><label for="barcode">	{{trans('messages.autoBarcode')}}</label></td>
								<td> <input type="text" class="form-control" name='barcode' value="{{$barcode}}" placeholder="{{trans('messages.autoBarcode')}}"></td>
           	   <td><button type='submit' class='btn btn-info'> {{trans('messages.ara')}}</button></td>
           	</tr>
           </table>
           </form>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>

									<th colspan='2'>	{{trans('messages.companyname')}}</th>
									<th>	{{trans('messages.autoBarcode')}}</th>
									<th>	{{trans('messages.ADR')}}</th>
                  <th>	{{trans('messages.cekiciplaka')}}</th>
                  <th>	{{trans('messages.dorseplaka')}}</th>
                  <th>	{{trans('messages.tirkarnesi')}}</th>
                  <th>	{{trans('messages.problem')}}</th>

                  <th>	{{trans('messages.gumrukadet')}}</th>
                  <th>	{{trans('messages.aciklama')}}</th>
               <!--    <th style='font-size:0.8em'>Evrak Yükle</th> -->
                  <th style='font-size:0.8em'>	{{trans('messages.incele')}}</th>
                  <th style='font-size:0.8em'>	{{trans('messages.yazdir')}}</th>
                  <th style='font-size:0.8em'>	{{trans('messages.edit')}}</th>
                  <th style='font-size:0.8em'>	{{trans('messages.delete')}}</th>
                  <th style='font-size:0.8em'>	{{trans('messages.durum')}}</th>
                </tr>

              </thead>
              <tfoot>
                <tr>
                   <th colspan='16'><i class="fa fa-circle" aria-hidden="true" style='color:green'></i> : 	{{trans('messages.yenitalimat')}}
                   <i class="fa fa-circle" aria-hidden="true" style='color:grey'></i> : 	{{trans('messages.gorulmustalimat')}}
                   <i class="fa fa-file-pdf-o" aria-hidden="true" style='color:blue'></i> : 	{{trans('messages.evraklaricin')}}
                   <i class="fa fa-pencil" aria-hidden="true" style='color:orange'></i> : 	{{trans('messages.duzenlemekicin')}}
                   <i class="fa fa-trash" aria-hidden="true" style='color:red'></i> :	{{trans('messages.silmekicin')}}
                   <i class="fa fa-file-text" aria-hidden="true" style='color:brown'></i> :	{{trans('messages.incelemekicin')}} </th>
                </tr>
              </tfoot>
              <tbody>
                @if (!empty($viewList[$evm->kisaKod]))
                    @foreach($viewList[$evm->kisaKod]['genel'] as $key=>$value)
                    <tr>
                    <td> <i class="fa fa-circle" aria-hidden="true" style='color:@if (($value['yeniTalimatMi']=='yes'))green @else grey @endif'></i>
                     </td>
                     <td>@if (\Auth::user()->role=='admin') {{$viewList[$evm->kisaKod]['user'][$key]['name']}} @else {{\Auth::user()->name}} @endif </td>
											<td>{{$value["autoBarcode"]}}</td>
                      <td>@if ($viewList[$evm->kisaKod]['gumruk'][$key]['adr']=='no') {{trans('messages.hayir')}} @else {{trans('messages.evet')}} @endif </td>
                      <td>{{$value['cekiciPlaka']}}</td>
                      <td>{{$value['dorsePlaka']}}</td>
                      @if ($evm->kisaKod=='tir' || $evm->kisaKod=='ata')
                      	<td>{{$viewList[$evm->kisaKod]['gumruk'][$key]['tirKarnesi']}}</td>
                      @else
                      	<td>{{trans('messages.yok')}}</td>
                      @endif
                      <td>@if ($viewList[$evm->kisaKod]['gumruk'][$key]['problem']=='no') {{trans('messages.yok')}} @else {{$viewList[$evm->kisaKod]['gumruk'][$key]['problemAciklama']}} @endif </td>
                      <td>
                      {{trans('messages.toplam')}} : {{$value['gumrukAdedi']}} <br />
                      	 @if (!empty($talimatList))
								 						@foreach($talimatList as $olmo=>$volmo)
								 							@if(!empty($viewList[$volmo->kisaKod]['gumruk'][$key]['talimatId']))
								 								{{$volmo->kodName}}: {{count($viewList[$volmo->kisaKod]['gumruk'][$key]['talimatId'])}}<br />
								 							@endif
								 						@endforeach
	 												@endif
                      </td>
                      <td>{{$viewList[$evm->kisaKod]['gumruk'][$key]['aciklama']}}</</td>

                  <td><a href='/talimat/goster/{{$value['talimatId']}}'><i class="fa fa-file-text" aria-hidden="true" style='color:brown'></i></a></td>
                  <td><a href='javascript:void(0)' onclick="PopupCenter('/talimat/yazdir/{{$value['talimatId']}}','xtf','930','500'); "><i class="fa fa-print" aria-hidden="true" style='color:brown'></i></a></td>
                  <td><a href='/talimat/edit/{{$value['talimatId']}}'><i class="fa fa-pencil" aria-hidden="true" style='color:orange'></i></a></td>
                  <td><a href='/talimat/sil/{{$value['talimatId']}}'><i class="fa fa-trash" aria-hidden="true" style='color:red'></i></a></td>
                  <td>

                  		<select name='durum' id='' onchange='sendMeOrderAction({{$value['talimatId']}},this)' @if (\Auth::user()->role!='admin') disabled="disabled"  @endif>
								<option value='0' @if ($value['durum']=='0') selected="selected" @endif>	{{trans('messages.bekleniyor')}}</option>
								<option value='1' @if ($value['durum']=='1') selected="selected" @endif>	{{trans('messages.islemyapiliyor')}}</option>
								<option value='2' @if ($value['durum']=='2') selected="selected" @endif>	{{trans('messages.tamamlandi')}}</option>
                  		</select>
                  </td>
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
