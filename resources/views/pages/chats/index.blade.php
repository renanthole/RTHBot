@extends('layouts.app', ['titlePage' => __('Chats'), 'activePage' => 'chats', 'breadcrumbs' => [['url' => route('chats.index'), 'label' => 'Chats']]])

@section('content')
    <div class="row mb-2">
        <div class="col-sm-2">
            <a href="{{ route('chats.create') }}" class="btn btn-primary btn-sm btn-block">Novo</a>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('Chats') }}</h3>
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
                        <th class="text-center">Celular</th>
                        <th class="text-center">Data<br />Início</th>
                        <th class="text-center">Data<br />Última Mensagem</th>
                        <th class="text-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($chats as $chat)
                        <tr>
                            <td>{{ $chat->id }}</td>
                            <td class="text-center">{{ $chat->phone }}</td>
                            <td class="text-center">{{ date('d/m/Y H:i', strtotime($chat->created_at)) }}</td>
                            <td class="text-center">{{ date('d/m/Y H:i', strtotime($chat->updated_at)) }}</td>
                            <td class="text-right">
                                <a href="{{ route('chats.show', $chat->id) }}" class="btn btn-success btn-xs">
                                    <i class="fas fa-eye"></i> Visualizar
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
            {{ $chats->links() }}
        </div>
    </div>
@endsection
