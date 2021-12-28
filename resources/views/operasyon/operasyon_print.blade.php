
<!doctype html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Language" content="en" />
    <link rel="icon" href="./favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" type="image/x-icon" href="./favicon.ico" />
    <!-- Generated: 2018-04-16 09:29:05 +0200 -->
    <title>Bosphore GROUP - Yönetim Sayfası</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext">
    <!-- Dashboard Core -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

  </head>
  <body class="" onload="window.print()">
    <div class="page    bg-white text-dark">
      <div class="page-main">
        <div class="header py-4">
          <div class="container-fluid">


	<div class="card mb-3">
    <div class="card-header">
      <img src='/img/0RRZ19.png' class="img-fluid w-50" />
    </div>
				<div class="card-body">
				<div class='row'>

					<div class='col-8'><i class="fa fa-table"></i> <span>{{trans('messages.createddate')}} : {{\Carbon\Carbon::parse($talimat->created_at)->format('d-m-Y H:i')}} / {{trans('messages.updateddate')}} : {{\Carbon\Carbon::parse($talimat->updated_at)->format('d-m-Y H:i')}}</span></div>
				</div>
					<div class="row mt-5">
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
																	 <td><strong>{{trans("messages.kayitilgilenen")}}</strong></td>
																	 <td>
                                     @if (!empty($talimat->ilgili))
																		 	    {{$talimat->ilgili->name}} {{$talimat->ilgili->email}}
                                    @endif
                                    </td>
																 </tr>
                                 <tr>
                                   <td><strong>{{trans("messages.islemilgilenen")}}</strong></td>
                                	<td>@if (!empty($talimat->ilgilikayit->name)) {{$talimat->ilgilikayit->name}} {{$talimat->ilgilikayit->email}} @endif</td>
                                 </tr>


																 <tr>
																	 <td><strong>{{trans("messages.talimatdurumu")}}</strong></td>
																	 <td>
																	 <span style='color:red'>{{trans("messages.".$talimat->durum)}}</span>
																	 </td>
																 </tr>

																 </table>

													 </div>

												 </div>

													 <div class='col-sm-12'>
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
																							<td>{{$altvalue->varisGumruk}}</td>
																							<td>{{$altvalue->yuklemeNoktasi}}</td>
																							<td>{{$ulke[$altvalue->yuklemeNoktasiulkekodu]}}</td>
																							<td>{{$altvalue->indirmeNoktasi}}</td>
																							<td>{{$ulke[$altvalue->indirmeNoktasiulkekodu]}}</td>
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
																								<td>{{$altvalue->mrnnumber}}</td>
                                                	<td>{{$altvalue->varisGumruk}}</td>
																								<td>{{$altvalue->yuklemeNoktasi}}</td>
																								<td>{{$ulke[$altvalue->yuklemeNoktasiulkekodu]}}</td>
																								<td>{{$altvalue->indirmeNoktasi}}</td>
																								<td>{{$ulke[$altvalue->indirmeNoktasiulkekodu]}}</td>
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
																					<td>{{$ulke[$altvalue->yuklemeNoktasiulkekodu]}}</td>
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
																					<td>{{$altvalue->baslangicGumruk}}</td>

																					<td>{{$altvalue->yuklemeNoktasi}}</td>
																					<td>{{$ulke[$altvalue->yuklemeNoktasiulkekodu]}}</td>
																					<td>{{$altvalue->varisGumruk}}</td>
																					<td>{{$altvalue->indirmeNoktasi}}</td>
																					<td>{{$ulke[$altvalue->indirmeNoktasiulkekodu]}}</td>
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
																					<td>{{$ulke[$altvalue->yuklemeNoktasiulkekodu]}}</td>
																					<td>{{$altvalue->indirmeNoktasi}}</td>
																					<td>{{$ulke[$altvalue->indirmeNoktasiulkekodu]}}</td>
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
																					<td>{{$ulke[$altvalue->yuklemeNoktasiulkekodu]}}</td>
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
																					<td>{{$altvalue->varisGumruk}}</td>
																					<td>{{$altvalue->yuklemeNoktasi}}</td>
																					<td>{{$ulke[$altvalue->yuklemeNoktasiulkekodu]}}</td>
																					<td>{{$altvalue->indirmeNoktasi}}</td>
																					<td>{{$ulke[$altvalue->indirmeNoktasiulkekodu]}}</td>
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
																					<td>{{$altvalue->varisGumruk}}</td>
																					<td>{{$altvalue->yuklemeNoktasi}}</td>
																					<td>{{$ulke[$altvalue->yuklemeNoktasiulkekodu]}}</td>
																					<td>{{$altvalue->indirmeNoktasi}}</td>
																					<td>{{$ulke[$altvalue->indirmeNoktasiulkekodu]}}</td>
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
																					<td>{{$ulke[$altvalue->yuklemeNoktasiulkekodu]}}</td>

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
																					<td>{{$altvalue->varisGumruk}}</td>
																					<td>{{$altvalue->yuklemeNoktasi}}</td>
																					<td>{{$ulke[$altvalue->yuklemeNoktasiulkekodu]}}</td>
																					<td>{{$altvalue->indirmeNoktasi}}</td>
																					<td>{{$ulke[$altvalue->indirmeNoktasiulkekodu]}}</td>
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
                                @if (!empty($talimat->altmodel))
                                  @php ($toplamkap = 0)
                                  @php ($toplamkilo = 0)
                                    @foreach($talimat->altmodel as $altkey=>$altvalue)
                                      @php ($toplamkap+=$altvalue->tekKap)
                                      @php ($toplamkilo+=$altvalue->tekKilo)
                                    @endforeach
                                  @endif
                                    <tr>
                                        <td colspan="3">{{trans("messages.toplamkap")}}</td>
                                        <td>{{$toplamkap}}</td>
                                        <td colspan="3">{{trans("messages.toplamkilo")}}</td>
                                        <td>{{$toplamkilo}}</td>
                                    </tr>
															 </tbody>

																</table>
														 </div>

				 								 	</div>



		 				</div>
			 </div>

</div>
</div>
</div>
</div>
</body>
</html>
