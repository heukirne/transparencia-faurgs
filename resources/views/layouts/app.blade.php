<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Transparencia Faurgs - @yield('title')</title>

    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,700" rel="stylesheet" type="text/css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" type="text/css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0-alpha1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <style type="text/css">
        body {
            font-family: 'Raleway';
            margin-top: 25px;
        }

        button .fa {
            margin-right: 6px;
        }

        .table-text div {
            padding-top: 6px;
        }

        footer {
            text-align: center;
        }

        .cell-right {
            text-align: right;
        }

        .btn-sm:after {
            font-family: "Glyphicons Halflings";
            content: "\e114";
        }

        .btn-sm.collapsed:after {
            content: "\e080";
        }

        .btn-sm.pull-right {
            margin-top: -5px;
        }
    </style>

    <script type="text/javascript">

      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-209713-20']);
      _gaq.push(['_trackPageview']);

      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();

    </script>
</head>

<body>
    <div class="container">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <a class="navbar-brand">Transparencia Faurgs</a>
                </div>

                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li class="{{ app('request')->is('faurgs/unidade*') ? 'active' : '' }}"><a href="/faurgs/unidades">Unidades</a></li>
                        <li class="{{ app('request')->is('faurgs/projeto*') ? 'active' : '' }}"><a href="/faurgs/projetos">Projetos</a></li>
                        <li class="{{ app('request')->is('faurgs/pessoa*') ? 'active' : '' }}"><a href="/faurgs/pessoa">Pessoas</a></li>
                        <li class="{{ app('request')->is('faurgs/empresa*') ? 'active' : '' }}"><a href="/faurgs/empresa">Empresas</a></li>
                        <li class="{{ app('request')->is('faurgs/despesa*') ? 'active' : '' }}"><a href="/faurgs/despesa">Despesas</a></li>
                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                    @if (!Auth::guest())
                        <li class="navbar-text"><i class="fa fa-btn fa-user" title="{{ Auth::user()->name }}"></i></li>
                        <li><a href="/faurgs/auth/logout" title="Logout"><i class="fa fa-btn fa-sign-out"></i></a></li>
                    @else
                        <li><a href="/faurgs/auth/social/google" title="Login"><i class="fa fa-btn fa-sign-in"></i></a></li>
                    @endif
                    </ul>

                    <div class="col-sm-3 col-md-3 pull-right">
                        <form class="navbar-form" role="search" method="GET" action="/faurgs/busca">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Buscar" name="q" id="srch-term" value="{{ app('request')->input('q') }}">
                                <div class="input-group-btn">
                                    <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
    </div>

    <div class="container">
        <div class="col-sm-offset-1 col-sm-10">
            @yield('content')
        </div>
    </div>

    <footer>
      <div class="container">
        <p class="text-muted">
            Fonte: Transparencia <a href="https://www.faurgs.ufrgs.br/Solpagweb/hdadosprojeto.aspx">FAURGS</a>
            e <a href="http://www.portaldatransparencia.gov.br/downloads/">Governo Federal</a>
        </p>
        <p class="text-muted">Registros de {{$dataini}} a {{$datafim}} </p>
        <p class="text-muted">Codigo-fonte no <a href="https://github.com/heukirne/transparencia-faurgs">GitHub</a> Powered by <a href="https://laravel.com/">Laravel</a></p>
      </div>
    </footer>

</body>
</html>