
<div class="tab-pane  @if ($say>0) fade @else active @endif" id="tab-{{$say+1}}"  aria-labelledby="tab{{$say+1}}" >

  <h3>{{trans("messages.lutfengumrukbilgigiriniz")}} - {{$say+1}}</h3>

  <div class="form-check  temizlenebilir alert alert-danger">
    <input  class="form-check-input" type="checkbox" name="ext1tot2"  value="yes" />
    <label class="form-check-label" for="ext1tot2">
      {{trans("messages.t2")}} {{trans("messages.makeit")}}</label>
  </div>

    <div class="form-group col-md-12 temizlenebilir ">
      <label for="yukleme">{{trans("messages.alicigondericiadet")}}</label>
        <select name="yuklemeNoktasiAdet[{{$say}}][]" class="form-control input-sm yuklemeNoktasi " data-num="1" onchange="noktalarIcinAlanOlustur(this,{{$say}})" >
          @for ($i = 1; $i < 100; $i++)
               <option value="{{ $i }}">{{ $i }}</option>
          @endfor
        </select>
      </div>
      <hr />

    <table class="table table-bordered malYuklemeBosaltmaTablolari" width="100%" cellspacing="0">
      <thead>
          <tr>

            <th>{{trans("messages.varisgumruk")}}</th>

            <th>{{trans("messages.gonderici")}}</th>
            <th>{{trans("messages.gonderici")}} {{trans("messages.ulkekodu")}}</th>
            <th>{{trans("messages.alici")}}</th>
            <th>{{trans("messages.alici")}} {{trans("messages.ulkekodu")}}</th>
            <th>{{trans("messages.kap")}}</th>
            <th>{{trans("messages.kilo")}}</th>

            <th>{{trans("messages.yukcinsi")}}</th>
            <th>{{trans("messages.faturacinsi")}}</th>
            <th>{{trans("messages.faturanumara")}}</th>
            <th>{{trans("messages.faturabedeli")}}</th>
          </tr>
      </thead>
      <tbody>
          <tr id="sampletr{{$say}}">


            <td><input type="text" class="form-control varisGumruk"  name='varisGumrugu[{{$say}}][]' id="" placeholder="Varış Gümrüğü" ></td>

          <td><input type="text" class="form-control kolaysay" name="yuklemeNoktasi[{{$say}}][]" required="required"/></td>

            <td>
              <select name="yuklemeNoktasiulkekodu[{{$say}}][]" class="form-control col-xs-2">
               <option value="0">{{trans("messages.seciniz")}}</option>
               @if(!empty($ulkeList))
                  @foreach ($ulkeList as $ulkekey => $ulkevalue)
                    <option value="{{$ulkevalue->id}}">{{$ulkevalue->global_name}}</option>
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
                    <option value="{{$ulkevalue->id}}">{{$ulkevalue->global_name}}</option>
                  @endforeach

              @endif
              </select>
            </td>

            <td><input type="text" class="form-control hesaplanacakKap" name="tekKap[{{$say}}][]" required="required" onchange="hesaplaKapKilo(0)"/></td>
            <td><input type="text" class="form-control  hesaplanacakKilo" name="tekKilo[{{$say}}][]" required="required"  onchange="hesaplaKapKilo(0)"/></td>
            <td><input type="text" class="form-control yukcinsi" name="yukcinsi[{{$say}}][]" required="required"   /> </td>
            <td>
              <select name="faturacinsi[{{$say}}][]" class="form-control col-xs-2">
                <option value="0">{{trans("messages.seciniz")}}</option>
                <option value="EXW">EXW</option>
                <option value="FCA">FCA</option>
                <option value="CPT">CPT</option>
                <option value="CIP">CIP</option>
                <option value="DAT">DAT</option>
                <option value="DAP">DAP</option>
                <option value="DDP">DDP</option>
                <option value="FAS">FAS</option>
                <option value="FOB">FOB</option>
                <option value="CFR">CFR</option>
                <option value="CIF">CIF</option>

              </select>
            </td>
            <td><input type="text" class="form-control" name="faturanumara[{{$say}}][]"  /> </td>
            <td class="faturabedel"><input type="text" class="form-control " name="faturabedeli[{{$say}}][]"  /> </td>

          </tr>
      </tbody>
    </table>
    <hr />
    <div class="form-group col-md-6 temizlenebilir">
      <label for="kap">{{trans("messages.toplamkap")}}</label>
      <input type="text" class="form-control" readonly="readonly" name='kap[{{$say}}]' id="kap" placeholder="Kap"  required="required">
    </div>
    <div class="form-group col-md-6 temizlenebilir">
      <label for="kilo">{{trans("messages.toplamkilo")}}</label>
      <input type="text" class="form-control" readonly="readonly" name='kilo[{{$say}}]' id="kilo" placeholder="Kilo"  required="required">
    </div>
    <div class="col-md-12">
    <h2>{{trans("messages.ozelevrakyuklemebaslik")}}</h2>
    <hr />
      <div id="evrakbolumu_{{$say}}">

      </div>
  </div>
</div>
