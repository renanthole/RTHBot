@extends('layouts.app', [
    'activePage' => 'quizzes',
    'titlePage' => __('Questionários'),
    'breadcrumbs' => [['url' => route('quizzes.index'), 'label' => __('Questionários')], ['url' => route('quizzes.create'), 'label' => __('Novo questionário')]],
])

@section('content')
    <form action="{{ route('quizzes.store') }}" method="POST">
        @csrf
        @method('POST')
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">{{ __('Novo Questionário') }}</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group {{ $errors->has('title') ? 'has-danger' : '' }}">
                            <label for="title" class="bmd-label-floating">{{ __('Título') }}</label>
                            <input type="text" name="title"
                                class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" id="title"
                                value="{{ old('title') }}" />
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
                                cols="30" rows="5">{{ old('description') }}</textarea>
                            @if ($errors->has('description'))
                                <span id="description_error" class="error text-danger"
                                    for="input_description">{{ $errors->first('description') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer clearfix">
                <button class="btn btn-primary btn-sm"><i class="fas fa-save"></i> {{ __('Cadastrar') }}</button>
                <a href="{{ route('quizzes.index') }}" class="btn btn-secondary btn-sm">{{ __('Cancelar') }}</a>
            </div>
        </div>
    </form>
@endsection
