@extends('layouts.app', [
    'activePage' => 'quizzes',
    'titlePage' => __('Perguntas'),
    'breadcrumbs' => [['url' => route('quizzes.index'), 'label' => __('Questionários')], ['url' => route('questions.index', $quiz->id), 'label' => __('Perguntas')], ['url' => route('questions.edit', [$quiz->id, $question->id]), 'label' => __('Editar pergunta')]],
])

@section('content')
    <form action="{{ route('questions.update', [$quiz->id, $question->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">{{ __('Editar pergunta') }}</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group {{ $errors->has('title') ? 'has-danger' : '' }}">
                            <label for="title" class="bmd-label-floating">{{ __('Título') }}</label>
                            <input type="text" name="title"
                                class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" id="title"
                                value="{{ old('title', $question->title) }}" />
                            @if ($errors->has('title'))
                                <span id="title_error" class="error text-danger"
                                    for="input_title">{{ $errors->first('title') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group {{ $errors->has('question') ? 'has-danger' : '' }}">
                            <label for="question" class="bmd-label-floating">{{ __('Pergunta') }}</label>
                            <textarea name="question" id="question" class="form-control {{ $errors->has('question') ? 'is-invalid' : '' }}"
                                cols="30" rows="5" required>{{ old('question', $question->question) }}</textarea>
                            @if ($errors->has('question'))
                                <span id="question_error" class="error text-danger"
                                    for="input_question">{{ $errors->first('question') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group {{ $errors->has('position') ? 'has-danger' : '' }}">
                            <label for="position" class="bmd-label-floating">{{ __('Posição') }}</label>
                            <input type="text" name="position"
                                class="form-control {{ $errors->has('position') ? 'is-invalid' : '' }}" id="position"
                                value="{{ old('position', $question->position) }}" />
                            @if ($errors->has('position'))
                                <span id="position_error" class="error text-danger"
                                    for="input_position">{{ $errors->first('position') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer clearfix">
                <button class="btn btn-primary btn-sm"><i class="fas fa-save"></i> {{ __('Salvar') }}</button>
                <a href="{{ route('questions.index', $quiz->id) }}"
                    class="btn btn-secondary btn-sm">{{ __('Cancelar') }}</a>
            </div>
        </div>
    </form>
@endsection
