@extends('layouts.app', [
    'activePage' => 'devices',
    'titlePage' => 'Dispositivos',
    'breadcrumbs' => [['url' => route('devices.index'), 'label' => 'Dispositivos']],
])

@section('content')
    <div class="row mb-2">
        <div class="col-sm-2">
            <a href="{{ route('devices.create') }}" class="btn btn-primary btn-sm btn-block">Novo</a>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('Dispositivos') }}</h3>
            <div class="card-tools">
                <form>
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="q" class="form-control float-right" placeholder="Procurar">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>#</th>
                        <th class="text-center">Nome</th>
                        <th class="text-center">Celular</th>
                        <th class="text-center">Instância</th>
                        <th class="text-center">Token</th>
                        <th class="text-center">Data de cadastro</th>
                        <th class="text-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($devices as $device)
                        <tr>
                            <td>{{ $device->id }}</td>
                            <td class="text-center">{{ $device->name }}</td>
                            <td class="text-center">{{ $device->phone }}</td>
                            <td class="text-center">{{ $device->instancia }}</td>
                            <td class="text-center">{{ $device->token }}</td>
                            <td class="text-center">{{ date('d/m/Y H:i', strtotime($device->created_at)) }}</td>
                            <td class="text-right">
                                <a href="{{ route('devices.edit', $device->id) }}" class="btn btn-warning btn-xs">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('devices.destroy', $device->id) }}" class="btn btn-danger btn-xs"
                                    data-toggle="tooltip" data-placement="bottom" title="Excluír" data-method="DELETE"
                                    data-confirm="Deseja excluír o registro?" data-theme="bootstrap">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">{{ __('message.table_no_records') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">
            {{ $devices->links() }}
        </div>
    </div>
@endsection
