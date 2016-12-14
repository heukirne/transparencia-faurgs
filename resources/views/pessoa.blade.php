@extends('layouts.app')

@section('title', isset($pessoas[0])?$pessoas[0]->CPF:'Sem descrição')

@inject('modelHelper', 'App\Models\ModelHelper')

@section('content')	
	
	@if ($alert)
		<div class="alert alert-warning">
			A comparação de CPF leva em conta somente 6 dígitos, por isso pode haver inconsistências.
		</div>
	@endif

	
	@if (count($pessoas) > 0)	
		@foreach ($pessoas as $pessoa)			
			<div class="panel panel-default">
				<div class="panel-heading">
					<a href="http://www.portaldatransparencia.gov.br/servidores/Servidor-ListaServidores.asp?TextoPesquisa={{$pessoa->Nome}}">
						{{$pessoa->Nome}} ({{$pessoa->CPF}})
					</a> 
					<i class="fa fa-external-link"></i>
					@if (count($pessoas)>1)
				    	<button type="button" class="btn btn-sm btn-default collapsed pull-right" data-toggle="collapse" data-target="#M{{$pessoa->Matricula.$pessoa->idDescricaoCargo}}"></button>
				    @endif
				</div>

				<div class="panel-body {{ count($pessoas)==1 ? '' : 'collapse' }}" id="M{{$pessoa->Matricula.$pessoa->idDescricaoCargo}}">
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
			</div>
		@endforeach
	@else
		<div class="panel panel-default">
			<div class="panel-heading">
				Sem dados funcionais
			</div>
		</div>
	@endif
	

	@if (count($totals) > 0)
		<div class="panel panel-default">
			<div class="panel-heading">
				Total recebido por CPF
			</div>

			<div class="panel-body">
				<table class="table table-striped total-table">
					<tbody>
						@foreach ($totals as $total)
							<tr>
								<th>
									<a href="/faurgs/fetch/{{ $total->CPFLink() }}">
									{{ $total->CPF }}
									</a>
									<i class="fa fa-external-link"></i>
								</th>
								<td>de {{ $total->AnoIni }} à {{ $total->AnoFim }}</td>
								<td>{{ $total->Projetos }} projetos</td>
								<td>{{ $total->Total }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>	
		</div>
	@endif
	

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
