@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="card-header">
        <h3 class="card-title">Lista de Usuarios</h3>
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
                    <div class="row">
                        <div class="form-group col-md-12">
                            <table id="tabela" class="table table-bordered table-hover" style="width:100%; font-size: 12px;">
                            </table>
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
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            $.fn.select2.defaults.set('language', 'pt-BR');


            $('#tabela').DataTable({
                destroy: true,
                order: [0, 'asc'],
                ajax: {
                    url: `api/users/lista`
                },
                columns: [{
                        data: "id",
                        title: "ID",
                    },
                    {
                        data: "name",
                        title: "name",
                    },


                ],
                // "language": {
                //     "url": "/intranet/css/DataTables/Portuguese-Brasil.json"
                // },
                dom: 'frtlp',
                "pageLength": 10,

            });

        });
    </script>
@stop
