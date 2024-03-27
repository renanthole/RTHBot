@extends('layouts.app', [
    'activePage' => 'quizzes',
    'titlePage' => 'Perguntas',
    'breadcrumbs' => [['url' => route('quizzes.index'), 'label' => 'Questionários'], ['url' => route('questions.index', $quiz->id), 'label' => 'Perguntas']],
])

@section('content')
    <div class="row mb-2">
        <div class="col-sm-2">
            <a href="{{ route('quizzes.index') }}" class="btn btn-secondary btn-sm btn-block">Voltar</a>
        </div>
        <div class="col-sm-2">
            <a href="{{ route('questions.create', $quiz->id) }}" class="btn btn-primary btn-sm btn-block">Nova</a>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('Perguntas') }}</h3>
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
                        <th class="text-center">Ordem</th>
                        <th class="text-center">Data<br />Cadastro</th>
                        <th class="text-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($questions as $question)
                        <tr>
                            <td>{{ $question->id }}</td>
                            <td class="text-center">{{ $question->title }}</td>
                            <td class="text-center">{{ $question->position }}</td>
                            <td class="text-center">{{ date('d/m/Y H:i', strtotime($question->created_at)) }}</td>
                            <td class="text-right">
                                <a href="{{ route('questions.edit', [$quiz->id, $question->id]) }}"
                                    class="btn btn-warning btn-xs">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('questions.destroy', [$quiz->id, $question->id]) }}"
                                    class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="bottom"
                                    title="Excluír" data-method="DELETE" data-confirm="Deseja excluír o registro?"
                                    data-theme="bootstrap">
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
            {{ $questions->links() }}
        </div>
    </div>
@endsection
