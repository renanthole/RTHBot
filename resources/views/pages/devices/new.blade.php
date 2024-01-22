@extends('layouts.app', [
    'activePage' => 'devices',
    'titlePage' => __('Dispositivos'),
    'breadcrumbs' => [['url' => route('devices.index'), 'label' => __('Dispositivos')], ['url' => route('devices.create'), 'label' => __('Novo dispositivo')]],
])

@section('content')
    <form action="{{ route('devices.store') }}" method="POST">
        @csrf
        @method('POST')
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">{{ __('Novo dispositivo') }}</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group {{ $errors->has('name') ? 'has-danger' : '' }}">
                            <label for="name" class="bmd-label-floating">{{ __('Nome') }}</label>
                            <input type="text" name="name"
                                class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name"
                                value="{{ old('name') }}" required />
                            @if ($errors->has('name'))
                                <span id="name_error" class="error text-danger"
                                    for="input_name">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('phone') ? 'has-danger' : '' }}">
                            <label for="phone" class="bmd-label-floating">{{ __('Número do celular') }}</label>
                            <input type="text" name="phone"
                                class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" id="phone"
                                value="{{ old('phone') }}" />
                            @if ($errors->has('phone'))
                                <span id="phone_error" class="error text-danger"
                                    for="input_phone">{{ $errors->first('phone') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('instancia') ? 'has-danger' : '' }}">
                            <label for="instancia" class="bmd-label-floating">{{ __('Instância') }}</label>
                            <input type="text" name="instancia"
                                class="form-control {{ $errors->has('instancia') ? 'is-invalid' : '' }}" id="instancia"
                                value="{{ old('instancia') }}" />
                            @if ($errors->has('instancia'))
                                <span id="instancia_error" class="error text-danger"
                                    for="input_instancia">{{ $errors->first('instancia') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('token') ? 'has-danger' : '' }}">
                            <label for="token" class="bmd-label-floating">{{ __('Token') }}</label>
                            <input type="text" name="token"
                                class="form-control {{ $errors->has('token') ? 'is-invalid' : '' }}" id="token"
                                value="{{ old('token') }}" />
                            @if ($errors->has('token'))
                                <span id="token_error" class="error text-danger"
                                    for="input_token">{{ $errors->first('token') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer clearfix">
                <button class="btn btn-primary btn-sm"><i class="fas fa-save"></i> {{ __('Cadastrar') }}</button>
                <a href="{{ route('devices.index') }}" class="btn btn-secondary btn-sm">{{ __('Cancelar') }}</a>
            </div>
        </div>
    </form>
@endsection
