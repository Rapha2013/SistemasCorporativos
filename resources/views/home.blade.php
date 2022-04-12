@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="card-header" style="text-align: center;">
        <h3 class="card-title">Projeto Sistemas Corporativos</h3>
    </div>
@stop

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- SELECT2 EXAMPLE -->
            <div class="card card-default">
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row" style="text-align: center !important;">
                        <div class="form-group col-md-12" style="margin-bottom: 0;">
                            <h1>Bem Vindo!</h1>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </section>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        console.log('Hi!');
    </script>
@stop
