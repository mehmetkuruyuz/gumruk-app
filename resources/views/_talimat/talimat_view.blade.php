@extends('layouts.app')

@section('kirinti')
	{{trans("messages.talimatinceleheader")}}
@endsection

@section('scripts')
<style>
table {font-size:0.9em;}
</style>
@endsection

@section('endscripts')

@endsection
@section('content')
	<div class="panel panel-default mb-3">
        <div class="panel-body">
        <div class='row'>

        	<div class='col-xs-8'><i class="fa fa-table"></i> <span>{{trans('messages.createddate')}} : {{\Carbon\Carbon::parse($talimat->created_at)->format('d-m-Y H:i')}} / {{trans('messages.updateddate')}} : {{\Carbon\Carbon::parse($talimat->updated_at)->format('d-m-Y H:i')}}</span></div>
        	<div class='col-xs-4 text-right'><a href='/talimat/yazdir/{{$talimat->id}}'>Yazdırmak İçin <i class="fa fa-print"></i> </a></div>

        	@if(Auth::user()->role=="admin")

        	<div class='col-xs-12 text-right'>
        	 	<ul class="pagination pagination-sm">
        	 	  <li class="disabled"><a href="#">{{trans('messages.degisiklikler')}}</a></li>

        			{!! Helper::getChangeList($talimat->id) !!}

                </ul>
                </div>

                @endif


            <div class='col-sm-6'>
          	 	 <h5>{{trans("messages.talimatverenkullanici")}}</h5>
                    <table class="table table-bordered" cellspacing="0" >
                    <tr>
                    	<td><strong>{{trans("messages.companyname")}}</strong></td>

                    	<td>{{$talimat->user->name}}</td>
                    </tr>
										<tr>
	                    <td><strong>{{trans("messages.autoBarcode")}}</strong></td>
	                    <td>
												<span style="font-size:3em;">{{$talimat->autoBarcode}}</span>
												<div>
												{!!$barcode!!}
												</div>

											</td>
	                  </tr>
                    <tr>
	                    	<td><strong>{{trans("messages.loginmail")}}</strong></td>
	                    	<td>{{$talimat->user->email}}</td>
	                    </tr>
	                    <tr>
	                    	<td><strong>{{trans("messages.firmavergi")}} / {{trans("messages.firmavergidaire")}}</strong></td>
	                    	<td>{{$talimat->user->vergiDairesi}}</td>
	                    </tr>
	                      <tr>
	                    	<td><strong>{{trans("messages.firmatelefon")}}</strong> </td>
	                    	<td>{{$talimat->user->telefonNo}}</td>
	                    </tr>
	                      <tr>
	                    	<td><strong>{{trans("messages.firmaadres")}}</strong></td>
	                    	<td>{{$talimat->user->address}}</td>
	                    </tr>
                    </table>
             </div>
             <div class='col-sm-6'>
             	 <h5>{{trans("messages.talimatbilgileri")}}</h5>
             	   <table class="table table-bordered" cellspacing="0">
             	    <tr>
                    	<td><strong>{{trans("messages.createddate")}}</strong></td>
                    	<td>{{\Carbon\Carbon::parse($talimat->created_at)->format('d-m-Y H:i')}}</td>
                    </tr>
			
                    <tr>
                    	<td><strong>{{trans("messages.cekiciplaka")}}</strong></td>
                    	<td>{{$talimat->cekiciPlaka}}</td>
                    </tr>
                    <tr>
                    	<td><strong>{{trans("messages.dorseplaka")}}</strong></td>
                    	<td>{{$talimat->dorsePlaka}}</td>
                    </tr>
               		<tr>
               			<td><strong>{{trans("messages.gumrukadet")}}</strong></td>
               			<td>{{$talimat->gumrukAdedi}}</td>
               		</tr>
               		<tr>
               			<td><strong>{{trans("messages.talimatdurumu")}}</strong></td>
               			<td>
                          			<h2 style='color:red'>
                   				@if ($talimat->durum==0) {{trans("messages.bekliyor")}}
                   				@elseif ($talimat->durum==1) {{trans("messages.islemyapiliyor")}}
                   				@elseif ($talimat->durum==2) {{trans("messages.tamamlandi")}}
                   				@endif

                   				</h2>
               			</td>
               		</tr>
                   </table>

             </div>
              <div class='col-sm-12'>
             	 <h5>{{trans("messages.gumrukbilgileri")}}</h5>
             	   <table class="table table-bordered" cellspacing="0">
             	   <tbody>
             	   @foreach($talimat->gumruk as $key=>$value)
             	   <tr>
             	   		<td colspan='11'><hr /></td>
             	   </tr>
					<tr>
             	   		<th>{{trans("messages.sira")}}</th>
             	   		<th>{{trans("messages.varisgumruk")}}</th>
             	   		<th>{{trans("messages.ADR")}}</th>
             	   		<th>{{trans("messages.atr")}}</th>
             	   		<th>{{trans("messages.talimattipi")}}</th>
             	   		<th>{{trans("messages.malcinsi")}}</th>
             	   		<th>{{trans("messages.kap")}}</th>
             	   		<th>{{trans("messages.kilo")}}</th>
             	   		<th>{{trans("messages.tirkarnesi")}}</th>
             	   		<th>{{trans("messages.problem")}}</th>
             	   		<th>{{trans("messages.aciklama")}}</th>
             	   	</tr

             	   	<tr>
             	   		<td>{{$loop->iteration}}</td>
             	   		<td>{{$value->varisGumrugu}}</td>
             	   		<td>@if ($value->adr=='no') {{trans("messages.yok")}} @else {{trans("messages.var")}} @endif</td>
             	   		<td>@if ($value->atr=='no') {{trans("messages.yapilmasin")}} @else {{trans("messages.yapilsin")}} @endif</td>
             	   		<td>
             	   		@foreach($talimatTipList as $m=>$v)
             	   			@if (($v->kisaKod==$value->talimatTipi)) {{ $v->kodName }} @endif
             	   		@endforeach
             	   		</td>
             	   		<td>@if ($value->malCinsi=='parsiyal' || $value->malCinsi=='parsiyel') {{trans('messages.parsiyel')}} @elseif ($value->malCinsi=='komple') {{trans('messages.komple')}} @endif</td>
             	   		<td>{{$value->kap}}</td>
             	   		<td>{{$value->kilo}}</td>
             	   		<td>{{$value->tirKarnesi}}</td>
             	   		<td>@if ($value->problem=='no') {{trans("messages.yok")}} @else {{$value->problemAciklama}} @endif</td>
             	   		<td>{{$value->aciklama}}</td>
             	   	</tr>
             	   	@if (!empty($value->yukleme))
             	   	<tr>
                 	   	<td colspan='4'>
                 	   	<h6>Yükleme ve İndirme Alanları</h6>
                 	   		<table class="table table-bordered" cellspacing="0" style='font-size:11px'>
                 	   			<thead>
                 	   				<tr>

										<th>{{trans("messages.sira")}}</th>
                     	   				<th>{{trans("messages.yuklemeyeri")}}</th>
                     	   				<th>{{trans("messages.bosaltmayeri")}}</th>
                     	   				<th>{{trans("messages.kap")}}</th>
                     	   				<th>{{trans("messages.kilo")}}</th>
                     	   			</tr>
                 	   			</thead>
                 	   			<tbody>
                     	   		@foreach($value->yukleme as $mmm=>$vvv)
                     	   		<tr>
                     	   			<td>{{$loop->iteration}}</td>
                     	   			<td>{{$vvv->yuklemeYeri}}</td>
                     	   			<td>{{$vvv->bosaltmaYeri}}</td>
                     	   			<td>{{$vvv->kap}}</td>
                     	   			<td>{{$vvv->kilo}}</td>
                 	   			</tr>
                     	   		@endforeach
                 	   		</tbody>
                 	   		</table>

                 	   		<hr />

                 	   	</td>
                 	   	<td colspan='7'>
	     	   		                 	   		<h6>{{trans("messages.gumrukdosyalari")}}</h6>
                 	   		     @if (!empty($value->evrak))
                 	   		    <table class="table table-bordered" cellspacing="0" style='font-size:11px'>
                 	   				<thead>
                 	   					<tr>
                  	   						<th>{{trans("messages.sira")}}</th>
                 	   						<th>{{trans("messages.dosyacesidi")}}</th>
                 	   						<th>{{trans("messages.dosyaindir")}}</th>
                 	   						<th>{{trans("messages.dosyatipi")}}</th>
                 	   						<th>{{trans("messages.sil")}}</th>
                 	   					</tr>
                 	   				</thead>
                 	   				<tbody>
                     	   			 @foreach($value->evrak as $uuu=>$ooo)
                         	   			<tr>
                         	   				<td>{{$loop->iteration}}</td>
                         	   				<td>{{$isimArray[$ooo->dosyaTipi]}}</td>
                         	   				<td><a href='/uploads/{{$ooo->fileName}}' target="_blank">{{trans("messages.indir")}}</a></td>
                         	   				<td>{{$ooo->filetype}}</td>
                         	   				<td><a href='/dosya/sil/{{$ooo->id}}' onclick='return confirm("{{trans("messages.silmeeminmisiniz")}}")'>{{trans("messages.sil")}}</a></td>
                         	   			</tr>
                     	   			 @endforeach
                     	   			</tbody>
                     	   			</table>
                     	   			 @else
                     	   			 	{{trans("messages.dosyayok")}}
                     	   			 @endif
                 	   	</td>
             	   	</tr>
             	   	@endif
             	   	@endforeach

             	   </tbody>

                   </table>
                </div>
                <div class='col-sm-12'>
                	 <h5>Yüklenmiş Evraklar</h5>
                	 @if (!empty($evrakList))
                	  <table class="table table-bordered" cellspacing="0">
             	   <thead>
             	   <tr>
             	   		<th>{{trans("messages.sira")}}</th>
                 	   	<th>{{trans("messages.dosyatipi")}}</th>
                 	   	<th>{{trans("messages.dosyaindir")}}</th>
                 	   	<th>{{trans("messages.sil")}}</th>
             	   	</tr>
             	   	</thead>
             	   	<tbody>

             	   	@foreach($evrakList as $an=>$de)
             	   	<tr>
             	   		<td>{{$loop->iteration}}</td>
             	   		<td>{{$de->filetype}}</td>
             	   		<td><a href='/uploads/{{$de->fileName}}' target='_blank'>İndir</a></td>
             	   		<td><a href='/dosya/sil/{{$de->id}}' onclick='return confirm("{{trans("messages.silmeeminmisiniz")}}")'>{{trans("messages.sil")}}</a></td>
             	   	</tr>
             	   	@endforeach

             	   	</tbody>
             	   	</table>
             	   	@endif
             	   	<div class='alert alert-info'>{{trans("messages.dosyayok")}}</div>
                </div>
         </div>
        </div>



     </div>


{{--
	<div class="card mb-3">
        <div class="card-header">
        <div class='row'>
        	<div class='col-4'><i class="fa fa-table"></i> {{\Carbon\Carbon::parse($talimat->created_at)->format('d-m-Y H:i')}}</div>
        	<div class='col-8 text-right'>Yazdırmak İçin <i class="fa fa-print"></i> </div>
        </div>
        </div>
        <div class="card-body">
        <div class='row'>
            <div class='col-sm-5'>
          	 	 <h5>Talimat Veren Kullanıcı</h5>
                    <table class="table table-bordered" cellspacing="0">
                    <tr>
                    	<td><strong>Firma İsmi</strong></td>
                    	<td>{{$talimat->user->name}}</td>
                    </tr>
                    <tr>
                    	<td><strong>Mail Adresi</strong></td>
                    	<td>{{$talimat->user->email}}</td>
                    </tr>
                    <tr>
                    	<td><strong>Vergi No / Vergi Dairesi</strong></td>
                    	<td>{{$talimat->user->vergiDairesi}}</td>
                    </tr>
                      <tr>
                    	<td><strong>Telefon No</strong> </td>
                    	<td>{{$talimat->user->telefonNo}}</td>
                    </tr>
                      <tr>
                    	<td><strong>Adres Bilgisi </strong></td>
                    	<td>{{$talimat->user->address}}</td>
                    </tr>
                    </table>
             </div>
             <div class='col-sm-5'>
             	 <h5>Talimat Bilgileri</h5>
             	   <table class="table table-bordered" cellspacing="0">
             	    <tr>
                    	<td><strong>Talimat Oluşturma Tarihi</strong></td>
                    	<td>{{\Carbon\Carbon::parse($talimat->created_at)->format('d-m-Y H:i')}}</td>
                    </tr>
                    <tr>
                    	<td><strong>Çekici Araç Plakası</strong></td>
                    	<td>{{$talimat->cekiciPlaka}}</td>
                    </tr>
                    <tr>
                    	<td><strong>Dorse Plakası</strong></td>
                    	<td>{{$talimat->dorsePlaka}}</td>
                    </tr>
               		<tr>
               			<td><strong>Gümrük Adet Sayısı</strong></td>
               			<td>{{$talimat->gumrukAdedi}}</td>
               		</tr>
                   </table>

             </div>
              <div class='col-sm-10'>
             	 <h5>Gümrük Bilgileri</h5>
             	   <table class="table table-bordered" cellspacing="0">
             	   <thead>
             	   <tr>
             	   		<th>Sıra No</th>
             	   		<th>Varış Gümrüğü</th>
             	   		<th>ADR</th>
             	   		<th>ATR</th>
             	   		<th>Talimat Tipi</th>
             	   		<th>Mal Cinsi</th>
             	   		<th>Kap</th>
             	   		<th>Kilo</th>
             	   		<th>Tır Karnesi</th>
             	   		<th>Problem</th>
             	   		<th>Aciklama</th>
             	   	</tr>
             	   </thead>
             	    <tfoot>
                 	   <tr>
                 	   		<th>Sıra No</th>
                 	   		<th>Varış Gümrüğü</th>
                 	   		<th>ADR</th>
                 	   		<th>ATR</th>
                 	   		<th>Talimat Tipi</th>
                 	   		<th>Mal Cinsi</th>
                 	   		<th>Kap</th>
                 	   		<th>Kilo</th>
                 	   		<th>Tır Karnesi</th>
                 	   		<th>Problem</th>
                 	   		<th>Aciklama</th>
                 	   	</tr>
             	   </tfoot>
             	   <tbody>
             	   @foreach($talimat->gumruk as $key=>$value)
             	   	<tr>
             	   		<td>{{$loop->iteration}}</td>
             	   		<td>{{$value->varisGumrugu}}</td>
             	   		<td>@if ($value->adr=='no') Yok @else Var @endif</td>
             	   		<td>@if ($value->atr=='no') Yok @else Var @endif</td>
             	   		<td>
             	   		@foreach($talimatTipList as $m=>$v)
             	   			@if (($v->kisaKod==$value->talimatTipi)) {{ $v->kodName }} @endif
             	   		@endforeach
             	   		</td>
             	   		<td>{{$value->malCinsi}}</td>
             	   		<td>{{$value->kap}}</td>
             	   		<td>{{$value->kilo}}</td>
             	   		<td>{{$value->tirKarnesi}}</td>
             	   		<td>@if ($value->problem=='no') Yok @else {{$value->problemAciklama}} @endif</td>
             	   		<td>{{$value->aciklama}}</td>
             	   	</tr>
             	   	@if (!empty($value->yukleme))
             	   	<tr>
                 	   	<td colspan='6'>
                 	   		<table class="table table-bordered" cellspacing="0" style='font-size:11px'>
                 	   			<thead>
                 	   				<tr>
                     	   				<th>Sıra</th>
                     	   				<th>Yükleme Yeri</th>
                     	   				<th>Boşaltma Yeri</th>
                     	   			</tr>
                 	   			</thead>
                 	   			<tbody>
                     	   		@foreach($value->yukleme as $mmm=>$vvv)
                     	   		<tr>
                     	   			<td>{{$loop->iteration}}</td>
                     	   			<td>{{$vvv->yuklemeYeri}}</td>
                     	   			<td>{{$vvv->bosaltmaYeri}}</td>
                 	   			</tr>
                     	   		@endforeach
                 	   		</tbody>
                 	   		</table>
                 	   	</td>
             	   	</tr>
             	   	@endif
             	   	@endforeach
             	   </tbody>

                   </table>
                </div>

         </div>
        </div>

     </div>
	--}}
@endsection
