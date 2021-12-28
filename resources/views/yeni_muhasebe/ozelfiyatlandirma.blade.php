@extends('layouts.app')

@section('kirinti')
	{{trans("messages.newinvoiceheader")}}
@endsection

@section('scripts')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" rel="stylesheet"/>

@endsection
@section('endscripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>
<script>
		function deleteTableItem(t)
		{

			var answer = confirm("{{trans('messages.silmeeminmisiniz')}}");
		        if (answer)
						{
							$(t).parent().parent().remove();
		        }
		}
		</script>
<script>
function formTemizle()
{

$(':input','.temizlenebilir')
.not(':button, :submit, :reset')
.val('')
.prop('checked', false)
.prop('selected', false);

}

function addTalimatForUser()
{
	var firma=$("#firmaId").val();
	var talimat=$("#talimattipi").val();
		if (firma<1) {alert("{{trans("messages.firmaseciniz")}}"); return false;}
		if (talimat<1) {alert("{{trans("messages.talimatseciniz")}}"); return false;}


		$.get("/muhasebe/yeni/ozelparametreler/"+talimat, function(data, status){
			$("#talimataction").append(data);
			console.log();
		});

}
</script>
@endsection

@section('content')
    <div class="card">
      <div class="card-header">
          	<h2>{{trans("messages.ozelfiyatlama")}}</h2>
      </div>
			<div class="card-body ">
				<form action="/muhasebe/yeni/ozelfiyatlamakaydet" method="post" name="d" class="row">
					{{csrf_field()}}
					<div class='col-md-12'>
		           		<label for="firmaId">{{trans("messages.companyname")}}</label>
		           		@if (!empty($companylist))
		           		<select name='firmaId' class="form-control" id="firmaId" >
										<option value="0">{{trans("messages.choose")}}</option>
		           			@foreach($companylist as $z=>$m)
		           				<option value='{{$m->id}}'>{{$m->name}}</option>
		           			@endforeach
		           		</select>
		           		@endif

		 		</div>
			<div class="col-md-5" id="talimaticinalan">
					<h4>{{trans("messages.gumruktalimatilist")}}</h4>
					<table class="table table-bordered">
							<thead>
								<th>Talimat Tipi</th>
								<th>Talimat Ücreti</th>
								<th>Talimat Para Birim</th>
								<th>Talimat'a Toplu Fiyat Uygula</th>
							</thead>
							<tbody id="talimataction">

							</tbody>
					</table>
			</div>
			<div class="col-md-7">

				<div class='col-md-12'>
					 <label for="talimat">{{trans("messages.talimattipi")}}</label>
			  		@if (!empty($talimatList))
							<select name='talimat' class="form-control" id="talimattipi" >
								<option value="0">{{trans("messages.choose")}}</option>
								@foreach($talimatList as $z=>$m)
									<option value='{{$m->id}}'>{{$m->kodName}}</option>
								@endforeach
							</select>
						@endif
				</div>
				<div class="col-md-12 mt-2">
						<button class="btn btn-success" onclick="addTalimatForUser()" type="button">{{trans("messages.add")}}</button>
				</div>
			</div>
			<button type="submit" class="btn btn-danger">{{trans("messages.save")}}</button>
		</form>


</div>
    </div>


@endsection
