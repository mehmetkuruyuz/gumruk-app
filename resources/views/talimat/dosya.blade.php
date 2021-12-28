<div class="row">
@for($i=0;$i<$adet;$i++)
<div class="col-md-4">
  <div class="form-group">
    <label for="" class="alert alert-danger">{{trans("messages.evrakyukle")}} {{($i+1)}}</label>
    <small>{{trans("messages.evrakyuklealt")}}</small>
    <hr />
    <label>{{trans("messages.ex1")}} {{trans("messages.evrakyukle")}}</label>
    <input type="file" name='specialfiles[ex1][{{$kac}}][{{$i}}][]' class='form-control' multiple >
    <br />
    <label>{{trans("messages.t2")}} {{trans("messages.evrakyukle")}}</label>
    <input type="file" name='specialfiles[t2][{{$kac}}][{{$i}}][]' class='form-control'  multiple>
    <br />
    <label>{{trans("messages.fatura")}} {{trans("messages.evrakyukle")}}</label>
    <input type="file" name='specialfiles[fatura][{{$kac}}][{{$i}}][]' class='form-control'  multiple>
    <br />
    <label>{{trans("messages.packinglist")}} {{trans("messages.evrakyukle")}}</label>
    <input type="file" name='specialfiles[packinglist][{{$kac}}][{{$i}}][]' class='form-control'  multiple>
    <br />
    <label>{{trans("messages.atr")}} {{trans("messages.evrakyukle")}}</label>
    <input type="file" name='specialfiles[atr][{{$kac}}][{{$i}}][]' class='form-control' multiple>
    <br />
    <label>{{trans("messages.adr")}} {{trans("messages.evrakyukle")}}</label>
    <input type="file" name='specialfiles[adr][{{$kac}}][{{$i}}][]' class='form-control'  multiple>
    <br />
    <label>{{trans("messages.cmr")}} {{trans("messages.evrakyukle")}}</label>
    <input type="file" name='specialfiles[cmr][{{$kac}}][{{$i}}][]' class='form-control'  multiple>
  </div>
</div>
@endfor
</div>
