@extends('layouts.app')

@section('kirinti')
	{{trans("messages.operasyoninceleheader")}}
@endsection

@section('scripts')
<style>
table {font-size:0.9em;}
</style>
@endsection

@section('endscripts')
	<script>
	function yonlendirTalimatPage(id,t)
	{


		var l=confirm("{{trans('messages.talimatyonlendirmemesaj')}}");
		if (l==true)
		{
				window.location.href='/operasyon/ozelislem/'+id+'/'+$(t).val();
		}
	}
</script>
@endsection
@section('content')
	<div class="card mb-3">
				<div class="card-body">
				<div class='row'>

					<div class='col-8'><i class="fa fa-table"></i> <span>{{trans('messages.createddate')}} : {{\Carbon\Carbon::parse($talimat->created_at)->format('d-m-Y H:i')}} / {{trans('messages.updateddate')}} : {{\Carbon\Carbon::parse($talimat->updated_at)->format('d-m-Y H:i')}}</span></div>
					

				</div>
					<div class="row">
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
																		<td><strong>{{trans("messages.talimattipi")}}</strong></td>
																		<td>
																			{{trans("messages.".$talimat->talimatTipi)}}
																		</td>
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
																	 <td><strong>{{trans("messages.bolgeilgilenen")}}</strong></td>
																	 <td>
																		 	{{$talimat->ilgili->name}} {{$talimat->ilgili->email}}</td>
																 </tr>
																 <tr>
																	 <td><strong>{{trans("messages.talimatdurumu")}}</strong></td>
																	 <td>
																	 <span style='color:red'>{{trans("messages.".$talimat->durum)}}</span>
																		@if (\Auth::user()->id==$talimat->ilgili->id || \Auth::user()->role=="admin")
																			@if($talimat->durum=="bekleme")
																				<br /><a href="/operation/donethis/{{$talimat->id}}" class="btn btn-danger">@if (\Auth::user()->role=="admin")Yönetici Olarak @endif Operasyonu Tamamla</a>
																			  @endif
																		@endif
																	 </td>

																 </tr>
																 <tr>
																	 	<td><strong>{{trans("messages.muhasebedurumu")}}</strong></td>
																		<td><strong>{{trans("messages.muhasebedurumu")}}</strong></td>
																 </tr>
																 </table>

													 </div>

												 </div>

													 <div class='col-sm-12'>
														 <form action="/operation/update" method="post">
    											 		{{ csrf_field() }}
														 <h5>{{trans("messages.gumrukbilgileri")}}</h5>
															 <table class="table table-bordered" cellspacing="0">
															 <tbody>
															 <tr>
																	<td colspan='11'><hr /></td>
															 </tr>
																<tbody>
																@if (!empty($talimat->altmodel))
																	@switch($talimat->talimatTipi)
    																		@case("ex1")
																				<tr>
																					<th>{{trans("messages.gumrukno")}}</th>
																					<th>{{trans("messages.varisgumruk")}}</th>

															            <th>{{trans("messages.gonderici")}}</th>
															            <th>{{trans("messages.ulkekodu")}}</th>
															            <th>{{trans("messages.alici")}}</th>
															            <th>{{trans("messages.ulkekodu")}}</th>
															            <th>{{trans("messages.kap")}}</th>
															            <th>{{trans("messages.kilo")}}</th>

															            <th>{{trans("messages.yukcinsi")}}</th>
															            <th>{{trans("messages.faturanumara")}}</th>
															            <th>{{trans("messages.faturabedeli")}}</th>
																				 </tr>
																					@foreach($talimat->altmodel as $altkey=>$altvalue)
																						<tr>
																							<td class="text-red">{{$altvalue->gumrukId+1}}</td>
																							<td><input type='text' name="varisgumruk[{{$altvalue->id}}]" class="form-control" value="{{$altvalue->varisGumruk}}" /></td>
																							<td>{{$altvalue->yuklemeNoktasi}}</td>
																							<td>{{$altvalue->yuklemeNoktasiulkekodu}}</td>
																							<td>{{$altvalue->indirmeNoktasi}}</td>
																							<td>{{$altvalue->indirmeNoktasiulkekodu}}</td>
																							<td>{{$altvalue->tekKap}}</td>
																							<td>{{$altvalue->tekKilo}}</td>
																							<td>{{$altvalue->yukcinsi}}</td>
																							<td>{{$altvalue->faturanumara}}</td>
																							<td>{{$altvalue->faturabedeli}}</td>
																						</tr>
																					@endforeach
																				@break
																				@case("t2")
																						<tr>
																							<th>{{trans("messages.gumrukno")}}</th>
																							<th>{{trans("messages.mrnnumber")}}</th>
																	            <th>{{trans("messages.gonderici")}}</th>
																	            <th>{{trans("messages.ulkekodu")}}</th>
																	            <th>{{trans("messages.alici")}}</th>
																	            <th>{{trans("messages.ulkekodu")}}</th>
																	            <th>{{trans("messages.kap")}}</th>
																	            <th>{{trans("messages.kilo")}}</th>

																	            <th>{{trans("messages.yukcinsi")}}</th>

																	            <th>{{trans("messages.faturanumara")}}</th>
																	            <th>{{trans("messages.faturabedeli")}}</th>
																	          </tr>
																						@foreach($talimat->altmodel as $altkey=>$altvalue)
																							<tr>
																								<td>{{$altvalue->gumrukId+1}}</td>
																								<td>{{$altvalue->mrnnumber}}</td>
																								<td>{{$altvalue->yuklemeNoktasi}}</td>
																								<td>{{$altvalue->yuklemeNoktasiulkekodu}}</td>
																								<td>{{$altvalue->indirmeNoktasi}}</td>
																								<td>{{$altvalue->indirmeNoktasiulkekodu}}</td>
																								<td>{{$altvalue->tekKap}}</td>
																								<td>{{$altvalue->tekKilo}}</td>
																								<td>{{$altvalue->yukcinsi}}</td>
																								<td>{{$altvalue->faturanumara}}</td>
																								<td>{{$altvalue->faturabedeli}}</td>
																							</tr>
																						@endforeach
																				@break
																		  @case("passage")
																			<tr>
																				<th>{{trans("messages.gumrukno")}}</th>
																				<th>{{trans("messages.tirnumarasi")}}</th>
														            <th>{{trans("messages.gonderici")}}</th>
														            <th>{{trans("messages.ulkekodu")}}</th>
														            <th>{{trans("messages.kap")}}</th>
														            <th>{{trans("messages.kilo")}}</th>
														            <th>{{trans("messages.faturacinsi")}}</th>
														            <th>{{trans("messages.faturanumara")}}</th>
														            <th>{{trans("messages.faturabedeli")}}</th>
																			</tr>
																			@foreach($talimat->altmodel as $altkey=>$altvalue)
																				<tr>
																					<td>{{$altvalue->gumrukId+1}}</td>
																					<td>{{$altvalue->tirnumarasi}}</td>
																					<td>{{$altvalue->yuklemeNoktasi}}</td>
																					<td>{{$altvalue->yuklemeNoktasiulkekodu}}</td>
																					<td>{{$altvalue->tekKap}}</td>
																					<td>{{$altvalue->tekKilo}}</td>
																					<td>{{$altvalue->yukcinsi}}</td>
																					<td>{{$altvalue->faturanumara}}</td>
																					<td>{{$altvalue->faturabedeli}}</td>
																				</tr>
																			@endforeach
																			@break
																		  @case("t1kapama")
																			<tr>
																				<th>{{trans("messages.gumrukno")}}</th>
																				<th>{{trans("messages.baslangicgumruk")}}</th>

														            <th>{{trans("messages.gonderici")}}</th>
														            <th>{{trans("messages.ulkekodu")}}</th>
														            <th>{{trans("messages.varisgumruk")}}</th>
														            <th>{{trans("messages.alici")}}</th>
														            <th>{{trans("messages.ulkekodu")}}</th>
														            <th>{{trans("messages.kap")}}</th>
														            <th>{{trans("messages.kilo")}}</th>

														            <th>{{trans("messages.yukcinsi")}}</th>
														            <th>{{trans("messages.faturacinsi")}}</th>
														            <th>{{trans("messages.faturanumara")}}</th>
														            <th>{{trans("messages.faturabedeli")}}</th>
																			</tr>
																			@foreach($talimat->altmodel as $altkey=>$altvalue)
																				<tr>
																					<td>{{$altvalue->gumrukId+1}}</td>
																					<td><input type='text' name="baslangicgumruk[{{$altvalue->id}}]" class="form-control" value="{{$altvalue->baslangicGumruk}}" /></td>

																					<td>{{$altvalue->yuklemeNoktasi}}</td>
																					<td>{{$altvalue->yuklemeNoktasiulkekodu}}</td>
																					<td><input type='text' name="varisgumruk[{{$altvalue->id}}]" class="form-control" value="{{$altvalue->varisGumruk}}" /></td>
																					<td>{{$altvalue->indirmeNoktasi}}</td>
																					<td>{{$altvalue->indirmeNoktasiulkekodu}}</td>
																					<td>{{$altvalue->tekKap}}</td>
																					<td>{{$altvalue->tekKilo}}</td>
																					<td>{{$altvalue->yukcinsi}}</td>
																					<td>{{$altvalue->faturanumara}}</td>
																					<td>{{$altvalue->faturabedeli}}</td>
																				</tr>
																			@endforeach
																		  @case("tir")
																			<tr>
																				<th>{{trans("messages.gumrukno")}}</th>
																				<th>{{trans("messages.tirnumarasi")}}</th>
														            <th>{{trans("messages.gonderici")}}</th>
														            <th>{{trans("messages.ulkekodu")}}</th>
														            <th>{{trans("messages.kap")}}</th>
														            <th>{{trans("messages.kilo")}}</th>

														            <th>{{trans("messages.faturacinsi")}}</th>
														            <th>{{trans("messages.faturanumara")}}</th>
														            <th>{{trans("messages.faturabedeli")}}</th>
																			</tr>
																			@foreach($talimat->altmodel as $altkey=>$altvalue)
																				<tr>
																					<td>{{$altvalue->gumrukId+1}}</td>
																					<td>{{$altvalue->tirnumarasi}}</td>
																					<td>{{$altvalue->yuklemeNoktasi}}</td>
																					<td>{{$altvalue->yuklemeNoktasiulkekodu}}</td>
																					<td>{{$altvalue->indirmeNoktasi}}</td>
																					<td>{{$altvalue->indirmeNoktasiulkekodu}}</td>
																					<td>{{$altvalue->tekKap}}</td>
																					<td>{{$altvalue->tekKilo}}</td>
																					<td>{{$altvalue->yukcinsi}}</td>
																					<td>{{$altvalue->faturanumara}}</td>
																					<td>{{$altvalue->faturabedeli}}</td>
																				</tr>
																			@endforeach
																			@break
																		  @case("ata")
																			<tr>
																				<th>{{trans("messages.gumrukno")}}</th>
																				<th>{{trans("messages.tirnumarasi")}}</th>
														            <th>{{trans("messages.gonderici")}}</th>
														            <th>{{trans("messages.ulkekodu")}}</th>
														            <th>{{trans("messages.kap")}}</th>
														            <th>{{trans("messages.kilo")}}</th>

														            <th>{{trans("messages.faturacinsi")}}</th>
														            <th>{{trans("messages.faturanumara")}}</th>
														            <th>{{trans("messages.faturabedeli")}}</th>
																			</tr>
																			@foreach($talimat->altmodel as $altkey=>$altvalue)
																				<tr>
																					<td>{{$altvalue->gumrukId+1}}</td>
																					<td>{{$altvalue->tirnumarasi}}</td>
																					<td>{{$altvalue->yuklemeNoktasi}}</td>
																					<td>{{$altvalue->yuklemeNoktasiulkekodu}}</td>
																					<td>{{$altvalue->tekKap}}</td>
																					<td>{{$altvalue->tekKilo}}</td>
																					<td>{{$altvalue->yukcinsi}}</td>
																					<td>{{$altvalue->faturanumara}}</td>
																					<td>{{$altvalue->faturabedeli}}</td>
																				</tr>
																			@endforeach
																			@break
																		  @case("listex")
																			<tr>
																				<th>{{trans("messages.gumrukno")}}</th>
																				<th>{{trans("messages.varisgumruk")}}</th>
														            <th>{{trans("messages.gonderici")}}</th>
														            <th>{{trans("messages.ulkekodu")}}</th>
														            <th>{{trans("messages.alici")}}</th>
														            <th>{{trans("messages.ulkekodu")}}</th>
														            <th>{{trans("messages.kap")}}</th>
														            <th>{{trans("messages.kilo")}}</th>

														            <th>{{trans("messages.yukcinsi")}}</th>

														            <th>{{trans("messages.faturanumara")}}</th>
														            <th>{{trans("messages.faturabedeli")}}</th>
																			</tr>
																			@foreach($talimat->altmodel as $altkey=>$altvalue)
																				<tr>
																					<td>{{$altvalue->gumrukId+1}}</td>
																					<td><input type='text' name="varisgumruk[{{$altvalue->id}}]" class="form-control" value="{{$altvalue->varisGumruk}}" /></td>
																					<td>{{$altvalue->yuklemeNoktasi}}</td>
																					<td>{{$altvalue->yuklemeNoktasiulkekodu}}</td>
																					<td>{{$altvalue->indirmeNoktasi}}</td>
																					<td>{{$altvalue->indirmeNoktasiulkekodu}}</td>
																					<td>{{$altvalue->tekKap}}</td>
																					<td>{{$altvalue->tekKilo}}</td>
																					<td>{{$altvalue->yukcinsi}}</td>
																					<td>{{$altvalue->faturanumara}}</td>
																					<td>{{$altvalue->faturabedeli}}</td>
																				</tr>
																			@endforeach
																			@break
																		  @case("ithalatimport")
																			<tr>
																				<th>{{trans("messages.gumrukno")}}</th>
																				<th>{{trans("messages.varisgumruk")}}</th>
														            <th>{{trans("messages.gonderici")}}</th>
														            <th>{{trans("messages.ulkekodu")}}</th>
														            <th>{{trans("messages.alici")}}</th>
														            <th>{{trans("messages.ulkekodu")}}</th>
														            <th>{{trans("messages.kap")}}</th>
														            <th>{{trans("messages.kilo")}}</th>

														            <th>{{trans("messages.yukcinsi")}}</th>
														            <th>{{trans("messages.faturacinsi")}}</th>
														            <th>{{trans("messages.faturanumara")}}</th>
														            <th>{{trans("messages.faturabedeli")}}</th>
																			</tr>
																			@foreach($talimat->altmodel as $altkey=>$altvalue)
																				<tr>
																					<td>{{$altvalue->gumrukId+1}}</td>
																					<td><input type='text' name="varisgumruk[{{$altvalue->id}}]" class="form-control" value="{{$altvalue->varisGumruk}}" /></td>
																					<td>{{$altvalue->yuklemeNoktasi}}</td>
																					<td>{{$altvalue->yuklemeNoktasiulkekodu}}</td>
																					<td>{{$altvalue->indirmeNoktasi}}</td>
																					<td>{{$altvalue->indirmeNoktasiulkekodu}}</td>
																					<td>{{$altvalue->tekKap}}</td>
																					<td>{{$altvalue->tekKilo}}</td>
																					<td>{{$altvalue->yukcinsi}}</td>
																					<td>{{$altvalue->faturanumara}}</td>
																					<td>{{$altvalue->faturabedeli}}</td>
																				</tr>
																			@endforeach
																			@break
																		  @case("bondeshortie")
																			<tr>
																				<th>{{trans("messages.plaka")}}</th>
														            <th>{{trans("messages.gonderici")}}</th>

																			</tr>
																			@foreach($talimat->altmodel as $altkey=>$altvalue)
																				<tr>
																					<td>{{$altvalue->yuklemeNoktasi}}</td>
																					<td>{{$altvalue->yuklemeNoktasiulkekodu}}</td>

																				</tr>
																			@endforeach
																			@break
																		  @case("ext1t2")
																			<tr>
																				<th>{{trans("messages.varisgumruk")}}</th>
														            <th>{{trans("messages.mrnnumber")}}</th>
														            <th>{{trans("messages.gonderici")}}</th>
														            <th>{{trans("messages.ulkekodu")}}</th>
														            <th>{{trans("messages.alici")}}</th>
														            <th>{{trans("messages.ulkekodu")}}</th>
														            <th>{{trans("messages.kap")}}</th>
														            <th>{{trans("messages.kilo")}}</th>

														            <th>{{trans("messages.yukcinsi")}}</th>
														            <th>{{trans("messages.faturacinsi")}}</th>
														            <th>{{trans("messages.faturanumara")}}</th>
														            <th>{{trans("messages.faturabedeli")}}</th>
																			</tr>
																			@foreach($talimat->altmodel as $altkey=>$altvalue)
																				<tr>
																					<td>{{$altvalue->gumrukId+1}}</td>
																						<td>{{$altvalue->mrnnumber}}</td>
																					<td><input type='text' name="varisgumruk[{{$altvalue->id}}]" class="form-control" value="{{$altvalue->varisGumruk}}" /></td>
																					<td>{{$altvalue->yuklemeNoktasi}}</td>
																					<td>{{$altvalue->yuklemeNoktasiulkekodu}}</td>
																					<td>{{$altvalue->indirmeNoktasi}}</td>
																					<td>{{$altvalue->indirmeNoktasiulkekodu}}</td>
																					<td>{{$altvalue->tekKap}}</td>
																					<td>{{$altvalue->tekKilo}}</td>
																					<td>{{$altvalue->yukcinsi}}</td>
																					<td>{{$altvalue->faturanumara}}</td>
																					<td>{{$altvalue->faturabedeli}}</td>
																				</tr>
																			@endforeach
																			@break
																	@endswitch
																@endif

															 </tbody>

																</table>
																<div class="col-12 text-right" >
																<button type="submit" value="1" class="btn btn-danger">{{trans("messages.update")}}</button>
																</div>

																</form>
														 </div>

				 								 	</div>



		 				</div>
			 </div>
@endsection
