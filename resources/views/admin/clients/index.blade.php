@extends('app')

@section('content')
<div class="container">
	<h3>Clientes</h3>
	
	<br /><a href="{{ route('admin.clients.create') }}" class="btn btn-default">Novo cliente</a><br />

	<table class="table">
		<thead>
			<tr>
				<th>ID</th>
				<th>Cliente</th>
				<th>Fone</th>
				<th>Estado</th>
				<th>Cidade</th>
				<th>CEP</th>
				<th>Ação</th>
			</tr>
		</thead>
		<tbody>
			@foreach($clients as $client)
			<tr>
				<td>{{ $client->user_id }}</td>
				<td>{{  $client->user->name  }}</td>
				<td>{{ $client->phone }}</td>
				<td>{{ $client->state }}</td>
				<td>{{ $client->city }}</td>
				<td>{{ $client->zipcode }}</td>
				<td>
					<a href="{{ route('admin.clients.edit',['id'=>$client->id]) }}" class="btn btn-default btn-sm">Editar</a>
					<a href="{{ route('admin.clients.destroy',['id'=>$client->id]) }}" class="btn btn-default btn-sm">Remover</a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>

	{!! $clients->render() !!} <!-- usas-e {! quando não se quer escapaar a informação que está sendo impressa-->
</div>
@endsection