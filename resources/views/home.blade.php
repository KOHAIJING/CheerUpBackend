@extends('layouts.app')

<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>CheerUp</title>

        <!-- Styles -->
        <style>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 80vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 50px;
                color:grey;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    @section('content')
    <body>
        <div class="flex-center position-ref full-height">
            <div>
                <div class="title m-b-md">
                    Welcome to CheerUp
                </div>
            </div>
        </div>
    </body>
    @endsection
</html>
