@extends('app')

@section('content')

<div class="container">
	<h3>Produtos</h3>

	<a href="{{ route('admin.products.create') }}" class="btn btn-default">Novo Produto</a>

	<br><br>

	<table class="table table-bordered">
		<thead>
			<tr>
				<th>ID</th>
				<th>Produto</th>
				<th>Categoria</th>
				<th>Preço</th>
				<th>Ação</th>
			</tr>
		</thead>
		<tbody>
			@foreach($products as $product)
			<tr>
				<td>{{ $product->id }}</td>
				<td>{{ $product->name }}</td>
				<td>{{ $product->category->name }}</td>
				<td>{{ $product->price }}</td>
				<td>
					<a class="btn btn-default btn-sm" href="{{ route('admin.products.edit', ['id'=>$product->id]) }}">
						Editar
					</a>
					<a class="btn btn-default btn-sm" href="{{ route('admin.products.destroy', ['id'=>$product->id]) }}">
						Remover
					</a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>

	{!! $products->render() !!}

</div>

@endsection