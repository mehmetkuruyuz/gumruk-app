    <table class="table table-bordered malYuklemeBosaltmaTablolari" width="100%" cellspacing="0">
      <thead>
          <tr>


            <th>{{trans("messages.dorseplaka")}} </th>
            <th>{{trans("messages.dorseplaka")}} {{trans("messages.ulkekodu")}}</th>
          </tr>
      </thead>
      <tbody>
          <tr><td colspan="6">{{trans("messages.".$talimattipi)}}</td></tr>
          <tr id="sampletr{{$say}}">


            <td><input type="text" class="form-control" name="dorse[{{$say}}][]" required="required"  value="{{$dorse}}"/></td>
            <td>
              <select name="indirmeNoktasiulkekodu[{{$say}}][]" class="form-control  col-xs-2">
               <option value="0">{{trans("messages.seciniz")}}</option>
               @if(!empty($ulkeList))
                  @foreach ($ulkeList as $ulkekey => $ulkevalue)
                    <option value="{{$ulkevalue->id}}">{{$ulkevalue->global_name}}</option>
                  @endforeach

              @endif
              </select>
            </td>
            <input type="hidden" name="talimattipi[{{$say}}][]" value="{{$talimattipi}}" />

            <td><a href='javascript:void(0)' onclick='deleteTableItem(this)'><i class="fa fa-remove"></i></a></td>
            <td>
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
