@extends('layouts.app')

@section('kirinti')
	{{trans('messages.successmessageheader')}}
@endsection
@section('scripts')

@endsection
@section('content')
	<div class='row'>
		<div class="alert alert-danger col-md-12" role="alert">
			{{$islemAciklama}}
		</div>
	</div>
@endsection
