@extends('layouts.app')

@section('title', ucwords($title))

@inject('modelHelper', 'App\Models\ModelHelper')

@section('content')

	@if (count($items) > 0)
		<div class="panel panel-default">
			<div class="panel-heading">
				Lista de {{ ucwords($link) }}s
				<span class="pull-right">Somatorio: {{ $modelHelper::soma($items) }}</span>
			</div>

			<div class="panel-body">
				<table class="table table-striped item-table">
					<thead>
						<th>Nome</th>
						@if ($link == 'projeto')
							<th class="cell-right">Executado</th>
						@endif
						<th class="cell-right">Valor</th>
					</thead>
					<tbody>
						@foreach ($items as $item)
							<tr>
								<td class="table-text">
									@if ($link == 'empresa')
										<a href="/faurgs/empresa/{{ $item->CNPJ }}">{{ $item->Nome }}</a>
									@elseif ($link == 'pessoa')
										<a href="/faurgs/pessoa/{{ $item->CPF }}">{{ $item->Nome }}</a>
									@elseif ($link == 'projetos')
										<a href="/faurgs/projeto/{{ $item->projeto->id }}">{{ $item->projeto->Nome }}</a>
									@elseif ($link == 'despesa')
										<a href="/faurgs/despesa/{{ $modelHelper::urlEncode($item->Nome) }}">{{ $item->Nome }}</a>
									@elseif ($link == 'search')
										<a href="/faurgs/{{ $item->link }}">{{ $item->Nome }}</a>
									@else
										<a href="/faurgs/{{ $link }}/{{ $item->id }}">{{ $item->Nome }}</a>
									@endif
								</td>
								@if ($link == 'projeto')
									<td class="cell-right {{ $item->Excedido() ? 'alert-danger' : '' }}">
										{{ $item->Executado }}
									</td>
								@endif
								<td class="cell-right">
									{{ $item->Valor }}
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	@endif

@endsection
