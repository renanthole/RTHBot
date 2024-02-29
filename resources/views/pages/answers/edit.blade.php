@extends('layouts.app', [
    'activePage' => 'quizzes',
    'titlePage' => __('Respostas'),
    'breadcrumbs' => [['url' => route('quizzes.index'), 'label' => __('Questionários')], ['url' => route('answers.index', $quiz->id), 'label' => __('Respostas')], ['url' => route('answers.edit', [$quiz->id, $answer->id]), 'label' => __('Editar resposta')]],
])

@section('content')
    <form action="{{ route('answers.update', [$quiz->id, $answer->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">{{ __('Editar resposta') }}</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group {{ $errors->has('question') ? 'has-danger' : '' }}">
                            <label for="question" class="bmd-label-floating">{{ __('Pergunta') }}</label>
                            <select name="question" id="question" class="form-control">
                                @forelse ($questions as $question)
                                    <option value="{{ $question->id }}"
                                        {{ $answer->question_id == $question->id ? 'selected' : '' }}>{{ $question->title }}
                                    </option>
                                @empty
                                    <option disabled>Nenhuma pergunta cadastrada para este questionário</option>
                                @endforelse
                            </select>
                            @if ($errors->has('question'))
                                <span id="question_error" class="error text-danger"
                                    for="input_question">{{ $errors->first('question') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group {{ $errors->has('option') ? 'has-danger' : '' }}">
                            <label for="option" class="bmd-label-floating">{{ __('Opção') }}</label>
                            <input type="text" name="option"
                                class="form-control {{ $errors->has('option') ? 'is-invalid' : '' }}" id="option"
                                value="{{ old('option', $answer->option) }}" />
                            <small class="text-help">Informe qual opção é necessária para o seguimento do formulário. Deixe
                                em branco para aceitar qualquer conteúdo.</small>
                            @if ($errors->has('option'))
                                <span id="option_error" class="error text-danger"
                                    for="option">{{ $errors->first('option') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group {{ $errors->has('next_question') ? 'has-danger' : '' }}">
                            <label for="next_question" class="bmd-label-floating">{{ __('Pergunta seguinte') }}</label>
                            <select name="next_question" id="next_question" class="form-control">
                                @foreach ($questions as $question)
                                    <option
                                        value="{{ $question->id }}"{{ $answer->next_id == $question->id ? 'selected' : '' }}>
                                        {{ $question->title }}</option>
                                @endforeach
                                <option value="finish" {{ $answer->next_id == null ? 'selected' : '' }}>
                                    Finalizar atendimento</option>
                            </select>
                            <small class="text-help">Selecionar a próxima sequência com base na escolha feita.</small>
                            @if ($errors->has('next_question'))
                                <span id="next_question_error" class="error text-danger"
                                    for="next_question">{{ $errors->first('next_question') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer clearfix">
                <button class="btn btn-primary btn-sm"><i class="fas fa-save"></i> {{ __('Salvar') }}</button>
                <a href="{{ route('answers.index', $quiz->id) }}"
                    class="btn btn-secondary btn-sm">{{ __('Cancelar') }}</a>
            </div>
        </div>
    </form>
@endsection
