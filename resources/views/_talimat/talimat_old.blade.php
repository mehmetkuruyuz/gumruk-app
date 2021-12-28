<!DOCTYPE html>
<html  lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="author" content="">
  <title>Bosphore GROUP</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="/dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="/bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="/bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">


</head>


<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper" style='background:#FFF'>



	<div class="card mb-3">
        <div class="card-header">
        <div class='row'>
        	<div class='col-4'><i class="fa fa-table"></i> {{\Carbon\Carbon::parse($talimat->created_at)->format('d-m-Y H:i')}}</div>

        </div>
        </div>
        <div class="card-body">
        <div class='row'>
            <div class='col-sm-6'>
          	 	 <h5>{{trans('messages.talimatverenkullanici')}}</h5>
                    <table class="table table-bordered" cellspacing="0">
                    <tr>
                    	<td><strong>{{trans('messages.companyname')}}</strong></td>
                    	
                    	<td>{{$talimat->user->name}}</td>
                    </tr>
                    <tr>
                    	<td><strong>{{trans('messages.loginmail')}}</strong></td>
                    	<td>{{$talimat->user->email}}</td>
                    </tr>    
                    <tr>
                    	<td><strong>{{trans('messages.firmavergi')}}/ {{trans('messages.firmavergidairesi')}}</strong></td>
                    	<td>{{$talimat->user->vergiDairesi}}</td>
                    </tr>   
                      <tr>
                    	<td><strong>{{trans('messages.firmatelefon')}}</strong> </td>
                    	<td>{{$talimat->user->telefonNo}}</td>
                    </tr>
                      <tr>
                    	<td><strong>{{trans('messages.firmaadres')}} </strong></td>
                    	<td>{{$talimat->user->address}}</td>
                    </tr>                                                       
                    </table>
             </div>
             <div class='col-sm-6'>
             	 <h5>{{trans("messages.talimatbilgileri")}}</h5>
             	   <table class="table table-bordered" cellspacing="0">
             	    <tr>
                    	<td><strong>{{trans('messages.createddate')}}</strong></td>
                    	<td>{{\Carbon\Carbon::parse($talimat->created_at)->format('d-m-Y H:i')}}</td>
                    </tr>   
                    <tr>
                    	<td><strong>{{trans('messages.cekiciplaka')}}</strong></td>
                    	<td>{{$talimat->cekiciPlaka}}</td>
                    </tr>
                    <tr>
                    	<td><strong>{{trans('messages.dorseplaka')}}</strong></td>
                    	<td>{{$talimat->dorsePlaka}}</td>
                    </tr>
               		<tr>
               			<td><strong>{{trans('messages.gumrukadet')}}</strong></td>
               			<td>{{$talimat->gumrukAdedi}}</td>
               		</tr>
               		<tr>
               			<td><strong>{{trans('messages.talimatverenkullanici')}}Talimat Durumu</strong></td>
               			<td>
                   			<h2 style='color:red'>
                   				@if ($talimat->durum==0) {{trans('messages.bekliyor')}}  
                   				@elseif ($talimat->durum==1) {{trans('messages.islemyapiliyor')}} 
                   				@elseif ($talimat->durum==2) {{trans('messages.tamamlandi')}}
                   				@endif
                   				
                   				</h2>
               			</td>
               		</tr>
                   </table>

             </div>
              <div class='col-sm-12'>
             	 <h5>{{trans('messages.gumrukbilgileri')}}</h5>
             	   <table class="table table-bordered" cellspacing="0">
             	   <tbody>
             	   @foreach($talimat->gumruk as $key=>$value)
             	   <tr>
             	   		<td colspan='11'><hr /></td>
             	   </tr>
					<tr>
             	   		<th>{{trans('messages.sira')}}</th>
             	   		<th>{{trans('messages.varisgumruk')}}</th>
             	   		<th>{{trans('messages.ADR')}}</th>
             	   		<th>{{trans('messages.atr')}}</th>
             	   		<th>{{trans('messages.talimattipi')}}</th>
             	   		<th>{{trans('messages.mailcinsi')}}</th>
             	   		<th>{{trans('messages.toplamkap')}}</th>
             	   		<th>{{trans('messages.toplamkilo')}}</th>
             	   		<th>{{trans('messages.tirkarnesi')}}</th>
             	   		<th>{{trans('messages.problem')}}</th>
             	   		<th>{{trans('messages.aciklama')}}</th>           	   		
             	   	</tr>
             	   
             	   	<tr>
             	   		<td>{{$loop->iteration}}</td>
             	   		<td>{{$value->varisGumrugu}}</td>
             	   		<td>@if ($value->adr=='no') {{trans('messages.yok')}}Yok @else {{trans('messages.var')}}Var @endif</td>
             	   		<td>@if ($value->atr=='no') {{trans('messages.yapilmasin')}} @else {{trans('messages.yapilsin')}} @endif</td>
             	   		<td>
             	   		@foreach($talimatTipList as $m=>$v)
             	   			@if (($v->kisaKod==$value->talimatTipi)) {{ $v->kodName }} @endif
             	   		@endforeach 
             	   		</td>
             	   		<td>{{$value->malCinsi}}</td>
             	   		<td>{{$value->kap}}</td>
             	   		<td>{{$value->kilo}}</td>
             	   		<td>{{$value->tirKarnesi}}</td>
             	   		<td>@if ($value->problem=='no') Yok @else {{$value->problemAciklama}} @endif</td>
             	   		<td>{{$value->aciklama}}</td>              	   		
             	   	</tr>
             	   	@if (!empty($value->yukleme))
             	   	<tr>
                 	   	<td colspan='4'>
                 	   	<h6>{{trans('messages.indirmeyuklemealani')}}</h6>
                 	   		<table class="table table-bordered" cellspacing="0" style='font-size:11px'>
                 	   			<thead>
                 	   				<tr>
                     	   				<th>{{trans('messages.sira')}}</th>
                     	   				<th>{{trans('messages.gonderici')}}</th>
                    	   				<th>{{trans('messages.alici')}}</th>
                     	   				<th>{{trans('messages.kap')}}</th>
                     	   				<th>{{trans('messages.kilo')}}</th>
                     	   			</tr>
                 	   			</thead>
                 	   			<tbody>
                     	   		@foreach($value->yukleme as $mmm=>$vvv)
                     	   		<tr>
                     	   			<td>{{$loop->iteration}}</td>
                     	   			<td>{{$vvv->yuklemeYeri}}</td>
                     	   			<td>{{$vvv->bosaltmaYeri}}</td>
                     	   			<td>{{$vvv->kap}}</td>
                     	   			<td>{{$vvv->kilo}}</td>
                 	   			</tr>
                     	   		@endforeach
                 	   		</tbody>
                 	   		</table>
                 	   		
                 	   		<hr />
 
                 	   	</td>
                 	   	<td colspan='7'>
	     	   		<h6>{{trans('messages.gumrukdosyalari')}}Gümrük Dosyaları</h6>
                 	   		     @if (!empty($value->evrak))
                 	   		    <table class="table table-bordered" cellspacing="0" style='font-size:11px'>
                 	   				<thead>
                 	   					<tr>
                 	   						<th>{{trans('messages.sira')}}</th>
                 	   						<th>{{trans('messages.dosyacesidi')}}</th>
                 	   						<th>{{trans('messages.dosyaindir')}}</th>
                 	   						<th>{{trans('messages.dosyatipi')}}</th>
                 	   						<th>{{trans('messages.sil')}}</th>
                 	   					</tr>
                 	   				</thead>	
                 	   				<tbody>
                     	   			 @foreach($value->evrak as $uuu=>$ooo)
                         	   			<tr>
                         	   				<td>{{$loop->iteration}}</td>
                         	   				<td>{{$isimArray[$ooo->dosyaTipi]}}</td>
                         	   				<td><a href='/uploads/{{$ooo->fileName}}' target="_blank">{{trans('messages.indir')}}</a></td>
                         	   				<td>{{$ooo->filetype}}</td>
                         	   				<td><a href='/dosya/sil/{{$ooo->id}}' onclick='return confirm("{{trans("messages.silmemesaji")}}")'>{{trans("messages.sil")}}</a></td>
                         	   			</tr>
                     	   			 @endforeach
                     	   			</tbody>            
                     	   			</table>    
                     	   			 @else
                     	   			 	{{trans('messages.dosyayok')}}
                     	   			 @endif
                 	   	</td>
             	   	</tr>	
             	   	@endif
             	   	@endforeach
             	   	
             	   </tbody>
             	   
                   </table>
                </div>

         </div>
        </div>
        
    
        
     </div>   
	


</div></body></html>