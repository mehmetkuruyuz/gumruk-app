@extends('layouts.app')

@section('kirinti')
	{{trans('messages.successmessageheader')}}
@endsection
@section('scripts')

@endsection
@section('content')
	<div class='row'>
		<div class="alert alert-success col-md-12" role="alert">
			{{trans('messages.messagemailsuccess')}}
		</div>
	</div>
@endsection