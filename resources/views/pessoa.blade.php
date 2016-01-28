@extends('layouts.app')

@section('title', $pessoa?$pessoa->CPF:'Sem descrição')

@inject('modelHelper', 'App\Models\ModelHelper')

@section('content')	
	
	<div class="panel panel-default">
		@if (!empty($pessoa))				
			<div class="panel-heading">
				<a href="http://www.portaldatransparencia.gov.br/servidores/Servidor-ListaServidores.asp?TextoPesquisa={{$pessoa->Nome}}">
					{{$pessoa->Nome}} ({{$pessoa->CPF}})
				</a> 
				<i class="fa fa-external-link"></i>
			</div>

			<div class="panel-body">
				<table class="table table-striped pessoa-table">
					<tbody>
						<tr>
							<th>Cargo</th>
							<td>
								<a href="http://gemeos.org/tp/servidor/classe?id={{ $pessoa->idDescricaoCargo }}">{{ $pessoa->DESCRICAO_CARGO }}</a> 
								<a href="http://gemeos.org/tp/servidor/padrao?id={{ $pessoa->idClasseCargo }}">{{ $pessoa->CLASSE_CARGO }}</a> 
								<a href="http://gemeos.org/tp/servidor/nivel?id={{ $pessoa->idPadraoCargo }}">{{ $pessoa->PADRAO_CARGO }}</a> 
								<a href="http://gemeos.org/tp/servidor/detalhesN?id={{ $pessoa->idNivelCargo }}">{{ $pessoa->NIVEL_CARGO }}</a> 
								<i class="fa fa-external-link"></i>
							</td>
						</tr>
						<tr><th>Situação</th><td>{{ $pessoa->SITUACAO_VINCULO }}</td></tr>
						<tr><th>Ingresso</th><td>{{ $pessoa->DATA_INGRESSO_ORGAO }}</td></tr>
						<tr><th>Jornada de Trabalho</th><td>{{ $pessoa->JORNADA_DE_TRABALHO }}</td></tr>
						<tr>
							<th>Lotação</th>
							<td><a href="http://gemeos.org/tp/servidor/detalhes?id={{ $pessoa->COD_UORG_LOTACAO }}">{{ $pessoa->UORG_LOTACAO }}</a> <i class="fa fa-external-link"></i> </td>
						</tr>
						<tr>
							<th>Exercício</th>
							<td><a href="http://gemeos.org/tp/servidor/unidade?id={{ $pessoa->COD_ORG_EXERCICIO }}">{{ $pessoa->ORG_EXERCICIO }}</a> <i class="fa fa-external-link"></i> </td>
						</tr>
						<tr><th>Função</th><td>{{ $pessoa->FUNCAO }}</td></tr>
						<tr><th>Atividade</th><td>{{ $pessoa->ATIVIDADE }}</td></tr>
					</tbody>
				</table>
			</div>
		@else
			<div class="panel-heading">
				Sem dados funcionais
			</div>
		@endif

		@if (count($totals) > 0)
			<div class="panel-body">
				<span>Total recebido por CPF</span>
				<table class="table table-striped total-table">
					<tbody>
						@foreach ($totals as $total)
							<tr>
								<th>{{ $total->CPF }}</th>
								<td>de {{ $total->AnoIni }} à {{ $total->AnoFim }}</td>
								<td>{{ $total->Projetos }} projetos</td>
								<td>{{ $total->Total }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>	
		@endif

	</div>

	<div class="alert alert-info">
		* a lista leva em conta somente 6 dígitos do CPF, por isso pode haver inconsistências
	</div>

	@if (count($projetos) > 0)
		<div class="panel panel-default">
			<div class="panel-heading">
				Lista de Projetos*
			</div>

			<div class="panel-body">
				<table class="table table-striped projetos-table">
					<thead>
						<th>Projeto</th>
						<th>CPF</th>
						<th>Tipo</th>
						<th>Despesa</th>
						<th class="cell-right">Total Recebido</th>
					</thead>
					<tbody>
						@foreach ($projetos as $projeto)
							<tr>
								<td class="table-text">
									<a href="/faurgs/projeto/{{ $projeto->idProjeto }}">{{ $projeto->projeto->Nome }}</a>
								</td>
								<td>{{ $projeto->CPF }}</td>
								<td>{{ $projeto->TipoPagamento=='F'?'Bolsista':'Servidor' }}</td>
								<td><a href="/faurgs/despesa/{{ $modelHelper::urlEncode($projeto->TipoDespesa) }}">{{ $projeto->TipoDespesa }}</a></td>
								<td class="cell-right">{{ $projeto->Total }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	@endif

@endsection
