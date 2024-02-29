<div class="direct-chat-messages">
    @forelse ($chat->messages as $message)
        <div class="direct-chat-msg {{ !$message->typeMessageDelivery() ? 'right' : '' }}">
            <div class="direct-chat-infos clearfix">
                <span
                    class="direct-chat-name float-left">{{ !$message->typeMessageDelivery() ? $chat->phone : config('app.name') }}</span>
                <span
                    class="direct-chat-timestamp float-right">{{ date('d/m/Y H:i', strtotime($message->created_at)) }}</span>
            </div>
            <img class="direct-chat-img" src="{{ asset('img/avatar.png') }}" alt="{{ config('app.name') }}">
            <div class="direct-chat-text">
                {!! $message->message !!}
            </div>
        </div>
    @empty
    @endforelse
</div>
