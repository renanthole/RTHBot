@extends('layouts.app', ['titlePage' => __('Chats'), 'activePage' => 'chats', 'breadcrumbs' => [['url' => route('chats.index'), 'label' => 'Chats'], ['url' => route('chats.show', $chat->id), 'label' => 'Chat - ' . $chat->id]]])

@section('content')
    <div class="card card-primary card-outline direct-chat direct-chat-primary">
        <div class="card-header">
            <h3 class="card-title">Mensagens</h3>
            <div class="card-tools">
                <span title="3 New Messages" class="badge bg-primary">3</span>
            </div>
        </div>

        <div class="card-body">

            <div class="direct-chat-messages">

                <div class="direct-chat-msg">
                    <div class="direct-chat-infos clearfix">
                        <span class="direct-chat-name float-left">{{ config('app.name') }}</span>
                        <span class="direct-chat-timestamp float-right">23 Jan 2:00 pm</span>
                    </div>

                    <img class="direct-chat-img" src="{{ asset('img/avatar.png') }}" alt="{{ config('app.name') }}">

                    <div class="direct-chat-text">
                        Is this template really for free? That's unbelievable!
                    </div>

                </div>


                <div class="direct-chat-msg right">
                    <div class="direct-chat-infos clearfix">
                        <span class="direct-chat-name float-right">Usuário - {{ $chat->phone }}</span>
                        <span class="direct-chat-timestamp float-left">23 Jan 2:05 pm</span>
                    </div>

                    <img class="direct-chat-img" src="{{ asset('img/avatar.png') }}" alt="User Image">

                    <div class="direct-chat-text">
                        You better believe it!
                    </div>

                </div>

            </div>


            <div class="direct-chat-contacts">
                <ul class="contacts-list">
                    <li>
                        <a href="#">
                            <img class="contacts-list-img" src="../dist/img/user1-128x128.jpg" alt="User Avatar">
                            <div class="contacts-list-info">
                                <span class="contacts-list-name">
                                    Count Dracula
                                    <small class="contacts-list-date float-right">2/28/2015</small>
                                </span>
                                <span class="contacts-list-msg">How have you been? I was...</span>
                            </div>

                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card-footer">
            <div class="input-group">
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
