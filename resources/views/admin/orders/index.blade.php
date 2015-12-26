@extends('app')

@section('content')
<div class="container">
	<h3>Pedidos</h3>
	
	<table class="table">
		<thead>
			<tr>
				<th>ID</th>
				<th>Total</th>
				<th>Data</th>
				<th>Itens</th>
				<th>Entregador</th>
				<th>Status</th>
				<th>Ação</th>
			</tr>
		</thead>
		<tbody>
			@foreach($orders as $order)
			<tr>
				<td>#{{ $order->id }}</td>
				<td>R$ {{ $order->total }}</td>
				<td>{{ $order->created_at }}</td>
				<td>
					@foreach($order->items as $item) 	
					<ul>
						<li>{{ $item->product->name }}</li> 
					</ul>
					@endforeach 	
				</td>
				<td>
					@if($order->deliveryman)
						{{ $order->deliveryman->name }}
					@else
						--
					@endif
				</td>
				<td>{{ $order->status }}</td>
				<td><a href="{{ route('admin.orders.edit',['id'=>$order->id]) }}" class="btn btn-default btn-sm">Editar</a></td>
			</tr>
			@endforeach
		</tbody>
	</table>

	{!! $orders->render() !!} <!-- usas-e {! quando não se quer escapaar a informação que está sendo impressa-->
</div>
@endsection