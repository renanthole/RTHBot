@extends('layouts.app', [
    'activePage' => 'quizzes',
    'titlePage' => __('Questionários'),
    'breadcrumbs' => [['url' => route('quizzes.index'), 'label' => __('Questionários')], ['url' => route('quizzes.sendStore', $quiz->id), 'label' => __('Enviar questionário')]],
])

@section('content')
    <form action="{{ route('quizzes.sendStore', $quiz->id) }}" method="POST">
        @csrf
        @method('POST')
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">{{ __('Enviar Questionário') }}</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group {{ $errors->has('phone') ? 'has-danger' : '' }}">
                            <label for="phone" class="bmd-label-floating">{{ __('Telefone') }}</label>
                            <input type="text" name="phone"
                                class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" id="phone"
                                value="{{ old('phone') }}" />
                            @if ($errors->has('phone'))
                                <span id="title_error" class="error text-danger"
                                    for="input_title">{{ $errors->first('phone') }}</span>
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
