@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7" style="margin-top: 2%">
                <div class="box">
                    <h3 class="box-title" style="padding: 2%">Verifique seu endereço de e-mail</h3>

                    <div class="box-body">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">Um novo link de verificação foi enviado para seu
                                endereço de email
                            </div>
                        @endif
                        <p>Antes de continuar, verifique se há um link de verificação em seu e-mail. Se você não recebeu o
                            email,</p>
                        <a href="#"
                            onclick="event.preventDefault(); document.getElementById('resend-form').submit();">
                            clique aqui para solicitar outro.
                        </a>
                        <form id="resend-form" action="{{ route('verification.resend') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
