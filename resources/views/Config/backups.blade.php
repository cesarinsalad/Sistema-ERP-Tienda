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

            <div class="d-flex" style="gap: 10px;">
                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Generar un nuevo respaldo de la base de datos">
                    <form action="{{ route('backups.store') }}" method="post">
                        @csrf
                        <button class="btn btn-success" type="submit" style="position:relative; border-radius: 10px; font-weight: 600;">
                            <i class="fas fa-plus mr-2"></i> Generar Backup
                        </button>
                    </form>
                </span>
                
                <button type="button" class="btn btn-primary" id="btnUploadBackup" style="border-radius: 10px; font-weight: 600; background-color: #2563EB; border-color: #2563EB;">
                    <i class="fas fa-upload mr-2"></i> Cargar Respaldo
                </button>
            </div>

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
                                    <button type="submit" class="btn btn-danger btn-delete-backup" style="border-radius: 8px;"><i class="fas fa-trash-alt"></i></button>
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
            $('#btnUploadBackup').on('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: '¿Cargar y Restaurar?',
                    html: `
                        <p class="text-muted mb-4" style="font-size: 1.15rem;">Al cargar este archivo, <strong class="text-danger">se sobrescribirá</strong> la base de datos actual. ¿Está seguro de continuar?</p>
                        <form action="{{ route('backups.upload') }}" method="POST" enctype="multipart/form-data" id="swalUploadForm">
                            @csrf
                            <div class="form-group text-left mb-4">
                                <label for="swal_backup_file" class="font-weight-bold" style="color: #475569;">Seleccionar archivo (.sql):</label>
                                <input type="file" name="backup_file" id="swal_backup_file" class="form-control-file" required accept=".sql,.gz,.txt" style="border: 2px dashed #CBD5E1; padding: 1rem; border-radius: 1rem; background: #F8FAFC; width: 100%;">
                            </div>
                        </form>
                    `,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#2563EB',
                    cancelButtonColor: 'transparent',
                    confirmButtonText: 'CONFIRMAR Y SUBIR',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true,
                    customClass: {
                        popup: 'swal-premium-popup',
                        confirmButton: 'swal-premium-btn',
                        cancelButton: 'swal-premium-btn'
                    },
                    preConfirm: () => {
                        const fileInput = document.getElementById('swal_backup_file');
                        if (!fileInput.files.length) {
                            Swal.showValidationMessage('Por favor selecciona un archivo (.sql)');
                            return false;
                        }
                        
                        const form = document.getElementById('swalUploadForm');
                        Swal.getConfirmButton().innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> RESTAURANDO...';
                        Swal.getConfirmButton().disabled = true;
                        form.submit();
                        return false; 
                    }
                });
            });
        });
    </script>
@stop

