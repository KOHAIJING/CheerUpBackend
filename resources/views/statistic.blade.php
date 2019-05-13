@extends('layouts.app')
<head>
	<title>Statistic Records</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
  @section('content')
<body>

<div class="container">
    <div class="row">
        <div class="col-md-14">
            <div class="panel panel-default">

							@if(Auth::check() && Auth::user()->isAdmin())
									@if (session('status'))
										<div class="panel-body">
											<div class="alert alert-success">
												{{ session('status') }}
											</div>
										</div>
									@endif
							@else
								<center><h4>You have no access rights. This page only available for admin.</h4></center>
							@endif

					 @if (Auth::check() && Auth::user()->isAdmin())

              <ul class="nav nav-tabs">
                <li><a href="usersdata">Depression's Records</a></li>
                <li class="active"><a href="statistic">Statistic Records</a></li>
              </ul>

							<div class="container">
							</br>
								 <div class="col-md-4">
								 	{!! Charts::styles() !!}
								 	<!-- Main Application (Can be VueJS or other JS framework) -->
								 	<div class="app">
								 			<center>
													<b>
 													 {!! $chartAge->html() !!}
 												 </b>
								 			</center>
								 	</div>
								 	<!-- End Of Main Application -->
								 	{!! Charts::scripts() !!}
								 	{!! $chartAge->script() !!}
								 </div>

								 <div class="col-md-4">
										 {!! Charts::styles() !!}
										 <!-- Main Application (Can be VueJS or other JS framework) -->
										 <div class="app">
											 <center>
												 <b>
													 {!! $chart->html() !!}
												 </b>
											 </center>
										 </div>
										 <!-- End Of Main Application -->
										 {!! Charts::scripts() !!}
										 {!! $chart->script() !!}
								 </div>

								 <div class="col-md-4">
										 {!! Charts::styles() !!}
										 <!-- Main Application (Can be VueJS or other JS framework) -->
										 <div class="app">
											 <center>
											 <b>
												 {!! $chartRace->html() !!}
											 </b>
											 </center>
										 </div>
										 <!-- End Of Main Application -->
										 {!! Charts::scripts() !!}
										 {!! $chartRace->script() !!}
								 </div>

							<div class="col-md-4">
								{!! Charts::styles() !!}
							 <!-- Main Application (Can be VueJS or other JS framework) -->
							 <div class="app">
									 <center>
											 <b>
												 {!! $chartHeight->html() !!}
											 </b>
									 </center>
							 </div>
							 <!-- End Of Main Application -->
							 {!! Charts::scripts() !!}
							 {!! $chartHeight->script() !!}
							</div>

							<div class="col-md-4">
								{!! Charts::styles() !!}
							 <!-- Main Application (Can be VueJS or other JS framework) -->
							 <div class="app">
									 <center>
											 <b>
												 {!! $chartWeight->html() !!}
											 </b>
									 </center>
							 </div>
							 <!-- End Of Main Application -->
							 {!! Charts::scripts() !!}
							 {!! $chartWeight->script() !!}
							</div>

								 <div class="col-md-4">
									 {!! Charts::styles() !!}
								 <div class="app">
                      <center>
													<b>
	 												 {!! $chartBt->html() !!}
	 											 </b>
                      </center>
                  </div>
                  <!-- End Of Main Application -->
                  {!! Charts::scripts() !!}
                  {!! $chartBt->script() !!}
              </div>
							</div>
					@endif
				</div>
			</div>
		</div>
	</div>
</body>
@endsection
