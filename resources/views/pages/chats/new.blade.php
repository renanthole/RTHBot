@extends('layouts.app', ['titlePage' => __('Chats'), 'activePage' => 'chats', 'breadcrumbs' => [['url' => route('chats.index'), 'label' => 'Chats']]])

@section('content')
    <div class="card card-primary card-outline direct-chat direct-chat-primary">
        <div class="card-header">
            <h3 class="card-title">Direct Chat</h3>
            <div class="card-tools">
                <span title="3 New Messages" class="badge bg-primary">3</span>
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" title="Contacts" data-widget="chat-pane-toggle">
                    <i class="fas fa-comments"></i>
                </button>
            </div>
        </div>

        <div class="card-body">

            <div class="direct-chat-messages">

                <div class="direct-chat-msg">
                    <div class="direct-chat-infos clearfix">
                        <span class="direct-chat-name float-left">Alexander Pierce</span>
                        <span class="direct-chat-timestamp float-right">23 Jan 2:00 pm</span>
                    </div>

                    <img class="direct-chat-img" src="../dist/img/user1-128x128.jpg" alt="Message User Image">

                    <div class="direct-chat-text">
                        Is this template really for free? That's unbelievable!
                    </div>

                </div>


                <div class="direct-chat-msg right">
                    <div class="direct-chat-infos clearfix">
                        <span class="direct-chat-name float-right">Sarah Bullock</span>
                        <span class="direct-chat-timestamp float-left">23 Jan 2:05 pm</span>
                    </div>

                    <img class="direct-chat-img" src="../dist/img/user3-128x128.jpg" alt="Message User Image">

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
            <form action="#" method="post">
                <div class="input-group">
                    <input type="text" name="message" placeholder="Type Message ..." class="form-control">
                    <span class="input-group-append">
                        <button type="submit" class="btn btn-primary">Send</button>
                    </span>
                </div>
            </form>
        </div>

    </div>
@endsection
