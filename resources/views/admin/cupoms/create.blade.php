@extends('app')

@section('content')
	<div class="container">
		<h3>Novo cupom</h3>

		@include('errors._check')

		{!! Form::open(['route'=>'admin.cupoms.store', 'class'=>'form']) !!} 

			@include('admin.cupoms._form')

			<div class="form-group">
				{!! Form::submit('Salvar', ['class'=>'btn btn-primary']) !!}
			</div>

		{!! Form::close() !!}

	</div>
@endsection