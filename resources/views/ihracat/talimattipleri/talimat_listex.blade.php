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

            <th>{{trans("messages.faturanumara")}}</th>
            <th>{{trans("messages.faturabedeli")}}</th>
          </tr>
      </thead>
      <tbody>
                <tr><td colspan="12">{{trans("messages.".$talimattipi)}}</td></tr>
          <tr id="sampletr{{$say}}">

            <td><input type="text" class="form-control varisGumruk"  name='varisGumrugu[{{$say}}][]' id="" placeholder="Varış Gümrüğü" ></td>
          <td><input type="text" class="form-control" name="yuklemeNoktasi[{{$say}}][]" required="required"/></td>

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

            <td><input type="text" class="form-control" name="faturanumara[{{$say}}][]"   /> </td>
            <td class="faturabedel"><input type="text" class="form-control " name="faturabedeli[{{$say}}][]"   /> </td>
            <td><a href='javascript:void(0)' onclick='deleteTableItem(this)'><i class="fa fa-remove"></i></a></td>
            <td>
                  <input type="hidden" name="talimattipi[{{$say}}][]" value="{{$talimattipi}}" />
              @php
                $idc=md5(microtime().rand(0,95221115));
              @endphp
              <label for="in_{{$idc}}" class="custom-file-upload">
                   <i class="fa fa-file" style="color:#467fcf" ></i>
              </label>
              <input type="file" name="spuserfile[{{$say}}][{{$which}}][]" id="in_{{$idc}}" class="d-none hidden" multiple /></td>
          </tr>
      </tbody>
    </table>
