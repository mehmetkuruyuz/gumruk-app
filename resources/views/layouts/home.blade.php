@extends('layouts.app')

@section('kirinti')

@endsection
@section('scripts')

@endsection
@section('content')
{{ Helper::langSet() }}
	<div class='row'>
		@if (Auth::user()->role!='nakitadmin'  && \Auth::user()->role!="bolgeadmin")
		<div class="col-6 col-sm-4 col-lg-3">
			<div class="card" style="background:#7a1010">
            <div class="card-body p-3 text-center">
              <div class="text-right text-white">
                {{$talimatSay}}
              <i class="fe fe-activity"></i>
              </div>
              <div class="h1 m-0  text-white" >  {{$talimatSay}}</div>

              	<div class="text-white mb-4">{{trans('messages.new')}} {{trans('messages.operasyon')}}	@if (\Auth::user()->role!="muhasebeadmin")  <a href="/ihracat/operasyon/list" class="col-lg-3 col-xs-6 text-white"> {{trans('messages.show')}} </a>			@endif</div>

            </div>
          </div>
			</div>

    @if (Auth::user()->role=='admin')
			<div class="col-6 col-sm-4 col-lg-3">
				<div class="card text-white"  style="background:#7a1010">
	            <div class="card-body p-3 text-center">
	              <div class="text-right text-white">
	                {{$muhasebeSay}}
	              <i class="fe fe-activity"></i>
	              </div>
	              <div class="h1 m-0  text-white">  {{$muhasebeSay}}</div>
	              <div class="text-white mb-4">{{trans('messages.muhasebekaydi')}} <a href="/muhasebe" class="text-white col-lg-3 col-xs-6"> {{trans('messages.show')}} </a></div>
	            </div>
	          </div>
				</div>
		@endif

				<div class="col-6 col-sm-4 col-lg-3">
					<div class="card" style="background:#7a1010">
								<div class="card-body p-3 text-center">
									<div class="text-right text-white">
										{{$mesajSay}}
									<i class="fe fe-activity"></i>
									</div>
									<div class="h1 m-0 text-white">  {{$mesajSay}}</div>
									<div class="text-white mb-4">{{trans('messages.newmessage')}} <a href="/mesaj" class="col-lg-3 col-xs-6 text-white"> {{trans('messages.show')}} </a></div>
								</div>
							</div>
					</div>

					<div class="col-6 col-sm-4 col-lg-3">
						<div class="card" style="background:#7a1010">
									<div class="card-body p-3 text-center">
										<div class="text-right text-white">
									            {{$talimatTamamSay}}
										<i class="fe fe-activity"></i>
										</div>
										<div class="h1 m-0  text-white">            {{$talimatTamamSay}}</div>

											<div class="text-white mb-4">{{trans('messages.operasyontamam')}} {{trans('messages.operasyon')}}	@if (\Auth::user()->role!="muhasebeadmin")<a href="/operation/done" class="text-white col-lg-3 col-xs-6"> {{trans('messages.show')}} </a>		@endif</div>

									</div>
								</div>
						</div>

						@if (\Auth::user()->role=='watcher' )
							@if (Helper::userUndoneJobs()>0)
								<div class="col-6 col-sm-4 col-lg-3">
									<div class="card" style="background:#7a1010">
												<div class="card-body p-3 text-center">
													<div class="text-right text-white">
												            {!! Helper::userUndoneJobs() !!}
													<i class="fe fe-activity"></i>
													</div>
													<div class="h1 m-0  text-white">
														 {!! Helper::userUndoneJobs() !!}
													</div>

														<div class="text-white mb-4">{{trans('messages.operasyonmecburi')}} 	<a href="{{ url('/operation/continue') }}" class="text-white col-lg-3 col-xs-6"> {{trans('messages.show')}} </a></div>

												</div>
											</div>
									</div>

							@endif
						@endif
						@if (\Auth::user()->role!="watcher" && \Auth::user()->role!="bolgeadmin" )
						<div class="col-12 col-sm-12 col-lg-6">
							<div class="card">
										<div class="card-header">
											<h3 class="card-title">Operasyon Kayıtları</h3>
										</div>
								<div id="chart-development-activity" style="height: 12rem"></div>
							</div>
						</div>
						<div class="col-12 col-sm-12 col-lg-3">
							<div class="card">
										<div class="card-header"><h3 class="card-title">Bölge Araç İstatistikleri</h3></div>
										<div class="card-body">
											<div id="chart-pie" style="height: 12rem;"></div>
										</div>
							</div>
						</div>
						<div class="col-12 col-sm-12 col-lg-3">
							<div class="card">
										<div class="card-header"><h3 class="card-title">Operasyon İstatistikleri</h3></div>
										<div class="card-body">
											<div id="chart-donut" style="height: 12rem;"></div>
										</div>
							</div>
						</div>
					@endif
      </div>
		@endif
		@if (\Auth::user()->role=="nakitadmin")
		<div class="col-12 col-sm-12 col-lg-5">
			<div class="card">
						<div class="card-header"><h3 class="card-title">{{trans("messages.nakit")}} {{trans("messages.muhasebelist")}}</h3></div>
						<div class="card-body">
							<form action="/muhasebe/nakitfinder" method="post">
							<div class="form-group">
								<label for="bolgeSecim">{{trans("messages.autoBarcode")}}</label>
								<input type="text" name="c" class="form-control" required />
									{{ csrf_field() }}
							</div>
								<div class="form-group">
								<button class="btn btn-success">{{trans("messages.ara")}}</button>
							</div>
						</form>
						</div>
			</div>
		</div>
	@endif
			@if (\Auth::user()->role=="cher")

			<div class="row row-cards row-deck">
				<div class="col-12">
					<div class="card">
						<div class="table-responsive">
							<table class="table table-hover table-outline table-vcenter text-nowrap card-table">
								<thead>
									<tr>
										<th class="text-center w-1"><i class="icon-people"></i></th>
										<th>Kullanıcı</th>
										<th>İşlem İstatistiği</th>
										<th class="text-center">İşlem</th>
										<th>Hareket</th>
										<th class="text-center">Başarı Oranı</th>
										<th class="text-center"><i class="icon-settings"></i></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="text-center">
											<div class="avatar d-block" style="background-image: url(demo/faces/female/26.jpg)">
												<span class="avatar-status bg-green"></span>
											</div>
										</td>
										<td>
											<div>Elizabeth Martin</div>
											<div class="small text-muted">
												Registered: Mar 19, 2018
											</div>
										</td>
										<td>
											<div class="clearfix">
												<div class="float-left">
													<strong>42%</strong>
												</div>
												<div class="float-right">
													<small class="text-muted">Jun 11, 2015 - Jul 10, 2015</small>
												</div>
											</div>
											<div class="progress progress-xs">
												<div class="progress-bar bg-yellow" role="progressbar" style="width: 42%"
					 aria-valuenow="42" aria-valuemin="0" aria-valuemax="100"></div>
											</div>
										</td>
										<td class="text-center">
											<i class="payment payment-visa"></i>
										</td>
										<td>
											<div class="small text-muted">Last login</div>
											<div>4 minutes ago</div>
										</td>
										<td class="text-center">
											<div class="mx-auto chart-circle chart-circle-xs" data-value="0.42" data-thickness="3" data-color="blue">
												<div class="chart-circle-value">42%</div>
											</div>
										</td>
										<td class="text-center">
											<div class="item-action dropdown">
												<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-more-vertical"></i></a>
												<div class="dropdown-menu dropdown-menu-right">
													<a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
													<a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-edit-2"></i> Another action </a>
													<a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-message-square"></i> Something else here</a>
													<div class="dropdown-divider"></div>
													<a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-link"></i> Separated link</a>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td class="text-center">
											<div class="avatar d-block" style="background-image: url(demo/faces/female/17.jpg)">
												<span class="avatar-status bg-green"></span>
											</div>
										</td>
										<td>
											<div>Michelle Schultz</div>
											<div class="small text-muted">
												Registered: Mar 2, 2018
											</div>
										</td>
										<td>
											<div class="clearfix">
												<div class="float-left">
													<strong>0%</strong>
												</div>
												<div class="float-right">
													<small class="text-muted">Jun 11, 2015 - Jul 10, 2015</small>
												</div>
											</div>
											<div class="progress progress-xs">
												<div class="progress-bar bg-red" role="progressbar" style="width: 0%"
					 aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
											</div>
										</td>
										<td class="text-center">
											<i class="payment payment-googlewallet"></i>
										</td>
										<td>
											<div class="small text-muted">Last login</div>
											<div>5 minutes ago</div>
										</td>
										<td class="text-center">
											<div class="mx-auto chart-circle chart-circle-xs" data-value="0.0" data-thickness="3" data-color="blue">
												<div class="chart-circle-value">0%</div>
											</div>
										</td>
										<td class="text-center">
											<div class="item-action dropdown">
												<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-more-vertical"></i></a>
												<div class="dropdown-menu dropdown-menu-right">
													<a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
													<a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-edit-2"></i> Another action </a>
													<a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-message-square"></i> Something else here</a>
													<div class="dropdown-divider"></div>
													<a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-link"></i> Separated link</a>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td class="text-center">
											<div class="avatar d-block" style="background-image: url(demo/faces/female/21.jpg)">
												<span class="avatar-status bg-green"></span>
											</div>
										</td>
										<td>
											<div>Crystal Austin</div>
											<div class="small text-muted">
												Registered: Apr 7, 2018
											</div>
										</td>
										<td>
											<div class="clearfix">
												<div class="float-left">
													<strong>96%</strong>
												</div>
												<div class="float-right">
													<small class="text-muted">Jun 11, 2015 - Jul 10, 2015</small>
												</div>
											</div>
											<div class="progress progress-xs">
												<div class="progress-bar bg-green" role="progressbar" style="width: 96%"
					 aria-valuenow="96" aria-valuemin="0" aria-valuemax="100"></div>
											</div>
										</td>
										<td class="text-center">
											<i class="payment payment-mastercard"></i>
										</td>
										<td>
											<div class="small text-muted">Last login</div>
											<div>a minute ago</div>
										</td>
										<td class="text-center">
											<div class="mx-auto chart-circle chart-circle-xs" data-value="0.96" data-thickness="3" data-color="blue">
												<div class="chart-circle-value">96%</div>
											</div>
										</td>
										<td class="text-center">
											<div class="item-action dropdown">
												<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-more-vertical"></i></a>
												<div class="dropdown-menu dropdown-menu-right">
													<a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
													<a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-edit-2"></i> Another action </a>
													<a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-message-square"></i> Something else here</a>
													<div class="dropdown-divider"></div>
													<a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-link"></i> Separated link</a>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td class="text-center">
											<div class="avatar d-block" style="background-image: url(demo/faces/male/32.jpg)">
												<span class="avatar-status bg-green"></span>
											</div>
										</td>
										<td>
											<div>Douglas Ray</div>
											<div class="small text-muted">
												Registered: Jan 15, 2018
											</div>
										</td>
										<td>
											<div class="clearfix">
												<div class="float-left">
													<strong>6%</strong>
												</div>
												<div class="float-right">
													<small class="text-muted">Jun 11, 2015 - Jul 10, 2015</small>
												</div>
											</div>
											<div class="progress progress-xs">
												<div class="progress-bar bg-red" role="progressbar" style="width: 6%"
					 aria-valuenow="6" aria-valuemin="0" aria-valuemax="100"></div>
											</div>
										</td>
										<td class="text-center">
											<i class="payment payment-shopify"></i>
										</td>
										<td>
											<div class="small text-muted">Last login</div>
											<div>a minute ago</div>
										</td>
										<td class="text-center">
											<div class="mx-auto chart-circle chart-circle-xs" data-value="0.06" data-thickness="3" data-color="blue">
												<div class="chart-circle-value">6%</div>
											</div>
										</td>
										<td class="text-center">
											<div class="item-action dropdown">
												<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-more-vertical"></i></a>
												<div class="dropdown-menu dropdown-menu-right">
													<a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
													<a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-edit-2"></i> Another action </a>
													<a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-message-square"></i> Something else here</a>
													<div class="dropdown-divider"></div>
													<a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-link"></i> Separated link</a>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td class="text-center">
											<div class="avatar d-block" style="background-image: url(demo/faces/female/12.jpg)">
												<span class="avatar-status bg-green"></span>
											</div>
										</td>
										<td>
											<div>Teresa Reyes</div>
											<div class="small text-muted">
												Registered: Mar 4, 2018
											</div>
										</td>
										<td>
											<div class="clearfix">
												<div class="float-left">
													<strong>36%</strong>
												</div>
												<div class="float-right">
													<small class="text-muted">Jun 11, 2015 - Jul 10, 2015</small>
												</div>
											</div>
											<div class="progress progress-xs">
												<div class="progress-bar bg-red" role="progressbar" style="width: 36%"
					 aria-valuenow="36" aria-valuemin="0" aria-valuemax="100"></div>
											</div>
										</td>
										<td class="text-center">
											<i class="payment payment-ebay"></i>
										</td>
										<td>
											<div class="small text-muted">Last login</div>
											<div>2 minutes ago</div>
										</td>
										<td class="text-center">
											<div class="mx-auto chart-circle chart-circle-xs" data-value="0.36" data-thickness="3" data-color="blue">
												<div class="chart-circle-value">36%</div>
											</div>
										</td>
										<td class="text-center">
											<div class="item-action dropdown">
												<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-more-vertical"></i></a>
												<div class="dropdown-menu dropdown-menu-right">
													<a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
													<a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-edit-2"></i> Another action </a>
													<a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-message-square"></i> Something else here</a>
													<div class="dropdown-divider"></div>
													<a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-link"></i> Separated link</a>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td class="text-center">
											<div class="avatar d-block" style="background-image: url(demo/faces/female/4.jpg)">
												<span class="avatar-status bg-green"></span>
											</div>
										</td>
										<td>
											<div>Emma Wade</div>
											<div class="small text-muted">
												Registered: Mar 20, 2018
											</div>
										</td>
										<td>
											<div class="clearfix">
												<div class="float-left">
													<strong>7%</strong>
												</div>
												<div class="float-right">
													<small class="text-muted">Jun 11, 2015 - Jul 10, 2015</small>
												</div>
											</div>
											<div class="progress progress-xs">
												<div class="progress-bar bg-red" role="progressbar" style="width: 7%"
					 aria-valuenow="7" aria-valuemin="0" aria-valuemax="100"></div>
											</div>
										</td>
										<td class="text-center">
											<i class="payment payment-paypal"></i>
										</td>
										<td>
											<div class="small text-muted">Last login</div>
											<div>a minute ago</div>
										</td>
										<td class="text-center">
											<div class="mx-auto chart-circle chart-circle-xs" data-value="0.07" data-thickness="3" data-color="blue">
												<div class="chart-circle-value">7%</div>
											</div>
										</td>
										<td class="text-center">
											<div class="item-action dropdown">
												<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-more-vertical"></i></a>
												<div class="dropdown-menu dropdown-menu-right">
													<a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
													<a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-edit-2"></i> Another action </a>
													<a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-message-square"></i> Something else here</a>
													<div class="dropdown-divider"></div>
													<a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-link"></i> Separated link</a>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td class="text-center">
											<div class="avatar d-block" style="background-image: url(demo/faces/female/27.jpg)">
												<span class="avatar-status bg-green"></span>
											</div>
										</td>
										<td>
											<div>Carol Henderson</div>
											<div class="small text-muted">
												Registered: Feb 22, 2018
											</div>
										</td>
										<td>
											<div class="clearfix">
												<div class="float-left">
													<strong>80%</strong>
												</div>
												<div class="float-right">
													<small class="text-muted">Jun 11, 2015 - Jul 10, 2015</small>
												</div>
											</div>
											<div class="progress progress-xs">
												<div class="progress-bar bg-green" role="progressbar" style="width: 80%"
					 aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
											</div>
										</td>
										<td class="text-center">
											<i class="payment payment-visa"></i>
										</td>
										<td>
											<div class="small text-muted">Last login</div>
											<div>9 minutes ago</div>
										</td>
										<td class="text-center">
											<div class="mx-auto chart-circle chart-circle-xs" data-value="0.8" data-thickness="3" data-color="blue">
												<div class="chart-circle-value">80%</div>
											</div>
										</td>
										<td class="text-center">
											<div class="item-action dropdown">
												<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-more-vertical"></i></a>
												<div class="dropdown-menu dropdown-menu-right">
													<a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
													<a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-edit-2"></i> Another action </a>
													<a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-message-square"></i> Something else here</a>
													<div class="dropdown-divider"></div>
													<a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-link"></i> Separated link</a>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td class="text-center">
											<div class="avatar d-block" style="background-image: url(demo/faces/male/20.jpg)">
												<span class="avatar-status bg-green"></span>
											</div>
										</td>
										<td>
											<div>Christopher Harvey</div>
											<div class="small text-muted">
												Registered: Jan 22, 2018
											</div>
										</td>
										<td>
											<div class="clearfix">
												<div class="float-left">
													<strong>83%</strong>
												</div>
												<div class="float-right">
													<small class="text-muted">Jun 11, 2015 - Jul 10, 2015</small>
												</div>
											</div>
											<div class="progress progress-xs">
												<div class="progress-bar bg-green" role="progressbar" style="width: 83%"
					 aria-valuenow="83" aria-valuemin="0" aria-valuemax="100"></div>
											</div>
										</td>
										<td class="text-center">
											<i class="payment payment-googlewallet"></i>
										</td>
										<td>
											<div class="small text-muted">Last login</div>
											<div>8 minutes ago</div>
										</td>
										<td class="text-center">
											<div class="mx-auto chart-circle chart-circle-xs" data-value="0.83" data-thickness="3" data-color="blue">
												<div class="chart-circle-value">83%</div>
											</div>
										</td>
										<td class="text-center">
											<div class="item-action dropdown">
												<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-more-vertical"></i></a>
												<div class="dropdown-menu dropdown-menu-right">
													<a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
													<a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-edit-2"></i> Another action </a>
													<a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-message-square"></i> Something else here</a>
													<div class="dropdown-divider"></div>
													<a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-link"></i> Separated link</a>
												</div>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						</div>
						</div>
						</div>
					@endif
  @endsection

	@section("endscripts")
	<script>
			 require(['c3', 'jquery'], function(c3, $) {
				 $(document).ready(function(){
					 var chart = c3.generate({
						 bindto: '#chart-development-activity', // id of chart wrapper
						 data: {
							 columns: [
									 // each columns data

								 ['data1',@if (!empty($operx))
					 							 @foreach ($operx as $key => $value)
					 							 		{{$value->toplam}},
					 							 @endforeach
					 						 @endif ]
							 ],
							 type: 'area', // default type of chart
							 groups: [
								 [ 'data1', 'data2', 'data3']
							 ],
							 colors: {
								 'data1': tabler.colors["red"]
							 },
							 names: {
									 // name of each serie
								 'data1': 'Operasyon Sayıları'
							 }
						 },
						 axis: {
							 y: {
								 padding: {
									 bottom: 0,
								 },
								 show: false,
									 tick: {
									 outer: false
								 }
							 },
							 x: {
								 padding: {
									 left: 0,
									 right: 0
								 },
								 show: false
							 }
						 },
						 legend: {
							 position: 'inset',
							 padding: 0,
							 inset: {
													 anchor: 'top-left',
								 x: 20,
								 y: 8,
								 step: 10
							 }
						 },
						 tooltip: {
							 format: {
								 title: function (x) {
									 return '';
								 }
							 }
						 },
						 padding: {
							 bottom: 0,
							 left: -1,
							 right: -1
						 },
						 point: {
							 show: false
						 }
					 });
				 });
			 });


			 require(['c3', 'jquery'], function(c3, $) {
	 $(document).ready(function(){
		 var chart = c3.generate({
			 bindto: '#chart-pie', // id of chart wrapper
			 data: {
				 columns: [
						 // each columns data
						 @if (!empty($bolge))
							 @foreach ($bolge as $key => $value)
							 		['data{{$key}}', {{$value->toplam}}],
							 @endforeach
						 @endif
						 /*
					 ['data2', 44],
					 ['data3', 12],
					 ['data4', 14]
					 */
				 ],
				 type: 'pie', // default type of chart
				 colors: {
					 'data0': tabler.colors["red-darker"],
					 'data1': tabler.colors["red"],
					 'data2': tabler.colors["red-light"],
					 'data3': tabler.colors["red-lighter"]
				 },
				 names: {
						 // name of each serie
						 @if (!empty($bolge))
							 @foreach ($bolge as $key => $value)
									'data{{$key}}' : @if (!empty($value->bolge->name)) "{{$value->bolge->name}}" @else "" @endif,
							 @endforeach
						 @endif
/*
					 'data1': 'İstanbul Bölge',
					 'data2': 'Fransa Bölge',
					 'data3': 'Almanya Bölge',
					 'data4': 'İtalya Bölge'
					 */
				 }
			 },
			 axis: {
			 },
			 legend: {
								 show: false, //hide legend
			 },
			 padding: {
				 bottom: 0,
				 top: 0
			 },
		 });
	 });
 });


									 require(['c3', 'jquery'], function(c3, $) {
										 $(document).ready(function(){
											 var chart = c3.generate({
												 bindto: '#chart-donut', // id of chart wrapper
												 data: {
													 columns: [
														 @if (!empty($operasyoncount))
															 @foreach ($operasyoncount as $key => $value)
																	['data{{$key}}', {{$value->toplam}}],
															 @endforeach
														 @endif
													 ],
													 type: 'donut', // default type of chart
													 colors: {
														 'data0': tabler.colors["red-light"],
														 'data1': tabler.colors["red-dark"]
													 },
													 names: {
														 @if (!empty($operasyoncount))
															 @foreach ($operasyoncount as $key => $value)
																	'data{{$key}}': "{{trans('messages.'.$value->durum)}}",
															 @endforeach
														 @endif
													 }
												 },
												 axis: {
												 },
												 legend: {
																	 show: false, //hide legend
												 },
												 padding: {
													 bottom: 0,
													 top: 0
												 },
											 });
										 });
									 });

		 </script>
	 </div>

	   @endsection
