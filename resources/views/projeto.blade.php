@extends('layouts.app')

@section('title', $projeto->Nome)

@inject('modelHelper', 'App\Models\ModelHelper')

@section('content')

	@if (!empty($projeto))
		<div class="panel panel-default">
			<div class="panel-heading">
				{{$projeto->Nome}}
			</div>

			<div class="panel-body">
				<table class="table table-striped projeto-table">
					<tbody>
						<tr><th>Valor</th><td>{{ $projeto->Valor }}</td></tr>
						@if (!empty($projeto->Processo))
							<tr><th>Processo</th><td><a href="https://www1.ufrgs.br/Protocolo/CadProc/processo/detalhes?CodProcesso={{ $projeto->Processo }}">{{ $projeto->Processo }}</a></td></tr>
						@endif
						<tr><th>Data de Inicio</th><td>{{ $projeto->DataInicio }}</td></tr>
						<tr><th>Data de Fim</th><td>{{ $projeto->DataFim }}</td></tr>
						<tr><th>Objeto</th><td>{{ $projeto->Objeto }}</td></tr>
						<tr><th>Contrato Convenio</th><td>{{ $projeto->ContratoConvenio }}</td></tr>
						<tr><th>Coordenador</th><td><a href="/faurgs/pessoa/coordenador/{{ $projeto->Coordenador }}">{{ $projeto->Coordenador }}<a/></td></tr>
						<tr><th>Unidade Executora</th><td><a href="/faurgs/unidade/{{ $projeto->idOrgao }}">{{ $projeto->UnidadeExecutora }}</a></td></tr>
						<tr><th>Orgao Financiador</th><td>{{ $projeto->OrgaoFinanciador }}</td></tr>
					</tbody>
				</table>
			</div>
		</div>
	@endif

	@if (count($pessoas) > 0)
		<div class="panel panel-default">
			<div class="panel-heading">
				Lista de Servidores
			</div>

			<div class="panel-body">
				<table class="table table-striped pessoas-table">
					<thead>
						<th>CPF</th>
						<th>Tipo</th>
						<th>Despesa</th>
						<th class="cell-right">Total Recebido</th>
					</thead>
					<tbody>
						@foreach ($pessoas as $pessoa)
							<tr>
								<td class="table-text">
									<a href="/faurgs/pessoa/{{ $pessoa->CPFcut }}">{{ $pessoa->CPF }}</a>
								</td>
								<td>
									{{ $pessoa->TipoPagamento=='F'?'Bolsista':'Servidor' }}
								</td>
								<td>
									<a href="/faurgs/despesa/{{ $modelHelper::urlEncode($pessoa->TipoDespesa) }}">{{ $pessoa->TipoDespesa }}</a>
								</td>
								<td class="cell-right">
									{{ $pessoa->Total }}
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	@endif

	@if (count($empresas) > 0)
		<div class="panel panel-default">
			<div class="panel-heading">
				Lista de Empresas
			</div>

			<div class="panel-body">
				<table class="table table-striped empresas-table">
					<thead>
						<th>CNPJ</th>
						<th>Tipo Despesa</th>
						<th class="cell-right">Total Recebido</th>
					</thead>
					<tbody>
						@foreach ($empresas as $empresa)
							<tr>
								<td class="table-text">
									<a href="/faurgs/empresa/{{ $empresa->CNPJ }}">{{ $empresa->NomeEmpresa }}</a>
								</td>
								<td>
									{{ $empresa->TipoDespesa }}
								</td>
								<td class="cell-right">
									{{ $empresa->Total }}
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	@endif
		
@endsection
