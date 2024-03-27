@extends('layouts.app', [
    'activePage' => 'quizzes',
    'titlePage' => __('Questionários'),
    'breadcrumbs' => [['url' => route('quizzes.index'), 'label' => __('Questionários')], ['url' => route('quizzes.edit', $quiz->id), 'label' => __('Editar questionário')]],
])

@section('content')
    <form action="{{ route('quizzes.update', $quiz->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">{{ __('Editar Questionário') }}</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group {{ $errors->has('title') ? 'has-danger' : '' }}">
                            <label for="title" class="bmd-label-floating">{{ __('Título') }}</label>
                            <input type="text" name="title"
                                class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" id="title"
                                value="{{ old('title', $quiz->title) }}" />
                            @if ($errors->has('title'))
                                <span id="title_error" class="error text-danger"
                                    for="input_title">{{ $errors->first('title') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group {{ $errors->has('description') ? 'has-danger' : '' }}">
                            <label for="description" class="bmd-label-floating">{{ __('Descrição') }}</label>
                            <textarea name="description" id="description" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}"
                                cols="30" rows="5">{{ old('description', $quiz->description) }}</textarea>
                            @if ($errors->has('description'))
                                <span id="description_error" class="error text-danger"
                                    for="input_description">{{ $errors->first('description') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('initial') ? 'has-danger' : '' }}">
                            <label for="initial" class="bmd-label-floating">{{ __('Atendimento Inicial') }}</label>
                            <select name="initial" id="initial" class="form-control">
                                <option value="1" {{ $quiz->initial == 1 ? 'selected' : '' }}>Sim</option>
                                <option value="0" {{ $quiz->initial == 0 ? 'selected' : '' }}>Não</option>
                            </select>
                            <small class="text-help">Selecione se este questionário será o questionário inicial do
                                atendimento ao receber uma nova mensagem</small>
                            @if ($errors->has('initial'))
                                <span id="initial_error" class="error text-danger"
                                    for="initial">{{ $errors->first('initial') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('nps') ? 'has-danger' : '' }}">
                            <label for="nps" class="bmd-label-floating">{{ __('NPS') }}</label>
                            <select name="nps" id="nps" class="form-control">
                                <option value="1" {{ (bool) $quiz->nps == 1 ? 'selected' : '' }}>Sim</option>
                                <option value="0" {{ (bool) $quiz->nps == 0 ? 'selected' : '' }}>Não</option>
                            </select>
                            <small class="text-help">Questionário para registro de NPS.</small>
                            @if ($errors->has('nps'))
                                <span id="nps_error" class="error text-danger"
                                    for="nps">{{ $errors->first('nps') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer clearfix">
                <button class="btn btn-primary btn-sm"><i class="fas fa-save"></i> {{ __('Salvar') }}</button>
                <a href="{{ route('quizzes.index') }}" class="btn btn-secondary btn-sm">{{ __('Cancelar') }}</a>
            </div>
        </div>
    </form>
@endsection
