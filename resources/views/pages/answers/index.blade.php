@extends('layouts.app', [
    'activePage' => 'quizzes',
    'titlePage' => 'Respostas',
    'breadcrumbs' => [['url' => route('quizzes.index'), 'label' => 'Questionários'], ['url' => route('answers.index', $quiz->id), 'label' => 'Respostas']],
])

@section('content')
    <div class="row mb-2">
        <div class="col-sm-2">
            <a href="{{ route('quizzes.index') }}" class="btn btn-secondary btn-sm btn-block">Voltar</a>
        </div>
        <div class="col-sm-2">
            <a href="{{ route('answers.create', $quiz->id) }}" class="btn btn-primary btn-sm btn-block">Novo</a>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('Respostas') }}</h3>
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
                        <th class="text-center">Pergunta</th>
                        <th class="text-center">Opção</th>
                        <th class="text-center">Próxima<br />Pergunta</th>
                        <th class="text-center">Data<br />Cadastro</th>
                        <th class="text-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($answers as $answer)
                        <tr>
                            <td>{{ $answer->id }}</td>
                            <td class="text-center">{{ $answer->question->title }}</td>
                            <td class="text-center">{{ $answer->option }}</td>
                            <td class="text-center">{{ $answer->finishedOption() }}</td>
                            <td class="text-center">{{ date('d/m/Y H:i', strtotime($answer->created_at)) }}</td>
                            <td class="text-right">
                                <a href="{{ route('answers.edit', [$quiz->id, $answer->id]) }}" class="btn btn-warning btn-xs">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('answers.destroy', [$quiz->id, $answer->id]) }}" class="btn btn-danger btn-xs"
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
            {{ $answers->links() }}
        </div>
    </div>
@endsection
