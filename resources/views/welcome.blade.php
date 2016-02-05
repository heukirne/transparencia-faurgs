@extends('layouts.app')

@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">Voce deve fazer login para acessar a aplicacao</div>

        <div class="panel-body">
        	<p class="text-center">
	            <a href="/faurgs/auth/social/google"><i class="fa fa-google"></i> Google</a> </br></br>
	            <a href="/faurgs/auth/social/facebook"><i class="fa fa-facebook"></i> Facebook</a>
        	</p>
        </div>
    </div>
       
@endsection
