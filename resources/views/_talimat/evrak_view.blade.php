    <div class='col-sm-10'>
    	 <h5>	{{trans("messages.talimatevrakyuklemebaslik")}}</h5>
    	  <table class="table table-bordered" cellspacing="0">
 	   <thead>
 	   <tr>
 	   		<th>	{{trans("messages.sirano")}}</th>
 	   		<th>	{{trans("messages.belgeturu")}}</th>
 	   		<th>	{{trans("messages.dosyaindir")}}</th>
 	   		<!--  <th>Sil</th> -->
 	   	</tr>
 	   	</thead>
 	   	<tbody>
 	   	@if (!empty($evrakList))
     	   	@foreach($evrakList as $an=>$de)
     	   	<tr>
     	   		<td>{{$loop->iteration}}</td>
     	   		<td>{{$de->filetype}}</td>
     	   		<td><a href='/uploads/{{$de->fileName}}' target='_blank'>	{{trans("messages.indir")}}</a></td>
     	   		<!--    -->
     	   	</tr>
     	   	@endforeach
 	   	@endif
 	   	</tbody>
 	   	</table>
    </div>
    <div class='col-md-12' style='margin-left:15px'>

	</div>				