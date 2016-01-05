<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 96px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">Laravel 5</div>
                @if(Auth::user())
                    @if(Auth::user()->role == "admin")
                        <h3><a href="{{ route('admin.categories.index') }}">Admin > Categorias</a></h3>
                    @elseif(Auth::user()->role == "client")
                        <h3><a href="{{ route('customer.order.index') }}">Meus pedidos</a></h3>
                    @endif
                @else
                    <h3><a href="/auth/login">Login</a></h3>
                @endif
            </div>
        </div>
    </body>
</html>
