
              	<div class="tab-pane @if($kacinci==1) active in @endif   fade" id="tab-{{$kacinci}}" role="tabpanel" aria-labelledby="tab-{{$kacinci}}" >
                  <br />
                      <div class='row'>
                          <div class='form-group col-md-6 temizlenebilir'>
                        <label for="varisGumrugu">{{trans("messages.varisgumruk")}}</label>
                            <input type="text" class="form-control varisGumruk" onkeyup="" name='varisGumrugu[]' id="" placeholder="Varış Gümrüğü"  required="required">
                          </div>
                  	 </div>
                  <hr />
                  <div class="form-group col-md-12 temizlenebilir ">
                    <div class="form-group col-md-12 temizlenebilir ">
                      <label for="yukleme">{{trans("messages.alicigondericiadet")}}</label>
                      	<select name="yuklemeNoktasiAdet[{{$say}}]" class="form-control input-sm yuklemeNoktasi " data-num="1" onchange="noktalarIcinAlanOlustur(this,{{$say}})" >
                     			@for ($i = 1; $i < 100; $i++)
            						       <option value="{{ $i }}">{{ $i }}</option>
        						      @endfor
                      	</select>
                      </div>
                      <div class="form-group col-md-12 temizlenebilir malCinsiTabloları">
                			<table class="table table-bordered malYuklemeBosaltmaTablolari" width="100%" cellspacing="0">
                				<thead>
                    				<tr>

                              <th>{{trans("messages.sira")}}</th>
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
                				<tbody>
                    				<tr>
                						<td>1</td>
                            <td><input type="text" class="form-control" name="mrnmumber[{{$say}}][]" required="required"/></td>
                              <td><input type="text" class="form-control" name="yuklemeNoktasi[{{$say}}][]" required="required"/></td>
                              <td>
																<select name="yuklemeNoktasiulkekodu[{{$say}}][]" class="form-control col-xs-2">
																 <option value="0">{{trans("messages.seciniz")}}</option>
																 @if(!empty($ulkeList))
																	 	@foreach ($ulkeList as $ulkekey => $ulkevalue)
																	 		<option value="{{$ulkevalue->kod_gib}}-{{$ulkevalue->world}}">{{$ulkevalue->global_name}}</option>
																	 	@endforeach
																@endif
															</select>
															</td>
                    					<td><input type="text" class="form-control" name="indirmeNoktasi[{{$say}}][]" required="required"/></td>
															<td>
																<select name="indirmeNoktasiulkekodu[{{$say}}][]" class="form-control col-xs-2">
																 <option value="0">{{trans("messages.seciniz")}}</option>
																 @if(!empty($ulkeList))
																	 	@foreach ($ulkeList as $ulkekey => $ulkevalue)
																	 		<option value="{{$ulkevalue->kod_gib}}-{{$ulkevalue->world}}">{{$ulkevalue->global_name}}</option>
																	 	@endforeach

																@endif
																</select>
															</td>

                              <td>
                                 @if (!empty($talimatList))
                                   <select name='talimatTipi[{{$say}}][]' class="form-control" id='talimatTipi' onchange='gettalimatData(this)'>
                                    	 	@foreach($talimatList as $key=>$value)
                                            	 <option value="{{ $value->kisaKod }}">{{ $value->kodName }}</option>
                                      	@endforeach
                                      	 </select>
                                  @endif
                                </td>
                              <td><input type="text" class="form-control hesaplanacakKap" name="tekKap[{{$say}}][]" required="required" onchange="hesaplaKapKilo({{$say}})"/></td>
            							    <td><input type="text" class="form-control  hesaplanacakKilo" name="tekKilo[{{$say}}][]" required="required"  onchange="hesaplaKapKilo({{$say}})"/></td>
															<td><input type="text" class="form-control" name="yukcinsi[{{$say}}][]" required="required"   /> </td>
															<td><input type="text" class="form-control" name="faturanumara[{{$say}}][]" required="required"   /> </td>
															<td  class="faturabedel"><input type="text" class="form-control" name="faturabedeli[{{$say}}][]" required="required"   /> </td>
                              <td>
																	<select name="adr[{{$say}}][]" class="form-control" >
							                  	 		<option value="no">{{trans("messages.yok")}}</option>
							                  	 		<option value="yes">{{trans("messages.var")}}</option>
							                  	 	</select>
															</td>
															<td>
																<select name="atr[{{$say}}][]" class="form-control" >
						                      	 	<option value="no">{{trans("messages.yapilmasin")}}</option>
						                      	 	<option value="yes">{{trans("messages.yapilsin")}}</option>
						                      	 </select>
															</td>
                    				</tr>
                				</tbody>
                			</table>
                      </div>
                        <hr />
                      <div class="form-group col-md-6 temizlenebilir">
                        <label for="kap">{{trans("messages.toplamkap")}}</label>
                        <input type="text" class="form-control" readonly="readonly" name='kap[{{$say}}]' id="kap" placeholder="Kap"  required="required">
                      </div>
                      <div class="form-group col-md-6 temizlenebilir">
                        <label for="kilo">{{trans("messages.toplamkilo")}}</label>
                        <input type="text" class="form-control" readonly="readonly" name='kilo[{{$say}}]' id="kilo" placeholder="Kilo"  required="required">
                      </div>
                    </div>
                    <div class="form-group col-md-6 temizlenebilir">
                      <label for="problem">{{trans("messages.problem")}}</label>
                     <select name="problem[{{$say}}]" class="form-control" id="" onchange="openPr(this)" >
                      <option value="no">{{trans("messages.yok")}}</option>
                      <option value="yes">{{trans("messages.var")}}</option>
                     </select>

                    <div class=' form-group col-md-6  temizlenebilir problemYazi hidden' ><label for="problemAciklama ">{{trans("messages.problemaciklama")}}</label>
                      <input type='text' name='problemAciklama[{{$say}}]' class="form-control" /></div>

                    </div>
                    <div class="form-group col-md-6 temizlenebilir">
                      <label for="aciklama">{{trans("messages.aciklama")}}</label>
                      <textarea class="form-control" name='aciklama[{{$say}}]' id="aciklama" rows='5'></textarea>
                    </div>

                  </div>


                  {{--
                  <div class="form-group col-md-6 temizlenebilir">
                    <label for="kap">{{trans("messages.toplamkap")}}</label>
                    <input type="text" class="form-control" readonly="readonly" name='kap[{{$kacinci}}]' id="kap" placeholder="Kap"  required="required">
                  </div>
                  <div class="form-group col-md-6 temizlenebilir">
                    <label for="kilo">{{trans("messages.toplamkilo")}}</label>
                    <input type="text" class="form-control" readonly="readonly" name='kilo[{{$kacinci}}]' id="kilo" placeholder="Kilo"  required="required">
                  </div>
                  --}}
              	</div>
