

@if(count($evm->talimat)>0)
      <table class="table table-bordered" cellspacing="0">
        <thead>
          <tr>
            <th>	{{trans('messages.cekiciplaka')}}</th>
            <th>	{{trans('messages.dorseplaka')}}</th>
            <th>	{{trans('messages.autoBarcode')}}</th>
            <th>	{{trans('messages.talimattipi')}}</th>
            <th>	{{trans('messages.createddate')}}</th>
            <th>	{{trans('messages.bolgehangisi')}}</th>
            <th>	{{trans('messages.bolgeilgilenen')}}</th>
            <th>	{{trans('messages.talimatevrakyuklemebaslik')}}</th>
            <th>	{{trans('messages.durum')}}</th>
            <th colspan="5">{{trans('messages.operasyonislem')}}</th>
          </tr>

        </thead>
          <tbody>
          @foreach($evm->talimat as $fm=>$fevm)
            <tr>
                <td>{{$fevm->cekiciPlaka}}</td>
                <td>{{$fevm->dorsePlaka}}</td>
                <td>{{$fevm->autoBarcode}}</td>
                <td>{{trans("messages.".$fevm->talimatTipi)}}</td>
                <td>{{\Carbon\Carbon::parse($fevm->created_at)->format("d-m-Y H:i:s")}}</td>
                <td>	@if (!empty($fevm->bolge->name)){{$fevm->bolge->name}} @endif</td>
                <td>	@if (!empty($fevm->ilgili->name)){{$fevm->ilgili->name}} @endif</td>
                <td>
                     @if ($fevm->durum=="tamamlandi" && $fevm->talimatTipi=="listex")
                        <a href='/operationexcel/{{$fevm->id}}' target="_blank">{{trans("messages.dosyaindir")}}</a><br />
                     @endif

                     @if (!empty($fevm->evrak[0]))
                        @foreach ($fevm->evrak as $evkey => $evvalue)
                          <a href='/uploads/{{$evvalue->fileName}}' class="btn btn-alert btn-sm" target="_blank">{{($evvalue->kacinci)+1}}. {{trans("messages.gumruk")}} {{-- trans("messages.yuk") --}} {{$evvalue->belgetipi}} - {{trans("messages.yuk")}} {{($evvalue->yukId)+1}} - {{trans("messages.dosya")}}  {{($evvalue->siraId)+1}} {{trans("messages.indir")}}</a><br  />
                            <!-- <a href='/uploads/{{$evvalue->fileName}}' target="_blank">{{trans("messages.dosyaindir")}}</a><br /> -->

                        @endforeach
                      @else

                     @endif
                </td>
                <td>	{{trans("messages.".$fevm->durum)}}</td>




                <td><a title="{{trans("messages.show")}}"  href='/operasyon/goster/{{$fevm->id}}'><i class="fa fa-file-text" aria-hidden="true" style='color:brown'></i></a></td>
                <td><a   title="{{trans("messages.print")}}" href='javascript:void(0)' onclick="PopupCenter('/operation/print/{{$fevm->id}}','xtf','930','500'); "><i class="fa fa-print" aria-hidden="true" style='color:brown'></i></a></td>
                <td><a href='/operation/edit/{{$fevm->id}}'><i class="fa fa-pencil" aria-hidden="true" style='color:orange'></i></a></td>
                <td><a  title="{{trans("messages.uploadfile")}}"  href='javascript:void(0)' onclick="PopupCenter('/operation/upload/{{$fevm->id}}','xtf','930','500'); "><i class="fa fa-file-pdf-o" aria-hidden="true" style='color:orange'></i></a></td>
              </tr>



            @endforeach
                </tbody>
                    </table>
    @endif
