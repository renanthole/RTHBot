@extends('layouts.app', [
    'activePage' => 'devices',
    'titlePage' => __('Dispositivos'),
    'breadcrumbs' => [['url' => route('devices.index'), 'label' => __('Dispositivos')], ['url' => route('devices.edit', $device->id), 'label' => __('Editar dispositivo')]],
])

@section('content')
    <form action="{{ route('devices.update', $device->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">{{ __('Editar dispositivo') }}</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group {{ $errors->has('name') ? 'has-danger' : '' }}">
                            <label for="name" class="bmd-label-floating">{{ __('Nome') }}</label>
                            <input type="text" name="name"
                                class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name"
                                value="{{ old('name', $device->name) }}" required />
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
                                value="{{ old('phone', $device->phone) }}" />
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
                                value="{{ old('instancia', $device->instancia) }}" />
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
                                value="{{ old('token', $device->token) }}" />
                            @if ($errors->has('token'))
                                <span id="token_error" class="error text-danger"
                                    for="input_token">{{ $errors->first('token') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                @if (!empty($device->instancia) && !empty($device->token))
                    <div class="row align-items-center">
                        <div class="col-md-10">
                            <div class="form-group {{ $errors->has('api') ? 'has-danger' : '' }}">
                                <label for="api" class="bmd-label-floating">{{ __('API da Instância') }}</label>
                                <div class="input-group mb-3">
                                    <input type="text" name="api"
                                        class="form-control {{ $errors->has('api') ? 'is-invalid' : '' }}" id="api"
                                        value="https://api.z-api.io/instances/{{ $device->instancia }}/token/{{ $device->token }}"
                                        readonly />
                                    <div class="input-group-prepend">
                                        <button class="btn btn-outline-secondary" type="button" id="copyBtn"><i
                                                class="fa fa-copy"></i></button>
                                    </div>
                                </div>
                                <small id="apiHelp"
                                    class="form-text text-muted">{{ __('Endereço base para conexão com API da Z-API') }}</small>
                                @if ($errors->has('api'))
                                    <span id="api_error" class="error text-danger"
                                        for="input_api">{{ $errors->first('api') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <button type="button" id="getStatus" class="btn btn-primary btn-sm btn-block"
                                    data-id="{{ $device->id }}">Verificar conexão</button>
                            </div>
                        </div>
                    </div>
                @endif
                @if ((bool) $device->connected === true)
                    <div class="alert alert-success" role="alert">
                        <h4 class="alert-heading">Dispositivo conectado</h4>
                        <p>Dispositivo conectado a Z-API e pronto para o envio de mensagens</p>
                        <a href="#" class="btn btn-danger btn-xs">Desconectar dispositivo</a>
                        <hr>
                        <small class="mb-0">Verificado em
                            {{ date('d/m/Y H:i', strtotime($device->connected_at)) }}</small>
                    </div>
                @endif
            </div>
            <div class="card-footer clearfix">
                <button class="btn btn-primary btn-sm"><i class="fas fa-save"></i> {{ __('Salvar') }}</button>
                <a href="{{ route('devices.index') }}" class="btn btn-secondary btn-sm">{{ __('Cancelar') }}</a>
            </div>
            <div class="overlay d-none"><i class="fas fa-sync fa-spin fa-lg"></i></div>
        </div>
    </form>
@endsection

@push('js')
    <script src="{{ asset('js/whatsapp.js') }}"></script>
@endpush
