@extends('adminlte::page')

@section('title', 'GIGI FASHION IMPORT')

@section('content')

    <style>
        tr:hover {
            background-color: #FFF9C3;
        }
    </style>

    <div class="row">
        <div class="col-lg-12 margin-tb">
        </div>
    </div>
    <br>
    <div class="card mb-3">
        <div class="py-3 px-3 border-bottom d-flex justify-content-between">
            <h4>Últimos Backups</h4>

            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Generar un nuevo respaldo de la base de datos">
                <form action="{{ route('backups.store') }}" method="post">
                    @csrf
                    <button class="btn btn-success" type="submit" style="position:relative; border-radius: 10px; font-weight: 600;">
                        <i class="fas fa-plus mr-2"></i> Generar Backup
                    </button>
                </form>
            </span>

        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success m-3">
                <p class="m-0">{{ $message }}</p>
            </div>
        @endif

        @if ($message = Session::get('error'))
            <div class="alert alert-danger m-3">
                <p class="m-0">{{ $message }}</p>
            </div>
        @endif

        <div class="card-body">
            <table class="table table-bordered table-sm">
                <thead class="thead-dark">
                <tr>
                    <th width="50px">ID</th>
                    <th>Nombre del Archivo</th>
                    <th width="120px" class="text-left">Acciones</th>
                </tr>
                </thead>
                @foreach ($backups as $backup)
                    <tr>
                        <td>{{ $backup->id }}</td>
                        <td>{{ $backup->file_name }}</td>
                        <td class="text-left">
                            <div class="d-flex justify-content-start" style="gap: 5px;">
                                <a href="{{route('backups.download', $backup->file_name)}}" target="_blank" class="btn btn-success" style="border-radius: 8px;">
                                    <i class="fa fa-download"></i>
                                </a>
                                <form action="{{ route('backups.destroy', $backup->id) }}" method="POST" class="delete-form m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-delete-backup" style="border-radius: 8px;"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </table>
            <div class="pagination-container pt-3">
                {!! $backups->links() !!}
            </div>
        </div>
    </div>

    {{-- Confirm Delete Modal (Premium Aesthetic) --}}
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 2rem;">
                <div class="modal-body text-center p-5">
                    <div class="warning-icon-container mb-4">
                        <div class="warning-icon-bg">
                            <i class="fas fa-trash-alt" style="font-size: 3rem;"></i>
                        </div>
                    </div>
                    <h2 class="font-weight-bold mb-3" style="color: #1E293B;">¿Eliminar Backup?</h2>
                    <p class="text-muted mb-4" style="font-size: 1.15rem;">Esta acción eliminará permanentemente el archivo de respaldo. ¿Está seguro de continuar?</p>
                    <div class="d-flex flex-column" style="gap: 12px;">
                        <button type="button" id="confirmDeleteBtn" class="btn btn-block py-3 font-weight-bold" 
                                style="background: #7D266E; color: white; border-radius: 50rem; box-shadow: 0 4px 12px rgba(125, 38, 110, 0.2); font-size: 1.1rem; text-transform: uppercase;">
                            SÍ, ELIMINAR
                        </button>
                        <button type="button" class="btn btn-link text-muted font-weight-bold py-2" data-dismiss="modal" style="text-decoration: none;">
                            CANCELAR
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <style>
        .warning-icon-container { display: flex; justify-content: center; }
        .warning-icon-bg {
            width: 120px; height: 120px; background: #FEE2E2; color: #EF4444;
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            animation: scaleUp 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        @keyframes scaleUp {
            from { transform: scale(0); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
    </style>
@stop

@section('js')
    <script>
        $(function () {
            let formToSubmit = null;

            $('.btn-delete-backup').on('click', function(e) {
                e.preventDefault();
                formToSubmit = $(this).closest('form');
                $('#confirmDeleteModal').modal('show');
            });

            $('#confirmDeleteBtn').on('click', function() {
                if(formToSubmit) {
                    formToSubmit.submit();
                }
            });
        });
    </script>
@stop

