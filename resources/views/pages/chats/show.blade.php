@extends('layouts.app', ['titlePage' => __('Chats'), 'activePage' => 'chats', 'breadcrumbs' => [['url' => route('chats.index'), 'label' => 'Chats'], ['url' => route('chats.show', $chat->id), 'label' => 'Chat - ' . $chat->id]]])

@section('content')
    <div class="card card-primary card-outline direct-chat direct-chat-primary">
        <div class="card-header">
            <h3 class="card-title">Mensagens</h3>
        </div>
        <div class="card-body" id="messages">
            @include('pages.chats.messages')
        </div>
        <div class="card-footer">
            <div class="input-group">
                <input type="hidden" id="chat" name="chat" value="{{ $chat->id }}">
                <input type="hidden" id="phone" name="phone" value="{{ $chat->phone }}">
                <input type="text" name="message" id="message" placeholder="Digite uma mensagem" class="form-control">
                <span class="input-group-append">
                    <button type="submit" id="setMessage" data-id="1" class="btn btn-primary">Enviar</button>
                </span>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('js/chat.js') }}"></script>
@endpush
