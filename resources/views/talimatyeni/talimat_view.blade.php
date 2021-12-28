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
        	<div class='col-xs-4 text-right'><a href='/talimat_yeni/yazdir/{{$talimat->id}}'>Yazdırmak İçin <i class="fa fa-print"></i> </a></div>

        	@if(Auth::user()->role=="admin")

        	<div class='col-xs-12 text-right'>
        	 	<ul class="pagination pagination-sm">
        	 	  <li class="disabled"><a href="#">{{trans('messages.degisiklikler')}}</a></li>

        					{!! Helper::getChangeList($talimat->id) !!}

                </ul>
                </div>

                @endif

         </div>
				 <div class="row">
					 	<div class="col-sm-12">
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
																	 <td><strong>{{trans("messages.totalkap")}}</strong></td>
																	 <td>{{$talimat->totalkap}}</td>
																 </tr>
																 <tr>
																	 <td><strong>{{trans("messages.totalkilo")}}</strong></td>
																	 <td>{{$talimat->totalkilo}}</td>
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
															 <tr>
																	<td colspan='11'><hr /></td>
															 </tr>



																<tbody>
																	@if (!empty($talimat->allparametres))
																		@foreach($talimat->allparametres as $altkey=>$altvalue)
																		<tr>
																			 <th>{{trans("messages.sira")}}</th>


																			 																			 <th>{{trans("messages.varisgumruk")}}</th>
																			 <th>{{trans("messages.yuklemeyeri")}}</th>
																			 <!--
																			 <th>{{trans("messages.ADR")}}</th>
																			 <th>{{trans("messages.atr")}}</th>
																			 <th>{{trans("messages.talimattipi")}}</th>
																			 <th>{{trans("messages.malcinsi")}}</th>
																			 <th>{{trans("messages.tirkarnesi")}}</th>
																		 -->
																			 <th>{{trans("messages.kap")}}</th>
																			 <th>{{trans("messages.kilo")}}</th>

																			 <th>{{trans("messages.problem")}}</th>
																			 <th>{{trans("messages.problemAciklama")}}</th>
																			 <th>{{trans("messages.aciklama")}}</th>
																		 </tr>
																			<tr>
																				<td>{{$altkey}}</td>

																				<td>{{$altvalue->varisGumrugu}}</td>
																				<td>{{$altvalue->yuklemeNoktasiAdet}}</td>
																				<td>{{$altvalue->kap}}</td>
																				<td>{{$altvalue->kilo}}</td>
																				<td>{{$altvalue->problem}}</td>
																				<td>{{$altvalue->problemAciklama}}</td>
																				<td>{{$altvalue->aciklama}}</td>
																			</tr>
																			@if (!empty($altvalue->param))
																			<tr>
																				<td colspan="8">
																				 <table class="table table-bordered" cellspacing="0">
																					 <thead>
																							 <tr>
																								<th>{{trans("messages.mrnnumber")}}</th>
																								<th>{{trans("messages.gonderici")}}</th>
																 								<th>{{trans("messages.ulkekodu")}}</th>
																 								<th>{{trans("messages.alici")}}</th>
																 								<th>{{trans("messages.ulkekodu")}}</th>
																 								<th>{{trans("messages.talimattipi")}}</th>
																 								<th>{{trans("messages.kap")}}</th>
																 								<th>{{trans("messages.kilo")}}</th>
																 								<th>{{trans("messages.yukcinsi")}}</th>
																 								<th>{{trans("messages.faturanumara")}}</th>
																 								<th>{{trans("messages.faturabedeli")}}</th>
																 								<th>{{trans("messages.ADR")}}</th>
																 								<th>{{trans("messages.atr")}}</th>
																							 </tr>
																					 </thead>
																					@foreach($altvalue->param as $paramkey=>$paramvalue)

																							<tr>
																									<td>{{$paramvalue->mrnnumber}}</td>
																									<td>{{$paramvalue->yuklemeNoktasi}}</td>
																									<td>{{$paramvalue->yuklemeNoktasiulkekodu}}</td>
																									<td>{{$paramvalue->indirmeNoktasi}}</td>
																									<td>{{$paramvalue->indirmeNoktasiulkekodu}}</td>
																									<td>{{$paramvalue->talimatTipi}}</td>
																									<td>{{$paramvalue->tekKap}}</td>
																									<td>{{$paramvalue->tekKilo}}</td>
																									<td>{{$paramvalue->yukcinsi}}</td>
																									<td>{{$paramvalue->faturanumara}}</td>

																									<td>{{$paramvalue->adr}}</td>
																									<td>{{$paramvalue->atr}}</td>
																									<td>{{$paramvalue->adtrmessage}}</td>
																							</tr>
																					@endforeach
																				</table>
																				</td>
																				</tr>
																			@endif
																		@endforeach
																	@endif

																	</tr>
															 </tbody>

																</table>
														 </div>
						</div>
         </div>



     </div>
@endsection
