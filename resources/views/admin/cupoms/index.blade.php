@extends('app')

@section('content')
<div class="container">
	<h3>Cupons</h3>
	
	<br /><a href="{{ route('admin.cupoms.create') }}" class="btn btn-default">Novo cupom</a><br />

	<table class="table">
		<thead>
			<tr>
				<th>ID</th>
				<th>Código</th>
				<th>Valor</th>
				<th>Ação</th>
			</tr>
		</thead>
		<tbody>
			@foreach($cupoms as $cupom)
			<tr>
				<td>{{ $cupom->id }}</td>
				<td>{{ $cupom->code }}</td>
				<td>{{ $cupom->value }}</td>
				<td>-</td>
			</tr>
			@endforeach
		</tbody>
	</table>

	{!! $cupoms->render() !!} <!-- usas-e {! quando não se quer escapaar a informação que está sendo impressa-->
</div>
@endsection